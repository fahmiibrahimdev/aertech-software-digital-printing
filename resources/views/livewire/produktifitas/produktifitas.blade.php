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
                                        <th class="p-3">Layan</th>
                                        <th class="p-3">L-A(1)</th>
                                        <th class="p-3">Bayar</th>
                                        <th class="p-3">B-L(2)</th>
                                        <th class="p-3">Opr Prod</th>
                                        <th class="p-3">P-B(3)</th>
                                        <th class="p-3">Opr Finish</th>
                                        <th class="p-3">Sls Finish</th>
                                        <th class="p-3">F-P(4)</th>
                                        <th class="p-3">Ambl Brg</th>
                                        <th class="p-3">Jam</th>
                                        <th class="p-3">Total</th>
                                        <th class="p-3">Deadline</th>
                                        <th class="p-3">+/-</th>
                                        <th class="p-3"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                    <tr class="tw-bg-white tw-border-b tw-text-xs hover:tw-bg-gray-50">
                                        <td class="p-3">{{ $row->time_layanan }}</td>
                                        <td class="p-3">00:00</td>
                                        <td class="p-3">{{ $row->time_pembayaran }}</td>
                                        <td class="p-3">{{ $row->time_pembayaran - $row->time_layanan }}</td>
                                    </tr>
                                    @empty
                                    <tr class="text-center p-3">
                                        <td colspan="15">
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
