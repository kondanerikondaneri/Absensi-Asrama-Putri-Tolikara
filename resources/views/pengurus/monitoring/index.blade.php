@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{
    // Basic polling mechanism
    init() {
        setInterval(() => {
            if(!document.hidden) {
                window.location.reload();
            }
        }, 30000); // Reload every 30 seconds for live monitoring
    }
}">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Live Monitoring Penghuni</h1>
            <p class="text-slate-500 text-sm mt-1">Pantau pergerakan dan status penghuni secara real-time. (Auto-refresh: 30 detik)</p>
        </div>
        <a href="{{ route('pengurus.dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 text-sm font-medium whitespace-nowrap self-start md:self-auto">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form method="GET" action="{{ route('pengurus.monitoring') }}" class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-auto flex-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Blok Asrama</label>
                <select name="blok" class="block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    <option value="">Semua Blok</option>
                    @foreach($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ request('blok') == $blok->id ? 'selected' : '' }}>{{ $blok->nama_blok }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-auto flex-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Status Kehadiran</label>
                <select name="status" class="block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    <option value="di_asrama" {{ request('status') == 'di_asrama' ? 'selected' : '' }}>Di Asrama</option>
                    <option value="sedang_di_luar" {{ request('status') == 'sedang_di_luar' ? 'selected' : '' }}>Sedang Di Luar</option>
                </select>
            </div>
            <div class="w-full md:w-auto">
                <button type="submit" class="w-full px-6 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 font-medium transition-colors">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <!-- Data Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Penghuni</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kamar & Blok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status Kehadiran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Terakhir Dilihat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($penghuni as $p)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full {{ $p->status == 'di_asrama' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} flex items-center justify-center font-bold">
                                    {{ substr($p->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-slate-900">{{ $p->nama_lengkap }}</div>
                                    <div class="text-xs text-slate-500">{{ $p->nomor_identitas }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            @if($p->kamar)
                                <span class="font-medium text-slate-800">{{ $p->kamar->blokAsrama->nama_blok }}</span><br>
                                Kamar {{ $p->kamar->nomor_kamar }}
                            @else
                                <span class="text-slate-400 italic">Belum diset</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($p->status == 'di_asrama')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-sm">
                                    <span class="w-2 h-2 mr-2 rounded-full bg-green-500 animate-pulse"></span>
                                    Di Asrama
                                </span>
                            @else
                                @php
                                    $isLate = false;
                                    if(now()->hour >= 22 || now()->hour < 5) {
                                        $isLate = true; // Curfew violation
                                    }
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $isLate ? 'bg-red-100 text-red-800 border border-red-300' : 'bg-orange-100 text-orange-800' }} shadow-sm">
                                    <span class="w-2 h-2 mr-2 rounded-full {{ $isLate ? 'bg-red-500 animate-bounce' : 'bg-orange-500' }}"></span>
                                    Sedang Keluar {!! $isLate ? '<strong class="ml-1 text-red-600">(LATE)</strong>' : '' !!}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            @if($p->absensiHarian()->latest('waktu_absensi')->first())
                                {{ $p->absensiHarian()->latest('waktu_absensi')->first()->waktu_absensi->diffForHumans() }}
                            @else
                                Belum pernah absen
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            Tidak ada data penghuni yang cocok dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($penghuni->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $penghuni->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
