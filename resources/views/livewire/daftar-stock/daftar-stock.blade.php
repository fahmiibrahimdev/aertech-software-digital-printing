<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Stock Bahan</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Daftar Stock Bahan</h6>
            <p class="section-lead tw-text-xs">Daftar Stock bahan ini berguna untuk melihat stock bahan sekarang.</p>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="tw-text-xl tw-text-black tw-font-bold tw-font-roboto">Data Stock Bahan</h4>
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
                                    <option value="100">100</option>
                                    <option value="250">250</option>
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
                                        <th class="p-3">Nama Kategori</th>
                                        <th class="p-3">Nama Barang</th>
                                        <th class="p-3">Stock</th>
                                        <th class="p-3">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                    <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                        <td class="p-3">{{ $row->nama_kategori }}</td>
                                        <td class="p-3">{{ $row->nama_barang }}</td>
                                        <td class="p-3 text-right">{{ $row->stock }}.00</td>
                                        <td class="p-3">{{ $row->satuan }}</td>
                                    </tr>
                                    @empty
                                    <tr class="text-center p-3">
                                        <td colspan="3">
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
