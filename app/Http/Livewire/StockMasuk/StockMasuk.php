<?php

namespace App\Http\Livewire\StockMasuk;

use App\Models\Bahan;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\TrackingStock;
use Illuminate\Support\Facades\DB;

class StockMasuk extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $id_bahan, $date, $qty, $keterangan, $category;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';
    
    public function mount()
    {
        $id_bahan = DB::table('bahans')->min('id');
        $this->id_bahan = $id_bahan;
        $this->date = date('Y-m-d');
        $this->qty = 1;
        $this->keterangan = '-';
    }

    private function resetInputFields()
    {
        $id_bahan = DB::table('bahans')->min('id');
        $this->id_bahan = $id_bahan;
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
        $searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;

        $dataBahan = Bahan::get();

        $data = TrackingStock::select('tracking_stocks.*', 'bahans.nama_barang')
                    ->join('bahans', 'bahans.id', 'tracking_stocks.id_bahan')
                    ->where('category', 'In')
                    ->where(function($query) use ($searchTerm) {
                        $query->where('nama_barang', 'LIKE', $searchTerm);
                        $query->orWhere('date', 'LIKE', $searchTerm);
                        $query->orWhere('qty', 'LIKE', $searchTerm);
                        $query->orWhere('keterangan', 'LIKE', $searchTerm);
                    })
                    ->orderBy('id', 'ASC')
                    ->paginate($lengthData);

        return view('livewire.stock-masuk.stock-masuk', compact('data', 'dataBahan'))
        ->extends('layouts.apps', ['title' => 'Stock Masuk']);
    }

    public function store()
    {
        $validate = $this->validate([
            'date'                  => 'required',
            'qty'                   => 'required',
        ]);

        DB::transaction(function () {

            $dataItem = Bahan::where('id', $this->id_bahan)->first();
            $stockBahan = Bahan::select('stock')->where('id', $this->id_bahan)->first()->stock ?? 0;
            $sum = $stockBahan + $this->qty;
            TrackingStock::create([
                'id_bahan'              => $this->id_bahan,
                'id_detail_order_kerja' => '-',
                'date'                  => $this->date,
                'qty'                   => $this->qty,
                'keterangan'            => $this->keterangan,
                'category'              => 'In',
            ]);
            $dataItem->update([
                'stock' => $sum
            ]);
            $this->resetInputFields();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Successfully!', 
                'text' => 'Stock Berhasil Ditambahkan!.'
            ]);
            $this->emit('dataStore');

        });

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = TrackingStock::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_bahan = $data->id_bahan;
        $this->date = $data->date;
        $this->qty = $data->qty;
        $this->keterangan = $data->keterangan;
    }

    public function update(Request $request)
    {
        $validate = $this->validate([
            'date'                  => 'required',
            'qty'                   => 'required',
        ]);
        
        DB::transaction(function () {
            $qty = $this->qty;
            $qtyIn = TrackingStock::where('id', $this->dataId)->first()->qty;
            
            if( $qty >= $qtyIn )
            {
                $stockQty = $qty - $qtyIn;
                $stockBahan = Bahan::where('id', $this->id_bahan)->first()->stock;
                $stockIn = $stockBahan + $stockQty;
                DB::table('bahans')->where('id', $this->id_bahan)->update(array('stock' => $stockIn));
            }
            else
            {
                $stockQty = $qty - $qtyIn; 
                $stockBahan = Bahan::where('id', $this->id_bahan)->first()->stock;
                $stockIn = $stockBahan + $stockQty;
                DB::table('bahans')->where('id', $this->id_bahan)->update(array('stock' => $stockIn));
            }

            if ($this->dataId) {
                $data = TrackingStock::findOrFail($this->dataId);
                $data->update([
                    'date'                  => $this->date,
                    'qty'                   => $this->qty,
                    'keterangan'            => $this->keterangan,
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
            $data = TrackingStock::findOrFail($this->idRemoved);

            $id_bahan = $data->id_bahan;
            $qty = $data->qty;
            $stockBahan = Bahan::select('stock')->where('id', $id_bahan)->first()->stock;
            $stock = $stockBahan - $qty;
    
            DB::table('bahans')->where('id', $id_bahan)->update(array('stock' => $stock));
            $data->delete();  
        });
    }

}
