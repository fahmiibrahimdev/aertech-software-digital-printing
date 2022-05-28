<?php

namespace App\Http\Livewire\RekapData;

use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Component;

class RekapData extends Component
{
	public $dari_tanggal, $sampai_tanggal;
	public $start_date, $end_date;

	public function mount()
	{
		$this->dari_tanggal = date('Y-m-d');
		$this->sampai_tanggal = date('Y-m-d');

		$this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
		$this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
		
	}

    public function render()
    {
		$dataCustomer = Customer::where('id_level_customer', 2)->get();
        return view('livewire.rekap-data.rekap-data', compact('dataCustomer'))
		->extends('layouts.apps', ['title' => 'Rekap Data']);
    }
}
