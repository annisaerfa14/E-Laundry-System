<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
        ]);
        
        \App\Models\Notification::create([
            'judul' => 'Pelanggan Baru Terdaftar',
            'pesan' => $request->nama_pelanggan . ' baru saja mendaftar sebagai pelanggan.',
            'tipe'  => 'pelanggan',
        ]);

        Pelanggan::create($request->all());
        return redirect()->back()->with('success', 'Data pelanggan berhasil ditambah!');
        
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Data pelanggan berhasil dihapus!');
    }
}