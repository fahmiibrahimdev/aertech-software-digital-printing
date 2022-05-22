<?php

namespace App\Http\Livewire\Pengeluaran;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengeluaran as ModelsPengeluaran;

class Pengeluaran extends Component
{
	use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
    public $tanggal, $keterangan, $jumlah, $dariTanggal, $sampaiTanggal;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

	public function mount()
	{
		$this->dariTanggal = date('Y-m-d', strtotime('first day of this month'));
        $this->sampaiTanggal = date('Y-m-d', strtotime('last day of this month'));
		$this->tanggal = date('Y-m-d');
        $this->keterangan = '-';
        $this->jumlah = 0;
	}

    private function resetInputFields()
    {
        $this->keterangan = '-';
        $this->jumlah = 0;
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
		$data 		= ModelsPengeluaran::whereBetween('tanggal', 
						[$this->dariTanggal, $this->sampaiTanggal]
					)
					->where(function($query) use ($searchTerm) {
						$query->where('tanggal', 'LIKE', $searchTerm);
						$query->orWhere('jumlah', 'LIKE', $searchTerm);
						$query->orWhere('keterangan', 'LIKE', $searchTerm);
					})
                    ->orderBy('tanggal', 'DESC')
                    ->paginate($lengthData);
		$total = ModelsPengeluaran::whereBetween('tanggal', 
					[$this->dariTanggal, $this->sampaiTanggal]
				)->sum('jumlah');

		return view('livewire.pengeluaran.pengeluaran', compact('data', 'total'))
        ->extends('layouts.apps', ['title' => 'Data Pengeluaran']);
    }

    public function store()
    {
        $validate = $this->validate([
            'jumlah'   		=> 'required',
            'keterangan'  	=> 'required',
            'tanggal'  		=> 'required',
        ]);
        ModelsPengeluaran::create([
            'jumlah'   		=> $this->jumlah,
            'tanggal'  		=> $this->tanggal,
            'keterangan'  	=> $this->keterangan,
        ]);
        $this->resetInputFields();
        $this->dispatchBrowserEvent('swal:modal', [
            'type' 		=> 'success',  
            'message' 	=> 'Successfully!', 
            'text' 		=> 'Data Berhasil Dibuat!.'
        ]);
        $this->emit('dataStore');
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = ModelsPengeluaran::where('id',$id)->first();
        $this->dataId = $id;
        $this->jumlah = $data->jumlah;
        $this->tanggal = $data->tanggal;
        $this->keterangan = $data->keterangan;
    }

    public function update()
    {
        $validate = $this->validate([
            'jumlah'   		=> 'required',
            'tanggal'  		=> 'required',
            'keterangan'  	=> 'required',
        ]);
        if ($this->dataId) {
            $data = ModelsPengeluaran::findOrFail($this->dataId);
            $data->update([
                'jumlah'   		=> $this->jumlah,
                'tanggal'  		=> $this->tanggal,
                'keterangan'  	=> $this->keterangan,
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
        $data = ModelsPengeluaran::findOrFail($this->idRemoved);
        $data->delete();
    }

}
