@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-purple-700 to-indigo-800 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Dashboard Pengurus</h1>
                <p class="text-purple-100 text-lg">Pusat Manajemen Asrama Smart System</p>
            </div>
            <div class="hidden md:block opacity-20">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <p class="text-sm font-medium text-slate-500 uppercase">Total Penghuni</p>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_penghuni'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <p class="text-sm font-medium text-slate-500 uppercase">Blok Asrama</p>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_blok'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <p class="text-sm font-medium text-slate-500 uppercase">Kamar Terdaftar</p>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_kamar'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 border-l-4 border-orange-500">
            <p class="text-sm font-medium text-slate-500 uppercase">Izin Keluar Aktif</p>
            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['di_luar'] }}</p>
        </div>
    </div>

    <!-- Quick Links -->
    <h2 class="text-xl font-bold text-slate-800 mt-8 mb-4">Master Data & Pengaturan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('pengurus.users.index') }}" class="group bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:border-primary-500 transition-colors flex items-center">
            <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Manajemen Pengguna</h3>
                <p class="text-xs text-slate-500">Kelola data penghuni, pengurus, keamanan.</p>
            </div>
        </a>

        <a href="{{ route('pengurus.blok.index') }}" class="group bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:border-primary-500 transition-colors flex items-center">
            <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Manajemen Blok & Kamar</h3>
                <p class="text-xs text-slate-500">Kelola blok asrama dan kamar.</p>
            </div>
        </a>

        <a href="{{ route('pengurus.qr.index') }}" class="group bg-white rounded-xl p-6 shadow-sm border border-slate-200 hover:border-primary-500 transition-colors flex items-center">
            <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Generator QR Code</h3>
                <p class="text-xs text-slate-500">Cetak QR Code lokasi / kamar / penghuni.</p>
            </div>
        </a>
    </div>
</div>
@endsection
