@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')

<style>
    .form-input {
        width: 100%;
        padding: 0.875rem 1.25rem;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.2s;
        outline: none;
    }
    .form-input:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.08);
    }
    .form-label {
        display: block;
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 0.5rem;
    }
    .table-th { padding: 1rem 1.5rem; font-weight: 900; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.08em; text-align: left; }
    .table-td { padding: 1rem 1.5rem; font-size: 0.875rem; }
</style>

{{-- Header --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-gray-800">Manajemen Pelanggan</h1>
        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Kelola data identitas pelanggan</p>
    </div>
    <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
        class="flex items-center gap-2 bg-[#FDE047] px-5 py-3 rounded-2xl font-black text-gray-900 shadow-sm hover:bg-yellow-400 transition text-sm">
        <i class="bi bi-person-plus-fill text-lg"></i> Tambah Pelanggan Baru
    </button>
</div>

@if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-sm font-bold text-green-700 flex items-center gap-3">
        <i class="bi bi-check-circle-fill text-green-500"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Stat Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="rounded-2xl border border-blue-100 shadow-sm p-5 flex items-center gap-4" style="background:#C7E7FF;">
        <div class="w-12 h-12 rounded-2xl bg-white/60 flex items-center justify-center shrink-0">
            <i class="bi bi-people-fill text-blue-600 text-xl"></i>
        </div>
        <div>
            <span class="block text-[9px] font-black uppercase tracking-widest text-blue-700 mb-0.5">Total Pelanggan</span>
            <span class="text-3xl font-black text-blue-900">{{ $pelanggans->count() }}</span>
        </div>
    </div>
        <div class="rounded-2xl border border-yellow-200 shadow-sm p-5 flex items-center gap-4" style="background:#FCE263;">
            <div class="w-12 h-12 rounded-2xl bg-white/60 flex items-center justify-center shrink-0">
                <i class="bi bi-person-badge-fill text-yellow-700 text-xl"></i>
            </div>
            <div>
                <span class="block text-[9px] font-black uppercase tracking-widest text-yellow-800 mb-0.5">Pelanggan Baru</span>
                <span class="text-3xl font-black text-yellow-900">{{ $pelanggans->count() }}</span>
            </div>
        </div>
            <div class="rounded-2xl border border-blue-100 shadow-sm p-5 flex items-center gap-4" style="background:#C7E7FF;">
            <div class="w-12 h-12 rounded-2xl bg-white/60 flex items-center justify-center shrink-0">
                <i class="bi bi-tags-fill text-blue-600 text-xl"></i>
            </div>
            <div>
                <span class="block text-[9px] font-black uppercase tracking-widest text-blue-700 mb-0.5">Info Promo</span>
                <span class="text-3xl font-black text-blue-900">10%</span>
            </div>
        </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
            <i class="bi bi-person-lines-fill text-blue-600 text-sm"></i>
        </div>
        <div>
            <h2 class="font-black text-gray-800 text-sm">Daftar Pelanggan</h2>
            <p class="text-[9px] text-gray-400">{{ $pelanggans->count() }} pelanggan terdaftar</p>
        </div>
    </div>
    <table class="min-w-full text-left">
        <thead>
            <tr style="background: linear-gradient(90deg, #1e3a5f 0%, #2d4a7a 100%);">
                <th class="table-th text-white">ID</th>
                <th class="table-th text-white">Nama Pelanggan</th>
                <th class="table-th text-white">Alamat</th>
                <th class="table-th text-white">No. Handphone</th>
                <th class="table-th text-white text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($pelanggans as $p)
            <tr class="hover:bg-blue-50/30 transition-colors">
                <td class="table-td">
                    <span class="font-black text-blue-800 bg-blue-50 px-3 py-1 rounded-lg text-xs">
                        PLG-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </td>
                <td class="table-td">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white text-xs font-black shrink-0">
                            {{ strtoupper(substr($p->nama_pelanggan, 0, 1)) }}
                        </div>
                        <span class="font-black text-gray-800">{{ $p->nama_pelanggan }}</span>
                    </div>
                </td>
                <td class="table-td text-gray-500 font-medium">{{ $p->alamat }}</td>
                <td class="table-td">
                    <span class="font-bold text-gray-700 flex items-center gap-1.5">
                        <i class="bi bi-telephone-fill text-blue-400 text-xs"></i>
                        {{ $p->nomor_telepon ?? $p->no_telepon }}
                    </span>
                </td>
                <td class="table-td">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('pelanggan.edit', $p->id) }}"
                            class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 font-black text-xs rounded-xl hover:bg-blue-100 transition">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 font-black text-xs rounded-xl hover:bg-red-100 transition">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center gap-2">
                        <i class="bi bi-people text-4xl text-gray-200"></i>
                        <p class="text-gray-400 font-bold text-sm">Belum ada data pelanggan terdaftar.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-3xl shadow-2xl w-[440px] border border-gray-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-2xl bg-yellow-50 flex items-center justify-center">
                <i class="bi bi-person-plus-fill text-yellow-500 text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-black text-gray-800">Tambah Pelanggan Baru</h2>
                <p class="text-[9px] text-gray-400 uppercase tracking-widest">Isi data identitas pelanggan</p>
            </div>
        </div>

        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" placeholder="Contoh: Budi Santoso"
                        class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" placeholder="Contoh: 08123456789"
                        class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" placeholder="Masukkan alamat lengkap..."
                        class="form-input" style="height:96px;resize:none;" required></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="button"
                    onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="flex-1 py-3 bg-gray-100 text-gray-600 font-black rounded-2xl text-sm hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 py-3 bg-[#003049] text-white font-black rounded-2xl text-sm hover:opacity-90 transition shadow-md">
                    <i class="bi bi-save-fill mr-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@endsection