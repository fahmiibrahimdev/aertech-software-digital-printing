<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use App\Models\Customer;
use App\Models\OrderKerja;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\NamaPekerjaan;
use App\Models\DetailOrderKerja;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PembayaranController extends Controller
{
    public function pembayaran($id)
    {
        $id = Crypt::decrypt($id);
        $dataCustomer = Customer::get();
        $dataOrderKerja = OrderKerja::where('id', $id)->first();
        $dataDetailOrderKerja = DetailOrderKerja::select('detail_order_kerjas.nama_file', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.harga', 'detail_order_kerjas.total', 'bahans.nama_barang', 'nama_pekerjaans.nama_pekerjaan', 'mesins.nama_printer')
                        ->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
                        ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                        ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                        ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                        ->where('id_order_kerja', $id)->get();

        return view('pembayaran.pembayaran', compact('dataOrderKerja', 'dataDetailOrderKerja', 'dataCustomer'));
    }

    public function store(Request $request)
    {
		if( $request->total_net == 0 && $request->sisa_kurang == 1 )
		{
			$total = OrderKerja::where('id', $request->id_order_kerja)->first()->total;

			Pembayaran::create([
                'id_user'           =>  Auth::user()->id,
                'id_order_kerja'    =>  $request->id_order_kerja,
                'discount_invoice'  =>  $request->discount_invoice,
                'discount_invoice'  =>  $request->discount_invoice,
                'pembulatan'        =>  $request->pembulatan,
                'total_net'         =>  $total,
                'bayar_dp'          =>  $request->bayar_dp,
                'sisa_kurang'       =>  $total,
                'metode_pembayaran' =>  $request->metode_pembayaran,
                'catatan_produksi'  =>  $request->catatan_produksi,
                'pembayaran'        =>  '0',
                'status_lunas'      =>  '0',
            ]);
            if( Auth::user()->hasRole('admin') )
			{
				return redirect()->route('cetak-invoice', $request->id_order_kerja);
			} else {
				return redirect()->route('data-transaksi');
			}
		}else if( $request->sisa_kurang == 0 ){
            $data = Pembayaran::create([
                'id_user'           =>  Auth::user()->id,
                'id_order_kerja'    =>  $request->id_order_kerja,
                'discount_invoice'  =>  $request->discount_invoice,
                'discount_invoice'  =>  $request->discount_invoice,
                'pembulatan'        =>  $request->pembulatan,
                'total_net'         =>  $request->total_net,
                'bayar_dp'          =>  $request->bayar_dp,
                'sisa_kurang'       =>  $request->sisa_kurang,
                'metode_pembayaran' =>  $request->metode_pembayaran,
                'catatan_produksi'  =>  $request->catatan_produksi,
                'pembayaran'        =>  '0',
                'status_lunas'      =>  '1',
            ]);
            if( Auth::user()->hasRole('admin') )
			{
				return redirect()->route('cetak-invoice', $request->id_order_kerja);
			} else {
				return redirect()->route('data-transaksi');
			}
        } else if ( $request->sisa_kurang > 0 ) {
            $data = Pembayaran::create([
                'id_user'           =>  Auth::user()->id,
                'id_order_kerja'    =>  $request->id_order_kerja,
                'discount_invoice'  =>  $request->discount_invoice,
                'discount_invoice'  =>  $request->discount_invoice,
                'pembulatan'        =>  $request->pembulatan,
                'total_net'         =>  $request->total_net,
                'bayar_dp'          =>  $request->bayar_dp,
                'sisa_kurang'       =>  $request->sisa_kurang,
                'metode_pembayaran' =>  $request->metode_pembayaran,
                'catatan_produksi'  =>  $request->catatan_produksi,
                'pembayaran'        =>  '0',
                'status_lunas'      =>  '0',
            ]);
			if( Auth::user()->hasRole('admin') )
			{
				return redirect()->route('cetak-invoice', $request->id_order_kerja);
			} else {
				return redirect()->route('data-transaksi');
			}
        } else if ( $request->sisa_kurang < 0 ) {
			if( Auth::user()->hasRole('admin') )
			{
				return redirect()->route('admin/data-transaksi');
			} else {
				return redirect()->route('data-transaksi');
			}
        }
    }
}
