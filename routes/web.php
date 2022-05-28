<?php

use App\Http\Livewire\Bahan\Bahan;
use App\Http\Livewire\Mesin\Mesin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Livewire\Customer\Customer;
use App\Http\Livewire\Kategori\Kategori;
use App\Http\Livewire\Produksi\Produksi;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\OrderKerja\OrderKerja;
use App\Http\Livewire\Pembayaran\Pembayaran;
use App\Http\Livewire\StockMasuk\StockMasuk;
use App\Http\Livewire\AmbilBarang\AmbilBarang;
use App\Http\Livewire\DaftarStock\DaftarStock;
use App\Http\Livewire\DetailBahan\DetailBahan;
use App\Http\Livewire\StatusOrder\StatusOrder;
use App\Http\Livewire\OrderKerja\EditOrderKerja;
use App\Http\Livewire\DataTransaksi\DataTransaksi;
use App\Http\Livewire\LevelCustomer\LevelCustomer;
use App\Http\Livewire\NamaPekerjaan\NamaPekerjaan;
use App\Http\Livewire\Produktifitas\Produktifitas;
use App\Http\Livewire\SettingTanggal\SettingTanggal;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Livewire\CetakStruk\CetakStruk;
use App\Http\Livewire\DataUser\DataUser;
use App\Http\Livewire\PembayaranBelumLunas\PembayaranBelumLunas;
use App\Http\Livewire\Pengeluaran\Pengeluaran;
use App\Http\Livewire\PengeluaranPengeluaran;
use App\Http\Livewire\RekapData\PrintDataOrder;
use App\Http\Livewire\RekapData\PrintPendapatanPengeluaran;
use App\Http\Livewire\RekapData\RekapData;
use App\Http\Livewire\TrackingOrder\TrackingOrder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/cache-clear', function() {
    Artisan::call('cache:clear'); 
    return 'Cache Clear Success!';
});

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('tracking-order', TrackingOrder::class)->name('tracking-order');

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
	Route::get('get-data-id-mesin/{id}', 'App\Http\Controllers\AllController@getDataIdMesin')->name('get-data-id-mesin');
    Route::get('get-data-mesin-printer/{id}', 'App\Http\Controllers\AllController@getDataMesinPrinter')->name('get-data-mesin-printer');
    Route::get('get-data-nama-pekerjaan/{id}/{idLevelCustomer}', 'App\Http\Controllers\AllController@getDataNamaPekerjaan')->name('get-data-nama-pekerjaan');
    Route::get('get-data-id-bahan-dan-pekerjaan/{id}', 'App\Http\Controllers\AllController@getDataIdBahanDanPekerjaan')->name('get-data-id-bahan-dan-pekerjaan');
    Route::get('get-data-pekerjaan-dan-id-mesin/{id_pekerjaan}', 'App\Http\Controllers\AllController@getDataPekerjaanDanIdMesin')->name('get-data-pekerjaan-dan-id-mesin');
    Route::get('cetak-invoice/{id}', 'App\Http\Controllers\AllController@cetakInvoice')->name('cetak-invoice');
    Route::get('print-data-order/{id_customer}/{start_date}/{end_date}', PrintDataOrder::class)->name('print-data-order');
});

Route::group(['middleware' => ['auth', 'role:admin']], function() {
	Route::get('/migrate-fresh-seed', function() {
		Artisan::call('migrate:fresh --seed'); 
		return 'Migrate Fresh Seed Success!';
	});
	Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
	Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('admin/mesin', Mesin::class)->name('mesin');
    Route::get('admin/nama-pekerjaan', NamaPekerjaan::class)->name('nama-pekerjaan');
    Route::get('admin/bahan', Bahan::class)->name('bahan');
    Route::get('admin/harga', DetailBahan::class)->name('harga');
    Route::get('admin/customer', Customer::class)->name('customer');
    Route::get('admin/order-kerja', OrderKerja::class)->name('order-kerja');
    Route::get('admin/edit-order-kerja/{id}', EditOrderKerja::class)->name('edit-order-kerja');
    Route::get('admin/data-transaksi', DataTransaksi::class)->name('admin/data-transaksi');
    Route::post('admin/pembayaran', 'App\Http\Controllers\PembayaranController@store')->name('admin/pembayaran.store');
    Route::get('admin/pembayaran/{id}', 'App\Http\Controllers\PembayaranController@pembayaran')->name('admin/pembayaran');
    Route::get('admin/produksi', Produksi::class)->name('produksi');
    Route::get('admin/ambil-barang', AmbilBarang::class)->name('ambil-barang');
    Route::get('admin/stock-masuk', StockMasuk::class)->name('stock-masuk');
    Route::get('admin/status-order', StatusOrder::class)->name('status-order');
    Route::get('admin/produktifitas', Produktifitas::class)->name('produktifitas');
    Route::get('admin/level-customer', LevelCustomer::class)->name('level-customer');
    Route::get('admin/kategori', Kategori::class)->name('kategori');
    Route::get('admin/daftar-stock', DaftarStock::class)->name('daftar-stock');
    Route::get('admin/daftar-user', DataUser::class)->name('daftar-user');
    Route::get('admin/pembayaran-belum-lunas', PembayaranBelumLunas::class)->name('pembayaran-belum-lunas');
    Route::get('admin/cetak-struk', CetakStruk::class)->name('cetak-struk');
	Route::get('admin/pengeluaran', Pengeluaran::class)->name('admin/pengeluaran');
    Route::get('admin/rekap-data', RekapData::class)->name('admin/rekap-data');
    Route::get('admin/print-pendapatan-pengeluaran/{dariTanggal}/{sampaiTanggal}', PrintPendapatanPengeluaran::class)->name('admin/print-pendapatan-pengeluaran');
});

Route::group(['middleware' => ['auth', 'role:desainer']], function() {
    Route::get('mesin', Mesin::class)->name('mesin');
    Route::get('nama-pekerjaan', NamaPekerjaan::class)->name('nama-pekerjaan');
    Route::get('bahan', Bahan::class)->name('bahan');
    Route::get('harga', DetailBahan::class)->name('harga');
    Route::get('customer', Customer::class)->name('customer');
    Route::get('order-kerja', OrderKerja::class)->name('order-kerja');
	Route::get('edit-order-kerja/{id}', EditOrderKerja::class)->name('edit-order-kerja');
    Route::get('data-transaksi', DataTransaksi::class)->name('data-transaksi');
    Route::post('pembayaran', 'App\Http\Controllers\PembayaranController@store')->name('pembayaran.store');
    Route::get('pembayaran-belum-lunas', PembayaranBelumLunas::class)->name('pembayaran-belum-lunas');
    Route::get('/pembayaran/{id}', 'App\Http\Controllers\PembayaranController@pembayaran')->name('pembayaran');
    Route::get('stock-masuk', StockMasuk::class)->name('stock-masuk');
    Route::get('level-customer', LevelCustomer::class)->name('level-customer');
    Route::get('kategori', Kategori::class)->name('kategori');
    Route::get('daftar-stock', DaftarStock::class)->name('daftar-stock');
    Route::get('cetak-struk', CetakStruk::class)->name('cetak-struk');
	Route::get('pengeluaran', Pengeluaran::class)->name('pengeluaran');
});

Route::group(['middleware' => ['auth', 'role:produksi']], function() {
	Route::get('produksi', Produksi::class)->name('produksi');
	Route::get('ambil-barang', AmbilBarang::class)->name('ambil-barang');
	Route::get('status-order', StatusOrder::class)->name('status-order');
    Route::get('produktifitas', Produktifitas::class)->name('produktifitas');
});

require __DIR__.'/auth.php';
