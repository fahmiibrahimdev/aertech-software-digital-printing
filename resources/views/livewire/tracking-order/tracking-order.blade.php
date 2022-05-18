<div>
    <div class="container mt-5">
        <div class="card tw-rounded-lg">
            <div class="card-header">
                <h4>Cek Resi</h4>
            </div>
            <div class="card-body">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<input type="text" wire:model="nomor_resi" id="nomor_resi" class="form-control form-control-lg" placeholder="Kode Resi">
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="card tw-rounded-lg">
            <div class="card-header">
                KODE RESI
                <h3 class="ml-auto font-bold text-dark"><b>{{ $nomor_resi }}</b></h3>
            </div>
        </div>
		<div class="activities">
			@foreach($data as $row)
				<div class="activity">
					<div
						class="activity-icon tw-bg-slate-900 text-white shadow-primary"
					>
					@if( $row->status == "1" )
						<i class="fas fa-archive tw-text-[17px] tw-text-orange-200"></i>
					@elseif( $row->status == "2" )
						<i class="fas fa-clipboard-list-check tw-text-[17px] tw-text-lime-300"></i>
					@elseif( $row->status == "4" )
						<i class="fas fa-badge-check tw-text-[17px] text-success"></i>
					@endif
					</div>
					<div class="activity-detail tw-drop-shadow-lg">
						<div class="mb-2">
							<span class="text-lg text-primary"
								>{{ $row->nama_file }}</span
							>
						</div>
						<p>
							<span class="text-dark">
								@if($row->tanggal_taking)
									<b>[{{ Carbon\Carbon::parse($row->tanggal_finishing)->format('d F H:i') }}]</b> 
									<span class="text-success">Pesanan telah diterima yang bersangkutan</span> <br>
								@else
								@endif
								@if($row->tanggal_finishing)
									<b>[{{ Carbon\Carbon::parse($row->tanggal_finishing)->format('d F H:i') }}]</b> 
									Pesanan sudah selesai diproduksi, silahkan diambil <br>
								@else
								@endif
								<b>[{{ Carbon\Carbon::parse($row->created_at)->format('d F H:i') }}]</b> Pesanan sedang diproduksi, mohon menunggu.
							</span>
						</p>
					</div>
				</div>
			@endforeach
		</div>
    </div>
</div>
