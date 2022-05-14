<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer as ModelsCustomer;
use App\Models\LevelCustomer;

class Customer extends Component
{
    use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $nama_customer, $no_telepon, $id_level_customer;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

	public function mount()
	{
		$this->id_level_customer = LevelCustomer::min('id');
	}

    private function resetInputFields()
    {
        $this->nama_customer = '';
        $this->no_telepon = '';
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

		$dataLevelCustomer = LevelCustomer::get();

        $data = ModelsCustomer::select('customers.*', 'level_customers.nama_level')
					->join('level_customers', 'level_customers.id', 'customers.id_level_customer')
					->where('nama_customer', 'LIKE', $searchTerm)
                    ->orWhere('no_telepon', 'LIKE', $searchTerm)
                    ->orderBy('level_customers.nama_level', 'DESC')
                    ->paginate($lengthData);

        return view('livewire.customer.customer', compact('data', 'dataLevelCustomer'))
        ->extends('layouts.apps', ['title' => 'Customer']);
    }

    public function store()
    {
        $validate = $this->validate([
			'id_level_customer'	=> 'required',
            'nama_customer' 	=> 'required',
            'no_telepon'    	=> 'required',
        ]);
        ModelsCustomer::create([
			'id_level_customer' => $this->id_level_customer,
            'nama_customer' 	=> $this->nama_customer,
            'no_telepon'    	=> $this->no_telepon,
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
        $data = ModelsCustomer::where('id',$id)->first();
        $this->dataId = $id;
        $this->id_level_customer = $data->id_level_customer;
        $this->nama_customer = $data->nama_customer;
        $this->no_telepon = $data->no_telepon;
    }

    public function update()
    {
        $validate = $this->validate([
            'id_level_customer'	=> 'required',
            'nama_customer' 	=> 'required',
            'no_telepon'    	=> 'required',
        ]);

        if ($this->dataId) {
            $data = ModelsCustomer::findOrFail($this->dataId);
            $data->update([
                'id_level_customer' => $this->id_level_customer,
				'nama_customer' 	=> $this->nama_customer,
				'no_telepon'    	=> $this->no_telepon,
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
        $data = ModelsCustomer::findOrFail($this->idRemoved);
        $data->delete();
    }

}
