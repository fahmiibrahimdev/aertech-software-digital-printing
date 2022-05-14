<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">User</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Data User</h6>
            <p class="section-lead tw-text-xs">Data user.</p>
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
                                    <tr class="tw-bg-white tw-border-b tw-text-xs text-uppercase">
                                        <th class="p-3">Nama</th>
                                        <th class="p-3">Email</th>
                                        <th class="p-3">Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                    <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                        <td class="p-3">{{ $row->name }}</td>
                                        <td class="p-3">{{ $row->email }}</td>
                                        <td class="p-3">{{ $row->nama_role }}</td>
                                        <td class="p-3 text-center">
											<button class="btn btn-primary" data-toggle="modal" data-target="#ubahDataModal" wire:click="edit({{ $row->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger" wire:click.prevent="deleteConfirm({{ $row->id }})">
                                                <i class="fas fa-trash"></i>
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
                        <div class="table-responsive p-3">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button
            class="tw-fixed tw-right-[30px] tw-bottom-[50px] tw-w-14 tw-h-14 tw-shadow-2xl tw-rounded-full tw-bg-slate-600 tw-z-40 text-white hover:tw-bg-slate-900 hover:tw-border-slate-600"
            onclick="location.href='{{ url('register') }}'">
            <i class="far fa-plus"></i>
        </button>
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
							<label for="name">Nama</label>
							<input type="text" wire:model="name" id="name" class="form-control">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" wire:model="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label for="role_id">Role User</label>
							<select wire:model="role_id" id="role_id" class="form-control">
								<option value="admin">Admin</option>
								<option value="desainer">Desainer</option>
								<option value="produksi">Op Produksi</option>
							</select>
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
