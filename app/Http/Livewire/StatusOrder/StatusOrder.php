<?php

namespace App\Http\Livewire\StatusOrder;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DetailOrderKerja;
use App\Models\OrderKerja;

class StatusOrder extends Component
{
    use WithPagination;
    public $idStatus, $dariTanggal, $sampaiTanggal, $status, $startDate, $endDate;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->idStatus = 0;
        $this->dariTanggal = date('Y-m-d', strtotime('first day of this month'));
        $this->sampaiTanggal = date('Y-m-d', strtotime('last day of this month'));
        $this->startDate = date('Y-m-d', strtotime('first day of this month'));
        $this->endDate = date('Y-m-d', strtotime('last day of this month'));
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;

        if( $this->idStatus == 0 ){
            $data = OrderKerja::select('order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_bahans.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status')
                    ->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                    ->join('customers', 'customers.id', 'order_kerjas.id_customer')
                    ->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
                    ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                    ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                    ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                    ->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
                    ->where(function($query) use ($searchTerm) {
                        $query->where('order_kerjas.tanggal', 'LIKE', $searchTerm);
                        $query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
                        $query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
                        $query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
                        $query->orWhere('detail_bahans.ukuran', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
                    })
                    ->orderBy('detail_order_kerjas.id', 'ASC')
                    ->paginate($lengthData);
        } else {
            $data = OrderKerja::select('order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_bahans.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status')
                    ->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                    ->join('customers', 'customers.id', 'order_kerjas.id_customer')
                    ->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
                    ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                    ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                    ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                    ->where('detail_order_kerjas.status', $this->idStatus)
                    ->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
                    ->where(function($query) use ($searchTerm) {
                        $query->where('order_kerjas.tanggal', 'LIKE', $searchTerm);
                        $query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
                        $query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
                        $query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
                        $query->orWhere('detail_bahans.ukuran', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
                    })
                    ->orderBy('detail_order_kerjas.id', 'ASC')
                    ->paginate($lengthData);
        }

        

        return view('livewire.status-order.status-order', compact('data'))
        ->extends('layouts.apps', ['title' => 'Status Order']);
    }
}
