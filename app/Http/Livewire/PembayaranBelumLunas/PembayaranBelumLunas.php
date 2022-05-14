<?php

namespace App\Http\Livewire\PembayaranBelumLunas;

use Livewire\Component;
use App\Models\OrderKerja;
use App\Models\Pembayaran;
use Livewire\WithPagination;

class PembayaranBelumLunas extends Component
{
	use WithPagination;
    protected $listeners = [
        'deleteConfirmed' => 'delete',
    ];
	public $total_net, $sisa_kurang, $bayar_dp;
    public $searchTerm, $lengthData;
    public $updateMode = false;
    public $idRemoved = null;
    protected $paginationTheme = 'bootstrap';

	private function resetInputFields()
    {
        $this->total_net = 0;
        $this->sisa_kurang = 0;
        $this->bayar_dp = 0;
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
		$data = OrderKerja::select('order_kerjas.*', 'customers.nama_customer', 'pembayarans.sisa_kurang', 'pembayarans.bayar_dp', 'pembayarans.updated_at', 'pembayarans.total_net')
                    ->join('customers', 'customers.id', 'order_kerjas.id_customer')
                    ->leftJoin('pembayarans', 'pembayarans.id_order_kerja', 'order_kerjas.id')
					->where('pembayarans.status_lunas', "0")
					->where(function($query) use ($searchTerm)
					{
						$query->where('order_kerjas.tanggal', 'LIKE', $searchTerm);
						$query->orWhere('order_kerjas.deadline', 'LIKE', $searchTerm);
						$query->orWhere('order_kerjas.deadline_time', 'LIKE', $searchTerm);
						$query->orWhere('order_kerjas.total', 'LIKE', $searchTerm);
						$query->orWhere('customers.nama_customer', 'LIKE', $searchTerm);
					})
                    ->orderBy('id', 'DESC')
                    ->paginate($lengthData);
					
        return view('livewire.pembayaran-belum-lunas.pembayaran-belum-lunas', compact('data'))
		->extends('layouts.apps', ['title' => 'Pembayaran Belum Lunas']);
    }

	public function edit($id)
	{
		$this->updateMode = true;
        $data = Pembayaran::where('id_order_kerja',$id)->first();
        $this->dataId = $id;
        $this->total_net = $data->total_net;
        $this->bayar_dp = $data->bayar_dp;
        $this->sisa_kurang = $data->sisa_kurang;
	}

	public function update()
    {
        $validate = $this->validate([
            'bayar_dp'   => 'required',
        ]);

		if( $this->bayar_dp > $this->total_net )
		{
			$this->dispatchBrowserEvent('swal:modal', [
				'type' => 'warning',  
				'message' => 'Alert!', 
				'html' => 'Pembayaran tidak boleh lebih dari sisa kurang!'
			]);
			return false;
		} else {
			if ($this->dataId) {
				$total_sisa_kurang = (int)$this->total_net - (int)$this->bayar_dp;
				if( $total_sisa_kurang == 0 )
				{
					$data = Pembayaran::findOrFail($this->dataId);
					$data->update([
						'bayar_dp'   	=> $this->bayar_dp,
						'sisa_kurang'   => $total_sisa_kurang,
						'status_lunas'	=> 1,
					]);
				} else {
					$data = Pembayaran::findOrFail($this->dataId);
					$data->update([
						'bayar_dp'   	=> $this->bayar_dp,
						'sisa_kurang'   => $total_sisa_kurang,
						'status_lunas'	=> 0,
					]);
				}
				
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
        
    }
}
