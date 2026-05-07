<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;

// Rute Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Rute Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rute Manajemen Pelanggan
Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::post('/admin/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/admin/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/admin/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/admin/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

// Rute Kelola Data Paket
Route::get('/admin/paket', [PaketController::class, 'index'])->name('paket.index');
Route::post('/admin/paket', [PaketController::class, 'store'])->name('paket.store');
Route::put('/admin/paket/{id}', [PaketController::class, 'update'])->name('paket.update');
Route::delete('/admin/paket/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');

// Rute Transaksi
Route::get('/admin/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/admin/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

// Rute Riwayat & Pembayaran
Route::get('/admin/pembayaran', [TransaksiController::class, 'pembayaran'])->name('pembayaran.index');
Route::post('/admin/pembayaran/simpan', [App\Http\Controllers\TransaksiController::class, 'simpanPembayaran']);

// Kasir
Route::get('/admin/kasir', [TransaksiController::class, 'kasirIndex'])->name('kasir.index');
Route::post('/admin/kasir/bayar', [TransaksiController::class, 'prosesPembayaran'])->name('kasir.bayar');

// Rute API Pencarian
Route::get('/api/transaksi/{invoice}', [TransaksiController::class, 'cariTransaksi'])->name('api.transaksi.cari');

Route::get('/admin/notifications', function() {
    return response()->json([
        'unread_count' => \App\Models\Notification::where('sudah_dibaca', false)->count(),
        'notifications' => \App\Models\Notification::latest()->take(10)->get(),
    ]);
});

Route::post('/admin/notifications/read-all', function() {
    \App\Models\Notification::where('sudah_dibaca', false)->update(['sudah_dibaca' => true]);
    return response()->json(['success' => true]);
});