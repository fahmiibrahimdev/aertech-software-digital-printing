<?php

namespace App\Http\Livewire\OrderKerja;

use App\Models\Bahan;
use App\Models\Mesin;
use Livewire\Component;
use App\Models\Customer;
use App\Models\detailBahan;
use App\Models\TrackingUser;
use Livewire\WithPagination;
use App\Models\LevelCustomer;
use App\Models\TrackingStock;
use App\Models\DetailOrderKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderKerja as ModelsOrderKerja;

class EditOrderKerja extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $nama_file, $ukuran, $qty, $keterangan, $id_detail_bahan, $id_order_kerja, $id_detail_order_kerja, $id_bahan, $date, $nama_customer, $no_telepon, $idLevelCustomer, $id_mesin_printer, $nama_barang, $id_level_customer;
	public $laminasi_meter, $cutting_meter, $laminasi_a3, $cutting_a3;
    public $id_customer, $tanggal, $deadline_time, $deadline;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->id_order_kerja = $id;

        $lastIdDetail = DetailOrderKerja::latest()->first();
        $id_detail_order_kerja = $lastIdDetail->id ?? 0;
        if( $id_detail_order_kerja == 0 )
        {
            $id_detail_order_kerja = $lastIdDetail->id ?? 0 + 1;
        } else {
            $id_detail_order_kerja = $lastIdDetail->id + 1;
        }
		$this->id_level_customer = LevelCustomer::min('id');
        $this->id_detail_order_kerja = $id_detail_order_kerja;
        $this->id_detail_bahan = detailBahan::min('id');
		$this->id_mesin_printer = Mesin::min('id');
        $this->id_customer = Customer::min('id');
        $this->laminasi_meter = 0;
        $this->laminasi_a3 = 0;
        $this->cutting_meter = 0;
        $this->cutting_a3 = 0;
        $this->ukuran = '';
        $this->tanggal = date('Y-m-d');
        $this->deadline_time = date('H:i');
        $this->deadline = date('Y-m-d');
        $this->qty = 1;
        $this->keterangan = '-';
    }

	private function resetIdOrderKerja()
	{
		$this->id_order_kerja = rand();
		$this->id_customer = Customer::min('id');
	}

    private function resetInputFields()
    {
        $lastIdDetail = DetailOrderKerja::latest()->first();
        $id_detail_order_kerja = $lastIdDetail->id ?? 0;
        if( $id_detail_order_kerja == 0 )
        {
            $id_detail_order_kerja = $lastIdDetail->id ?? 0 + 1;
        } else {
            $id_detail_order_kerja = $lastIdDetail->id + 1;
        }
        $this->id_detail_order_kerja = $id_detail_order_kerja;
        $this->ukuran = '';
        $this->laminasi_meter = 0;
        $this->cutting_meter = 0;
        $this->laminasi_a3 = 0;
        $this->cutting_a3 = 0;
        $this->id_detail_bahan = detailBahan::min('id');
        $this->qty = 1;
        $this->keterangan = '-';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function render()
    {
		$this->idLevelCustomer = Customer::where('id', $this->id_customer)->first()->id_level_customer;

        $searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;

        $data = DetailOrderKerja::select('detail_order_kerjas.id', 'detail_order_kerjas.nama_file', 'detail_order_kerjas.ukuran', 'detail_order_kerjas.qty', 'detail_order_kerjas.harga', 'detail_order_kerjas.harga', 'detail_order_kerjas.total', 'detail_order_kerjas.keterangan', 'bahans.nama_barang', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan')
                    ->join('detail_bahans', 'detail_bahans.id', 'detail_order_kerjas.id_detail_bahan')
                    ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                    ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                    ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                    ->where('id_order_kerja', $this->id_order_kerja)
                    ->where(function($query) use ($searchTerm) {
                        $query->where('bahans.nama_barang', 'LIKE', $searchTerm);
                        $query->orWhere('mesins.nama_printer', 'LIKE', $searchTerm);
                        $query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.nama_file', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.ukuran', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.qty', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.harga', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.keterangan', 'LIKE', $searchTerm);
                        $query->orWhere('detail_order_kerjas.total', 'LIKE', $searchTerm);
                    })
                    ->orderBy('detail_order_kerjas.id', 'ASC')
                    ->paginate($lengthData);

        $dataCustomer = Customer::select('customers.*', 'level_customers.nama_level')->join('level_customers', 'level_customers.id', 'customers.id_level_customer')->orderBy('customers.nama_customer', 'ASC')->get();
		$dataLevelCustomer = LevelCustomer::get();

        $dataPrinter = Mesin::select('id', 'kode_printer', 'nama_printer')->get();
        if( $this->id_detail_bahan == 0 )
        {
            $this->nama_barang = '';
        }else {
            $this->nama_barang = detailBahan::join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
								->where('detail_bahans.id', $this->id_detail_bahan)
								->first()
								->nama_barang;
        }
		

        $dataBahan = detailBahan::select('detail_bahans.id', 'bahans.nama_barang', 'nama_pekerjaans.nama_pekerjaan', 'mesins.nama_printer', 'detail_bahans.ukuran', 'detail_bahans.harga_jual')
                            ->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
                            ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                            ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
							->where('detail_bahans.id_level_customer', $this->idLevelCustomer)
							->where('nama_pekerjaans.id_mesin', $this->id_mesin_printer)
                            ->get();

        $sumTotal = DetailOrderKerja::select(DB::raw("SUM(total) as total"))->where('id_order_kerja', $this->id_order_kerja)->first();

        return view('livewire.order-kerja.edit-order-kerja', compact('data', 'dataCustomer', 'dataBahan', 'sumTotal', 'dataPrinter', 'dataLevelCustomer'))
        ->extends('layouts.apps', ['title' => 'Buat Orderan Baru']);
    }

    public function store()
    {
        $validate = $this->validate([
            'nama_file'     => 'required',
            'qty'           => 'required',
            'keterangan'    => 'required',
        ]);
        
        DB::transaction(function () { 
            $qty = $this->qty;
            $id_detail_bahan = $this->id_detail_bahan;
            $dataDetailBahan = detailBahan::select('id', 'id_pekerjaan', 'id_bahan')->where('id', $id_detail_bahan)->first();
            $id_pekerjaan = $dataDetailBahan->id_pekerjaan;
            $id_bahan = $dataDetailBahan->id_bahan;
            $hargaJual = detailBahan::select('harga_jual')
                                ->whereRaw("$qty BETWEEN min_qty AND max_qty")
                                ->where('id_pekerjaan', $id_pekerjaan)
                                ->where('id_bahan', $id_bahan)
								->where('id_level_customer', $this->idLevelCustomer)
                                ->first()->harga_jual;
            $stockItem = Bahan::select('stock')->where('id', $id_bahan)->first()->stock;

			$getUkuranBahan = detailBahan::where('detail_bahans.id', $id_detail_bahan)
                                ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                                ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                                ->first()->ukuran;

			// STOCK BARANG
								
            if( $getUkuranBahan == '' )
            {
                $ukuran = $this->ukuran;
                $ukuranReplace = str_replace(["X", "x"], "*", $ukuran); // 1.5*2.3
                $totalUkuran = eval("return $ukuranReplace;"); // 1.5*2.3 = 3.45
				
				$stockOut = $stockItem - ($totalUkuran * $qty);
				if( $stockOut < 0 ){
					$this->dispatchBrowserEvent('swal:modal', [
						'type' => 'warning',  
						'message' => 'Alert!', 
						'html' => 'Jumlah stock keluar input tidak boleh melebihi stok saat ini!. <br><b>Stock bahan sekarang: '.$stockItem.'</b>'
					]);
					return false;
				}
				else
				{
					TrackingStock::create([
						'id_bahan'              => $id_bahan,
						'id_detail_order_kerja' => $this->id_detail_order_kerja,
						'date'                  => date('Y-m-d'),
						'qty'                   => $qty,
						'keterangan'            => 'Barang keluar dari transaksi order kerja',
						'category'              => 'Out',
					]);
					DB::table('bahans')->where('id', $id_bahan)->update(array('stock' => $stockOut));
				}
				
            } else {
                $totalUkuran = $getUkuranBahan;
				$stockOut = $stockItem - $qty;
				if( $stockOut < 0 ){
					$this->dispatchBrowserEvent('swal:modal', [
						'type' => 'warning',  
						'message' => 'Alert!', 
						'html' => 'Jumlah stock keluar input tidak boleh melebihi stok saat ini!. <br><b>Stock bahan sekarang: '.$stockItem.'</b>'
					]);
					return false;
				}
				else{
					TrackingStock::create([
						'id_bahan'              => $id_bahan,
						'id_detail_order_kerja' => $this->id_detail_order_kerja,
						'date'                  => date('Y-m-d'),
						'qty'                   => $qty,
						'keterangan'            => 'Barang keluar dari transaksi order kerja',
						'category'              => 'Out',
					]);
					DB::table('bahans')->where('id', $id_bahan)->update(array('stock' => $stockOut));
				}
            }

            $getUkuran = detailBahan::where('detail_bahans.id', $id_detail_bahan)
                                ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                                ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                                ->first()->ukuran;

            if( $getUkuran == '' )
            {
                $ukuran = $this->ukuran;
                $ukuranReplace = str_replace(["X", "x"], "*", $ukuran); // 1.5*2.3
                $totalUkuran = eval("return $ukuranReplace;"); // 1.5*2.3 = 3.45
				if( $this->laminasi_meter > 0 )
				{
					$totalLaminasiMeter = (((float)$totalUkuran * (int)$qty) * (int)$this->laminasi_meter );
				} else {
					$totalLaminasiMeter = $this->laminasi_meter;
				}
				if( $this->cutting_meter > 0 )
				{
					$totalCuttingMeter = (((float)$totalUkuran * (int)$qty) * (int)$this->cutting_meter );
				} else {
					$totalCuttingMeter = $this->cutting_meter;
				}
				if( $this->laminasi_a3 > 0 )
				{
					$totalLaminasiA3 = 0;
				} else {
					$totalLaminasiA3 = $this->laminasi_a3;
				}
				if( $this->cutting_a3 > 0 )
				{
					$totalCuttingA3 = 0;
				} else {
					$totalCuttingA3 = $this->cutting_a3;
				}
                $total = (((float)$totalUkuran * (int)$qty) * (int)$hargaJual + (int)$totalLaminasiMeter + (int)$totalCuttingMeter );
            } else {
                $ukuran = $getUkuran;
				if( $this->laminasi_a3 > 0 )
				{
					$totalLaminasiA3 = ((int)$qty * (int)$this->laminasi_a3);
				} else {
					$totalLaminasiA3 = $this->laminasi_a3;
				}
				if( $this->cutting_a3 > 0 )
				{
					$totalCuttingA3 = ((int)$qty * (int)$this->cutting_a3);
				} else {
					$totalCuttingA3 = $this->cutting_a3;
				}
				if( $this->laminasi_meter > 0 )
				{
					$totalLaminasiMeter = 0;
				} else {
					$totalLaminasiMeter = $this->laminasi_meter;
				}
				if( $this->cutting_meter > 0 )
				{
					$totalCuttingMeter = 0;
				} else {
					$totalCuttingMeter = $this->cutting_meter;
				}
                $total = ((int)$hargaJual * (int)$qty + (int)$totalLaminasiA3 + (int)$totalCuttingA3);
            }

            // $cekReplace = str_replace(["X", "x", ".", ","], "", $ukuran); // 1523
            // $cek = is_numeric($cekReplace); // CEK NOMOR APA BUKAN
            // if ($cek === true) {  
            // } else { 
            // }
			// dd( $totalLaminasiMeter, $totalCuttingMeter, $totalLaminasiA3, $totalCuttingA3 );
            TrackingUser::create([
                'id_detail_order_kerja' => $this->id_detail_order_kerja,
                'id_user_produksi'      => Auth::user()->id,
                'id_user_finishing'     => Auth::user()->id,
                'id_user_taking'        => Auth::user()->id,
            ]);
			
            DetailOrderKerja::create([
                'id_order_kerja'    => $this->id_order_kerja,
                'id_detail_bahan'   => $this->id_detail_bahan,
                'nama_file'         => $this->nama_file,
                'ukuran'            => $ukuran,
                'qty'               => $this->qty,
                'harga'             => $hargaJual,
                'laminasi_meter'	=> $this->laminasi_meter,
                'cutting_meter'		=> $this->cutting_meter,
                'laminasi_a3'		=> $this->laminasi_a3,
                'cutting_a3'		=> $this->cutting_a3,
                'keterangan'        => $this->keterangan,
                'total'             => $total,
            ]);
            $this->resetInputFields();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Successfully!', 
                'text' => 'Data Berhasil Dibuat!.'
            ]);
            $this->emit('dataStore');

        });
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = DetailOrderKerja::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_detail_bahan = $data->id_detail_bahan;
        $this->nama_file = $data->nama_file;
        $this->ukuran = $data->ukuran;
        $this->laminasi_meter = $data->laminasi_meter;
        $this->cutting_meter = $data->cutting_meter;
        $this->laminasi_a3 = $data->laminasi_a3;
        $this->cutting_a3 = $data->cutting_a3;
        $this->qty = $data->qty;
        $this->keterangan = $data->keterangan;
    }

    public function update()
    {
        $validate = $this->validate([
            'nama_file'     => 'required',
            'qty'           => 'required',
            'keterangan'    => 'required',
        ]);

        DB::transaction(function () {
            $id = TrackingStock::select('id')->where('id_detail_order_kerja', $this->dataId)->first()->id;
            $id_detail_bahan = $this->id_detail_bahan;
            $id_bahan = detailBahan::select('id_bahan')->where('id', $id_detail_bahan)->first()->id_bahan;
            $qty = $this->qty;
            $qtyNow = TrackingStock::where('id', $id)->first()->qty;
            $stockItemNow = Bahan::where('id', $id_bahan)->first()->stock ?? 0;

			$getUkuranBahan = detailBahan::where('detail_bahans.id', $id_detail_bahan)
                                ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                                ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                                ->first()->ukuran;
								
			if( $getUkuranBahan == '' )
			{

				$ukuran = $this->ukuran;
				$ukuranReplace = str_replace(["X", "x"], "*", $ukuran); // 1.5*1
				$totalUkuran = eval("return $ukuranReplace;"); // 1.5*1 = 1.5

				if( ($qty * $totalUkuran) >= $qtyNow ){
					$difference = ($qty * $totalUkuran) - $qtyNow;
					$reduceStock = $stockItemNow - $difference;
					if( $reduceStock < 0 )
					{
						$this->dispatchBrowserEvent('swal:modal', [
							'type' => 'error',  
							'message' => 'Alert!', 
							'html' => 'Jumlah stock keluar input tidak boleh melebihi stok saat ini!. <br><b>Stock bahan sekarang: '.$stockItemNow.'</b>'
						]);
						return false;
					} else {
						DB::table('bahans')->where('id', $id_bahan)->update(array('stock' => $reduceStock));
						TrackingStock::where('id_detail_order_kerja', $this->dataId)->first()->update(array('qty' => $this->qty));
					}
				} else {
					$difference = $qtyNow - ($qty * $totalUkuran);
					$reduceStock = $stockItemNow + $difference;
					DB::table('bahans')->where('id', $id_bahan)->update(array('stock' => $reduceStock));
					TrackingStock::where('id_detail_order_kerja', $this->dataId)->first()->update(array('qty' => $this->qty));
				}

			} else {
				$ukuran = $getUkuranBahan;
			}


            if ($this->dataId) {

                $qty = $this->qty; // 5
                $id_detail_bahan = $this->id_detail_bahan; // 5
                $dataDetailBahan = detailBahan::select('id', 'id_pekerjaan', 'id_bahan')->where('id', $id_detail_bahan)->first();
                $id_pekerjaan = $dataDetailBahan->id_pekerjaan;
                $id_bahan = $dataDetailBahan->id_bahan;
                $hargaJual = detailBahan::select('harga_jual')
                                ->whereRaw("$qty BETWEEN min_qty AND max_qty")
                                ->where('id_pekerjaan', $id_pekerjaan)
                                ->where('id_bahan', $id_bahan)
								->where('id_level_customer', $this->idLevelCustomer)
                                ->first()->harga_jual;

                $getUkuran = detailBahan::where('detail_bahans.id', $id_detail_bahan)
                                ->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
                                ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
                                ->first()->ukuran;

                if( $getUkuran == '' )
                {
                    $ukuran = $this->ukuran;
                    $ukuranReplace = str_replace(["X", "x"], "*", $ukuran); // 1.5*1
                    $totalUkuran = eval("return $ukuranReplace;"); // 1.5*1 = 1.5
					if( $this->laminasi_meter > 0 )
					{
						$totalLaminasiMeter = (((float)$totalUkuran * (int)$qty) * (int)$this->laminasi_meter );
					} else {
						$totalLaminasiMeter = $this->laminasi_meter;
					}
					if( $this->cutting_meter > 0 )
					{
						$totalCuttingMeter = (((float)$totalUkuran * (int)$qty) * (int)$this->cutting_meter );
					} else {
						$totalCuttingMeter = $this->cutting_meter;
					}
					if( $this->laminasi_a3 > 0 )
					{
						$totalLaminasiA3 = 0;
					} else {
						$totalLaminasiA3 = $this->laminasi_a3;
					}
					if( $this->cutting_a3 > 0 )
					{
						$totalCuttingA3 = 0;
					} else {
						$totalCuttingA3 = $this->cutting_a3;
					}
					$total = (((float)$totalUkuran * (int)$qty) * (int)$hargaJual + (int)$totalLaminasiMeter + (int)$totalCuttingMeter );
                } else {
                    $ukuran = $getUkuran;
					if( $this->laminasi_a3 > 0 )
					{
						$totalLaminasiA3 = ((int)$qty * (int)$this->laminasi_a3);
					} else {
						$totalLaminasiA3 = $this->laminasi_a3;
					}
					if( $this->cutting_a3 > 0 )
					{
						$totalCuttingA3 = ((int)$qty * (int)$this->cutting_a3);
					} else {
						$totalCuttingA3 = $this->cutting_a3;
					}
					if( $this->laminasi_meter > 0 )
					{
						$totalLaminasiMeter = 0;
					} else {
						$totalLaminasiMeter = $this->laminasi_meter;
					}
					if( $this->cutting_meter > 0 )
					{
						$totalCuttingMeter = 0;
					} else {
						$totalCuttingMeter = $this->cutting_meter;
					}
					$total = ((int)$hargaJual * (int)$qty + (int)$totalLaminasiA3 + (int)$totalCuttingA3);
				}

                $data = DetailOrderKerja::findOrFail($this->dataId);
                $data->update([
                    'id_detail_bahan'   => $this->id_detail_bahan,
                    'nama_file'         => $this->nama_file,
                    'ukuran'            => $this->ukuran,
                    'laminasi_meter'	=> $this->laminasi_meter,
                    'cutting_meter'		=> $this->cutting_meter,
                    'laminasi_a3'		=> $this->laminasi_a3,
                    'cutting_a3'		=> $this->cutting_a3,
                    'qty'               => $this->qty,
                    'harga'             => $hargaJual,
                    'keterangan'        => $this->keterangan,
                    'total'             => $total,
                ]);
                $this->updateMode = false;
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'success',  
                    'message' => 'Successfully!', 
                    'text' => 'Data Updated Successfully!.'
                ]);
                $this->resetInputFields();
                $this->emit('dataStore');
            }
        });

        
    }

    public function deleteConfirm($id)
    {
        $this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal');
    }

    public function delete()
    {
        DB::transaction(function () {
            $dataTrackingStock = TrackingStock::where('id_detail_order_kerja', $this->idRemoved)->first();
        
            $id_bahan = $dataTrackingStock->id_bahan;
            $qty = $dataTrackingStock->qty;
            $stockItem = Bahan::select('stock')->where('id', $id_bahan)->first()->stock;
            
            $stockOut = $stockItem + $qty;

            DB::table('bahans')->where('id', $id_bahan)->update(array('stock' => $stockOut));
            $dataTrackingStock->delete();
        });

        $data = DetailOrderKerja::findOrFail($this->idRemoved);
        $data->delete();
        TrackingUser::where('id_detail_order_kerja', $this->idRemoved)->delete();
        if( $data ){
            $max = DB::table('detail_order_kerjas')->max('id') + 1; 
            DB::statement("ALTER TABLE detail_order_kerjas AUTO_INCREMENT = $max");
        }
        $this->resetInputFields();
    }

    public function storeOrder($total)
    {
		$data = ModelsOrderKerja::findOrFail($this->id_order_kerja);
        $data->update([
            'id'   				=> $this->id_order_kerja,
            'id_customer'   	=> $this->id_customer,
            'tanggal'       	=> $this->tanggal,
            'deadline'      	=> $this->deadline,
            'deadline_time' 	=> $this->deadline_time,
            'total'         	=> $total,
        ]);
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',  
            'message' => 'Successfully!', 
            'text' => 'Data Berhasil Diubah!.'
        ]);
        $this->emit('dataStore');
		if( Auth::user()->hasRole('admin') )
		{
			return redirect()->route('admin/data-transaksi');
		} else {
			return redirect()->route('data-transaksi');
		}
    }

    public function storeCustomer()
    {
        $validate = $this->validate([
            'id_level_customer' =>  'required',
            'nama_customer' =>  'required',
            'no_telepon' =>  'required'
        ]);

        Customer::create([
            'id_level_customer' => $this->id_level_customer,
            'nama_customer' => $this->nama_customer,
            'no_telepon'    => $this->no_telepon
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',  
            'message' => 'Successfully!', 
            'text' => 'Customer Berhasil Dibuat!.'
        ]);
        $this->emit('dataStore');
    }
}
