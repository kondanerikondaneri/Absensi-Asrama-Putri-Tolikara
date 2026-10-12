@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10">
            <svg class="w-64 h-64 -mt-10 -mr-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
        </div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Halo, {{ $user->nama_lengkap }}!</h1>
            <p class="text-primary-100 text-lg">Selamat datang di Dashboard Penghuni Asrama.</p>
            <div class="mt-6 flex flex-wrap gap-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-sm font-medium">
                    Kamar: {{ $user->kamar ? $user->kamar->blokAsrama->nama_blok . ' - ' . $user->kamar->nomor_kamar : 'Belum Ditentukan' }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full {{ $user->status == 'di_asrama' ? 'bg-green-500/80' : 'bg-red-500/80' }} text-white text-sm font-medium">
                    Status: {{ str_replace('_', ' ', strtoupper($user->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Absensi Harian Card -->
        <a href="{{ route('penghuni.absensi') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition duration-200 transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Absensi Kehadiran</h3>
            <p class="text-slate-500 text-sm">Lakukan absensi harian menggunakan GPS atau pemindaian QR Code.</p>
        </a>

        <!-- Izin Keluar Card -->
        <a href="{{ route('penghuni.keluar') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition duration-200 transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Izin Keluar Masuk</h3>
            <p class="text-slate-500 text-sm">Ajukan izin keluar asrama dan lapor kembali ke asrama.</p>
        </a>

        <!-- Riwayat Card -->
        <a href="{{ route('penghuni.riwayat') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition duration-200 transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Riwayat Anda</h3>
            <p class="text-slate-500 text-sm">Lihat log absensi harian dan rekam jejak keluar masuk Anda.</p>
        </a>
    </div>
</div>
@endsection
