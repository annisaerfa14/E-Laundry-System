<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Paket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
        {
            $pelanggans = \App\Models\Pelanggan::all();
            $pakets = \App\Models\Paket::all();
            $latest = \App\Models\Transaksi::latest()->first();
            $number = $latest ? $latest->id + 1 : 1;
            $nextInv = 'INV-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            $query = \App\Models\Transaksi::with(['pelanggan', 'paket'])->latest();

            if (request('tanggal_dari')) {
                $query->whereDate('tanggal_selesai', '>=', request('tanggal_dari'));
            }
            if (request('tanggal_sampai')) {
                $query->whereDate('tanggal_selesai', '<=', request('tanggal_sampai'));
            }
            $status = $request->input('status_pembayaran', 'Belum Lunas');
            
            if ($status !== 'Semua') {
                $query->where('status_pembayaran', $status);
            }
           $transaksis = $query->paginate(3);

            return view('admin.transaksi.index', compact('pelanggans', 'pakets', 'nextInv', 'transaksis'));
        }
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'paket_id' => 'required',
            'berat' => 'required|numeric|min:1',
            'tanggal_selesai' => 'required|date', 
        ]);

        $paket = Paket::findOrFail($request->paket_id);
        $total_harga = $paket->harga_per_kg * $request->berat;
        $tanggal_masuk = \Carbon\Carbon::now()->toDateString();

        $tanggal_selesai = $request->tanggal_selesai; 

        Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total_harga' => $total_harga,
            'tanggal_masuk' => $tanggal_masuk,
            'tanggal_selesai' => $tanggal_selesai, 
            'status_pembayaran' => 'Belum Lunas',
            'status_cucian' => 'Dalam Proses',
        ]);

        \App\Models\Notification::create([
            'judul' => 'Pesanan Baru Masuk',
            'pesan' => 'Pesanan baru dari ' . \App\Models\Pelanggan::find($request->pelanggan_id)->nama_pelanggan . ' telah dibuat.',
            'tipe'  => 'transaksi',
        ]);
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

        public function pembayaran(Request $request)
            {
                $status = $request->input('status_pembayaran');
                $query = Transaksi::with(['pelanggan', 'paket'])->latest();

                if ($status) {
                    $query->where('status_pembayaran', $status);
                }

                $transaksis = $query->paginate(10);

                return view('admin.pembayaran.index', compact('transaksis'));
            }

            public function simpanPembayaran(Request $request)
            {
                $transaksi = \App\Models\Transaksi::find($request->transaksi_id);
                
                if ($transaksi) {
                    $transaksi->status_pembayaran = 'Lunas';
                    $transaksi->save();

                \App\Models\Notification::create([
                    'judul' => 'Pembayaran Berhasil',
                    'pesan' => 'Pembayaran ' . $transaksi->pelanggan->nama_pelanggan . ' sebesar Rp ' . number_format($transaksi->total_harga, 0, ',', '.') . ' telah dikonfirmasi.',
                    'tipe'  => 'pembayaran',
                ]);
                    
                    return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi dan disimpan.');
                }
                
                return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
            }

    public function kasirIndex()
    {
        $totalPaket = Paket::count();
        $transaksis = Transaksi::with(['pelanggan', 'paket'])->latest()->get();
        return view('admin.kasir.index', compact('totalPaket', 'transaksis'));
    }

    public function cariTransaksi($invoice)
    {

        $id = str_replace('INV-', '', $invoice);
        
        $transaksi = Transaksi::with(['pelanggan', 'paket'])->find($id);

        if ($transaksi) {
            return response()->json([
                'success' => true,
                'data' => $transaksi,
                'pelanggan' => $transaksi->pelanggan->nama_pelanggan,
                'paket' => $transaksi->paket->nama_paket,
                'tagihan' => $transaksi->total_harga
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function prosesPembayaran(Request $request)
    {
        return redirect()->back()->with('success', 'Pembayaran berhasil diproses!');
    }
}