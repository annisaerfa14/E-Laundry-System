@extends('layouts.app')

@section('title', 'Kelola Data Paket')

@section('content')
    <h1 class="text-3xl font-black text-gray-800 mb-2">Menu Paket Layanan</h1>
    <p class="text-xs text-gray-500 uppercase tracking-wider mb-8">Kelola dan input paket layanan laundry</p>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-sm font-bold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <table class="min-w-full text-left">
            <thead class="bg-[#DBEAFE] text-blue-900">
                <tr>
                    <th class="px-6 py-4 font-bold uppercase text-xs w-16">No</th>
                    <th class="px-6 py-4 font-bold uppercase text-xs">Nama Paket</th>
                    <th class="px-6 py-4 font-bold uppercase text-xs">Harga per Kg (Rp)</th>
                    <th class="px-6 py-4 font-bold uppercase text-xs text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm text-gray-700 font-medium">
                @forelse($pakets as $index => $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-blue-800 font-black">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-black text-gray-800">{{ $p->nama_paket }}</td>
                    <td class="px-6 py-4 font-black text-gray-600">Rp {{ number_format($p->harga_per_kg, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-4">
                            <button onclick="document.getElementById('modalEdit{{ $p->id }}').classList.remove('hidden')" class="text-blue-600 hover:text-blue-800 font-bold">
                                <i class="bi bi-pencil-square text-base"></i> Edit
                            </button>
                            <form action="{{ route('paket.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket {{ $p->nama_paket }} ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold">
                                    <i class="bi bi-trash-fill text-base"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <div id="modalEdit{{ $p->id }}" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
                    <div class="bg-white p-8 rounded-3xl shadow-xl w-[400px]">
                        <h2 class="text-2xl font-black text-gray-800 mb-6">Edit Paket</h2>
                        
                        <form action="{{ route('paket.update', $p->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Nama Paket</label>
                                    <input type="text" name="nama_paket" value="{{ $p->nama_paket }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-blue-500 text-sm font-medium" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Harga per Kg (Rp)</label>
                                    <input type="number" name="harga_per_kg" value="{{ $p->harga_per_kg }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-blue-500 text-sm font-medium" required>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end gap-3">
                                <button type="button" onclick="document.getElementById('modalEdit{{ $p->id }}').classList.add('hidden')" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-2xl text-sm hover:bg-gray-300 transition">Batal</button>
                                <button type="submit" class="px-6 py-3 bg-[#003049] text-white font-bold rounded-2xl text-sm hover:bg-blue-900 transition">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data paket yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-black text-gray-800 mb-6 flex items-center gap-2">
                <i class="bi bi-plus-circle-fill text-blue-900"></i> Input Paket Baru
            </h3>
            <form action="{{ route('paket.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Nama Paket</label>
                        <input type="text" name="nama_paket" placeholder="Contoh: Cuci Setrika Ekspres" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-blue-500 text-sm font-medium" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Harga per Kg (Rp)</label>
                        <input type="number" name="harga_per_kg" placeholder="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-blue-500 text-sm font-medium" required>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="reset" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-2xl text-sm hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="px-6 py-3 bg-[#003049] text-white font-bold rounded-2xl text-sm hover:bg-blue-900 transition">Simpan Paket</button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="bg-[#DDEBFF] p-6 rounded-3xl border border-blue-100">
                <div class="text-2xl mb-2">
                    <i class="bi bi-info-circle-fill text-blue-900"></i>
                </div>
                <h4 class="font-black text-blue-900 text-xs tracking-widest uppercase mb-2">Informasi Paket</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Kebijakan penentuan harga paket laundry harus disesuaikan dengan standar operasional perusahaan. Pastikan input harga sudah termasuk PPN.
                </p>
            </div>

            <div class="bg-[#FFD166] rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="block text-[10px] uppercase font-black text-gray-700 tracking-widest mb-1">TOTAL PAKET AKTIF</span>
                    <span class="text-4xl font-black text-gray-900">{{ $pakets->count() }}</span>
                    <span class="text-xs font-black text-gray-800 ml-1">Layanan</span>
                </div>
                <i class="bi bi-box-seam text-3xl text-gray-800 opacity-80"></i>
            </div>
        </div>
    </div>
@endsection