<?php

namespace App\Http\Livewire\RekapData;

use Livewire\Component;

class PrintDataOrder extends Component
{
	public $start_date, $end_date;

	public function mount($startDate, $endDate)
	{

	}

    public function render()
    {
        return view('livewire.rekap-data.print-data-order');
    }
}
