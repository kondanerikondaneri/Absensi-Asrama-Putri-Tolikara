@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Apel Malam (Sweeping)</h1>
        <a href="{{ route('keamanan.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Dashboard</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu & Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kamar & Blok</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Penghuni</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Diperiksa Oleh</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($riwayat as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                        {{ $item->waktu_cek->format('d M Y, H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                        @if($item->user->kamar)
                            {{ $item->user->kamar->blokAsrama->nama_blok }} - {{ $item->user->kamar->nomor_kamar }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                        {{ $item->user->nama_lengkap }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->is_hadir)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Tidak Ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        {{ $item->checker->nama_lengkap }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        Belum ada riwayat sweeping apel malam.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($riwayat->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $riwayat->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
