@extends('layouts.admin')

@section('title', 'Data Dosen')
@section('subtitle', 'Kelola data dosen pengampu')

@section('content')
    <form method="GET" action="{{ route('admin.dosen.index') }}"
        class="bg-[#f5efe6] border border-[#e8dcc8] rounded-xl p-4 mb-5 shadow-sm
                grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">

        <div class="min-w-0">
            <label class="block text-xs text-[#8b6f47] mb-1 font-medium">Cari nama / NIP</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Ketik kata kunci..."
                class="w-full border border-[#e8dcc8] rounded-lg px-3 py-2 text-sm bg-white
                        focus:outline-none focus:ring-2 focus:ring-[#a68a64] focus:border-[#8b6f47]">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="flex-1 bg-[#8b6f47] hover:bg-[#6f5838] text-white text-sm px-4 py-2 rounded-lg
                        transition-all duration-200 shadow-sm hover:shadow">
                Filter
            </button>
            @if (request('search'))
                <a href="{{ route('admin.dosen.index') }}"
                class="flex-1 text-center text-sm text-[#a68a64] hover:text-[#8b6f47] hover:underline
                        px-4 py-2 rounded-lg border border-[#e8dcc8] bg-white transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <div class="bg-white border border-[#e8dcc8] rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f5efe6] text-[#8b6f47] text-left">
                <tr>
                    <th class="px-5 py-3 font-semibold">NIP</th>
                    <th class="px-5 py-3 font-semibold">Nama</th>
                    <th class="px-5 py-3 font-semibold">Departemen</th>
                    <th class="px-5 py-3 font-semibold">Jabatan</th>
                    <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosens as $d)
                    <tr class="border-t border-[#f0e8dc] hover:bg-[#faf6f0] transition-colors">
                        <td class="px-5 py-3 text-[#a68a64] font-mono text-xs">{{ $d->nip }}</td>
                        <td class="px-5 py-3 font-medium text-[#4a3b2a]">{{ $d->nama }}</td>
                        <td class="px-5 py-3 text-[#6b5530]">{{ $d->departemen }}</td>
                        <td class="px-5 py-3 text-[#6b5530]">{{ $d->jabatan }}</td>
                        <td class="px-5 py-3 text-right">
                            @can('hapus-data')
                                <form method="POST" action="{{ route('admin.dosen.destroy', $d) }}"
                                      onsubmit="return confirm('Hapus dosen {{ $d->nama }}?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-[#a04a4a] hover:text-[#7a2a2a] hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-[#a68a64]">Tidak ada data dosen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-[#e8dcc8] bg-[#faf6f0]">
            {{ $dosens->links() }}
        </div>
    </div>
@endsection