@extends('layouts.app')

@section('title', 'Kasir & Pembayaran')

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
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 900;
    }
    .badge-red   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
    .badge-green { background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a; }
    .badge-blue  { background:#eff6ff; border:1px solid #bfdbfe; color:#2563eb; }
    .table-th { padding:1rem 1.5rem; font-weight:900; font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; text-align:left; }
    .table-td { padding:1rem 1.5rem; font-size:0.875rem; }
    
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeSlideIn 0.3s ease forwards; }
</style>

<div class="flex justify-between items-center mb-8 print-hidden">
    <div>
        <h1 class="text-3xl font-black text-gray-800">Kasir & Pembayaran</h1>
        <p class="text-gray-400 text-xs tracking-widest uppercase mt-1">Selesaikan pelunasan tagihan berdasarkan nomor invoice</p>
    </div>
    <div class="flex items-center gap-2 bg-white border border-gray-100 rounded-2xl px-4 py-2 shadow-sm">
        <i class="bi bi-calendar3 text-blue-400 text-sm"></i>
        <span class="text-xs font-bold text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm font-bold text-green-700 rounded-2xl flex items-center gap-3 print-hidden">
        <i class="bi bi-check-circle-fill text-green-500 text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-12 print-hidden">

    <div class="xl:col-span-3 card">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="bi bi-search text-blue-600"></i>
            </div>
            <div>
                <h2 class="font-black text-gray-800 text-base">Cari Invoice</h2>
                <p class="text-[10px] text-gray-400 font-medium">Masukkan ID transaksi atau nomor invoice</p>
            </div>
        </div>

        <div class="mb-6">
            <label class="form-label">ID Transaksi / Invoice</label>
            <div class="flex gap-3">
                <input type="text" id="kode_invoice" placeholder="Contoh: 4 atau INV-004"
                    class="form-input" onkeydown="if(event.key==='Enter') cariDataInvoice()">
                <button onclick="cariDataInvoice()"
                    class="px-7 py-3 bg-[#003049] text-white font-black rounded-2xl text-sm hover:opacity-90 transition shadow-md whitespace-nowrap flex items-center gap-2">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </div>

        <div id="form_pembayaran" class="hidden animate-fade-in">

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div class="bg-blue-50 rounded-2xl p-4">
                    <span class="block text-[9px] font-black uppercase tracking-widest text-blue-400 mb-1">Pelanggan</span>
                    <span class="font-black text-gray-800 text-base" id="nama_pelanggan">-</span>
                </div>
                <div class="bg-gray-50 rounded-2xl p-4">
                    <span class="block text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Layanan</span>
                    <span class="font-black text-gray-700 text-sm" id="layanan_text">-</span>
                </div>
            </div>

            <div class="rounded-2xl p-6 mb-5 flex justify-between items-center shadow-lg"
                style="background: linear-gradient(135deg, #03045E 0%, #0077B6 100%);">
                <div>
                    <span class="block text-[9px] uppercase font-black text-blue-200 tracking-widest mb-1">Total Tagihan</span>
                    <span class="text-4xl font-black text-white" id="total_tagihan_display">Rp 0</span>
                </div>
                <button onclick="prosesPembayaran()" id="btn_bayar"
                    class="px-8 py-4 bg-[#FFB703] text-gray-900 font-black rounded-2xl shadow-lg hover:bg-[#FB8500] hover:text-white transition transform active:scale-95 text-sm">
                    <i class="bi bi-cash-coin mr-1"></i> BAYAR
                </button>
            </div>

            <div class="flex gap-3">
                <button onclick="cetakKwitansiHalaman()"
                    class="flex-1 py-3.5 border-2 border-gray-200 rounded-2xl text-xs font-black text-gray-600 hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <i class="bi bi-printer-fill text-blue-500"></i> Cetak Kwitansi
                </button>
                <form action="{{ url('/admin/pembayaran/simpan') }}" method="POST" class="flex-1" id="form_simpan">
                    @csrf
                    <input type="hidden" name="transaksi_id" id="input_transaksi_id" value="">
                    <button type="submit" onclick="return confirm('Konfirmasi pelunasan Invoice ini?')"
                        class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black rounded-2xl text-xs hover:from-emerald-700 hover:to-teal-700 transition shadow-md flex items-center justify-center gap-2">
                        <i class="bi bi-wallet-fill"></i> Tambah Pembayaran
                    </button>
                </form>
            </div>
        </div>

        <div id="alert_invoice_not_found"
            class="hidden p-4 mt-4 bg-red-50 border border-red-200 text-xs font-bold text-red-700 rounded-2xl flex items-center gap-3">
            <i class="bi bi-exclamation-circle-fill text-red-400 text-lg"></i>
            Transaksi tidak ditemukan. Masukkan angka ID transaksi yang benar.
        </div>
    </div>

    <div class="xl:col-span-2 card flex flex-col">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-9 h-9 rounded-xl bg-yellow-50 flex items-center justify-center">
                <i class="bi bi-calculator text-yellow-500"></i>
            </div>
            <div>
                <h2 class="font-black text-gray-800 text-base">Kalkulator Kembalian</h2>
                <p class="text-[10px] text-gray-400 font-medium">Hitung uang kembalian pelanggan</p>
            </div>
        </div>

        <div class="mb-5">
            <label class="form-label">Nominal Diterima</label>
            <input type="number" id="jumlah_uang" placeholder="0"
                oninput="hitungKembalian()"
                class="form-input text-lg font-black">
        </div>

        <div class="rounded-2xl p-6 text-center shadow-md mb-5 flex-1 flex flex-col items-center justify-center"
            style="background: linear-gradient(135deg, #FFD166 0%, #FB8500 100%);">
            <span class="block text-[9px] uppercase font-black text-gray-800 tracking-widest mb-1">Kembalian</span>
            <span class="text-4xl font-black text-white drop-shadow" id="kembalian_display">Rp 0</span>
        </div>

        <p class="text-[9px] text-center text-gray-400 leading-relaxed mt-auto">
            *Pastikan uang fisik telah diterima pelanggan sebelum konfirmasi pelunasan.
        </p>
    </div>
</div>

<div class="print-hidden">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-black text-gray-800">Riwayat Pembayaran</h2>
            <p class="text-xs text-gray-400 font-medium mt-0.5">Daftar semua transaksi pembayaran</p>
        </div>
        <form method="GET" action="{{ url()->current() }}">
            <select name="status_pembayaran" onchange="this.form.submit()"
                class="px-5 py-2.5 bg-gradient-to-r from-blue-900 to-indigo-800 text-white rounded-2xl text-xs font-black border-none outline-none shadow cursor-pointer">
                <option value="">📋 Semua Status</option>
                <option value="Lunas"       {{ request('status_pembayaran') == 'Lunas'       ? 'selected' : '' }}>✅ Lunas</option>
                <option value="Belum Lunas" {{ request('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>⏳ Belum Lunas</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-4">
        <table class="min-w-full text-left">
            <thead>
                <tr style="background: linear-gradient(90deg, #1e3a5f 0%, #2d4a7a 100%);">
                    <th class="table-th text-white">Invoice</th>
                    <th class="table-th text-white">Pelanggan</th>
                    <th class="table-th text-white">Paket / Layanan</th>
                    <th class="table-th text-white">Total Harga</th>
                    <th class="table-th text-white">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transaksis ?? [] as $t)
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
                    <td class="table-td font-black text-blue-700">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="table-td">
                        <span class="badge {{ $t->status_pembayaran == 'Lunas' ? 'badge-green' : 'badge-red' }}">
                            <i class="bi {{ $t->status_pembayaran == 'Lunas' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                            {{ $t->status_pembayaran ?? 'Belum Lunas' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="bi bi-inbox text-4xl text-gray-200"></i>
                            <p class="text-gray-400 font-bold text-sm">Belum ada riwayat pembayaran</p>
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
</div>

<div id="print_area" class="hidden p-10 bg-white max-w-2xl mx-auto rounded-3xl relative overflow-hidden font-sans border-2 border-gray-100 shadow-sm">
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0 opacity-[0.04]">
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" fill="currentColor" viewBox="0 0 16 16">
            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .364-1.008zm-.49 3.695.837-1.046.95 1.083A1.375 1.375 0 0 0 5.75 5.5a1.375 1.375 0 0 0 2.5 0 1.375 1.375 0 0 0 2.5 0 1.375 1.375 0 0 0 1.453-.768l.95-1.083.836 1.046A.5.5 0 0 0 14.5 5.37v.255a1.375 1.375 0 0 1-2.75 0 .5.5 0 0 0-1 0 1.375 1.375 0 0 1-2.75 0 .5.5 0 0 0-1 0 1.375 1.375 0 0 1-2.75 0 .5.5 0 0 0-1 0 1.375 1.375 0 0 1-2.75 0V5.37a.5.5 0 0 0 .48-.325z"/>
        </svg>
    </div>
    <div class="relative z-10">
        <div class="mb-6">
            <h2 class="text-2xl font-black text-gray-800 tracking-widest uppercase">KWITANSI</h2>
            <hr class="mt-2 border-gray-300">
        </div>
        <div class="flex justify-between items-end mb-6">
            <div>
                <p class="text-[11px] font-bold text-gray-500 mb-1">Nama Pelanggan</p>
                <p class="text-xl font-black text-gray-900" id="print_nama">-</p>
            </div>
            <div class="text-right">
                <p class="text-[11px] font-bold text-gray-500 mb-1">Nomor Invoice</p>
                <p class="text-xl font-black text-gray-900" id="print_invoice">-</p>
            </div>
        </div>
        <div class="bg-[#F8FAFC] rounded-2xl p-6 mb-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                <p class="text-sm font-bold text-gray-600">Layanan</p>
                <p class="text-sm font-black text-gray-900" id="print_layanan">-</p>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <p class="text-[11px] font-bold text-gray-500">Tanggal Masuk:</p>
                    <p class="text-[11px] font-black text-gray-800" id="print_tgl_masuk">-</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-[11px] font-bold text-gray-500">Tanggal Selesai:</p>
                    <p class="text-[11px] font-black text-gray-800" id="print_tgl_selesai">-</p>
                </div>
            </div>
        </div>
        <div class="mb-8">
            <div class="bg-[#E2E8F0] rounded-t-xl px-6 py-3 flex justify-between items-center">
                <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest">Deskripsi</p>
                <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest">Jumlah</p>
            </div>
            <div class="px-6 py-5 border-x border-b border-gray-200 rounded-b-xl space-y-4">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-bold text-gray-700">Total Tagihan</p>
                    <p class="text-sm font-medium text-gray-800" id="print_tagihan">Rp 0</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-sm font-bold text-gray-700">Pembayaran</p>
                    <p class="text-sm font-medium text-gray-800" id="print_bayar">Rp 0</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-sm font-bold text-gray-700">Kembalian</p>
                    <p class="text-sm font-medium text-[#2ECC71]" id="print_kembalian">Rp 0</p>
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center border-t border-gray-300 pt-6 mb-8">
            <p class="text-lg font-black text-gray-800 uppercase tracking-widest">Total Dibayar</p>
            <p class="text-2xl font-black text-gray-900" id="print_total_dibayar">Rp 0</p>
        </div>
        <div class="text-center pt-4">
            <p class="text-[11px] font-bold text-gray-800">Terima kasih telah mempercayakan layanan kepada kami.</p>
        </div>
    </div>
</div>

<script>
    let selectedId = null;

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    function formatTanggal(tanggal) {
        if (!tanggal) return '-';
        const date = new Date(tanggal);
        const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return `${date.getDate()} ${bulan[date.getMonth()]} ${date.getFullYear()}`;
    }

    function hitungKembalian() {
        const jumlahUang = parseInt(document.getElementById('jumlah_uang').value) || 0;
        const total = parseInt(document.getElementById('btn_bayar').getAttribute('data-total')) || 0;
        const kembalian = Math.max(0, jumlahUang - total);
        document.getElementById('kembalian_display').textContent = formatRupiah(kembalian);
    }

    function cariDataInvoice() {
        let id = document.getElementById('kode_invoice').value;
        if (!id) { alert('Silakan masukkan nomor invoice atau ID terlebih dahulu.'); return; }
        id = id.replace('INV-', '').trim();

        fetch(`/api/transaksi/${id}`)
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data) {
                    selectedId = res.data.id;

                    document.getElementById('nama_pelanggan').textContent        = res.pelanggan;
                    document.getElementById('layanan_text').textContent          = res.paket;
                    document.getElementById('total_tagihan_display').textContent = formatRupiah(res.tagihan);

                    document.getElementById('print_nama').textContent       = res.pelanggan;
                    document.getElementById('print_invoice').textContent    = "INV-" + String(res.data.id).padStart(3, '0');
                    document.getElementById('print_layanan').textContent    = res.paket + " - " + res.data.berat + " Kg";
                    document.getElementById('print_tgl_masuk').textContent  = formatTanggal(res.data.tanggal_masuk);
                    document.getElementById('print_tgl_selesai').textContent= formatTanggal(res.data.tanggal_selesai);
                    document.getElementById('print_tagihan').textContent    = formatRupiah(res.tagihan);

                    document.getElementById('btn_bayar').setAttribute('data-total', res.tagihan);
                    document.getElementById('input_transaksi_id').value = selectedId;

                    document.getElementById('form_pembayaran').classList.remove('hidden');
                    document.getElementById('alert_invoice_not_found').classList.add('hidden');

                    document.getElementById('kembalian_display').textContent = 'Rp 0';
                    document.getElementById('jumlah_uang').value = '';
                } else {
                    document.getElementById('form_pembayaran').classList.add('hidden');
                    document.getElementById('alert_invoice_not_found').classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error("Error:", err);
                document.getElementById('form_pembayaran').classList.add('hidden');
                document.getElementById('alert_invoice_not_found').classList.remove('hidden');
            });
    }

    function prosesPembayaran() {
        const jumlahUang = parseInt(document.getElementById('jumlah_uang').value) || 0;
        const total      = parseInt(document.getElementById('btn_bayar').getAttribute('data-total')) || 0;

        if (jumlahUang < total) { alert('Nominal uang yang dimasukkan kurang dari total tagihan!'); return; }

        const kembalian = jumlahUang - total;
        document.getElementById('kembalian_display').textContent    = formatRupiah(kembalian);
        document.getElementById('print_bayar').textContent          = formatRupiah(jumlahUang);
        document.getElementById('print_kembalian').textContent      = formatRupiah(kembalian);
        document.getElementById('print_total_dibayar').textContent  = formatRupiah(jumlahUang);

        const btn = document.getElementById('btn_bayar');
        btn.className   = 'px-8 py-4 bg-green-500 text-white font-black rounded-2xl shadow transition text-sm';
        btn.innerHTML   = '<i class="bi bi-check-circle-fill mr-1"></i> Lunas';
    }

    function cetakKwitansiHalaman() { window.print(); }
</script>

<style>
    @media print {
        html, body { background-color: #ffffff !important; background-image: none !important; }
        .print-hidden { display: none !important; }
        body * { visibility: hidden; }
        #print_area, #print_area * { visibility: visible; }
        #print_area {
            display: block !important;
            position: absolute;
            left: 0; right: 0; top: 0;
            margin: 0 auto !important;
            width: 100% !important;
            max-width: 800px !important;
            padding: 40px !important;
            background-color: #ffffff !important;
            border: none !important;
            box-shadow: none !important;
        }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>

@endsection