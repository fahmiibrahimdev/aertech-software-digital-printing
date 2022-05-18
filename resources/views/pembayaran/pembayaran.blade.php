@extends('layouts.apps2', ['title' => 'Pembayaran'])

@section('content')
<div>
    <div class="section-header tw-rounded-lg tw-text-black lg:tw-hidden">
        <h4 class="tw-text-lg">Pembayaran</h4>
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
                                            style="padding: 67px; font-size: 30px; font-weight: bold; text-align: center;" readonly value="Rp{{ number_format($dataOrderKerja->total) }}">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" id="tanggal" value="{{ $dataOrderKerja->tanggal }}" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="deadline">Deadline</label>
                                                <input type="date" id="deadline" class="form-control" value="{{ $dataOrderKerja->deadline }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="deadline_time">Jam Deadline</label>
                                                <input type="time" id="deadline_time" class="form-control" value="{{ $dataOrderKerja->deadline_time }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_customer">Customer</label>
                                        <select name="id_customer" id="id_customer" class="form-control" disabled>
                                            @foreach ($dataCustomer as $customer)
                                                <option value="{{ $customer->id }}" {{ $customer->id == $dataOrderKerja->id_customer ? 'selected':'' }}>
                                                    ({{ preg_replace('/(?<=\d)(?=(\d{4})+$)/', '-', $customer->no_telepon) }}) 
                                                    {{ $customer->nama_customer }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card card-primary mt-3">
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
                                                <th class="p-3">Disc(Rp)</th>
                                                <th class="p-3">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($dataDetailOrderKerja as $row)
                                            <tr class="tw-bg-white tw-border-b hover:tw-bg-gray-50">
                                                <td class="p-3">{{ $row->nama_file }}</td>
                                                <td class="p-3">{{ $row->nama_printer }}</td>
                                                <td class="p-3">{{ $row->nama_pekerjaan }}</td>
                                                <td class="p-3">{{ $row->nama_barang }}</td>
                                                <td class="p-3">{{ $row->ukuran }}</td>
                                                <td class="p-3 text-right">{{ $row->qty }}</td>
                                                <td class="p-3 text-right">{{ number_format($row->harga) }}</td>
                                                <td class="p-3 text-right">{{ number_format($row->discount) }}</td>
                                                <td class="p-3 text-right">{{ number_format($row->total) }}</td>
                                            </tr>
                                            @empty
                                            <tr class="text-center p-3">
                                                <td colspan="11">
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
            </div>
        </div>
        <button
            class="tw-fixed tw-right-[30px] tw-bottom-[50px] tw-w-14 tw-h-14 tw-shadow-2xl tw-rounded-full tw-bg-slate-600 tw-z-40 text-white hover:tw-bg-slate-900 hover:tw-border-slate-600"
            data-toggle="modal" data-target="#tambahDataModal">
            <i class="far fa-plus"></i>
        </button>
    </div>

    {{-- Tambah Data --}}
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalLabel">Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="@if(Auth::user()->hasRole('admin')){{ route('admin/pembayaran.store') }}@else{{ route('pembayaran.store') }}@endif" method="post">
                    @csrf
                    <div class="modal-body">    
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="id_order_kerja" class="form-control" value="{{ $dataOrderKerja->id }}">
                                <div class="form-group">
                                    <label for="sub_total">Sub Total</label>
                                    <input type="number" id="sub_total2" class="form-control" value="{{ $dataOrderKerja->total }}" readonly>
                                    <input type="hidden" id="sub_total" class="form-control" value="{{ $dataOrderKerja->total }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pembulatan">Pembulatan</label>
                                    <input type="number" name="pembulatan" id="pembulatan" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="discount_invoice">Discount Invoice</label>
                                    <input type="number" name="discount_invoice" id="discount_invoice" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="total_net">Total Net</label>
                                    <input type="number" name="total_net" id="total_net" class="form-control" value="0" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="grand_total">Grand Total</label>
                                    <input type="number" id="grand_total" class="form-control" value="{{ $dataOrderKerja->total }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bayar_dp">Bayar DP / Bayar Full</label>
                                    <input type="number" name="bayar_dp" id="bayar_dp" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sisa_kurang">Sisa Kurang Pembayaran</label>
                                    <input type="number" name="sisa_kurang" id="sisa_kurang" class="form-control" value="1" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <input type="text" name="metode_pembayaran" id="metode_pembayaran" class="form-control" value="CASH">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan_produksi">Catatan Produksi</label>
                            <textarea class="form-control" id="catatan_produksi" name="catatan_produksi" style="height: 100px !important;">-</textarea>
                        </div>
                        <div class="form-group">
                            <label for="penerima_file">Penerima File</label>
                            <input type="text" id="penerima_file" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_kasir">Nama Kasir</label>
                            <input type="text" id="nama_kasir" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="save-data" class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@section('js')
<script>
    $(document).ready(function () {
        $('#discount_invoice, #sub_total, #grand_total, #total_net, #bayar_dp').keyup(function () {
            var discount_invoice = parseInt($('#discount_invoice').val())
            var sub_total = parseInt($('#sub_total').val())
            $('#grand_total').val(sub_total - discount_invoice)
            $('#total_net').val(sub_total - discount_invoice)
            $('#sisa_kurang').val(sub_total - discount_invoice)
        });
        $('#bayar_dp, #total_net, #sisa_kurang').keyup(function (e) { 
            var bayar_dp = parseInt($('#bayar_dp').val())
            var total_net = parseInt($('#total_net').val())
            $('#sisa_kurang').val(total_net - bayar_dp)
        });
        $('#pembulatan, #sub_total').keyup(function (e) { 
            var pembulatan = parseInt($('#pembulatan').val())
            $('#sub_total').val(pembulatan)
            $('#grand_total').val(pembulatan)
        });

        $('#save-data').on('click', function () {
            var sisa_kurang = parseInt($('#sisa_kurang').val())
            if( sisa_kurang == 0 )
            {
                Swal.fire(
                    'Pembayaran Berhasil!',
                    'Pembayaran lunas!, anda akan di redirect ke halaman Data Transaksi',
                    'success'
                );
            } else if( sisa_kurang > 0 )
            {
                Swal.fire(
                    'Pembayaran Berhasil!',
                    'Pembayaran belum lunas!, anda akan di redirect ke halaman Data Transaksi',
                    'success'
                );
            } else if( sisa_kurang < 0 )
            {
                Swal.fire(
                    'Pembayaran Gagal!',
                    'Pembayaran tidak boleh minus!, anda akan di redirect ke halaman Data Transaksi',
                    'error'
                );
            } 
        });
    });
</script>
@endsection
@endsection