<?php

namespace App\Http\Livewire\Mesin;

use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Mesin as ModelsMesin;

class Mesin extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'unkonfirmasiConfirmed' => 'unactive',
        'konfirmasiConfirmed' => 'active'
    ];
    public $kode_printer, $nama_printer, $id_kategori;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

	public function mount()
	{
		$this->id_kategori = Kategori::min('id');
	}

    private function resetInputFields()
    {
        $this->kode_printer = '';
        $this->nama_printer = '';
        $this->id_kategori = Kategori::min('id');
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
        $data = ModelsMesin::select('mesins.id', 'mesins.kode_printer', 'mesins.nama_printer', 'kategoris.nama_kategori')
					->join('kategoris', 'kategoris.id', 'mesins.id_kategori')
					->where('mesins.kode_printer', 'LIKE', $searchTerm)
                    ->orWhere('mesins.nama_printer', 'LIKE', $searchTerm)
                    ->orWhere('kategoris.nama_kategori', 'LIKE', $searchTerm)
                    ->orderBy('mesins.id', 'ASC')
                    ->paginate($lengthData);

        return view('livewire.mesin.mesin', compact('data', 'dataKategori'))
        ->extends('layouts.apps', ['title' => 'Data Mesin']);
    }

    public function store()
    {
        $validate = $this->validate([
            'id_kategori'   => 'required',
            'kode_printer'  => 'required',
            'nama_printer'  => 'required',
        ]);
        ModelsMesin::create([
            'id_kategori'   => $this->id_kategori,
            'kode_printer'  => $this->kode_printer,
            'nama_printer'  => $this->nama_printer,
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
        $data = ModelsMesin::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_kategori = $data->id_kategori;
        $this->kode_printer = $data->kode_printer;
        $this->nama_printer = $data->nama_printer;
    }

    public function update()
    {
        $validate = $this->validate([
            'id_kategori'   => 'required',
            'kode_printer'  => 'required',
            'nama_printer'  => 'required',
        ]);
        if ($this->dataId) {
            $data = ModelsMesin::findOrFail($this->dataId);
            $data->update([
                'id_kategori'   => $this->id_kategori,
                'kode_printer'  => $this->kode_printer,
                'nama_printer'  => $this->nama_printer,
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
        $data = ModelsMesin::findOrFail($this->idRemoved);
        $data->delete();
    }

    public function unactive($id)
    {
        $this->idRemoved = $id;
        $data = ModelsMesin::findOrFail($this->idRemoved);
        $data->update(array('status_perkalian_ukuran' => '0'));
    }

    public function active($id)
    {
        $this->idRemoved = $id;
        $data = ModelsMesin::findOrFail($this->idRemoved);
        $data->update(array('status_perkalian_ukuran' => '1'));
    }

}
