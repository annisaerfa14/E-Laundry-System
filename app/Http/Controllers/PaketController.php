<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // Tampilkan Data
    public function index()
    {
        $pakets = Paket::all();
        $totalPaket = Paket::count(); 
        return view('admin.paket.index', compact('pakets', 'totalPaket'));
    }

    //Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'harga_per_kg' => 'required|numeric',
        ]);

        Paket::create($request->all());
        return redirect()->back()->with('success', 'Paket layanan berhasil ditambah!');
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->update($request->all());
        return redirect()->back()->with('success', 'Paket layanan berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();
        return redirect()->back()->with('success', 'Paket layanan berhasil dihapus!');
    }
}