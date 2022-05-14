<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Harga</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Data Harga Bahan</h6>
            <p class="section-lead tw-text-xs">Mempunyai range quantity untuk transaksi.</p>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body card-primary">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select wire:model="id_kat" id="category" class="form-control">
								@foreach($dataKategori as $kategori)
									<option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
								@endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="level">Level User</label>
                            <select wire:model="id_level" id="level" class="form-control">
                                	<option value="0">ALL</option>
								@foreach($dataLevelCustomer as $levelCust)									
                                	<option value="{{ $levelCust->id }}">{{ $levelCust->nama_level }}</option>
								@endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
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
                            <table class="tw-w-full tw-text-black tw-text-sm tw-border-t mt-4">
                                <thead>
                                    <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
                                        <th class="p-3">Level</th>
                                        <th class="p-3">Prntr</th>
                                        <th class="p-3">NM PKRJN</th>
                                        <th class="p-3">Ukrn</th>
                                        <th class="p-3">Bhn</th>
                                        <th class="p-3">Rng Qty</th>
                                        <th class="p-3">Hrg Jual</th>
                                        <th class="p-3">Min Ord</th>
                                        <th class="p-3"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                    <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                        <td class="p-3"><span class="badge tw-bg-green-200">{{ $row->nama_level }}</span></td>
                                        <td class="p-3">{{ $row->nama_printer }}</td>
                                        <td class="p-3">{{ $row->nama_pekerjaan }}</td>
                                        <td class="p-3">{{ $row->ukuran }}</td>
                                        <td class="p-3">{{ $row->nama_barang }}</td>
                                        <td class="p-3">{{ $row->min_qty }} - {{ $row->max_qty }}</td>
                                        <td class="p-3 text-right">{{ number_format($row->harga_jual) }},00</td>
                                        <td class="p-3">{{ $row->min_order }}</td>
                                        <td class="p-3 text-center">
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#ubahDataModal" wire:click="edit({{ $row->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger"
                                                wire:click.prevent="deleteConfirm({{ $row->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center p-3">
                                        <td colspan="9">
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
        <button
            class="tw-fixed tw-right-[30px] tw-bottom-[50px] tw-w-14 tw-h-14 tw-shadow-2xl tw-rounded-full tw-bg-slate-600 tw-z-40 text-white hover:tw-bg-slate-900 hover:tw-border-slate-600"
            data-toggle="modal" data-target="#tambahDataModal">
            <i class="far fa-plus"></i>
        </button>
    </div>

    {{-- Tambah Data --}}
    <div class="modal fade" wire:ignore.self id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="nama_printer">Printer</label>
                                    <input type="text" name="nama_printer" id="nama_printer" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id_pekerjaan">Pekerjaan</label>
                                    <select wire:model="id_pekerjaan" id="id_pekerjaan" class="form-control">
                                        @foreach ($dataPekerjaan as $pekerjaan)
                                            <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->nama_printer }} - {{ $pekerjaan->nama_pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ukuran">Ukuran</label>
                                    <input type="text" wire:model="ukuran" id="ukuran" class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="id_bahan">Bahan</label>
									<select wire:model="id_bahan" id="id_bahan" class="form-control">
											<option selected disabled>-- Select Option --</option>
										@foreach ($dataBahan as $bahan)
											<option value="{{ $bahan->id }}">{{ $bahan->nama_barang }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="id_level_customer">Level Customer</label>
									<select wire:model="id_level_customer" id="id_level_customer" class="form-control">
										@foreach ($dataLevelCustomer as $level)
											<option value="{{ $level->id }}">{{ $level->nama_level }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
                        <div class="form-group">
                            <label>Range Qty</label>
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" wire:model="min_qty" id="min_qty" class="form-control">
                                </div>
                                <div class="col-2">
                                    -
                                </div>
                                <div class="col-5">
                                    <input type="text" wire:model="max_qty" id="max_qty" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="number" min="1" wire:model="harga_jual" id="harga_jual" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="min_order">Min Order</label>
                                    <input type="text" wire:model="min_order" id="min_order" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="store()" wire:loading.attr="disabled"
                            class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Data --}}
    <div class="modal fade" wire:ignore.self id="ubahDataModal" tabindex="-1" aria-labelledby="ubahDataModalLabel"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahDataModalLabel">Edit Data</h5>
                    <button type="button" wire:click.prevent='cancel()' class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <input type="hidden" wire:model='dataId'>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id_pekerjaan">Pekerjaan</label>
                                    <select wire:model="id_pekerjaan" id="id_pekerjaan" class="form-control">
                                        @foreach ($dataPekerjaan as $pekerjaan)
                                            <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->nama_printer }} - {{ $pekerjaan->nama_pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ukuran">Ukuran</label>
                                    <input type="text" wire:model="ukuran" id="ukuran" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id_bahan">Bahan</label>
                                    <select wire:model="id_bahan" id="id_bahan" class="form-control">
                                        @foreach ($dataBahan as $bahan)
                                        <option value="{{ $bahan->id }}">{{ $bahan->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Range Qty</label>
                            <div class="row">
                                <div class="col-5">
                                    <input type="text" wire:model="min_qty" id="min_qty" class="form-control">
                                </div>
                                <div class="col-2">
                                    -
                                </div>
                                <div class="col-5">
                                    <input type="text" wire:model="max_qty" id="max_qty" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga_jual">Harga Jual</label>
                                    <input type="number" min="1" wire:model="harga_jual" id="harga_jual" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="min_order">Min Order</label>
                                    <input type="text" wire:model="min_order" id="min_order" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click.prevent='cancel()' class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button wire:click.prevent="update()" wire:loading.attr="disabled" type="button"
                            class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@section('js')
<script>
    $(document).ready(function () {
        var id = {{ $id_pekerjaan }}
        get_data_printer()

        $('#id_pekerjaan').change(function (e) {
            var id = $(this).val()
            $.ajax({
                type: "GET",
                url: "/get-data-id-mesin/" + id,
                success: function (data) {
                    $.ajax({
                        type: "GET",
                        url: "/get-data-mesin-printer/" + data[0].id_mesin,
                        success: function (res) {
                            $('#nama_printer').val(res[0].nama_printer)
                        }
                    });
                }
            });
        })
    })

    function get_data_printer() {
        var id = {{ $id_pekerjaan }}
        $.ajax({
            type: "GET",
            url: "/get-data-id-mesin/" + id,
            success: function (data) {
                $.ajax({
                    type: "GET",
                    url: "/get-data-mesin-printer/" + data[0].id_mesin,
                    success: function (res) {
                        $('#nama_printer').val(res[0].nama_printer)
                    }
                });
            }
        });
    }

</script>
@endsection
