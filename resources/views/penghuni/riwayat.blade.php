@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Absensi Anda</h1>
        <a href="{{ route('penghuni.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali ke Dashboard</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal & Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Metode</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Detail Lokasi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($absensi as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                        {{ $item->waktu_absensi->format('d M Y, H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 uppercase">
                        {{ str_replace('_', ' ', $item->metode) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->status == 'berhasil')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Berhasil</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Di Luar Area / Gagal</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                        @if($item->jarak_meter)
                            Jarak: {{ round($item->jarak_meter) }}m
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                        Belum ada data riwayat absensi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($absensi->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $absensi->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
