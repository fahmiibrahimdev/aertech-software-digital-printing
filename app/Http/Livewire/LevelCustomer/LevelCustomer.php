<?php

namespace App\Http\Livewire\LevelCustomer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LevelCustomer as ModelsLevelCustomer;

class LevelCustomer extends Component
{
	use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $nama_level;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

	private function resetInputFields()
    {
        $this->nama_level = '';
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
		
		$data = ModelsLevelCustomer::where('nama_level', 'LIKE', $searchTerm)
				  ->orderBy('id', 'ASC')
				  ->paginate($lengthData);

		return view('livewire.level-customer.level-customer', compact('data'))
		  ->extends('layouts.apps', ['title' => 'Level Customer']);
    }

	public function store()
    {
        $validate = $this->validate([
            'nama_level'  => 'required'
        ]);
        ModelsLevelCustomer::create([
            'nama_level'  => $this->nama_level
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
        $data = ModelsLevelCustomer::where('id',$id)->first();
        $this->dataId = $id;
        $this->nama_level = $data->nama_level;
    }

    public function update()
    {
        $validate = $this->validate([
            'nama_level'  => 'required',
        ]);

        if ($this->dataId) {
            $data = ModelsLevelCustomer::findOrFail($this->dataId);
            $data->update([
                'nama_level'  => $this->nama_level,
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
        $data = ModelsLevelCustomer::findOrFail($this->idRemoved);
        $data->delete();
    }

}
