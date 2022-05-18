<?php

namespace App\Http\Livewire\DetailBahan;

use App\Models\Bahan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\detailBahan as ModelsDetailBahan;
use App\Models\Kategori;
use App\Models\LevelCustomer;
use App\Models\NamaPekerjaan;

class DetailBahan extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $id_pekerjaan, $id_bahan, $ukuran, $min_qty, $max_qty, $harga_jual, $min_order, $id_level_customer, $id_kat, $id_level;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
		$this->id_kat = Kategori::min('id');
		$this->id_level = 0;
        $this->id_pekerjaan = NamaPekerjaan::min('id');
        $this->id_bahan = Bahan::min('id');
		$this->id_level_customer = LevelCustomer::min('id');
        $this->ukuran = '';
        $this->min_qty = 1;
        $this->max_qty= 999;
        $this->harga_jual = 0;
        $this->min_order = 1;
    }

    private function resetInputFields()
    {
        $this->ukuran = '';
        $this->min_qty = 1;
        $this->max_qty= 999;
        $this->harga_jual = 0;
        $this->min_order = 1;
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

		

        $dataPekerjaan = NamaPekerjaan::select('nama_pekerjaans.id', 'nama_pekerjaans.nama_pekerjaan', 'mesins.nama_printer')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->join('kategoris', 'kategoris.id', 'mesins.id_kategori')
						->orderBy('kategoris.nama_kategori', 'ASC')
						->get();

		$searchBahan = NamaPekerjaan::select('kategoris.id')
						->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
						->join('kategoris', 'kategoris.id', 'mesins.id_kategori')
						->where('nama_pekerjaans.id', $this->id_pekerjaan)
						->orderBy('kategoris.nama_kategori', 'ASC')
						->first()->id;
						
		$dataLevelCustomer = LevelCustomer::get();
		$dataKategori = Kategori::get();
        $dataBahan = Bahan::select('bahans.id', 'bahans.nama_barang')
						->join('kategoris', 'kategoris.id', 'bahans.id_kategori')
						->where('kategoris.id', $searchBahan)
						->get();

		if( $this->id_level == 0 )
		{
			$data = ModelsDetailBahan::select('detail_bahans.id', 'bahans.nama_barang', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_bahans.ukuran', 'detail_bahans.min_qty', 'detail_bahans.max_qty', 'detail_bahans.harga_jual', 'detail_bahans.min_order', 'level_customers.nama_level', 'kategoris.nama_kategori')
			->join('level_customers', 'level_customers.id', 'detail_bahans.id_level_customer')
			->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
			->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
			->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
			->join('kategoris', 'kategoris.id', 'mesins.id_kategori')
			->where(function($query) use ($searchTerm) {
				$query->where('mesins.nama_printer', 'LIKE', $searchTerm);
				$query->orWhere('bahans.nama_barang', 'LIKE', $searchTerm);
				$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
				$query->orWhere('detail_bahans.ukuran', 'LIKE', $searchTerm);
				$query->orWhere('detail_bahans.min_qty', 'LIKE', $searchTerm);
				$query->orWhere('detail_bahans.max_qty', 'LIKE', $searchTerm);
				$query->orWhere('detail_bahans.harga_jual', 'LIKE', $searchTerm);
				$query->orWhere('detail_bahans.min_order', 'LIKE', $searchTerm);
			})
			->orderBy('level_customers.nama_level', 'ASC')
			->orderBy('bahans.nama_barang', 'ASC')
			->paginate($lengthData);
		} else {
			$data = ModelsDetailBahan::select('detail_bahans.id', 'bahans.nama_barang', 'mesins.nama_printer', 'nama_pekerjaans.nama_pekerjaan', 'detail_bahans.ukuran', 'detail_bahans.min_qty', 'detail_bahans.max_qty', 'detail_bahans.harga_jual', 'detail_bahans.min_order', 'level_customers.nama_level', 'kategoris.nama_kategori')
					->join('level_customers', 'level_customers.id', 'detail_bahans.id_level_customer')
					->join('bahans', 'bahans.id', 'detail_bahans.id_bahan')
					->join('nama_pekerjaans', 'nama_pekerjaans.id', 'detail_bahans.id_pekerjaan')
					->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
					->join('kategoris', 'kategoris.id', 'mesins.id_kategori')
					->where('kategoris.id', $this->id_kat)
					->where('level_customers.id', $this->id_level)
					->where(function($query) use ($searchTerm) {
						$query->where('mesins.nama_printer', 'LIKE', $searchTerm);
						$query->orWhere('bahans.nama_barang', 'LIKE', $searchTerm);
						$query->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm);
						$query->orWhere('detail_bahans.ukuran', 'LIKE', $searchTerm);
						$query->orWhere('detail_bahans.min_qty', 'LIKE', $searchTerm);
						$query->orWhere('detail_bahans.max_qty', 'LIKE', $searchTerm);
						$query->orWhere('detail_bahans.harga_jual', 'LIKE', $searchTerm);
						$query->orWhere('detail_bahans.min_order', 'LIKE', $searchTerm);
					})
					->orderBy('mesins.nama_printer', 'ASC')
					->paginate($lengthData);
		}

        

        return view('livewire.detail-bahan.detail-bahan', compact('data', 'dataPekerjaan', 'dataBahan', 'dataLevelCustomer', 'dataKategori'))
        ->extends('layouts.apps', ['title' => 'Data Harga Bahan']);
    }

    public function store()
    {
        $validate = $this->validate([
			'id_level_customer'	=> 'required',
            'id_bahan'      	=> 'required',
            'id_pekerjaan'  	=> 'required',
            'min_qty'       	=> 'required',
            'max_qty'       	=> 'required',
            'harga_jual'    	=> 'required',
            'min_order'     	=> 'required',
        ]);
        ModelsDetailBahan::create([
            'id_level_customer'	=> $this->id_level_customer,
            'id_bahan'      	=> $this->id_bahan,
            'id_pekerjaan'  	=> $this->id_pekerjaan,
            'ukuran'        	=> $this->ukuran,
            'min_qty'       	=> $this->min_qty,
            'max_qty'       	=> $this->max_qty,
            'harga_jual'    	=> $this->harga_jual,
            'min_order'     	=> $this->min_order,
        ]);
        $this->resetInputFields();
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',  
            'message' => 'Successfully!', 
            'text' => 'Data Berhasil Dibuat!.'
        ]);
        $this->emit('dataStore');
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = ModelsDetailBahan::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_level_customer = $data->id_level_customer;
        $this->id_bahan = $data->id_bahan;
        $this->id_pekerjaan = $data->id_pekerjaan;
        $this->ukuran = $data->ukuran;
        $this->min_qty = $data->min_qty;
        $this->max_qty = $data->max_qty;
        $this->harga_jual = $data->harga_jual;
        $this->min_order = $data->min_order;
    }

    public function update()
    {
        $validate = $this->validate([
			'id_level_customer'	=> 'required',
            'id_bahan'      	=> 'required',
            'id_pekerjaan'  	=> 'required',
            'min_qty'       	=> 'required',
            'max_qty'       	=> 'required',
            'harga_jual'    	=> 'required',
            'min_order'     	=> 'required',
        ]);

        if ($this->dataId) {
            $data = ModelsDetailBahan::findOrFail($this->dataId);
            $data->update([
				'id_level_customer'	=> $this->id_level_customer,
                'id_bahan'      	=> $this->id_bahan,
                'id_pekerjaan'  	=> $this->id_pekerjaan,
                'ukuran'        	=> $this->ukuran,
                'min_qty'       	=> $this->min_qty,
                'max_qty'       	=> $this->max_qty,
                'harga_jual'    	=> $this->harga_jual,
                'min_order'     	=> $this->min_order,
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
    }

    public function deleteConfirm($id)
    {
        $this->idRemoved = $id;
        $this->dispatchBrowserEvent('swal');
    }

    public function delete()
    {
        $data = ModelsDetailBahan::findOrFail($this->idRemoved);
        $data->delete();
    }

}
