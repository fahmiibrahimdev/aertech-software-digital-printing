<div>
    <div class="container">
        <center>
            <h3 class="tw-text-2xl tw-font-bold">SINTESA DIGITAL PRINTING</h3>
            <h6 class="tw-text-base">LAPORAN PENDAPATAN DAN PENGELUARAN</h6>
            <p class="tw-text-sm">{{ Carbon\Carbon::parse($tanggalAwal)->isoFormat('D MMMM Y') }} s/d {{ Carbon\Carbon::parse($tanggalAkhir)->isoFormat('D MMMM Y') }}</p>
        </center>
        <table class="tw-table-fixed tw-w-full tw-text-black tw-text-sm tw-border-collapse tw-border-black tw-border-t mt-4">
			<thead>
				<tr class="tw-bg-sky-100 tw-border-b tw-text-xs text-center text-uppercase">
					<th class="p-1 tw-border" width="20%">TANGGAL</th>
					<th class="p-1 tw-border" width="16%">PRINTER</th>
					<th class="p-1 tw-border" width="35%">NM PEKERJAAN</th>
					<th class="p-1 tw-border" width="10%">UKURAN</th>
					<th class="p-1 tw-border" width="10%">QTY</th>
					<th class="p-1 tw-border" width="20%">TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs">
					<td class="p-2 tw-border fw-bold px-2 text-center" colspan="6">PENDAPATAN</td>
				</tr>
				@foreach($data->groupBy('id_order_kerja') as $row)
				<tr class="tw-border-b hover:tw-bg-gray-50">
					<td class="p-1 tw-border px-2 tw-text-xs fw-bold" colspan="6">> {{ $row[0]['nama_customer'] }}</td>
				</tr>
					@foreach ($row as $item)
					<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center">
						<td class="p-1 tw-border px-2">{{ Carbon\Carbon::parse($item['tanggal'])->isoFormat('D MMMM Y') }}</td>
						<td class="p-1 tw-border px-2">{{ $item['nama_printer'] }}</td>
						<td class="p-1 tw-border px-2">{{ $item['nama_pekerjaan'] }}</td>
						<td class="p-1 tw-border px-2">{{ $item['ukuran'] }}</td>
						<td class="p-1 tw-border px-2">{{ $item['qty'] }}.00</td>
						<td class="p-1 tw-border px-2 text-end">{{ number_format($item['total'], 0, ',', '.') }},00</td>
					</tr>
					@endforeach
				@endforeach
				
				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center fw-bold">
					<td class="p-2 tw-border px-2" colspan="4">SUB TOTAL & TOTAL</td>
					<td class="p-2 tw-border px-2">{{ $dataTotal->qty }}.00</td>
					<td class="p-2 tw-border px-2 text-end text-success">Rp{{ number_format($dataTotal->total_pendapatan, 0, ',', '.') }},00</td>
				</tr>

				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center">
					<td class="p-1 tw-border" colspan="6">-</td>
				</tr>

				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs">
					<td class="p-2 tw-border fw-bold px-2 text-center" colspan="6">PENGELUARAN</td>
				</tr>
				@foreach($dataPengeluaran->groupBy('tanggal') as $rowPengeluaran)
				<tr class="tw-border-b hover:tw-bg-gray-50">
					<td class="p-1 tw-border px-2 tw-text-xs fw-bold" colspan="6">> {{ Carbon\Carbon::parse($rowPengeluaran[0]['tanggal'])->isoFormat('D MMMM Y') }}</td>
				</tr>
					@foreach ($rowPengeluaran as $itemPengeluaran)
						<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center">
							<td class="p-1 tw-border px-2" colspan="5">{{ $itemPengeluaran['keterangan'] }}</td>
							<td class="p-1 tw-border px-2 text-end">{{ number_format($itemPengeluaran['jumlah'], 0, ',', '.') }},00</td>
						</tr>
					@endforeach
				@endforeach

				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center fw-bold">
					<td class="p-2 tw-border px-2" colspan="5">TOTAL PENGELUARAN</td>
					<td class="p-2 tw-border px-2 text-end text-danger">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }},00</td>
				</tr>

				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center">
					<td class="p-1 tw-border" colspan="6">-</td>
				</tr>

				<tr class="tw-border-b hover:tw-bg-gray-50 tw-text-xs text-center fw-bold">
					<td class="p-2 tw-border px-2" colspan="5">PENDAPATAN - PENGELUARAN</td>
					<td class="p-2 tw-border px-2 text-end">Rp{{ number_format($dataTotal->total_pendapatan - $totalPengeluaran, 0, ',', '.') }},00,00</td>
				</tr>

			</tbody>
		</table>
    </div>
</div>
