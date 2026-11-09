@extends('layouts.admin')

@section('title', 'Dashboard Dosen')
@section('subtitle', 'Nilai mahasiswa yang Anda ampu')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                    rounded-xl p-5 transition-all duration-200">
            <p class="text-sm text-[#a68a64] font-medium">Total Nilai Diampu</p>
            <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $stats['total_mahasiswa_dinilai'] }}</p>
        </div>
        <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                    rounded-xl p-5 transition-all duration-200">
            <p class="text-sm text-[#a68a64] font-medium">Rata-rata Nilai</p>
            <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $stats['rata_rata'] }}</p>
        </div>
        <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                    rounded-xl p-5 transition-all duration-200">
            <p class="text-sm text-[#a68a64] font-medium">Jumlah Mata Kuliah</p>
            <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $stats['jumlah_matkul'] }}</p>
        </div>
    </div>

    <div class="bg-white border border-[#e8dcc8] rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 bg-[#f5efe6] border-b border-[#e8dcc8]">
            <h3 class="font-semibold text-[#8b6f47]">Daftar Nilai Mahasiswa</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-[#faf6f0] text-[#8b6f47] text-left">
                <tr>
                    <th class="px-5 py-3 font-semibold">NRP</th>
                    <th class="px-5 py-3 font-semibold">Mahasiswa</th>
                    <th class="px-5 py-3 font-semibold">Mata Kuliah</th>
                    <th class="px-5 py-3 font-semibold text-center">Angka</th>
                    <th class="px-5 py-3 font-semibold text-center">Huruf</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nilais as $n)
                    <tr class="border-t border-[#f0e8dc] hover:bg-[#faf6f0] transition-colors">
                        <td class="px-5 py-3 font-mono text-xs text-[#a68a64]">{{ $n->mahasiswa?->nrp }}</td>
                        <td class="px-5 py-3 font-medium">{{ $n->mahasiswa?->nama }}</td>
                        <td class="px-5 py-3">{{ $n->mata_kuliah }}</td>
                        <td class="px-5 py-3 text-center">{{ number_format($n->nilai_angka, 1) }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-block px-2 py-0.5 rounded text-xs font-bold
                                @if(in_array($n->nilai_huruf, ['A', 'AB'])) bg-[#e8f0dc] text-[#4a6b2a]
                                @elseif(in_array($n->nilai_huruf, ['B', 'BC'])) bg-[#f0e8dc] text-[#6b5530]
                                @else bg-[#f5e0dc] text-[#6b3a2a] @endif">
                                {{ $n->nilai_huruf }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-[#a68a64]">
                            Belum ada nilai mahasiswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-[#e8dcc8] bg-[#faf6f0]">
            {{ $nilais->links() }}
        </div>
    </div>
@endsection