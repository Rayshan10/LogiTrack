<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('barang', BarangController::class);
    Route::get('/barang/{id}/download-qr', [BarangController::class, 'downloadQr'])->middleware('auth');
    Route::get('/barang/{id}/print-qr', [BarangController::class, 'printQr'])->middleware('auth');
});

Route::get('/scan-qr', function () {
    return view('scan.index');
})->middleware('auth');

Route::get('/barang/export/pdf-qr',
    [BarangController::class, 'exportPdfQr'])
    ->middleware('auth');

Route::post('/barang/{id}/update-status',
    [BarangController::class, 'updateStatus'])
    ->middleware('auth');

require __DIR__.'/auth.php';
