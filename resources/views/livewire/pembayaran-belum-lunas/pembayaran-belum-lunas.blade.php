<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Pembayaran Belum Lunas</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Data Pembayaran Belum Lunas</h6>
            <p class="section-lead tw-text-xs">Daftar Pembayaran yang belum lunas pada transaksi.</p>
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
                                        <th class="p-3">Kode Resi</th>
                                        <th class="p-3">Nm Cust</th>
                                        <th class="p-3">Tgl Pmbyrn DP</th>
                                        <th class="p-3">Total</th>
                                        <th class="p-3">Pmbyrn DP</th>
                                        <th class="p-3">Sisa Kurang</th>
                                        <th class="p-3"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        @if ($row->status_lunas == NULL)
                                        <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                            <td class="p-3">{{ $row->nomor_transaksi }}</td>
                                            <td class="p-3">{{ $row->nama_customer }}</td>
                                            <td class="p-3">{{ $row->updated_at }}</td>
                                            <td class="p-3">Rp{{ number_format($row->total_net, 0, ',', '.') }},00</td>
                                            <td class="p-3">Rp{{ number_format($row->bayar_dp, 0, ',', '.') }},00</td>
                                            <td class="p-3">Rp{{ number_format($row->sisa_kurang, 0, ',', '.') }},00</td>
                                            <td class="p-3 text-center">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#ubahDataModal" wire:click="edit({{ $row->id }})">
													<i class="fas fa-donate"></i>
												</button>
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
    </div>

	<div class="modal fade" wire:ignore.self id="ubahDataModal" tabindex="-1" aria-labelledby="ubahDataModalLabel" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahDataModalLabel">Pembayaran</h5>
                    <button type="button" wire:click.prevent='cancel()' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <input type="hidden" wire:model='dataId'>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="total_net">Total Net</label>
									<input type="number" wire:model="total_net" id="total_net" class="form-control" readonly>
									<small class="form-text text-muted">Rp {{ number_format((int)$total_net, 0, ',', '.') }},00</small>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="sisa_kurang">Sisa Kurang</label>
									<input type="number" wire:model="sisa_kurang" id="sisa_kurang" class="form-control" readonly>
									<small class="form-text text-muted">Rp {{ number_format((int)$sisa_kurang, 0, ',', '.') }},00</small>
								</div>
							</div>
						</div>
                        <div class="form-group">
                            <label for="bayar_dp">Pembayaran</label>
                            <input type="number" wire:model="bayar_dp" id="bayar_dp" class="form-control">
                            <small class="form-text text-muted">Rp {{ number_format((int)$bayar_dp, 0, ',', '.') }},00</small>
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
