<?php

namespace App\Http\Livewire\DataTransaksi;

use Livewire\Component;
use App\Models\OrderKerja;
use Livewire\WithPagination;
use App\Models\DetailOrderKerja;
use Illuminate\Support\Facades\DB;

class DataTransaksi extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;
        $data = OrderKerja::select('order_kerjas.*', 'customers.nama_customer', 'pembayarans.status_lunas')
                    ->join('customers', 'customers.id', 'order_kerjas.id_customer')
                    ->leftJoin('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
                    ->where('order_kerjas.tanggal', 'LIKE', $searchTerm)
                    ->orWhere('order_kerjas.deadline', 'LIKE', $searchTerm)
                    ->orWhere('order_kerjas.deadline_time', 'LIKE', $searchTerm)
                    ->orWhere('order_kerjas.total', 'LIKE', $searchTerm)
                    ->orWhere('customers.nama_customer', 'LIKE', $searchTerm)
                    ->orderBy('id', 'DESC')
                    ->paginate($lengthData);

        return view('livewire.data-transaksi.data-transaksi', compact('data'))
        ->extends('layouts.apps', ['title' => 'Data Transaksi']);
    }

    public function deleteConfirm($id)
    {
        $this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal');
    }

    public function delete()
    {
        $data = OrderKerja::findOrFail($this->idRemoved);
        $data->delete();
        $del = DetailOrderKerja::where('id_order_kerja', $this->idRemoved)->delete(); 
        if( $data ){
            $max = DB::table('order_kerjas')->max('id') + 1; 
            DB::statement("ALTER TABLE order_kerjas AUTO_INCREMENT = $max");

            $maxDetail = DB::table('detail_order_kerjas')->max('id') + 1; 
            DB::statement("ALTER TABLE detail_order_kerjas AUTO_INCREMENT = $maxDetail");
        }
    }

}
