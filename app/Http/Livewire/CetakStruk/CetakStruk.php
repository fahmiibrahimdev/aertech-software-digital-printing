<?php

namespace App\Http\Livewire\CetakStruk;

use Livewire\Component;
use App\Models\OrderKerja;
use Livewire\WithPagination;

class CetakStruk extends Component
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

        return view('livewire.cetak-struk.cetak-struk', compact('data'))
        ->extends('layouts.apps', ['title' => 'Cetak Struk']);
    }
}
