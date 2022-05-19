<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Transaksi</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Data Transaksi</h6>
            <p class="section-lead tw-text-xs">Daftar Transaksi yang sudah dibuat.</p>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h4 class="tw-text-xl tw-text-black tw-font-bold tw-font-roboto">Data Transaksi <a class="btn btn-info ml-auto" href="@if(Auth::user()->hasRole('admin')){{ url('admin/data-transaksi') }} @else {{ url('data-transaksi') }} @endif"><i class="fas fa-sync"></i></a></h4>
                    </div>
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
                        <div class="table-responsive" wire:poll.5s>
                            <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-t mt-4">
                                <thead>
                                    <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
                                        <th class="p-3">Nama Customer</th>
                                        <th class="p-3">Tanggal</th>
                                        <th class="p-3">Deadline</th>
                                        <th class="p-3">Total</th>
                                        <th class="p-3"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        @if ($row->status_lunas == NULL)
                                        <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                            <td class="p-3">{{ $row->nama_customer }}</td>
                                            <td class="p-3">{{ $row->tanggal }}</td>
                                            <td class="p-3">{{ $row->deadline }} {{ $row->deadline_time }}</td>
                                            <td class="p-3">Rp{{ number_format($row->total, 0, ',', '.') }},00</td>
                                            <td class="p-3 text-center">
                                                <a href="@if(Auth::user()->hasRole('admin')){{ route('admin/pembayaran', Crypt::encrypt($row->id)) }}@else{{ route('pembayaran', Crypt::encrypt($row->id)) }}@endif" target="_BLANK" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-donate"></i>
                                                </a>
                                                <a href="@if( Auth::user()->hasRole('admin') ){{ url('admin/edit-order-kerja', $row->id) }}@else{{ url('edit-order-kerja', $row->id) }}@endif" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @else
                                            
                                        @endif
                                    @endforeach
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
        <button
            class="tw-fixed tw-right-[30px] tw-bottom-[50px] tw-w-14 tw-h-14 tw-shadow-2xl tw-rounded-full tw-bg-slate-600 tw-z-40 text-white hover:tw-bg-slate-900 hover:tw-border-slate-600"
            onclick="location.href='@if(Auth::user()->hasRole('admin')){{ url('admin/order-kerja') }}@else{{ url('admin/order-kerja') }}@endif'">
            <i class="far fa-plus"></i>
        </button>
    </div>

</div>
