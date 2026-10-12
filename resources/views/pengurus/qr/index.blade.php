@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Generator QR Code</h1>
        <a href="{{ route('pengurus.dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Generate QR Baru</h3>
                <form method="POST" action="{{ route('pengurus.qr.generate') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700">Tipe QR Code</label>
                        <select name="tipe" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            <option value="lokasi">Pos Lokasi Asrama</option>
                            <option value="kamar">Kamar Tertentu</option>
                            <option value="identitas">Identitas Penghuni</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-teal-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-teal-700">Generate QR</button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kode UUID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($qrCodes as $qr)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ ucfirst($qr->tipe) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500 font-mono text-xs">{{ $qr->kode }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($qr->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $qr->kode }}" target="_blank" class="text-primary-600 hover:text-primary-900">Lihat / Cetak</a>
                                
                                @if($qr->is_active)
                                <form action="{{ route('pengurus.qr.destroy', $qr->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Nonaktifkan QR ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Nonaktifkan</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-4 text-center text-slate-500">Belum ada data QR Code.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
