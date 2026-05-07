@extends('layouts.app')

@section('title', 'Edit Pelanggan')

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
</style>

<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('pelanggan.index') }}"
            class="w-10 h-10 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center hover:bg-gray-50 transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-gray-800">Edit Data Pelanggan</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">Ubah data identitas pelanggan</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-4"
            style="background: linear-gradient(135deg, #f0f7ff 0%, #e8f4fd 100%);">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-black shadow-md">
                {{ strtoupper(substr($pelanggan->nama_pelanggan, 0, 1)) }}
            </div>
            <div>
                <p class="font-black text-gray-800 text-lg">{{ $pelanggan->nama_pelanggan }}</p>
                <p class="text-xs text-blue-600 font-black">PLG-{{ str_pad($pelanggan->id, 3, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan"
                            value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}"
                            class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">Nomor Telepon</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="bi bi-telephone-fill text-sm"></i>
                            </span>
                            <input type="text" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $pelanggan->nomor_telepon ?? $pelanggan->no_telepon) }}"
                                class="form-input" style="padding-left:2.75rem;" required>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-input" style="height:100px;resize:none;"
                            required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('pelanggan.index') }}"
                        class="flex-1 py-3.5 text-center bg-gray-100 text-gray-600 font-black rounded-2xl text-sm hover:bg-gray-200 transition flex items-center justify-center gap-2">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    <button type="submit"
                        class="flex-1 py-3.5 bg-[#003049] text-white font-black rounded-2xl text-sm hover:opacity-90 transition shadow-md flex items-center justify-center gap-2">
                        <i class="bi bi-save-fill"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection