@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Ringkasan sistem akademik')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        @foreach ([
            ['label' => 'Total Mahasiswa', 'value' => $stats['total_mahasiswa'], 'kode' => 'M'],
            ['label' => 'Total Dosen',     'value' => $stats['total_dosen'],     'kode' => 'D'],
            ['label' => 'Total Asisten Dosen', 'value' => $stats['total_asdos'], 'kode' => 'A'],
        ] as $box)
            <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                        rounded-xl p-5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[#a68a64] font-medium">{{ $box['label'] }}</p>
                        <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $box['value'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-[#f5efe6] flex items-center justify-center
                                text-[#8b6f47] font-bold text-lg">
                        {{ $box['kode'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-gradient-to-r from-[#f5efe6] to-white border border-[#e8dcc8]
                rounded-xl p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="font-semibold text-[#8b6f47]">Area Khusus Admin</p>
                <p class="text-sm text-[#a68a64] mt-0.5">Aksi demo penghapusan mahasiswa terbaru.</p>
            </div>
            <form method="POST" action="{{ route('admin.hapus-demo') }}"
                  onsubmit="return confirm('Yakin hapus 1 mahasiswa demo?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-[#8b6f47] hover:bg-[#6f5838] text-white text-sm px-4 py-2
                               rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                    Hapus Data Demo
                </button>
            </form>
        </div>
    </div>
@endsection