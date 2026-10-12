@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan & Statistik</h1>
            <p class="text-slate-500 text-sm mt-1">Lihat dan ekspor data rekapitulasi asrama.</p>
        </div>
        <a href="{{ route('pengurus.dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 text-sm font-medium whitespace-nowrap">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Tipe Laporan Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="flex border-b border-slate-200">
            <a href="{{ route('pengurus.laporan', ['tipe' => 'absensi_harian']) }}" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors {{ $tipe == 'absensi_harian' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                Absensi Harian
            </a>
            <a href="{{ route('pengurus.laporan', ['tipe' => 'izin_keluar']) }}" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors {{ $tipe == 'izin_keluar' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                Riwayat Izin Keluar
            </a>
            <a href="{{ route('pengurus.laporan', ['tipe' => 'curfew']) }}" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors {{ $tipe == 'curfew' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                Apel Malam (Sweeping)
            </a>
        </div>

        <div class="p-6">
            <div class="flex justify-end mb-4">
                <button onclick="alert('Fitur Ekspor PDF & Excel akan aktif setelah package wkhtmltopdf atau DOMPDF terinstall di server produksi.')" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Data Laporan
                </button>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Penghuni</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Detail Laporan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($data as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                                @if($tipe == 'absensi_harian')
                                    {{ $item->waktu_absensi->format('d M Y, H:i') }}
                                @elseif($tipe == 'izin_keluar')
                                    Keluar: {{ $item->waktu_keluar->format('d M Y, H:i') }}<br>
                                    Kembali: {{ $item->waktu_kembali ? $item->waktu_kembali->format('d M Y, H:i') : 'Belum Kembali' }}
                                @else
                                    {{ $item->waktu_cek->format('d M Y, H:i') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $item->user->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $item->user->kamar ? $item->user->kamar->blokAsrama->nama_blok . ' - ' . $item->user->kamar->nomor_kamar : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                @if($tipe == 'absensi_harian')
                                    Metode: <strong>{{ strtoupper($item->metode) }}</strong><br>
                                    Status: <span class="{{ $item->status == 'berhasil' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($item->status) }}</span>
                                @elseif($tipe == 'izin_keluar')
                                    Keterangan: <em>"{{ $item->keterangan }}"</em>
                                @else
                                    Kehadiran: <strong>{{ $item->is_hadir ? 'Hadir' : 'Tidak Ada' }}</strong><br>
                                    Diperiksa: {{ $item->checker->nama_lengkap }}
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                Belum ada data untuk laporan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($data->hasPages())
            <div class="mt-4">
                {{ $data->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
