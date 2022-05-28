<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Rekap</h4>
    </div>

    <div class="section-body lg:tw-mt-[-30px]">
        <div class="tw-mt-[-10px] mb-3">
            <h6 class="section-title tw-text-sm">Rekap Data</h6>
            <p class="section-lead tw-text-xs">Rekap data ada 2: pendapatan & pengeluaran dan data order per orang dalam bentuk PDF.</p>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
					<div class="card-header">
						<h4>Rekap pendapatan dan pengeluaran</h4>
					</div>
                    <div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="dari_tanggal">Dari Tanggal</label>
									<input type="date" wire:model="dari_tanggal" id="dari_tanggal" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="sampai_tanggal">s/d Tanggal</label>
									<input type="date" wire:model="sampai_tanggal" id="sampai_tanggal" class="form-control">
								</div>
							</div>
						</div>
						<a href="{{ route('admin/print-pendapatan-pengeluaran', ['dariTanggal' => $dari_tanggal, 'sampaiTanggal' => $sampai_tanggal]) }}" class="btn btn-outline-primary form-control" target="_BLANK"><i class="fas fa-print"></i> Print PDF</a>
                    </div>
                </div>
            </div>
			<div class="col-lg-6">
                <div class="card card-warning">
					<div class="card-header">
						<h4>Rekap data order per customer</h4>
					</div>
                    <div class="card-body">
						<div class="form-group">
							<label for="id_customer">Customer</label>
							<select wire:model="id_customer" id="id_customer" class="form-control">
								@foreach($dataCustomer as $customer)
									<option value="{{ $customer->id }}">{{ $customer->nama_customer }} - {{ $customer->no_telepon }}</option>
								@endforeach
							</select>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="start_date">Dari Tanggal</label>
									<input type="date" wire:model="start_date" id="start_date" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="end_date">s/d Tanggal</label>
									<input type="date" wire:model="end_date" id="end_date" class="form-control">
								</div>
							</div>
						</div>
						<a href="" class="btn btn-outline-warning form-control" target="_BLANK"><i class="fas fa-print"></i> Print PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
