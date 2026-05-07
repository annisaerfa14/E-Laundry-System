@extends('layouts.app')

@section('title', 'Kasir & Pembayaran')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-800">Kasir & Pembayaran</h1>
            <p class="text-gray-500 text-xs tracking-wider uppercase mt-1">Selesaikan pelunasan tagihan berdasarkan nomor invoice</p>
        </div>
        <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100">
            <span class="text-xs font-bold text-gray-600">Administrator:</span>
            <span class="text-sm font-black text-blue-800">Admin Nisa</span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-sm font-bold text-green-700 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mb-12">
        <div class="flex-1 col-span-2">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm mb-8">
                <div class="mb-6">
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Cari ID Transaksi / Invoice</label>
                    <div class="flex gap-3">
                        <input type="text" id="kode_invoice" placeholder="Contoh: 4 atau INV-004 (Masukkan angka ID)" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:border-blue-500 text-sm font-medium">
                        <button onclick="cariDataInvoice()" class="px-6 py-3 bg-[#003049] text-white font-bold rounded-2xl text-sm hover:bg-blue-900 transition">
                            Cari
                        </button>
                    </div>
                </div>

                <div id="form_pembayaran" class="hidden">
                    <div class="p-6 bg-gray-50 rounded-2xl mb-6">
                        <span class="block text-[10px] font-black uppercase text-gray-400 tracking-wider mb-1">Pelanggan</span>
                        <span class="font-black text-xl text-gray-800" id="nama_pelanggan">-</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="block text-[9px] font-black uppercase text-gray-400 mb-1">Nomor Invoice</span>
                            <span class="font-black text-gray-700" id="invoice_text">#INV-</span>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="block text-[9px] font-black uppercase text-gray-400 mb-1">Layanan</span>
                            <span class="font-bold text-gray-700 text-sm" id="layanan_text">-</span>
                        </div>
                    </div>

                    <div class="p-8 bg-[#023E8A] rounded-3xl flex justify-between items-center shadow-lg mb-6">
                        <div>
                            <span class="block text-[9px] uppercase font-black text-blue-200 tracking-widest mb-1">Total Tagihan</span>
                            <span class="text-4xl font-black text-white" id="total_tagihan_display">Rp 0</span>
                        </div>
                        <button onclick="prosesPembayaran()" id="btn_bayar" class="px-8 py-4 bg-[#D00000] text-white font-black rounded-2xl shadow hover:bg-red-800 transition">
                            BAYAR
                        </button>
                    </div>

                    <div class="flex gap-4">
                        <button onclick="window.print()" class="flex-1 py-4 text-center border-2 border-gray-300 rounded-2xl text-xs font-black text-gray-700 hover:bg-gray-50 transition">
                            <i class="bi bi-printer-fill"></i> Cetak Kwitansi
                        </button>
                        <form id="form_simpan" action="#" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_pembayaran" value="Lunas">
                            <button type="button" onclick="simpanPembayaran()" id="btn_tambah_pembayaran" class="w-full py-4 bg-[#03045E] text-white font-black rounded-2xl text-xs hover:bg-indigo-900 transition">
                                <i class="bi bi-wallet-fill"></i> Tambah Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

                <div id="alert_invoice_not_found" class="hidden p-4 mt-4 bg-red-50 border border-red-200 text-xs font-bold text-red-700 rounded-2xl text-center">
                    Transaksi tidak ditemukan. Masukkan angka ID transaksi yang benar.
                </div>
            </div>
        </div>

        <div class="w-96 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm self-start">
            <div class="mb-6">
                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Nominal Diterima</label>
                <input type="number" id="jumlah_uang" placeholder="Rp 0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-gray-700 focus:outline-none focus:border-blue-500 text-sm">
            </div>
            
            <div class="p-6 bg-[#FFD166] rounded-2xl mb-8 text-center shadow-inner">
                <span class="block text-[10px] uppercase font-black text-gray-700 tracking-widest mb-1">Kembalian / Sisa Uang</span>
                <span class="text-3xl font-black text-gray-900" id="kembalian_display">Rp 0</span>
            </div>

            <p class="text-[10px] text-gray-400 leading-relaxed text-center">
                *Harap pastikan uang fisik telah diterima pelanggan sebelum melakukan konfirmasi pelunasan.
            </p>
        </div>
    </div>

    <div class="max-w-6xl">
        <h2 class="text-xl font-black text-gray-800 mb-4">Riwayat Transaksi Masuk</h2>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full text-left">
                <thead class="bg-[#DBEAFE] text-blue-900">
                    <tr>
                        <th class="px-6 py-4 font-bold uppercase text-xs">Invoice</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs">Pelanggan</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs">Paket / Layanan</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs">Total Harga</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-700 font-medium">
                    @forelse($transaksis ?? [] as $t)
                    <tr>
                        <td class="px-6 py-4 font-black text-blue-900">INV-{{ str_pad($t->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 font-black text-gray-800">{{ $t->pelanggan->nama_pelanggan }}</td>
                        <td class="px-6 py-4 text-xs font-black">{{ $t->paket->nama_paket }} ({{ $t->berat }} Kg)</td>
                        <td class="px-6 py-4 font-black text-blue-600">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 {{ $t->status_pembayaran == 'Lunas' ? 'bg-blue-50 border border-blue-100 text-blue-600' : 'bg-red-50 border border-red-100 text-red-600' }} text-[9px] font-black rounded-full">
                                {{ $t->status_pembayaran ?? 'Belum Lunas' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Belum ada riwayat transaksi dari database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let selectedId = null;

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        function cariDataInvoice() {
            let id = document.getElementById('kode_invoice').value;
            id = id.replace('INV-', '');

            if (!id) return alert('Silakan masukkan ID atau nomor invoice terlebih dahulu.');

            fetch(`/api/transaksi/${id}`)
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        selectedId = res.data.id;
                        document.getElementById('nama_pelanggan').textContent = res.pelanggan;
                        document.getElementById('layanan_text').textContent = res.paket;
                        document.getElementById('invoice_text').textContent = "#INV-" + String(res.data.id).padStart(3, '0');
                        document.getElementById('total_tagihan_display').textContent = formatRupiah(res.tagihan);
                        
                        document.getElementById('btn_bayar').setAttribute('data-total', res.tagihan);
                        document.getElementById('form_simpan').action = `/admin/transaksi/${res.data.id}/status`;

                        document.getElementById('form_pembayaran').classList.remove('hidden');
                        document.getElementById('alert_invoice_not_found').classList.add('hidden');
                    } else {
                        document.getElementById('form_pembayaran').classList.add('hidden');
                        document.getElementById('alert_invoice_not_found').classList.remove('hidden');
                    }
                })
                .catch(err => {
                    console.error("Error memuat data:", err);
                });
        }

        function prosesPembayaran() {
            const jumlahUang = parseInt(document.getElementById('jumlah_uang').value) || 0;
            const total = parseInt(document.getElementById('btn_bayar').getAttribute('data-total')) || 0;

            if (jumlahUang < total) {
                alert('Nominal uang yang dimasukkan kurang dari total tagihan!');
                return;
            }

            const kembalian = jumlahUang - total;
            document.getElementById('kembalian_display').textContent = formatRupiah(kembalian);

            const btnBayar = document.getElementById('btn_bayar');
            btnBayar.className = 'px-8 py-4 bg-green-600 text-white font-black rounded-2xl shadow transition';
            btnBayar.textContent = '✓ Lunas';
        }

        function simpanPembayaran() {
            if (!selectedId) return alert('Lakukan pencarian transaksi terlebih dahulu.');
            alert('Pembayaran berhasil dikonfirmasi dan disimpan.');
            document.getElementById('form_simpan').submit();
        }
    </script>
@endsection