@extends('layouts.admin')

@section('title', 'Data Mahasiswa')
@section('subtitle', 'Kelola mahasiswa aktif dan cuti')

@section('content')
    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.mahasiswa.index') }}"
        class="bg-[#f5efe6] border border-[#e8dcc8] rounded-xl p-4 mb-5 shadow-sm
                grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 items-end">

        <div class="min-w-0">
            <label class="block text-xs text-[#8b6f47] mb-1 font-medium">Cari nama / NRP</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Ketik kata kunci..."
                class="w-full border border-[#e8dcc8] rounded-lg px-3 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-[#a68a64] focus:border-[#8b6f47]">
        </div>

        <div class="min-w-0">
            <label class="block text-xs text-[#8b6f47] mb-1 font-medium">Status</label>
            <select name="status"
                    class="w-full border border-[#e8dcc8] rounded-lg px-3 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-[#a68a64]">
                <option value="">Semua</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="cuti" @selected(request('status') === 'cuti')>Cuti</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="flex-1 bg-[#8b6f47] hover:bg-[#6f5838] text-white text-sm px-4 py-2 rounded-lg
                        transition-all duration-200 shadow-sm hover:shadow">
                Filter
            </button>
            @if (request('search') || request('status'))
                <a href="{{ route('admin.mahasiswa.index') }}"
                class="flex-1 text-center text-sm text-[#a68a64] hover:text-[#8b6f47] hover:underline
                        px-4 py-2 rounded-lg border border-[#e8dcc8] bg-white transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white border border-[#e8dcc8] rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f5efe6] text-[#8b6f47] text-left">
                <tr>
                    <th class="px-5 py-3 font-semibold">NRP</th>
                    <th class="px-5 py-3 font-semibold">Nama</th>
                    <th class="px-5 py-3 font-semibold">Departemen</th>
                    <th class="px-5 py-3 font-semibold">Angkatan</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                    <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswas as $m)
                    <tr class="border-t border-[#f0e8dc] hover:bg-[#faf6f0] transition-colors">
                        <td class="px-5 py-3 text-[#a68a64] font-mono text-xs">{{ $m->nrp }}</td>
                        <td class="px-5 py-3 font-medium text-[#4a3b2a]">{{ $m->nama }}</td>
                        <td class="px-5 py-3 text-[#6b5530]">{{ $m->departemen }}</td>
                        <td class="px-5 py-3 text-[#6b5530]">{{ $m->angkatan }}</td>
                        <td class="px-5 py-3">
                            @if ($m->is_active)
                                <span class="bg-[#e8f0dc] text-[#4a6b2a] px-2 py-0.5 rounded-full text-xs font-medium">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-[#f5e0dc] text-[#6b3a2a] px-2 py-0.5 rounded-full text-xs font-medium">
                                    Cuti
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            @can('hapus-data')
                                <form method="POST" action="{{ route('admin.mahasiswa.destroy', $m) }}"
                                      onsubmit="return confirm('Hapus mahasiswa {{ $m->nama }}?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-[#a04a4a] hover:text-[#7a2a2a] hover:underline
                                                   transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-[#a68a64]">
                            Tidak ada data mahasiswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-[#e8dcc8] bg-[#faf6f0]">
            {{ $mahasiswas->links() }}
        </div>
    </div>
@endsection