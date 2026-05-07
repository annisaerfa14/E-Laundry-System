<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - E-Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-[#FFF9E8] font-sans">
    <div class="flex h-screen">
        <div class="w-64 bg-[#DBEAFE] shadow-md flex flex-col h-screen relative z-20">
            <div class="flex items-center gap-3 p-5 border-b border-blue-100">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-md" style="background-color: #005072;">
            <img src="{{ asset('images/LogoMesinCuci.png') }}" alt="Logo" class="w-15 h-15 object-contain rounded-2xl">
        </div>
                <div>
                    <h2 class="font-black text-[#003049] text-xl leading-tight">E-Laundry</h2>
                    <p class="text-[9px] font-bold text-blue-700 tracking-widest uppercase">Laundry Management</p>
                </div>
            </div>

            <nav class="flex-1 mt-6 px-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-[#FDE047] font-bold text-gray-900 shadow-md' : 'text-blue-900 font-medium hover:bg-[#FDE047] hover:text-gray-900' }}">
                    <i class="bi bi-house-door-fill text-lg"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('pelanggan.*') ? 'bg-[#FDE047] font-bold text-gray-900 shadow-md' : 'text-blue-900 font-medium hover:bg-[#FDE047] hover:text-gray-900' }}">
                    <i class="bi bi-people-fill text-lg"></i> <span>Manajemen Pelanggan</span>
                </a>
                <a href="{{ route('paket.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('paket.*') ? 'bg-[#FDE047] font-bold text-gray-900 shadow-md' : 'text-blue-900 font-medium hover:bg-[#FDE047] hover:text-gray-900' }}">
                    <i class="bi bi-box-seam-fill text-lg"></i> <span>Kelola Data Paket</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('transaksi.*') ? 'bg-[#FDE047] font-bold text-gray-900 shadow-md' : 'text-blue-900 font-medium hover:bg-[#FDE047] hover:text-gray-900' }}">
                    <i class="bi bi-receipt text-lg"></i> <span>Transaksi</span>
                </a>
                <a href="{{ route('pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('pembayaran.*') ? 'bg-[#FDE047] font-bold text-gray-900 shadow-md' : 'text-blue-900 font-medium hover:bg-[#FDE047] hover:text-gray-900' }}">
                    <i class="bi bi-wallet2 text-lg"></i> <span>Pembayaran</span>
                </a>
            </nav>

            <div class="p-4 mt-auto border-t border-blue-200">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 font-bold rounded-xl shadow-sm hover:bg-red-50 hover:text-red-600 transition-all border border-gray-200">
                        <i class="bi bi-box-arrow-left text-lg"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-10">
            @yield('content')
        </div>
    </div>
</body>
</html>