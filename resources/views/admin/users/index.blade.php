@extends('layouts.admin')

@section('title', 'Data User')
@section('subtitle', 'Kelola pengguna sistem')

@section('content')
    {{-- Form Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="bg-white border border-[#e8dcc8] rounded-lg p-4 mb-4 shadow-sm flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs text-[#a68a64] mb-1">Cari nama / email</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Ketik kata kunci..."
                   class="w-full border border-[#e8dcc8] rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#a68a64]">
        </div>

        <div>
            <label class="block text-xs text-[#a68a64] mb-1">Role</label>
            <select name="role"
                    class="border border-[#e8dcc8] rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#a68a64]">
                <option value="">Semua</option>
                @foreach ($roles as $r)
                    <option value="{{ $r->name }}" @selected(request('role') === $r->name)>
                        {{ $r->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="bg-[#8b6f47] hover:bg-[#6f5838] text-white text-sm px-4 py-2 rounded transition">
            Filter
        </button>
        @if (request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-[#a68a64] hover:underline">Reset</a>
        @endif
    </form>

    {{-- Tabel --}}
    <div class="bg-white border border-[#e8dcc8] rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#f0e8dc] text-[#8b6f47] text-left">
                <tr>
                    <th class="px-5 py-3">Nama</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Role</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $u)
                    <tr class="border-t border-[#f0e8dc] hover:bg-[#faf6f0]">
                        <td class="px-5 py-3 font-medium">{{ $u->name }}</td>
                        <td class="px-5 py-3 text-[#a68a64]">{{ $u->email }}</td>
                        <td class="px-5 py-3">
                            @foreach ($u->roles as $r)
                                <span class="bg-[#f0e8dc] text-[#8b6f47] px-2 py-0.5 rounded text-xs font-medium">
                                    {{ $r->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-5 py-3 text-right">
                            @can('hapus-data')
                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                      onsubmit="return confirm('Hapus user {{ $u->name }}?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-red-600 hover:text-red-800 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-[#a68a64]">
                            Tidak ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-[#e8dcc8]">
            {{ $users->links() }}
        </div>
    </div>
@endsection