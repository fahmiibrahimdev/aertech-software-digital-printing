<?php

namespace App\Http\Livewire\NamaPekerjaan;

use App\Models\Mesin;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\NamaPekerjaan as ModelsNamaPekerjaan;

class NamaPekerjaan extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
        'unkonfirmasiConfirmed' => 'unactive',
        'konfirmasiConfirmed' => 'active'
    ];
    public $id_mesin, $nama_pekerjaan;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

    private function resetInputFields()
    {
        $this->nama_pekerjaan = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
    
    public function mount()
    {
        $id_mesin = DB::table('mesins')->min('id');
        $this->id_mesin = $id_mesin;
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $lengthData = $this->lengthData;
        $data = ModelsNamaPekerjaan::select(DB::raw('nama_pekerjaans.id as appid'), 'nama_pekerjaans.*', 'mesins.*', 'kategoris.nama_kategori')
                    ->join('mesins', 'mesins.id', 'nama_pekerjaans.id_mesin')
					->join('kategoris', 'kategoris.id', 'mesins.id_kategori')
                    ->where('mesins.nama_printer', 'LIKE', $searchTerm)
                    ->orWhere('nama_pekerjaans.nama_pekerjaan', 'LIKE', $searchTerm)
                    ->orderBy('kategoris.nama_kategori', 'ASC')
                    ->paginate($lengthData);

        $dataMesin = Mesin::get();

        return view('livewire.nama-pekerjaan.nama-pekerjaan', compact('data', 'dataMesin'))
        ->extends('layouts.apps', ['title' => 'Nama Pekerjaan']);
    }

    public function store()
    {
        $validate = $this->validate([
            'id_mesin'  => 'required',
            'nama_pekerjaan'  => 'required|unique:nama_pekerjaans,nama_pekerjaan',
        ]);
        ModelsNamaPekerjaan::create([
            'id_mesin'  => $this->id_mesin,
            'nama_pekerjaan'  => $this->nama_pekerjaan,
            'lewat_produksi'  => '1',
            'lewat_finishing'  => '1',
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
        $data = ModelsNamaPekerjaan::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_mesin = $data->id_mesin;
        $this->nama_pekerjaan = $data->nama_pekerjaan;
    }

    public function update()
    {
        $validate = $this->validate([
            'id_mesin'  => 'required',
            'nama_pekerjaan'  => 'required',
        ]);

        if ($this->dataId) {
            $data = ModelsNamaPekerjaan::findOrFail($this->dataId);
            $data->update([
                'id_mesin'  => $this->id_mesin,
                'nama_pekerjaan'  => $this->nama_pekerjaan,
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
        $data = ModelsNamaPekerjaan::findOrFail($this->idRemoved);
        $data->delete();
    }

    public function unactive($id)
    {
        $this->idRemoved = $id;
        $data = ModelsNamaPekerjaan::findOrFail($this->idRemoved);
        $data->update(array('lewat_finishing' => '0'));
    }

    public function active($id)
    {
        $this->idRemoved = $id;
        $data = ModelsNamaPekerjaan::findOrFail($this->idRemoved);
        $data->update(array('lewat_finishing' => '1'));
    }

}
