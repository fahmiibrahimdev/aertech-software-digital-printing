<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Pengeluaran</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Data Pengeluaran</h6>
            <p class="section-lead tw-text-xs">Data pengeluaran.</p>
        </div>
        <div class="row">
            <div class="col-lg-3 tw-hidden lg:tw-block">
                <div class="card">
                    <div class="card-body">
						<button type="button" class="btn btn-outline-primary form-control mb-3" data-toggle="modal" data-target="#filteringModal">
							FILTERING
						</button>
						<div class="form-group text-uppercase">
							<label for="total">TOTAL</label>
							<input type="text" name="total" id="total" class="form-control"
								style="padding: 20px; font-size: 18px; font-weight: bold; text-align: center;"
								readonly value="Rp{{ number_format((int)$total, 0, ',', '.') }},00">
						</div>
                        <form>
                            <div class="form-group">
								<label for="tanggal">Tanggal</label>
								<input type="date" wire:model="tanggal" id="tanggal" class="form-control">
								@error('tanggal')
									<small class="form-text text-muted">
										{{ $message }}
									</small> 
								@enderror
							</div>
							<div class="form-group">
								<label for="jumlah">Jumlah</label>
								<input type="number" wire:model="jumlah" id="jumlah" class="form-control">
								<small class="form-text text-muted">
									Rp{{ number_format((int)$jumlah, 0, ',', '.') }},00
								</small>
								@error('jumlah')
									<small class="form-text text-muted">
										{{ $message }}
									</small> 
								@enderror
							</div>
							<div class="form-group">
								<label for="keterangan">Keterangan</label>
								<textarea wire:model="keterangan" id="keterangan" class="form-control" style="height: 100px"></textarea>
								@error('keterangan')
									<small class="form-text text-muted">
										{{ $message }}
									</small> 
								@enderror
							</div>
                            <button type="submit" wire:click.prevent="store()" wire:loading.attr="disabled" class="btn btn-outline-success form-control">Save Data</button>
                        </form>
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
                                        <th class="p-3">Tanggal</th>
                                        <th class="p-3">Keterangan</th>
                                        <th class="p-3">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
								@foreach($data->groupBy('tanggal') as $row)
									<tr class="tw-border-b hover:tw-bg-gray-50">
										<td class="p-3 text-center">
											<h3>
												<b>
													 {{ $row[0]['tanggal'] }}
												</b>
											</h3>
										</td>
										<td colspan="2"></td>
									</tr>
									@foreach ($row as $item)
                                    <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
									<td></td>
                                        <td class="p-3">{{ $item['keterangan'] }}</td> 
                                        <td class="p-3 text-right">Rp{{ number_format((int)$item['jumlah'], 0, ',', '.') }},00</td>
                                        <td class="p-3 text-center">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#ubahDataModal" wire:click="edit({{ $item['id'] }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger" wire:click.prevent="deleteConfirm({{ $item['id'] }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
									<tr class="tw-border-b hover:tw-bg-gray-50">
										<td class="p-3 text-center" colspan="2">
											<h3>
												<b>
													 TOTAL : 
												</b>
											</h3>
										</td>
										<td class="text-right">
											<h3>
												<b>
													 Rp{{ number_format((int)$row->sum('jumlah'), 0, ',', '.') }},00
												</b>
											</h3>
										</td>
									</tr>
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
            class="tw-fixed tw-right-[30px] tw-bottom-[50px] tw-w-14 tw-h-14 tw-shadow-2xl tw-rounded-full tw-bg-slate-600 tw-z-40 text-white hover:tw-bg-slate-900 hover:tw-border-slate-600 lg:tw-hidden"
            data-toggle="modal" data-target="#tambahDataModal">
            <i class="far fa-plus"></i>
        </button>
    </div>

	{{-- Filtering Data --}}
    <div class="modal fade" wire:ignore.self id="filteringModal" tabindex="-1" aria-labelledby="filteringModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filteringModalLabel">Data Filtering</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
				<div class="card-body">
					<div class="form-group">
						<label for="dariTanggal">Dari Tanggal</label>
						<input type="date" wire:model="dariTanggal" id="dariTanggal" class="form-control">
					</div>
					<div class="form-group">
						<label for="sampaiTanggal">s/d Tanggal</label>
						<input type="date" wire:model="sampaiTanggal" id="sampaiTanggal" class="form-control">
					</div>
				</div>
            </div>
        </div>
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
                        <div class="form-group">
							<label for="tanggal">Tanggal</label>
							<input type="date" wire:model="tanggal" id="tanggal" class="form-control">
							@error('tanggal')
								<small class="form-text text-muted">
									{{ $message }}
								</small> 
							@enderror
						</div>
						<div class="form-group">
							<label for="jumlah">Jumlah</label>
							<input type="number" wire:model="jumlah" id="jumlah" class="form-control">
							<small class="form-text text-muted">
								Rp{{ number_format((int)$jumlah, 0, ',', '.') }},00
							</small>
							@error('jumlah')
								<small class="form-text text-muted">
									{{ $message }}
								</small> 
							@enderror
						</div>
						<div class="form-group">
							<label for="keterangan">Keterangan</label>
							<textarea wire:model="keterangan" id="keterangan" class="form-control" style="height: 100px"></textarea>
							@error('keterangan')
								<small class="form-text text-muted">
									{{ $message }}
								</small> 
							@enderror
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="store()" wire:loading.attr="disabled" class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Data --}}
    <div class="modal fade" wire:ignore.self id="ubahDataModal" tabindex="-1" aria-labelledby="ubahDataModalLabel" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahDataModalLabel">Edit Data</h5>
                    <button type="button" wire:click.prevent='cancel()' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <input type="hidden" wire:model='dataId'>
                        <div class="form-group">
							<label for="tanggal">Tanggal</label>
							<input type="date" wire:model="tanggal" id="tanggal" class="form-control">
							@error('tanggal')
								<small class="form-text text-muted">
									{{ $message }}
								</small> 
							@enderror
						</div>
						<div class="form-group">
							<label for="jumlah">Jumlah</label>
							<input type="number" wire:model="jumlah" id="jumlah" class="form-control">
							<small class="form-text text-muted">
								Rp{{ number_format((int)$jumlah, 0, ',', '.') }},00
							</small>
							@error('jumlah')
								<small class="form-text text-muted">
									{{ $message }}
								</small> 
							@enderror
						</div>
						<div class="form-group">
							<label for="keterangan">Keterangan</label>
							<textarea wire:model="keterangan" id="keterangan" class="form-control" style="height: 100px"></textarea>
							@error('keterangan')
								<small class="form-text text-muted">
									{{ $message }}
								</small> 
							@enderror
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click.prevent='cancel()' class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:click.prevent="update()" wire:loading.attr="disabled" type="button" class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
