<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>INVOICE Transaksi</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
            crossorigin="anonymous"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter&display=swap"
            rel="stylesheet"
        />
    </head>
    <body style="font-family: Inter, sans-serif">
			<div class="text-center">
				<h3><b>SINTESA DIGITAL PRINTING</b></h3>
				<p>Subang, Jawa Barat.</p>
			</div>
            <hr style="border-top: 5px dashed black" />
            <div id="customer" class="mt-3">
                <div class="row">
                    <div class="col-12">
                        <table style="font-size: 14px">
                            <tbody>
                                <tr>
                                    <th>Customer:</th>
                                </tr>
                                <tr>
                                    <td>Kode Resi</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                                    <td>&nbsp;{{ $data->nomor_transaksi }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                                    <td>&nbsp;{{ $data->nama_customer }}</td>
                                </tr>
                                <tr>
                                    <td>No Telepon</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                                    <td>&nbsp;{{ $data->no_telepon }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="data-transaksi" class="mt-3">
                <table style="font-size: 12px" width="100%">
                    <thead>
                        <tr
                            style="
                                border-top: 2px dashed black;
                                border-bottom: 2px dashed black;
                            ">
                            <th style="padding-top: 10px; padding-bottom: 10px">
                                NAMA FILE
                            </th>
                            <th class="text-end" style="padding-top: 10px; padding-bottom: 10px">
                                QTY
                            </th>
                            <th class="text-end" style="padding-top: 10px; padding-bottom: 10px">
                                TOTAL
                            </th>
                        </tr>
                    </thead>
                    <tbody style="border-bottom: 2px dashed black">
                        @foreach($dataTransaksi as $row)
                        <tr class="align-middle">
                            <td style="padding-top: 5px;">
                                <b>{{ $row->nama_file }}</b> <br />
                                {{ $row->keterangan }}_{{ $row->nama_barang }} <br />
                                @if( $row->laminasi_meter || $row->laminasi_a3 )
                                    LAMINASI <br />
                                @else
                                
                                @endif
                                @if( $row->cutting_meter || $row->cutting_a3 )
                                    CUTTING <br />
                                @else
                                
                                @endif
                            </td>
                            <td class="text-end"><b>{{ $row->qty }}.00</b></td>
                            <td class="text-end"><b>{{ str_replace(',', '.', number_format($row->total)) }}</b>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
					@if( $data->status_lunas == "0" )
                        <tr class="text-end">
                            <th style="padding-top: 10px"></th>
                            <th style="padding-top: 10px">Total</th>
                            <th style="padding-top: 10px">
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->total)) }}</span>
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Pembulatan</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->pembulatan)) }}</span
                                >
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Discount</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->discount_invoice)) }}</span
                                >
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Total Net</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->total_net)) }}</span
                                >
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Bayar</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->bayar_dp)) }}</span
                                >
                            </th>
                        </tr>
						<tr class="text-end">
                            <th></th>
                            <th>Sisa Kurang</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->sisa_kurang)) }}</span
                                >
                            </th>
                        </tr>
					@else( $data->status_lunas == "1" )
						<tr class="text-end">
                            <th style="padding-top: 10px"></th>
                            <th style="padding-top: 10px">Total</th>
                            <th style="padding-top: 10px">
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->total)) }}</span>
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Pembulatan</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->pembulatan)) }}</span
                                >
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Discount</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->discount_invoice)) }}</span
                                >
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Total Net</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->total_net)) }}</span
                                >
                            </th>
                        </tr>
                        <tr class="text-end">
                            <th></th>
                            <th>Bayar</th>
                            <th>
                                <span class="float-end"
                                    >{{ str_replace(',', '.', number_format($data->total_net)) }}</span
                                >
                            </th>
                        </tr>
						<tr class="text-end">
                            <th></th>
                            <th>Sisa Kurang</th>
                            <th>
                                <span class="float-end"
                                    >0</span
                                >
                            </th>
                        </tr>
					@endif
                    </thead>
                </table>
            </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"
        ></script>
        <script>
            window.print();
        </script>
    </body>
</html>
