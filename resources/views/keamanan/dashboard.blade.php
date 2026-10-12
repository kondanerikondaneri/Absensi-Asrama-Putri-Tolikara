@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-slate-700 to-slate-900 rounded-2xl p-8 text-white shadow-lg">
        <h1 class="text-3xl font-bold mb-2">Keamanan Asrama</h1>
        <p class="text-slate-300 text-lg">Dashboard Petugas Keamanan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 uppercase">Total Penghuni Asrama</p>
                <p class="text-3xl font-bold text-slate-800">{{ $totalPenghuni }}</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 uppercase">Sedang Berada di Luar</p>
                <p class="text-3xl font-bold text-orange-600">{{ $sedangKeluar }}</p>
            </div>
            <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <a href="{{ route('keamanan.curfew') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-primary-500 transition-colors">
            <h3 class="text-xl font-bold text-slate-800 group-hover:text-primary-600">Apel Malam (Sweeping) &rarr;</h3>
            <p class="text-slate-500 mt-2">Mulai proses pendataan manual kehadiran di kamar. Dapat dilakukan setiap hari pukul 22:00 - 23:00.</p>
        </a>

        <a href="{{ route('keamanan.curfew.riwayat') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:border-primary-500 transition-colors">
            <h3 class="text-xl font-bold text-slate-800 group-hover:text-primary-600">Riwayat Sweeping &rarr;</h3>
            <p class="text-slate-500 mt-2">Lihat data rekaman absensi apel malam pada hari-hari sebelumnya.</p>
        </a>
    </div>
</div>
@endsection
