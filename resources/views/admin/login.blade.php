<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-gradient {
            background: linear-gradient(135deg, #005072 0%, #006994 100%);
        }
        .btn-gradient {
            background: linear-gradient(90deg, #005072 0%, #006994 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, #003049 0%, #005072 100%);
        }
    </style>
</head>
<body class="bg-[#FFF9E8] font-sans h-screen flex items-center justify-center">

    <div class="flex w-full max-w-5xl h-[580px] bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="hidden lg:flex w-1/2 login-gradient flex-col justify-between p-10 text-white relative">
            <div class="flex items-center gap-3 z-10">
                <img src="{{ asset('images/logoMesinCuci.png') }}" alt="Logo" class="w-12 h-12 rounded-2xl object-contain bg-[#006994] p-1 shadow-md">
                <span class="font-black text-xl tracking-wide">E-Laundry</span>
            </div>

            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset('Fotolondri.jpg') }}" alt="Foto Laundry" class="w-full h-full object-cover">
            </div>

            <div class="z-10 max-w-sm">
                <h1 class="text-3xl font-black mb-3 leading-tight">Manajemen Laundry<br>Lebih Cerdas</h1>
                <p class="text-[11px] text-blue-100 leading-relaxed">
                    Kelola data pelanggan, catat transaksi, dan pantau pendapatan harian dalam satu platform digital yang efisien dan terpusat.
                </p>
            </div>

            <div class="text-[9px] text-blue-300 tracking-wider z-10">
                E-Laundry Versi 1.0 &bull; &copy; 2026
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-10">
            <div class="w-full max-w-sm">
                
                <div class="flex lg:hidden items-center justify-center gap-3 mb-6">
                    <div class="bg-[#006994] text-white p-2 rounded-xl font-black text-md shadow-md">EL</div>
                    <span class="font-black text-lg text-gray-800">E-Laundry</span>
                </div>

                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-black text-gray-800 mb-1">Login</h2>
                    <p class="text-[10px] text-gray-400 tracking-wide uppercase">Masukkan kredensial untuk mengakses sistem</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-3 bg-red-50 border border-red-200 text-red-700 text-[10px] font-bold rounded-2xl text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-[9px] font-black uppercase text-gray-400 tracking-wider mb-2 text-center">Username</label>
                        <input type="text" name="username" placeholder="Masukkan Username" required 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-medium focus:outline-none focus:border-[#006994] text-center">
                    </div>

                    <div>
                        <label class="block text-[9px] font-black uppercase text-gray-400 tracking-wider mb-2 text-center">Password</label>
                        <input type="password" name="password" placeholder="Masukkan Password" required 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-medium focus:outline-none focus:border-[#006994] text-center">
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-gray-500 font-medium px-1">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded text-[#006994] focus:ring-0">
                            <span>Ingat saya</span>
                        </label>
                        <a href="#" class="text-[#006994] font-bold hover:underline">Bantuan?</a>
                    </div>

                    <button type="submit" class="w-full py-3.5 text-white font-black rounded-2xl btn-gradient shadow text-sm transition duration-200">
                        Masuk ke Sistem &rarr;
                    </button>
                </form>

                <div class="mt-8 pt-4 border-t border-gray-50 text-center text-[9px] text-gray-400">
                    Privasi &bull; Syarat Ketentuan
                </div>
            </div>
        </div>

    </div>

</body>
</html>