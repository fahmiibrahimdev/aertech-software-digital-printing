<div>
	<div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Status Order</h6>
            <p class="section-lead tw-text-xs">Merekap semua data transaksi order dari status.</p>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card card-info">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="dariTanggal">Tanggal Order</label>
                            <input type="date" wire:model='dariTanggal' id="dariTanggal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="sampaiTanggal">s/d Tanggal</label>
                            <input type="date" wire:model='sampaiTanggal' id="sampaiTanggal" class="form-control">
                        </div>
                        <div class="form-group">
                              <label for="status">Status Order</label>
                              <select wire:model='idStatus' id="status" class="form-control">
                                <option value="0">All</option>
                                <option value="1">Sedang Produksi (1)</option>
                                <option value="2">Selesai Finishing (2)</option>
                                <option value="3">Selesai Belum Di-Ambil (3)</option>
                                <option value="4">Selesai Sudah Di-Ambil (4)</option>
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
                            <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-t mt-4">
                                <thead>
                                    <tr class="tw-bg-white tw-border-b tw-text-xs text-center text-uppercase">
                                        <th class="p-3">TGL</th>
                                        <th class="p-3">Nm File</th>
                                        <th class="p-3">Printer</th>
                                        <th class="p-3">Nm Pkrjn</th>
                                        <th class="p-3">Ukuran</th>
                                        <th class="p-3">Qty</th>
                                        <th class="p-3">St</th>
                                    </tr>
                                </thead>
                                <tbody>
								@foreach($data->groupBy('id_order_kerja') as $row)
									<tr class="tw-border-b hover:tw-bg-gray-50">
										<td class="p-3" colspan="6">
											<h3>
												<b>
													ID: {{ $row[0]['id_order_kerja'] }} | {{ $row[0]['nama_customer'] }}
													@if($row[0]['status_lunas'] == "0")

													@elseif($row[0]['status_lunas'] == "1")
														<i class="fas fa-check text-success"></i> </td>
													@endif
												</b>
											</h3>
										</td>
										<td class="text-center p-3">
										@if( $row[0]['sisa_kurang'] == 0 )

										@else
											@if($row[0]['status_lunas'] == "0")
												<button wire:click.prevent="lunas({{ $row[0]['id'] }})"
												class="btn btn-sm btn-outline-warning">Lunaskan</button>
											@elseif($row[0]['status_lunas'] == "1")
												<button wire:click.prevent="batalkanLunas({{ $row[0]['id'] }})"
												class="btn btn-sm btn-outline-danger">Batalkan</button>
											@endif
										@endif
										</td>
									</tr>
									@foreach ($row as $item)
									<tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
										<td class="p-3">{{ $item['tanggal'] }} </td>
										<td class="p-3">{{ $item['nama_file'] }}</td>
										<td class="p-3 text-center">{{ $item['nama_printer'] }}</td>
										<td class="p-3">{{ $item['nama_pekerjaan'] }}</td>
										<td class="p-3 text-center">{{ $item['ukuran'] }}</td>
										<td class="p-3 text-right">{{ $item['qty'] }}.00</td>
										<td class="p-3 text-center">
											@if ( $item['status'] == '1' )
												<button wire:click.prevent="konf({{ $item['id'] }})"
												class="btn btn-sm btn-outline-info">Produksi</button>
											@elseif($item['status'] == '3')
												<button wire:click.prevent="konfirmasi({{ $item['id'] }})"
												class="btn btn-sm btn-outline-success">TakingIt</button>
											@elseif($item['status'] == '4')
												<span class="badge tw-bg-green-200 tw-text-green-900">Selesai</span>
											@endif
										</td>
									</tr>
									@endforeach
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
</div>