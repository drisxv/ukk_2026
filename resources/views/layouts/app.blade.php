<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Sarana Sekolah</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="h-screen overflow-hidden bg-slate-100 font-sans text-slate-900">

    <!-- Cek apakah pengguna saat ini adalah admin atau siswa -->
    @php
    $isAdmin = auth()->user()?->is_siswa === false;
    @endphp

    <div class="flex h-full overflow-hidden">
        <aside class="flex h-screen w-72 shrink-0 flex-col bg-slate-950 text-white shadow-sm">

            <!-- Judul aplikasi yang tampil di bagian atas sidebar -->
            <div class="border-b border-slate-800 px-6 py-6">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-sm bg-blue-500/15 text-blue-300">
                        <i class="fa-solid fa-book text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Dashboard</p>
                        <h1 class="text-xl font-bold tracking-wide">Aduan Sarana</h1>
                    </div>
                </div>
            </div>

            <!-- Navigasi utama -->
            <nav class="flex-grow space-y-2 px-4 py-6">
                <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Navigasi</p>
                <a href="{{ route('aspirasi.index') }}" class="group flex items-center rounded-sm px-3 py-3 {{ request()->routeIs('aspirasi.*') ? 'bg-slate-800 text-white shadow-lg shadow-slate-950/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} transition-colors duration-200">
                    <i class="fa-solid fa-list w-6 text-center {{ request()->routeIs('aspirasi.*') ? 'text-blue-400' : 'group-hover:text-blue-400' }}"></i>
                    <span class="ml-3">Aspirasi</span>
                </a>
                <!-- Navigasi untuk admin -->
                @if ($isAdmin)
                <a href="{{ route('umpan-balik.index') }}" class="group flex items-center rounded-sm px-3 py-3 {{ request()->routeIs('umpan-balik.*') ? 'bg-slate-800 text-white shadow-lg shadow-slate-950/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} transition-colors duration-200">
                    <i class="fa-solid fa-list w-6 text-center {{ request()->routeIs('umpan-balik.*') ? 'text-blue-400' : 'group-hover:text-blue-400' }}"></i>
                    <span class="ml-3">Umpan Balik</span>
                </a>
                <a href="{{ route('users.index') }}" class="group flex items-center rounded-sm px-3 py-3 {{ request()->routeIs('users.*') ? 'bg-slate-800 text-white shadow-lg shadow-slate-950/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }} transition-colors duration-200">
                    <i class="fa-solid fa-list w-6 text-center {{ request()->routeIs('users.*') ? 'text-blue-400' : 'group-hover:text-blue-400' }}"></i>
                    <span class="ml-3">Pengguna</span>
                </a>
                @endif
            </nav>

            <!-- Tombol keluar -->
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-3 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors duration-200">
                        <i class="fa-solid fa-right-from-bracket w-6 text-center"></i>
                        <span class="ml-3 font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>
        <main class="flex-1 overflow-y-auto">
            <div class="min-h-full p-8">
                <!-- Tampilan pesan sukses setelah melakukan aksi tertentu -->
                @if (session('success'))
                <div class="mb-6 rounded-sm border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700 shadow-sm">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="mb-6 rounded-sm border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-medium text-rose-700 shadow-sm">
                    {{ session('error') }}
                </div>
                @endif

                <div class="rounded-sm border border-slate-200 bg-white p-6 shadow-sm">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

</body>

</html>