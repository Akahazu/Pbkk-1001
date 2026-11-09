<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#faf6f0] text-[#4a3b2a] font-sans antialiased">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-[#8b6f47] text-[#faf6f0] shadow-xl flex flex-col">
            <div class="px-6 py-6 border-b border-[#a68a64]/40">
                <h1 class="font-bold text-xl tracking-wide">Admin Panel</h1>
                <p class="text-xs text-[#e8dcc8] mt-1">PBKK Sistem Akademik</p>
            </div>

            <nav class="px-5 py-5 space-y-2 text-sm flex-1">
                <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-3 rounded-lg transition-all duration-200
                        {{ request()->routeIs('admin.dashboard')
                                ? 'bg-[#a68a64] font-semibold shadow-inner'
                                : 'hover:bg-[#a68a64]/60' }}">
                    Dashboard
                </a>

                @can('kelola-mahasiswa')
                    <a href="{{ route('admin.mahasiswa.index') }}"
                    class="block px-4 py-3 rounded-lg transition-all duration-200
                            {{ request()->routeIs('admin.mahasiswa.*')
                                    ? 'bg-[#a68a64] font-semibold shadow-inner'
                                    : 'hover:bg-[#a68a64]/60' }}">
                        Mahasiswa
                    </a>
                @endcan

                @can('kelola-dosen')
                    <a href="{{ route('admin.dosen.index') }}"
                    class="block px-4 py-3 rounded-lg transition-all duration-200
                            {{ request()->routeIs('admin.dosen.*')
                                    ? 'bg-[#a68a64] font-semibold shadow-inner'
                                    : 'hover:bg-[#a68a64]/60' }}">
                        Dosen
                    </a>
                @endcan

                @can('kelola-asdos')
                    <a href="{{ route('admin.asdos.index') }}"
                    class="block px-4 py-3 rounded-lg transition-all duration-200
                            {{ request()->routeIs('admin.asdos.*')
                                    ? 'bg-[#a68a64] font-semibold shadow-inner'
                                    : 'hover:bg-[#a68a64]/60' }}">
                        Asisten Dosen
                    </a>
                @endcan
            </nav>

            <div class="px-5 py-4 border-t border-[#a68a64]/40 text-xs text-[#e8dcc8]">
                <p class="mb-2">Login sebagai <strong class="text-white">{{ auth()->user()->name }}</strong></p>
                <div class="flex flex-wrap gap-1">
                    @foreach (auth()->user()->roles as $role)
                        <span class="bg-[#a68a64]/50 text-[#faf6f0] px-2 py-0.5 rounded text-[10px] font-medium">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- Konten --}}
        <div class="flex-1 flex flex-col">

            {{-- Topbar --}}
            <header class="bg-white/90 backdrop-blur border-b border-[#e8dcc8] shadow-sm sticky top-0 z-10">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold text-[#8b6f47] text-lg">@yield('title', 'Dashboard')</h2>
                        <p class="text-xs text-[#a68a64]">@yield('subtitle', '')</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm bg-[#8b6f47] hover:bg-[#6f5838] text-white px-4 py-2 rounded-lg
                                       transition-all duration-200 shadow-sm hover:shadow">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-6 flex-1">
                @if (session('success'))
                    <div class="mb-4 bg-[#f0e8dc] border border-[#c9b18a] text-[#6b5530]
                                text-sm px-4 py-3 rounded-lg shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-[#f5dcdc] border border-[#c47a7a] text-[#6b2a2a]
                                text-sm px-4 py-3 rounded-lg shadow-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="px-6 py-3 text-xs text-[#a68a64] border-t border-[#e8dcc8] bg-[#f5efe6]/60">
                &copy; {{ date('Y') }} PBKK ITS - Admin Dashboard
            </footer>
        </div>
    </div>
</body>
</html>