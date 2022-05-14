<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Pengambilan Barang</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Pengambilan Barang</h6>
            <p class="section-lead tw-text-xs">Data Pengambilan Barang didapatkan setelah selesai produksi.</p>
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
                                        <th class="p-3">Deadline</th>
                                        <th class="p-3">Desk</th>
                                        <th class="p-3">Op Prod</th>
                                        <th class="p-3">Customer</th>
                                        <th class="p-3">Nm File</th>
                                        <th class="p-3">Nm Pkrjn</th>
                                        <th class="p-3">Bahan</th>
                                        <th class="p-3">Ukuran</th>
                                        <th class="p-3">Qty</th>
                                        <th class="p-3">Ket</th>
                                        <th class="p-3"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                    <tr class="tw-bg-white tw-border-b tw-text-xs hover:tw-bg-gray-50">
                                        <td class="p-3">{{ $row->deadline }} {{ date('H:i', strtotime($row->deadline_time)) }}</td>
                                        <td class="p-3">{{ $row->name }}</td>
                                        <td class="p-3">{{ $row->name }}</td>
                                        <td class="p-3">{{ $row->nama_customer }}</td>
                                        <td class="p-3">{{ $row->nama_file }}</td>
                                        <td class="p-3">{{ $row->nama_pekerjaan }}</td>
                                        <td class="p-3">{{ $row->nama_barang }}</td>
                                        <td class="p-3">{{ $row->ukuran }}</td>
                                        <td class="p-3">{{ $row->qty }}</td>
                                        <td class="p-3">{{ $row->keterangan }}</td>
                                        <td class="p-3 text-center">
                                            @if ( $row->status == '3' )
                                            <button wire:click.prevent="konfirmasi({{ $row->id }})"
                                                class="btn btn-sm btn-outline-success">Proccess</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center p-3">
                                        <td colspan="11">
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
