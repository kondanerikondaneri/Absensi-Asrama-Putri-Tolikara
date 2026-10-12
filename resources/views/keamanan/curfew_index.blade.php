@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Apel Malam - Pilih Blok Asrama</h1>
        <a href="{{ route('keamanan.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Dashboard</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($blokAsrama as $blok)
            <a href="{{ route('keamanan.curfew.blok', $blok->id) }}" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-slate-800">{{ $blok->nama_blok }}</h3>
                    <div class="bg-slate-100 p-2 rounded text-slate-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <p class="text-sm text-slate-500">{{ $blok->deskripsi }}</p>
                <div class="mt-4 pt-4 border-t border-slate-100 text-sm text-slate-600">
                    Total Penghuni: <span class="font-bold">{{ $blok->total_penghuni }}</span> orang
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
