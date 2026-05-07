@extends('layouts.app')

@section('title', 'Transaksi Cucian Masuk')

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
    .card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 16px rgba(0,0,0,0.05);
        padding: 2rem;
    }
    .btn-primary {
        width: 100%;
        padding: 1rem;
        background: #003049;
        color: #fff;
        font-weight: 900;
        border-radius: 14px;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.1s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-secondary {
        width: 100%;
        padding: 1rem;
        background: #f1f5f9;
        color: #003049;
        font-weight: 900;
        border-radius: 14px;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-secondary:hover { background: #e2e8f0; }
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 900;
    }
    .badge-red { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
    .badge-blue { background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; }
    .badge-green { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
    .table-th {
        padding: 1rem 1.5rem;
        font-weight: 900;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        text-align: left;
    }
    .table-td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
    }
    .nota-label {
        font-size: 0.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #94a3b8;
        margin-bottom: 0.25rem;
    }
    .nota-value {
        font-size: 0.9rem;
        font-weight: 900;
        color: #1e293b;
    }
    .total-box {
        background: linear-gradient(135deg, #FFD166 0%, #FFBA08 100%);
        border-radius: 16px;
        padding: 1rem 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(255,186,8,0.25);
    }
</style>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-black text-gray-800">Cucian Masuk</h1>
        <p class="text-gray-400 text-xs tracking-widest uppercase mt-1">Input detail pesanan pelanggan baru di sini.</p>
    </div>
    <div class="flex items-center gap-2 bg-white border border-gray-100 rounded-2xl px-4 py-2 shadow-sm">
        <i class="bi bi-calendar3 text-blue-400 text-sm"></i>
        <span class="text-xs font-bold text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm font-bold text-green-700 rounded-2xl flex items-center gap-3">
        <i class="bi bi-check-circle-fill text-green-500 text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-12">

    <div class="xl:col-span-3 card">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="bi bi-pencil-square text-blue-600"></i>
            </div>
            <div>
                <h2 class="font-black text-gray-800 text-base">Form Transaksi Baru</h2>
                <p class="text-[10px] text-gray-400 font-medium">Isi semua data di bawah ini dengan benar</p>
            </div>
        </div>

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="form-label">Pilih Pelanggan</label>
                <select name="pelanggan_id" onchange="hitungTotal()" class="form-input" required>
                    <option value="">Pilih Nama Pelanggan</option>
                    @foreach($pelanggans as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="form-label">Pilih Paket Layanan</label>
                <select name="paket_id" onchange="hitungTotal()" class="form-input" required>
                    <option value="">Pilih Paket Layanan</option>
                    @foreach($pakets as $p)
                        <option value="{{ $p->id }}" data-harga="{{ $p->harga_per_kg }}">
                            {{ $p->nama_paket }} (Rp {{ number_format($p->harga_per_kg, 0, ',', '.') }}/kg)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 items-end">
                <div>
                    <label class="form-label">Berat (Kg)</label>
                    <input type="number" id="berat" name="berat" oninput="hitungTotal()"
                        class="form-input" placeholder="Contoh: 3.5" step="0.1" min="0" required>
                </div>
                <div>
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" onchange="hitungTotal()"
                        class="form-input" required>
                </div>
                <div class="total-box">
                    <span class="text-[9px] font-black text-gray-700 tracking-widest uppercase mb-0.5">Total Harga</span>
                    <span class="text-xl font-black text-gray-900" id="total_harga_display">Rp 0</span>
                </div>
            </div>

            <div class="border-t border-gray-100 mb-6"></div>

            <button type="submit" class="btn-primary">
                <i class="bi bi-printer-fill"></i> Simpan & Cetak Nota
            </button>
            <button type="button" onclick="window.location.reload()" class="btn-secondary">
                <i class="bi bi-arrow-counterclockwise"></i> Buat Transaksi Baru
            </button>
        </form>
    </div>

    <div class="xl:col-span-2 card flex flex-col" style="background: linear-gradient(145deg, #fff 80%, #f0f7ff 100%);">

        <div class="flex justify-between items-start mb-5 pb-4 border-b border-dashed border-gray-200">
            <div>
                <p class="font-black text-[#006994] text-sm tracking-wide flex items-center gap-1.5">
                    <i class="bi bi-receipt"></i> E-LAUNDRY
                </p>
                <p class="text-[9px] text-gray-400 mt-1 leading-relaxed">Jl. Iskandar Baksir No.29<br>Pasar Manna</p>
            </div>
            <div class="text-right">
                <p class="text-[8px] font-black text-gray-300 uppercase tracking-widest">Invoice</p>
                <p class="text-base font-black text-gray-800">{{ $nextInv }}</p>
            </div>
        </div>

        <div class="flex-1 space-y-4">
            <div class="bg-gray-50 rounded-2xl p-4">
                <p class="nota-label">Pelanggan</p>
                <p class="nota-value" id="preview_pelanggan">-</p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-4">
                <p class="nota-label">Paket Layanan</p>
                <p class="nota-value mb-3" id="preview_paket">-</p>
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-[10px] text-gray-400">
                        <span>Tanggal Masuk</span>
                        <span class="font-bold text-gray-600">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px] text-gray-400">
                        <span>Tanggal Selesai</span>
                        <span class="font-bold text-gray-600" id="preview_tgl_selesai">-</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center border-t-2 border-dashed border-gray-200 pt-4">
                <span class="font-black text-gray-700 text-sm">Total Tagihan</span>
                <span class="text-2xl font-black text-[#006994]" id="preview_total">Rp 0</span>
            </div>

            <div class="flex flex-col gap-2 pt-1">
                <div class="badge badge-red w-full justify-center py-2">
                    <i class="bi bi-exclamation-circle-fill"></i> Status Pembayaran: Belum Lunas
                </div>
                <div class="badge badge-blue w-full justify-center py-2">
                    <i class="bi bi-clock-fill"></i> Status Cucian: Dalam Proses
                </div>
            </div>
        </div>

        <p class="text-[7px] text-center text-gray-500 font-bold mt-5 leading-relaxed uppercase tracking-wider border-t border-dashed border-gray-100 pt-4">
            Perhatian: Komplain kerusakan maksimal 1×24 jam setelah diambil.<br>Thank you for trusting us.
        </p>
    </div>
</div>

<div class="mb-4 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-black text-gray-800">Riwayat Transaksi</h2>
        <p class="text-xs text-gray-400 font-medium mt-0.5">Daftar semua transaksi cucian masuk</p>
    </div>
</div>

<form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-end gap-3 mb-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
    <div>
        <label class="form-label">Dari Tanggal</label>
        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
            class="form-input" style="width:180px;">
    </div>
    <div>
        <label class="form-label">Sampai Tanggal</label>
        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
            class="form-input" style="width:180px;">
    </div>
    <button type="submit"
        class="px-6 py-3 bg-[#003049] text-white font-black rounded-2xl text-xs hover:opacity-90 transition shadow flex items-center gap-2">
        <i class="bi bi-funnel-fill"></i> Filter
    </button>
    @if(request('tanggal_dari') || request('tanggal_sampai'))
    <a href="{{ url()->current() }}"
        class="px-6 py-3 bg-gray-100 text-gray-600 font-black rounded-2xl text-xs hover:bg-gray-200 transition flex items-center gap-2">
        <i class="bi bi-x-circle"></i> Reset
    </a>
    @endif
</form>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-4">
    <table class="min-w-full text-left">
       <thead>
            <tr style="background: linear-gradient(90deg, #1e3a5f 0%, #2d4a7a 100%);">
                <th class="table-th text-white">Invoice</th>
                <th class="table-th text-white">Pelanggan</th>
                <th class="table-th text-white">Paket / Layanan</th>
                <th class="table-th text-white">Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($transaksis as $t)
            <tr class="hover:bg-blue-50/30 transition-colors">
                <td class="table-td">
                    <span class="font-black text-blue-800 bg-blue-50 px-3 py-1 rounded-lg text-xs">
                        INV-{{ str_pad($t->id, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </td>
                    <td class="table-td font-bold text-gray-800">{{ $t->pelanggan->nama_pelanggan }}</td>
                    <td class="table-td text-xs font-semibold">
                        <span class="font-black text-gray-800">{{ $t->paket->nama_paket }}</span>
                        <span class="text-gray-400"> · {{ $t->berat }} Kg</span>
                    </td>
                <td class="table-td font-semibold text-gray-600">
                    {{ \Carbon\Carbon::parse($t->tanggal_selesai)->format('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center gap-2">
                        <i class="bi bi-inbox text-4xl text-gray-200"></i>
                        <p class="text-gray-400 font-bold text-sm">Belum ada riwayat transaksi.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="px-4 py-3 bg-white rounded-2xl border border-gray-100 shadow-sm print-hidden">
    {{ $transaksis->appends(['status_pembayaran' => request('status_pembayaran')])->links() }}
</div>

<script>
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    function resetPreview() {
        document.getElementById('preview_pelanggan').textContent = '-';
        document.getElementById('preview_paket').textContent = '-';
        document.getElementById('preview_tgl_selesai').textContent = '-';
        document.getElementById('preview_total').textContent = 'Rp 0';
        document.getElementById('total_harga_display').textContent = 'Rp 0';
    }

    function hitungTotal() {
        const pelangganSelect = document.querySelector('select[name="pelanggan_id"]');
        const paketSelect = document.querySelector('select[name="paket_id"]');
        const beratInput = document.getElementById('berat');
        const tglSelesaiInput = document.querySelector('input[name="tanggal_selesai"]');

        let hargaPerKg = 0;
        let namaPaket = '-';
        if (paketSelect && paketSelect.selectedIndex > 0) {
            const selectedOption = paketSelect.options[paketSelect.selectedIndex];
            hargaPerKg = selectedOption.getAttribute('data-harga') || 0;
            namaPaket = selectedOption.text.split(' (')[0];
        }

        let namaPelanggan = '-';
        if (pelangganSelect && pelangganSelect.selectedIndex > 0) {
            namaPelanggan = pelangganSelect.options[pelangganSelect.selectedIndex].text;
        }

        const berat = parseFloat(beratInput.value) || 0;
        const total = hargaPerKg * berat;

        document.getElementById('total_harga_display').textContent = formatRupiah(total);
        document.getElementById('preview_pelanggan').textContent = namaPelanggan;
        document.getElementById('preview_paket').textContent = namaPaket;
        document.getElementById('preview_total').textContent = formatRupiah(total);

        if (tglSelesaiInput && tglSelesaiInput.value) {
            const d = new Date(tglSelesaiInput.value);
            const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            document.getElementById('preview_tgl_selesai').textContent =
                `${d.getDate()} ${bulan[d.getMonth()]} ${d.getFullYear()}`;
        } else {
            document.getElementById('preview_tgl_selesai').textContent = '-';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const formElements = [
            document.querySelector('select[name="pelanggan_id"]'),
            document.querySelector('select[name="paket_id"]'),
            document.querySelector('input[name="tanggal_selesai"]'),
            document.getElementById('berat')
        ];
        formElements.forEach(el => {
            if (el) {
                el.addEventListener('change', hitungTotal);
                el.addEventListener('input', hitungTotal);
            }
        });
    });
</script>

@endsection