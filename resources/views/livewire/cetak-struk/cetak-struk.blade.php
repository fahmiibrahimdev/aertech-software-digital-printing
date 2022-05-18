<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Cetak Struk</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Data Cetak Struk</h6>
            <p class="section-lead tw-text-xs">Cetak Struk ini digunakan untuk mencetak transaksi ke laporan PDF.</p>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body px-0">
                        <div class="row mb-3 px-4">
                            <div class="col-4 col-lg-2">
                                <select class="form-control" wire:model='lengthData'>
                                    <option value="0" selected>-</option>
                                    <option value="1" selected>1</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-8 col-lg-4 ml-auto">
                                <input wire:model="searchTerm" type="search" class="form-control ml-auto"
                                    placeholder="Search here.." wire:model='searchTerm'>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-t mt-4">
                                <thead>
                                    <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
										<th class="p-3">ID</th>
                                        <th class="p-3">Nama Customer</th>
                                        <th class="p-3">Tanggal</th>
                                        <th class="p-3">Deadline</th>
                                        <th class="p-3">Total</th>
                                        <th class="p-3">St Pembayaran</th>
                                        <th class="p-3"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                    <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                        <td class="p-3 text-center">{{ $row->id }}</td>
                                        <td class="p-3 text-center">{{ $row->nama_customer }}</td>
                                        <td class="p-3 text-center">{{ $row->tanggal }}</td>
                                        <td class="p-3 text-center">{{ $row->deadline }} {{ $row->deadline_time }}</td>
                                        <td class="p-3">Rp <span class="float-right">{{ number_format($row->total) }},00</span></td>
                                        <td class="p-3 text-center">
											@if($row->status_lunas == "1")
												<i class="fas fa-badge-check text-success tw-text-[20px]"></i>
											@elseif( $row->status_lunas == "0" )
												<i class="fas fa-times text-danger tw-text-[20px]"></i>
											@else
												<span class="badge tw-bg-red-200">Belum Bayar</span>
											@endif
										</td>
										@if( $row->status_lunas == "1" || $row->status_lunas == "0"  ) 
                                        <td class="p-3 text-center">
                                            <a class="btn tw-bg-cyan-100" href="{{ url('cetak-invoice', $row->id) }}" target="blank"><i class="fas fa-print"></i> Cetak</a>
                                        </td>
                                        @else
                                        
                                        @endif
                                    </tr>
                                    @empty
                                    <tr class="text-center p-3">
                                        <td colspan="6">
                                            No data available in table
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive p-3">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
