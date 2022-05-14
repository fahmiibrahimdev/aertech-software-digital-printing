<?php

namespace App\Http\Livewire\Produksi;

use DateTime;
use Livewire\Component;
use App\Models\TrackingUser;
use Livewire\WithPagination;
use App\Models\DetailOrderKerja;
use Illuminate\Support\Facades\Auth;

class Produksi extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'konfirmasiConfirmedProd' => 'active'
    ];
    public $kode_printer, $nama_printer;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;

        $data = DetailOrderKerja::select('detail_order_kerjas.id', 'order_kerjas.deadline', 'order_kerjas.deadline_time', 'users.name', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'bahans.nama_barang', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.keterangan', 'detail_order_kerjas.status')
                        ->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
                        ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                        ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                        ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                        ->join('order_kerjas', 'order_kerjas.id', 'detail_order_kerjas.id_order_kerja')
                        ->join('customers', 'customers.id', 'order_kerjas.id_customer')
                        ->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
                        ->join('users', 'users.id', 'pembayarans.id_user')
                        ->where('detail_order_kerjas.status', 1)
                        ->where(function($query) use ($searchTerm) {
                            $query->where('order_kerjas.deadline', 'LIKE', $searchTerm);
                            $query->orWhere('users.name', 'LIKE', $searchTerm);
                            $query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
                            $query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
                            $query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
                            $query->orWhere('bahans.nama_barang', 'LIKE', $searchTerm);
                            $query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
                            $query->orWhere('detail_order_kerjas.keterangan', 'LIKE', $searchTerm);
                        })
                        ->orderBy('detail_order_kerjas.id', 'ASC')
                        ->paginate($lengthData);

        return view('livewire.produksi.produksi', compact('data'))
        ->extends('layouts.apps', ['title' => 'Produksi']);
    }

    public function konfirmasi($id)
    {
        $this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal:konfirmasi');
    }

    public function active()
    {
        $data = DetailOrderKerja::findOrFail($this->idRemoved);
        $data->update(array('status' => 3));
        TrackingUser::where('id_detail_order_kerja', $this->idRemoved)->update(array(
            'id_user_finishing' => Auth::user()->id,
            'tanggal_finishing' => new DateTime()
        ));
    }

}
