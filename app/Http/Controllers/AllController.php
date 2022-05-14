<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Mesin;
use App\Models\OrderKerja;
use App\Models\detailBahan;
use Illuminate\Http\Request;
use App\Models\NamaPekerjaan;
use App\Models\DetailOrderKerja;
use Illuminate\Support\Facades\DB;

class AllController extends Controller
{
    public function getDataIdMesin($id)
    {
        $idMesin = NamaPekerjaan::select('id_mesin')->where('id', $id)->first();

        return response()->json(array(
            $idMesin
        ));
    }

    public function getDataMesinPrinter($id)
    {
        $dataMesin = Mesin::select('id', 'nama_printer')->where('id', $id)->first();

        return response()->json(array(
            $dataMesin
        ));
    }

    public function getDataNamaPekerjaan($id, $idLevelCustomer)
    {
        $data = NamaPekerjaan::select('detail_bahans.id', 'nama_pekerjaans.nama_pekerjaan', 'bahans.nama_barang', 'detail_bahans.ukuran', 'detail_bahans.harga_jual')
                    ->join('detail_bahans', 'detail_bahans.id_pekerjaan', 'nama_pekerjaans.id')
                    ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                    ->where('nama_pekerjaans.id_mesin', $id)
                    ->where('detail_bahans.id_level_customer', $idLevelCustomer)
                    ->get();

        return response()->json($data);
    }

    public function getDataIdBahanDanPekerjaan($id)
    {
        $idPekerjaan = detailBahan::select('id_pekerjaan')->where('id', $id)->first();
        $idBahan = detailBahan::select('id_bahan')->where('id', $id)->first();

        return response()->json(array(
            $idPekerjaan,
            $idBahan
        ));
    }

    public function getDataPekerjaanDanIdMesin($id_pekerjaan)
    {
        $idMesin = NamaPekerjaan::select('id_mesin')->where('id', $id_pekerjaan)->first();
        $dataPekerjaan = NamaPekerjaan::select('nama_pekerjaan')->where('id', $id_pekerjaan)->first();

        return response()->json(array(
            $idMesin,
            $dataPekerjaan,
        ));
    }

	public function cetakInvoice($id)
	{
		$data = OrderKerja::select('order_kerjas.*', DB::raw('order_kerjas.id AS appid'), 'customers.nama_customer', 'customers.no_telepon', 'pembayarans.*')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->where('order_kerjas.id', $id)
						->first();

		$dataTransaksi = $dataDetailOrderKerja = DetailOrderKerja::select('detail_order_kerjas.nama_file', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.harga', 'detail_order_kerjas.total', 'bahans.nama_barang', 'nama_pekerjaans.nama_pekerjaan', 'mesins.nama_printer', 'detail_order_kerjas.keterangan')
				->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
				->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
				->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
				->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
				->where('id_order_kerja', $id)->get();

		return view('cetak-invoice.cetak-invoice', compact('data', 'dataTransaksi'));
	}

}
