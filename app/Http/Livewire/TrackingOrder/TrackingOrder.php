<?php

namespace App\Http\Livewire\TrackingOrder;

use Livewire\Component;
use App\Models\DetailOrderKerja;
use App\Models\OrderKerja;

class TrackingOrder extends Component
{
	public $nomor_resi;

    public function render()
    {
		$id_order_kerja = OrderKerja::where('nomor_transaksi', $this->nomor_resi)->first()->id ?? 0;
		if( $id_order_kerja == 1 ){
			$id_order_kerja = 0;
		} else {
			$id_order_kerja = OrderKerja::where('nomor_transaksi', $this->nomor_resi)->first()->id ?? 0;
		}

		$data = DetailOrderKerja::select('detail_order_kerjas.nama_file', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'detail_order_kerjas.harga', 'detail_order_kerjas.total', 'bahans.nama_barang', 'nama_pekerjaans.nama_pekerjaan', 'mesins.nama_printer', 'tracking_users.tanggal_finishing', 'tracking_users.tanggal_taking', 'tracking_users.created_at')
                        ->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
                        ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                        ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                        ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->join('tracking_users', 'tracking_users.id_detail_order_kerja', 'detail_order_kerjas.id')
                        ->where('id_order_kerja', $id_order_kerja)->get();
						
        return view('livewire.tracking-order.tracking-order', compact('data', 'id_order_kerja'))
		->extends('layouts.apps3', ['title' => 'Tracking Order System']);
    }
}
