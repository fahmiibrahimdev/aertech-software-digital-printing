<?php

namespace App\Http\Livewire\AmbilBarang;

use Livewire\Component;
use App\Models\TrackingUser;
use Livewire\WithPagination;
use App\Models\DetailOrderKerja;
use App\Models\Pembayaran;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AmbilBarang extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'konfirmasiConfirmed' => 'active'
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
                        ->where('detail_order_kerjas.status', 3)
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

        return view('livewire.ambil-barang.ambil-barang', compact('data'))
        ->extends('layouts.apps', ['title' => 'Pengambilan Barang']);
    }

    public function konfirmasi($id)
    {
        $this->idRemoved = $id;
        $data = DetailOrderKerja::select('id_order_kerja')->where('id', $id)->first();
        $id_order_kerja = $data->id_order_kerja;

        $pembayaran = Pembayaran::select('sisa_kurang')->where('id_order_kerja', $id_order_kerja)->first();
        $check = $pembayaran->sisa_kurang;
        if( $check > 0 ){
            $this->dispatchBrowserEvent('swal:konfirmasiTaking');
        } else {
            $this->dispatchBrowserEvent('swal:konfirmasiTakingAgree');
        }
    }

    public function active()
    {
        $data = DetailOrderKerja::findOrFail($this->idRemoved);
        $data->update(array('status' => 4));
        TrackingUser::where('id_detail_order_kerja', $this->idRemoved)->update(array(
            'id_user_taking' => Auth::user()->id,
            'tanggal_taking' => new DateTime()
        ));
    }

}
