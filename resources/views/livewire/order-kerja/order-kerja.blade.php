<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Order Kerja {{ $id_order_kerja }}</h4>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group text-uppercase">
                                        <label for="total_hargaa">TOTAL HARGA TRANSAKSI</label>
                                        <input type="text" name="total_hargaa" id="total_hargaa" class="form-control"
                                            style="padding: 67px; font-size: 30px; font-weight: bold; text-align: center;"
                                            readonly value="Rp{{ number_format($sumTotal->total) }}">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
														<div class="input-group-text" data-toggle="modal"
															data-target="#tambahDataCustomerModal"><i class="fas fa-users"></i></div>
													</div>
                                                    <input type="date" wire:model="tanggal" id="tanggal"
                                                    class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="deadline">Deadline</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                    </div>
                                                    <input type="date" wire:model="deadline" id="deadline"
                                                    class="form-control">
                                                </div>
                                            </div>
                                        </div>
										<div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="deadline_time">Deadline Time</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="fas fa-calendar"></i></div>
                                                    </div>
                                                    <input type="time" wire:model="deadline_time" id="deadline_time"
                                                    class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
										<label for="id_customer">Customer</label>
										<div wire:ignore>
											<select wire:model="id_customer" id="id_customer" class="form-control">
												@foreach ($dataCustomer as $customer)
												<option value="{{ $customer->id }}">
													({{ preg_replace('/(?<=\d)(?=(\d{4})+$)/', '-', $customer->no_telepon) }})
													{{ $customer->nama_customer }} - {{ $customer->nama_level }}</option>
												@endforeach
											</select>
										</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" wire:click.prevent="storeOrder({{ $sumTotal->total }})"
                                    wire:loading.attr="disabled" class="btn btn-outline-info form-control">Save
                                    Data</button>
                            </div>
                        </form>
                        <div class="card card-primary mt-3">
                            <div class="card-header">
                                <h4 class="tw-text-xl tw-text-black tw-font-bold tw-font-roboto">Form Order Kerja</h4>
                            </div>
                            <div class="card-body px-0">
                                <div class="table-responsive">
                                    <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-t">
                                        <thead>
                                            <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
                                                <th class="p-3">Nama File</th>
                                                <th class="p-3">Mesin</th>
                                                <th class="p-3">Pekerjaan</th>
                                                <th class="p-3">Bahan</th>
                                                <th class="p-3">Ukuran</th>
                                                <th class="p-3">Qty</th>
                                                <th class="p-3">Harga</th>
                                                <th class="p-3">Total</th>
                                                <th class="p-3">Ket</th>
                                                <th class="p-3"><span></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $row)
                                            <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                                <td class="p-3">{{ $row->nama_file }}</td>
                                                <td class="p-3">{{ $row->nama_printer }}</td>
                                                <td class="p-3">{{ $row->nama_pekerjaan }}</td>
                                                <td class="p-3">{{ $row->nama_barang }}</td>
                                                <td class="p-3">{{ $row->ukuran }}</td>
                                                <td class="p-3 text-right">{{ $row->qty }}</td>
                                                <td class="p-3 text-right">{{ number_format($row->harga) }}</td>
                                                <td class="p-3 text-right">{{ number_format($row->total) }}</td>
                                                <td class="p-3">{{ $row->keterangan }}</td>
                                                <td class="p-3 text-center">
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#ubahDataModal" wire:click="edit({{ $row->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger"
                                                        wire:click.prevent="deleteConfirm({{ $row->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="text-center p-3">
                                                <td colspan="10">
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
                        <input type="hidden" wire:model='id_detail_order_kerja'>
                        <div class="form-group">
                            <label for="nama_file">Nama File</label>
                            <input type="text" wire:model="nama_file" id="nama_file" class="form-control"
                                placeholder="contoh.pdf">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
									<label for="id_mesin_printer">Mesin Printer</label>
									<select wire:model="id_mesin_printer" id="id_mesin_printer" class="form-control">
										@foreach ($dataPrinter as $printer)
											<option value="{{ $printer->id }}">{{ $printer->nama_printer }}</option>
										@endforeach
									</select>
								</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
									<label for="id_detail_bahan">Nama Pekerjaan</label>
									<select wire:model="id_detail_bahan" id="id_detail_bahan" class="form-control">
									<option selected disabled>-- Select Option --</option>
										@foreach ($dataBahan as $bahan)
											<option value="{{ $bahan->id }}">{{ $bahan->nama_pekerjaan }} - {{ $bahan->nama_barang }} | {{ $bahan->ukuran }} | Rp{{ number_format($bahan->harga_jual) }}</option>
										@endforeach
									</select>
								</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Bahan</label>
                            <input type="text" wire:model='nama_barang' class="form-control" id="nama_barang" readonly>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ukuran">Ukuran</label>
                                    <input type="text" wire:model="ukuran" id="ukuran" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" wire:model="qty" id="qty" class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="laminasi_meter">
									<label class="form-check-label" for="laminasi_meter">Laminasi Meter</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='laminasi_meter' class="form-control" id="laminasi_meteran">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="cutting_meter">
									<label class="form-check-label" for="cutting_meter">Cutting Meter</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='cutting_meter' class="form-control" id="cutting_meteran">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="laminasi_a3">
									<label class="form-check-label" for="laminasi_a3">Laminasi A3</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='laminasi_a3' class="form-control" id="laminasi_a3an">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="cutting_a3">
									<label class="form-check-label" for="cutting_a3">Cutting A3</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='cutting_a3' class="form-control" id="cutting_a3an">
								</div>
							</div>
						</div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" wire:model="keterangan"
                                style="height: 100px !important;"></textarea>
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
                        <div class="form-group">
                            <label for="nama_file">Nama File</label>
                            <input type="text" wire:model="nama_file" id="nama_file" class="form-control"
                                placeholder="contoh.pdf">
                        </div>
                        <div class="form-group">
                            <label for="id_detail_bahan">Nama Bahan <span class="text-danger">*nama printer - nama
                                    pekerjaan - nama bahan</span></label>
                            <select wire:model="id_detail_bahan" id="id_detail_bahan" class="form-control" disabled>
                                @foreach ($dataBahan as $bahan)
                                <option value="{{ $bahan->id }}">{{ $bahan->nama_printer }} -
                                    {{ $bahan->nama_pekerjaan }} - {{ $bahan->nama_barang }} -
                                    Rp{{ number_format($bahan->harga_jual) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ukuran">Ukuran</label>
                                    <input type="text" wire:model="ukuran" id="ukuran" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" wire:model="qty" id="qty" class="form-control">
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="laminasi_meter">
									<label class="form-check-label" for="laminasi_meter">Laminasi Meter</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='laminasi_meter' class="form-control" id="laminasi_meteran">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="cutting_meter">
									<label class="form-check-label" for="cutting_meter">Cutting Meter</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='cutting_meter' class="form-control" id="cutting_meteran">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="laminasi_a3">
									<label class="form-check-label" for="laminasi_a3">Laminasi A3</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='laminasi_a3' class="form-control" id="laminasi_a3an">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="cutting_a3">
									<label class="form-check-label" for="cutting_a3">Cutting A3</label>
								</div>
								<div class="form-group">
									<input type="number" wire:model='cutting_a3' class="form-control" id="cutting_a3an">
								</div>
							</div>
						</div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" wire:model="keterangan"
                                style="height: 100px !important;"></textarea>
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

    <!-- Tambah Data Customer -->
    <div class="modal fade" wire:ignore.self id="tambahDataCustomerModal" tabindex="-1" aria-labelledby="tambahDataCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataCustomerModalLabel">Tambah Data Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_customer">Nama Customer</label>
                            <input type="text" wire:model="nama_customer" id="nama_customer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">No HP</label>
                            <input type="text" wire:model="no_telepon" id="no_telepon" class="form-control">
                        </div>
						<div class="form-group">
							<label for="level">Level User</label>
							<select wire:model="id_level_customer" id="level" class="form-control">
								@foreach($dataLevelCustomer as $levelCust)
									<option value="{{ $levelCust->id }}">{{ $levelCust->nama_level }}</option>
								@endforeach
							</select>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="storeCustomer()" wire:loading.attr="disabled"
                            class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

{{-- <!-- Mesin Printer -->
<div class="modal fade" id="mesinPrinterModal" tabindex="-1" aria-labelledby="mesinPrinterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-t mt-4" id="dataTable">
                        <thead>
                            <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
                                <th class="p-3">Kode Printer</th>
                                <th class="p-3">Nama Printer</th>
                                <th class="p-3"><span></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataPrinter as $printer)
                            <tr class="tw-bg-white tw-text-xs tw-border-b hover:tw-bg-gray-50">
                                <td class="p-3">{{ $printer->kode_printer }}</td>
                                <td class="p-3">{{ $printer->nama_printer }}</td>
                                <td class="p-3 text-center">
                                    <button class="btn btn-sm btn-info" id="select-printer" data-id="{{ $printer->id }}">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </td>
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
            </div>
        </div>
    </div>
</div>

<!-- Nama Pekerjaan -->
<div class="modal fade" id="namaPekerjaanModal" tabindex="-1" aria-labelledby="namaPekerjaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-t mt-4" id="dataTables">
                        <thead>
                            <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
                                <th class="p-3">Nama Pekerjaan</th>
                                <th class="p-3">Nama Bahan</th>
                                <th class="p-3">Ukuran</th>
                                <th class="p-3">Harga</th>
                                <th class="p-3"><span></span></th>
                            </tr>
                        </thead>
                        <tbody id="data-nama-pekerjaan">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@section('js')
<script>
	$(document).ready(function () {
		$('#laminasi_meteran').hide()
		$('#laminasi_a3an').hide()
		$('#cutting_meteran').hide()
		$('#cutting_a3an').hide()

		$('#laminasi_meter').on('click', function () {
			if ($(this).prop('checked')) {
				$('#laminasi_meter').hide();
				$('#laminasi_meteran').show()
			} else {
				$('#laminasi_meter').show();
				$('#laminasi_meteran').hide()
			}
		})

		$('#cutting_meter').on('click', function () {
			if ($(this).prop('checked')) {
				$('#cutting_meter').hide();
				$('#cutting_meteran').show()
			} else {
				$('#cutting_meter').show();
				$('#cutting_meteran').hide()
			}
		})

		$('#laminasi_a3').on('click', function () {
			if ($(this).prop('checked')) {
				$('#laminasi_a3').hide();
				$('#laminasi_a3an').show()
			} else {
				$('#laminasi_a3').show();
				$('#laminasi_a3an').hide()
			}
		})

		$('#cutting_a3').on('click', function () {
			if ($(this).prop('checked')) {
				$('#cutting_a3').hide();
				$('#cutting_a3an').show()
			} else {
				$('#cutting_a3').show();
				$('#cutting_a3an').hide()
			}
		})


	});
</script>
@endsection
@push('scripts')
<script>
	$(document).ready(function () {
        $('#id_customer').select2();
        $('#id_customer').on('change', function (e) {
            var data = $('#id_customer').select2("val");
            @this.set('id_customer', data);
        });
    });
</script>
@endpush
