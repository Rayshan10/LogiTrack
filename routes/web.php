<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatPengirimanController;
use App\Http\Controllers\ImportBarangController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',
        [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Admin Route
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Data Barang
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Import Dataset Kaggle
    |--------------------------------------------------------------------------
    */

    Route::get('/barang/import', [ImportBarangController::class, 'index'])
        ->name('barang.import');

    Route::post('/barang/import', [ImportBarangController::class, 'store'])
        ->name('barang.import.store');

    Route::resource(
        'barang',
        BarangController::class
    );

    Route::post(
        '/barang/import/process',
        [ImportBarangController::class,'process']
    )->name('barang.import.process');

    /*
    |--------------------------------------------------------------------------
    | QR Code
    |--------------------------------------------------------------------------
    */

    Route::get('/barang/{id}/download-qr',
        [BarangController::class, 'downloadQr']);

    Route::get('/barang/{id}/print-qr',
        [BarangController::class, 'printQr']);

    Route::get('/barang/export/pdf-qr',
        [BarangController::class, 'exportPdfQr']);

    /*
    |--------------------------------------------------------------------------
    | SAW
    |--------------------------------------------------------------------------
    */

    Route::get('/hitung-saw',
        [BarangController::class, 'hitungSAW']);
    
    Route::post('/proses-saw',
    [BarangController::class, 'hitungSAW']);

    Route::get('/export-saw-pdf',
        [BarangController::class, 'exportSAWPDF']);

    Route::resource(
        'kurir',
        KurirController::class
    );

    Route::get(
        '/kurir/{id}/statistik',
        [KurirController::class, 'statistik']
        )->name('kurir.statistik');

});

/*
|--------------------------------------------------------------------------
| Kurir Route
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:kurir'
])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Scan QR
    |--------------------------------------------------------------------------
    */

    Route::get('/scan-qr', function () {

        return view('scan.index');

    });

    Route::post('/scan/update-status',
        [BarangController::class, 'scanUpdateStatus']);

    Route::get(
        '/riwayat-pengiriman',
        [RiwayatPengirimanController::class, 'index']
    );

});

/*
|--------------------------------------------------------------------------
| Shared Route
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Update Status Manual
    |--------------------------------------------------------------------------
    */

    Route::post('/barang/{id}/update-status',
        [BarangController::class, 'updateStatus']);

});

Route::middleware([
    'auth',
    'role:admin'
])->group(function () {

    Route::get(
        '/laporan-distribusi',
        [App\Http\Controllers\LaporanController::class, 'index']
    )->name('laporan.index');

    Route::post(
        '/laporan-distribusi/export',
        [App\Http\Controllers\LaporanController::class, 'export']
    )->name('laporan.export');

});

require __DIR__.'/auth.php';