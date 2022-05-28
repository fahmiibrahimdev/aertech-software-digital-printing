<?php

namespace App\Http\Livewire\RekapData;

use Livewire\Component;
use App\Models\OrderKerja;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;

class PrintPendapatanPengeluaran extends Component
{
	public $dari_tanggal, $sampai_tanggal;

	public function mount($dariTanggal, $sampaiTanggal)
	{
		$this->dari_tanggal = $dariTanggal;
		$this->sampai_tanggal = $sampaiTanggal;
	}

    public function render()
    {
		$tanggalAwal = $this->dari_tanggal;
		$tanggalAkhir = $this->sampai_tanggal;

		$data = OrderKerja::select('order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang', 'detail_order_kerjas.total')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->whereBetween('order_kerjas.tanggal', [$this->dari_tanggal, $this->sampai_tanggal])
						->orderBy('detail_order_kerjas.id', 'DESC')
						->get();

		$dataTotal = OrderKerja::select(DB::raw('SUM(detail_order_kerjas.total) AS total_pendapatan'), DB::raw('SUM(detail_order_kerjas.qty) AS qty'))
					->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
					->whereBetween('order_kerjas.tanggal', [$this->dari_tanggal, $this->sampai_tanggal])
					->orderBy('detail_order_kerjas.id', 'DESC')
					->first();


		$dataPengeluaran = Pengeluaran::whereBetween('tanggal', 
								[$this->dari_tanggal, $this->sampai_tanggal]
							)
							->orderBy('tanggal', 'DESC')
							->get();

		$totalPengeluaran = Pengeluaran::whereBetween('tanggal', 
								[$this->dari_tanggal, $this->sampai_tanggal]
							)->sum('jumlah');
					// dd($subTotal);

        return view('livewire.rekap-data.print-pendapatan-pengeluaran', compact('tanggalAwal', 'tanggalAkhir', 'data', 'dataTotal', 'dataPengeluaran', 'totalPengeluaran'))
		->extends('layouts.layout-print', ['title' => 'Laporan Pendapatan dan Pengeluaran '.$this->dari_tanggal]);
    }
}
