<?php

namespace App\Http\Livewire\Dashboard;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\OrderKerja;
use App\Models\Pembayaran;
use App\Models\TrackingUser;
use Livewire\WithPagination;
use App\Models\SettingTanggal;
use App\Models\DetailOrderKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
	use WithPagination;
	protected $listeners = [
        'konfirmasiConfirmed' => 'active',
		'konfirmasiConfirmedProd' => 'actives',
		'lunasKonfirm' => 'lunasKonfir',
		'batalkanLunasKonfirm' => 'batalkanLunasKonfir',
    ];
    public $tanggal;
    public $updateMode = false;
    public $idStatus, $dariTanggal, $sampaiTanggal, $status, $startDate, $endDate;
    public $searchTerm, $lengthData;
    public $idRemoved = null;
    public $idTaking = null;
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
        if( Auth::user()->hasRole('admin') )
        {
            $id = SettingTanggal::where('id', '1')->first()->id;
            $tanggalHariIni = date('Y-m-d');
            $pendapatanHariIni = Pembayaran::select(DB::raw('SUM(total_net) AS total'), 'order_kerjas.tanggal')
                                        ->join('order_kerjas', 'order_kerjas.id', 'pembayarans.id_order_kerja')
                                        ->where('order_kerjas.tanggal', $tanggalHariIni)
                                        ->first()->total ?? 0;
            $transaksiHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where('order_kerjas.tanggal', $tanggalHariIni)
                                        ->count();
            
            $produksiHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where([
                                            ['order_kerjas.tanggal', $tanggalHariIni],
                                            ['detail_order_kerjas.status', 1]
                                        ])
                                        ->count();

            $finishingHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where([
                                            ['order_kerjas.tanggal', $tanggalHariIni],
                                            ['detail_order_kerjas.status', 3]
                                        ])
                                        ->count();

            $diambilHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where([
                                            ['order_kerjas.tanggal', $tanggalHariIni],
                                            ['detail_order_kerjas.status', 4]
                                        ])
                                        ->count();
                                        
            // =======================================================
            $pendapatanMingguIni = Pembayaran::select(DB::raw('SUM(total_net) AS total'), 'order_kerjas.tanggal')
                                        ->join('order_kerjas', 'order_kerjas.id', 'pembayarans.id_order_kerja')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->first()->total ?? 0;

            $transaksiMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->count();
            
            $produksiMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->where('detail_order_kerjas.status', 1)
                                        ->count();

            $finishingMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->where('detail_order_kerjas.status', 3)
                                        ->count();

            $diambilMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->where('detail_order_kerjas.status', 4)
                                        ->count();

            // =======================================================
            $settingTanggal = SettingTanggal::where('id', 1)->first()->tanggal;
            $bulanDanTahun = date('Y-m');
            $bulanSekarang = $bulanDanTahun."-".$settingTanggal;
            $bulanDepan = date('Y-m-d', strtotime('+1 month', strtotime($bulanSekarang)));

            setlocale(LC_TIME, 'id_ID');
            Carbon::setLocale('id');
            // dd($bulanDepan);
            $pendapatanBulanIni = Pembayaran::select(DB::raw('SUM(total_net) AS total'), 'order_kerjas.tanggal')
                        ->join('order_kerjas', 'order_kerjas.id', 'pembayarans.id_order_kerja')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->first()->total ?? 0;

            $transaksiBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->count();

            $produksiBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->where('detail_order_kerjas.status', 1)
                        ->count();

            $finishingBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->where('detail_order_kerjas.status', 3)
                        ->count();

            $diambilBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->where('detail_order_kerjas.status', 4)
                        ->count();

			$searchTerm = '%'.$this->searchTerm.'%';
			$lengthData = $this->lengthData;
				
			if( $this->idStatus == 0 ){
				$data = OrderKerja::select('detail_order_kerjas.id','order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
						->where(function($query) use ($searchTerm) {
							$query->where('order_kerjas.id', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.nomor_transaksi', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.tanggal', 'LIKE', $searchTerm);
							$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
							$query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
							$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
						})
						->orderBy('detail_order_kerjas.id', 'DESC')
						// ->groupBy('detail_order_kerjas.id_order_kerja')
						->paginate($lengthData);
			} else {
				$data = OrderKerja::select('order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->where('detail_order_kerjas.status', $this->idStatus)
						->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
						->where(function($query) use ($searchTerm) {
							$query->where('order_kerjas.id', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.nomor_transaksi', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.tanggal', 'LIKE', $searchTerm);
							$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
							$query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
							$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
						})
						->orderBy('detail_order_kerjas.id', 'DESC')
						// ->groupBy('detail_order_kerjas.id_order_kerja')
						->paginate($lengthData);
			}
            return view('livewire.dashboard.dashboard-admin', compact(
                'pendapatanHariIni', 'transaksiHariIni', 'produksiHariIni', 'finishingHariIni', 'diambilHariIni',
                'pendapatanMingguIni', 'transaksiMingguIni', 'produksiMingguIni', 'finishingMingguIni', 'diambilMingguIni',
                'pendapatanBulanIni', 'transaksiBulanIni', 'produksiBulanIni', 'finishingBulanIni', 'diambilBulanIni', 'id', 'bulanSekarang', 'bulanDepan', 'data'
                ))
                ->extends('layouts.apps', ['title' => 'Dashboard']);
        }

		else if (Auth::user()->hasRole('desainer'))
		{
			$id = SettingTanggal::where('id', '1')->first()->id;
            $tanggalHariIni = date('Y-m-d');
            $pendapatanHariIni = Pembayaran::select(DB::raw('SUM(total_net) AS total'), 'order_kerjas.tanggal')
                                        ->join('order_kerjas', 'order_kerjas.id', 'pembayarans.id_order_kerja')
                                        ->where('order_kerjas.tanggal', $tanggalHariIni)
                                        ->first()->total ?? 0;
            $transaksiHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where('order_kerjas.tanggal', $tanggalHariIni)
                                        ->count();
            
            $produksiHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where([
                                            ['order_kerjas.tanggal', $tanggalHariIni],
                                            ['detail_order_kerjas.status', 1]
                                        ])
                                        ->count();

            $finishingHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where([
                                            ['order_kerjas.tanggal', $tanggalHariIni],
                                            ['detail_order_kerjas.status', 3]
                                        ])
                                        ->count();

            $diambilHariIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->where([
                                            ['order_kerjas.tanggal', $tanggalHariIni],
                                            ['detail_order_kerjas.status', 4]
                                        ])
                                        ->count();
                                        
            // =======================================================
            $pendapatanMingguIni = Pembayaran::select(DB::raw('SUM(total_net) AS total'), 'order_kerjas.tanggal')
                                        ->join('order_kerjas', 'order_kerjas.id', 'pembayarans.id_order_kerja')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->first()->total ?? 0;

            $transaksiMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->count();
            
            $produksiMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->where('detail_order_kerjas.status', 1)
                                        ->count();

            $finishingMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->where('detail_order_kerjas.status', 3)
                                        ->count();

            $diambilMingguIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                                        ->whereBetween('order_kerjas.tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                        ->where('detail_order_kerjas.status', 4)
                                        ->count();

            // =======================================================
            $settingTanggal = SettingTanggal::where('id', 1)->first()->tanggal;
            $bulanDanTahun = date('Y-m');
            $bulanSekarang = $bulanDanTahun."-".$settingTanggal;
            $bulanDepan = date('Y-m-d', strtotime('+1 month', strtotime($bulanSekarang)));

            setlocale(LC_TIME, 'id_ID');
            Carbon::setLocale('id');
            // dd($bulanDepan);
            $pendapatanBulanIni = Pembayaran::select(DB::raw('SUM(total_net) AS total'), 'order_kerjas.tanggal')
                        ->join('order_kerjas', 'order_kerjas.id', 'pembayarans.id_order_kerja')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->first()->total ?? 0;

            $transaksiBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->count();

            $produksiBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->where('detail_order_kerjas.status', 1)
                        ->count();

            $finishingBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->where('detail_order_kerjas.status', 3)
                        ->count();

            $diambilBulanIni = OrderKerja::join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
                        ->whereBetween('order_kerjas.tanggal', [$bulanSekarang, $bulanDepan])
                        ->where('detail_order_kerjas.status', 4)
                        ->count();

			$searchTerm = '%'.$this->searchTerm.'%';
			$lengthData = $this->lengthData;
				
			if( $this->idStatus == 0 ){
				$data = OrderKerja::select('detail_order_kerjas.id','order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
						->where(function($query) use ($searchTerm) {
							$query->where('order_kerjas.id', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.nomor_transaksi', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.tanggal', 'LIKE', $searchTerm);
							$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
							$query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
							$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
						})
						->orderBy('detail_order_kerjas.id', 'ASC')
						->paginate($lengthData);
			} else {
				$data = OrderKerja::select('order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->where('detail_order_kerjas.status', $this->idStatus)
						->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
						->where(function($query) use ($searchTerm) {
							$query->where('order_kerjas.id', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.nomor_transaksi', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.tanggal', 'LIKE', $searchTerm);
							$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
							$query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
							$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
						})
						->orderBy('detail_order_kerjas.id', 'ASC')
						->paginate($lengthData);
			}
            return view('livewire.dashboard.dashboard-admin', compact(
                'pendapatanHariIni', 'transaksiHariIni', 'produksiHariIni', 'finishingHariIni', 'diambilHariIni',
                'pendapatanMingguIni', 'transaksiMingguIni', 'produksiMingguIni', 'finishingMingguIni', 'diambilMingguIni',
                'pendapatanBulanIni', 'transaksiBulanIni', 'produksiBulanIni', 'finishingBulanIni', 'diambilBulanIni', 'id', 'bulanSekarang', 'bulanDepan', 'data'
                ))
                ->extends('layouts.apps', ['title' => 'Dashboard']);
		}
		
        else if ( Auth::user()->hasRole('produksi') )
        {
			$searchTerm = '%'.$this->searchTerm.'%';
			$lengthData = $this->lengthData;
				
			if( $this->idStatus == 0 ){
				$data = OrderKerja::select('detail_order_kerjas.id','order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
						->where(function($query) use ($searchTerm) {
							$query->where('order_kerjas.id', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.nomor_transaksi', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.tanggal', 'LIKE', $searchTerm);
							$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
							$query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
							$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
						})
						->orderBy('detail_order_kerjas.id', 'ASC')
						->paginate($lengthData);
			} else {
				$data = OrderKerja::select('order_kerjas.tanggal', 'customers.nama_customer', 'detail_order_kerjas.nama_file', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.status', 'pembayarans.status_lunas', 'detail_order_kerjas.id_order_kerja', 'pembayarans.sisa_kurang')
						->join('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
						->join('detail_order_kerjas', 'detail_order_kerjas.id_order_kerja', 'order_kerjas.id')
						->join('customers', 'customers.id', 'order_kerjas.id_customer')
						->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
						->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
						->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->where('detail_order_kerjas.status', $this->idStatus)
						->whereBetween('order_kerjas.tanggal', [$this->dariTanggal, $this->sampaiTanggal])
						->where(function($query) use ($searchTerm) {
							$query->where('order_kerjas.id', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.nomor_transaksi', 'LIKE', $searchTerm);
							$query->orWhere('order_kerjas.tanggal', 'LIKE', $searchTerm);
							$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
							$query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
							$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
							$query->orWhere('detail_order_kerjas.status', 'LIKE', $searchTerm);
						})
						->orderBy('detail_order_kerjas.id', 'ASC')
						->paginate($lengthData);
			}

            return view('livewire.dashboard.dashboard-supplier', compact('data'))
                ->extends('layouts.apps', ['title' => 'Dashboard']);
        }
    }

    public function edit($id)
    {
        $data = SettingTanggal::where('id',$id)->first();
        $this->dataId = $id;
        $this->tanggal = $data->tanggal;
    }

    public function update()
    {
        $validate = $this->validate([
            'tanggal'  => 'required',
        ]);

        if ($this->dataId) {
            $data = SettingTanggal::findOrFail($this->dataId);
            $data->update([
                'tanggal'  => $this->tanggal,
            ]);
            $this->updateMode = false;
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Successfully!', 
                'text' => 'Data Updated Successfully!.'
            ]);
            $this->emit('dataStore');
        }
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

	public function konf($id)
	{
		$this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal:konfirmasi');
	}

	public function actives()
    {
        $data = DetailOrderKerja::findOrFail($this->idRemoved);
        $data->update(array('status' => 3));
        TrackingUser::where('id_detail_order_kerja', $this->idRemoved)->update(array(
            'id_user_finishing' => Auth::user()->id,
            'tanggal_finishing' => new DateTime()
        ));
    }

	public function lunas($id)
	{
		$this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal:pelunasan');
	}

	public function lunasKonfir()
    {
        $id_order_kerja = DetailOrderKerja::where('id', $this->idRemoved)->first()->id_order_kerja;
		$data = Pembayaran::where('id_order_kerja', $id_order_kerja)->first();
        $data->update(array('status_lunas' => '1'));
    }

	public function batalkanLunas($id)
	{
		$this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal:batalkanPelunasan');
	}

	public function batalkanLunasKonfir()
    {
        $id_order_kerja = DetailOrderKerja::where('id', $this->idRemoved)->first()->id_order_kerja;
		$data = Pembayaran::where('id_order_kerja', $id_order_kerja)->first();
        $data->update(array('status_lunas' => '0'));
    }
}
