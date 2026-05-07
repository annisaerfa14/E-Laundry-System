<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $cucianMasuk = Transaksi::where('status_pembayaran', 'Belum Lunas')->count();

            $transaksiLunas = Transaksi::with(['pelanggan', 'paket'])
                                ->where('status_pembayaran', 'Lunas')
                                ->latest()
                                ->take(3)
                                ->get();

         $pendapatanHariIni = Transaksi::where('status_pembayaran', 'Lunas')
                            ->whereDate('updated_at', today())
                            ->sum('total_harga');

            $unreadCount = \App\Models\Notification::where('sudah_dibaca', false)->count();
        return view('admin.dashboard', compact('cucianMasuk', 'transaksiLunas', 'pendapatanHariIni', 'unreadCount'));
    }

    
}