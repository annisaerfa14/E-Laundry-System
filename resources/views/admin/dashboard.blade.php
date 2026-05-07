@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- ===== PAGE HEADER ===== --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-black text-gray-800">Ringkasan Hari Ini</h1>
        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Pantau efisiensi operasional dan kas secara real-time</p>
    </div>

    <div class="flex items-center gap-3">
        <div class="text-right">
            <p class="text-sm font-black text-gray-700">Admin Nisa</p>
            <p class="text-[9px] text-gray-400 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="relative">
            <button onclick="toggleNotif()"
                class="w-10 h-10 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center hover:bg-gray-50 transition relative">
                <i class="bi bi-bell-fill text-gray-500 text-sm"></i>
                @if(isset($unreadCount) && $unreadCount > 0)
                <span id="notif-badge"
                    class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center">
                    {{ $unreadCount }}
                </span>
                @endif
            </button>

            <div id="notif-panel"
                class="hidden absolute right-0 mt-2 w-96 bg-white rounded-3xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100">
                    <h3 class="font-black text-gray-800">Pemberitahuan</h3>
                    <button onclick="tandaiSemuaDibaca()" class="text-[10px] font-black text-blue-600 hover:underline">
                        Tandai semua sebagai dibaca
                    </button>
                </div>
                <div id="notif-list" class="divide-y divide-gray-50 max-h-96 overflow-y-auto">
                    <div class="px-5 py-8 text-center text-gray-400 text-xs">Memuat notifikasi...</div>
                </div>
            </div>
        </div>
    </div>
</div>  {{-- ← penutup flex justify-between --}}

    <div class="grid grid-cols-3 gap-8">
        
        <div class="col-span-2 bg-white p-8 rounded-3xl border border-gray-50 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-gray-800">Tren Mingguan</h2>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Volume pencucian dalam 7 hari terakhir</span>
            </div>

            <div class="flex items-end justify-between h-56 px-4 border-b border-gray-100 pb-6 mb-6">
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-24 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#003049] rounded-t-lg h-10"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Sen</span>
                </div>
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-36 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#FFD166] rounded-t-lg h-6 absolute bottom-0"></div>
                        <div class="w-10 bg-[#003049] rounded-t-lg h-20 absolute bottom-6"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Sel</span>
                </div>
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-24 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#003049] rounded-t-lg h-12"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Rab</span>
                </div>
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-40 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#FFD166] rounded-t-lg h-14"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Kam</span>
                </div>
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-36 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#FFD166] rounded-t-lg h-4"></div>
                        <div class="w-10 bg-[#003049] rounded-t-lg h-24"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Jum</span>
                </div>
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-48 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#FFD166] rounded-t-lg h-10"></div>
                        <div class="w-10 bg-[#003049] rounded-t-lg h-28"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Sab</span>
                </div>
                <div class="flex flex-col items-center gap-2 flex-1 max-w-[48px]">
                    <div class="w-10 bg-gray-200 rounded-t-lg h-24 relative flex flex-col justify-end">
                        <div class="w-10 bg-[#003049] rounded-t-lg h-16"></div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Ming</span>
                </div>
            </div>

            <div class="flex items-center gap-6 text-[10px] font-bold text-gray-500 uppercase">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-[#003049] rounded-full"></span> Premium
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-[#FFD166] rounded-full"></span> Ekspres
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <div class="bg-[#DDEBFF] p-6 rounded-3xl shadow-sm border border-blue-100 flex justify-between items-center">
                    <div>
                        <span class="block text-[10px] uppercase font-black tracking-widest mb-1 opacity-75">Cucian Masuk</span>
                        <span class="text-4xl font-black">{{ $cucianMasuk ?? 0 }}</span>
                        <span class="text-xs font-black ml-1 opacity-90">Pesanan</span>
                    </div>
                <span class="text-[10px] font-black bg-green-500 text-white px-2.5 py-1 rounded-full">+12%</span>
            </div>

            <div class="bg-[#003049] p-6 rounded-3xl shadow-sm flex flex-col justify-between h-44">
                <div>
                    <span class="text-[9px] font-black uppercase text-blue-200 tracking-widest mb-2 block">Pendapatan Hari Ini</span>
                    <span class="text-3xl font-black text-white">
                        Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                    </span>
                </div>
                <span class="text-[9px] font-medium text-gray-400">
                    Terakhir diperbarui: {{ \Carbon\Carbon::now()->format('H:i') }} WIB
                </span>
            </div>
        </div>
    </div>

<div class="mt-8 bg-white p-8 rounded-3xl border border-gray-50 shadow-sm flex flex-col md:flex-row justify-between items-start gap-8">
    
    <div class="flex-1 w-full pr-0 md:pr-8 border-r-0 md:border-r border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-sm font-black text-gray-800 tracking-tight">Transaksi Terakhir (Lunas)</h3>
            <a href="{{ route('pembayaran.index') }}" class="text-[10px] font-black text-blue-700 hover:underline uppercase tracking-widest">Lihat Semua</a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-inner">
            <table class="min-w-full text-left">
                <thead class="bg-gradient-to-r from-emerald-50 via-green-50 to-emerald-100 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-4 font-bold uppercase text-[9px] text-emerald-800 tracking-widest">Pelanggan</th>
                        <th class="px-5 py-4 font-bold uppercase text-[9px] text-emerald-800 tracking-widest">Layanan</th>
                        <th class="px-5 py-4 font-bold uppercase text-[9px] text-emerald-800 tracking-widest text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-700 font-medium">
                    @forelse($transaksiLunas ?? [] as $t)
                    <tr class="hover:bg-emerald-50 transition-colors">
                        <td class="px-5 py-4 font-bold text-gray-800">
                            {{ $t->pelanggan->nama_pelanggan }}
                            <span class="block text-[10px] text-blue-900 font-black">INV-{{ str_pad($t->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs font-semibold text-gray-600">
                            {{ $t->paket->nama_paket }}
                            <span class="block text-[10px] text-gray-400 font-normal">{{ $t->berat }} Kg</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-black text-emerald-700">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                            <span class="block text-[8px] font-black bg-white border border-emerald-100 text-emerald-600 px-1.5 py-0.5 rounded-full inline-block mt-1">LUNAS</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center text-gray-400 italic">
                            <i class="bi bi-inbox text-xl mb-2 block"></i>
                            Belum ada data pelunasan hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full md:w-80 self-stretch">
        <div class="mb-8">
            <span class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Efisiensi Kerja</span>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-black text-gray-800">4,2</span>
                <span class="text-xs font-bold text-gray-400 mb-1.5 uppercase">Jam / Selesai</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5">
                <i class="bi bi-graph-up-arrow text-emerald-500 text-xs"></i>
                <span class="text-[10px] text-emerald-600 font-black tracking-tight">Lebih cepat 10% dari kemarin</span>
            </div>
        </div>
        
        <div>
            <span class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-3 block">Target Bulanan</span>
            <div class="flex justify-between text-xs font-black text-gray-800 mb-2">
                <span>Rp 6.250.000</span>
                <span class="text-blue-600">82%</span>
            </div>
            <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-blue-900 to-indigo-700 h-full rounded-full" style="width: 82%"></div>
            </div>
        </div>
    </div>
</div>
<script>
const iconMap = {
    transaksi:  { icon: 'bi-basket2-fill',    bg: 'bg-blue-100',   color: 'text-blue-600'  },
    pembayaran: { icon: 'bi-cash-coin',        bg: 'bg-green-100',  color: 'text-green-600' },
    pelanggan:  { icon: 'bi-person-plus-fill', bg: 'bg-yellow-100', color: 'text-yellow-600'},
    paket:      { icon: 'bi-box-seam-fill',    bg: 'bg-purple-100', color: 'text-purple-600'},
};

function toggleNotif() {
    const panel = document.getElementById('notif-panel');
    panel.classList.toggle('hidden');
    if (!panel.classList.contains('hidden')) loadNotifications();
}

function loadNotifications() {
    fetch('/admin/notifications')
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('notif-list');
            const badge = document.getElementById('notif-badge');
            if (badge) badge.textContent = data.unread_count || '';
            if (data.unread_count === 0 && badge) badge.classList.add('hidden');

            if (!data.notifications.length) {
                list.innerHTML = '<div class="px-5 py-8 text-center text-gray-400 text-xs">Tidak ada notifikasi.</div>';
                return;
            }

            list.innerHTML = data.notifications.map(n => {
                const ic = iconMap[n.tipe] || iconMap['transaksi'];
                const waktu = new Date(n.created_at);
                const menit = Math.floor((Date.now() - waktu) / 60000);
                const waktuStr = menit < 60 ? menit + ' menit yang lalu' : Math.floor(menit/60) + ' jam yang lalu';
                return `
                <div class="flex gap-3 px-5 py-4 ${n.sudah_dibaca ? '' : 'bg-blue-50/40'}">
                    <div class="w-10 h-10 rounded-2xl ${ic.bg} flex items-center justify-center shrink-0">
                        <i class="bi ${ic.icon} ${ic.color}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-black text-gray-800 text-sm">${n.judul}</p>
                        <p class="text-[11px] text-gray-500 mt-0.5 leading-relaxed">${n.pesan}</p>
                        <p class="text-[10px] text-blue-500 font-bold mt-1">${waktuStr}</p>
                    </div>
                    ${!n.sudah_dibaca ? '<div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0"></div>' : ''}
                </div>`;
            }).join('');
        });
}

function tandaiSemuaDibaca() {
    fetch('/admin/notifications/read-all', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
    }).then(() => loadNotifications());
}

document.addEventListener('click', function(e) {
    const panel = document.getElementById('notif-panel');
    const btn = e.target.closest('button[onclick="toggleNotif()"]');
    if (!btn && panel && !panel.contains(e.target)) panel.classList.add('hidden');
});

setInterval(() => {
    fetch('/admin/notifications')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('notif-badge');
            if (badge) {
                badge.textContent = data.unread_count || '';
                data.unread_count > 0 ? badge.classList.remove('hidden') : badge.classList.add('hidden');
            }
        });
}, 30000);
</script>

@endsection