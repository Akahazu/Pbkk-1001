@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan sistem akademik')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        {{-- Mahasiswa --}}
        <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                    rounded-xl p-5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#a68a64] font-medium">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $stats['total_mahasiswa'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#f5efe6] flex items-center justify-center
                            text-[#8b6f47] font-bold text-lg">
                    M
                </div>
            </div>
        </div>

        {{-- Dosen --}}
        <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                    rounded-xl p-5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#a68a64] font-medium">Total Dosen</p>
                    <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $stats['total_dosen'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#f5efe6] flex items-center justify-center
                            text-[#8b6f47] font-bold text-lg">
                    D
                </div>
            </div>
        </div>

        {{-- Asdos --}}
        <div class="bg-white border-l-4 border-[#8b6f47] shadow-sm hover:shadow-md
                    rounded-xl p-5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#a68a64] font-medium">Total Asisten Dosen</p>
                    <p class="text-3xl font-bold text-[#8b6f47] mt-1">{{ $stats['total_asdos'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#f5efe6] flex items-center justify-center
                            text-[#8b6f47] font-bold text-lg">
                    A
                </div>
            </div>
        </div>
    </div>

    @can('hapus-data')
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
    @endcan
@endsection