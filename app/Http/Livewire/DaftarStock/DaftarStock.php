<?php

namespace App\Http\Livewire\DaftarStock;

use App\Models\Bahan;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;

class DaftarStock extends Component
{
	use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'unkonfirmasiConfirmed' => 'unactive',
        'konfirmasiConfirmed' => 'active'
    ];
    public $id_pekerjaan, $nama_barang, $satuan, $id_kategori;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->nama_barang = '';
        $this->satuan = 'PCS';
    }

    private function resetInputFields()
    {
        $this->nama_barang = '';
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
		$dataKategori = Kategori::get();
        $data = Bahan::select('bahans.id', 'nama_barang', 'satuan', 'nama_kategori', 'stock')
					->join('kategoris', 'kategoris.id', 'bahans.id_kategori')
					->where('nama_barang', 'LIKE', $searchTerm)
					->orWhere('satuan', 'LIKE', $searchTerm)
					->orWhere('stock', 'LIKE', $searchTerm)
					->orWhere('nama_kategori', 'LIKE', $searchTerm)
					->orderBy('nama_kategori', 'ASC')
					->paginate($lengthData);

        return view('livewire.daftar-stock.daftar-stock', compact('data', 'dataKategori'))
        ->extends('layouts.apps', ['title' => 'Data Bahan']);
    }

    public function store()
    {
        $validate = $this->validate([
			'id_kategori'		=> 'required',
            'nama_barang'       => 'required',
            'satuan'            => 'required',
        ]);
        Bahan::create([
			'id_kategori'		=> $this->id_kategori,
            'nama_barang'       => $this->nama_barang,
            'satuan'            => $this->satuan,
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
        $data = Bahan::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_kategori = $data->id_kategori;
        $this->nama_barang = $data->nama_barang;
        $this->satuan = $data->satuan;
    }

    public function update()
    {
        $validate = $this->validate([
			'id_kategori'		=> 'required',
            'nama_barang'       => 'required',
            'satuan'            => 'required',
        ]);

        if ($this->dataId) {
            $data = Bahan::findOrFail($this->dataId);
            $data->update([
				'id_kategori'		=> $this->id_kategori,
                'nama_barang'       => $this->nama_barang,
                'satuan'            => $this->satuan,
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
        $data = Bahan::findOrFail($this->idRemoved);
        $data->delete();
        $this->resetInputFields();
    }
}
