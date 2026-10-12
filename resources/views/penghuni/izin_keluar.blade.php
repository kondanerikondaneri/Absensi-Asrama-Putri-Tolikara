@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Izin Keluar Asrama</h1>
        <a href="{{ route('penghuni.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali ke Dashboard</a>
    </div>

    @if($activeKeluar)
        <!-- Status Sedang Keluar -->
        <div class="bg-orange-50 border-l-4 border-orange-500 p-6 rounded-r-lg shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-orange-500 rounded-full p-2 text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-orange-800">Anda sedang berada di luar asrama.</h3>
                    <p class="mt-1 text-orange-700 text-sm">Waktu keluar: {{ $activeKeluar->waktu_keluar->format('d M Y, H:i') }}</p>
                    <p class="mt-1 text-orange-700 text-sm">Tujuan/Keterangan: {{ $activeKeluar->keterangan }}</p>
                    
                    <form method="POST" action="{{ route('penghuni.kembali') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700">
                            Lapor Kembali ke Asrama
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- Form Izin Keluar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <p class="text-slate-500 mb-6">Silakan isi formulir di bawah ini untuk mendata izin keluar. Perlu diingat bahwa izin keluar hanya dapat dilakukan pada pukul 05:00 hingga 22:00.</p>
            
            <form method="POST" action="{{ route('penghuni.keluar.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-slate-700">Tujuan & Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3" required class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Contoh: Pergi ke kampus untuk kuliah, atau Membeli makan malam di luar"></textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700">
                        Catat Waktu Keluar
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
