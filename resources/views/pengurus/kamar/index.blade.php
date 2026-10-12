@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Kamar</h1>
        <a href="{{ route('pengurus.dashboard') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Tambah Kamar Baru</h3>
                <form method="POST" action="{{ route('pengurus.kamar.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700">Pilih Blok</label>
                        <select name="blok_asrama_id" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                            @foreach(\App\Models\BlokAsrama::all() as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_blok }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" required placeholder="Misal: 101" class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700">Kapasitas Orang</label>
                        <input type="number" name="kapasitas" required value="4" min="1" class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    </div>
                    <button type="submit" class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-700">Simpan Kamar</button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Blok & No Kamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($kamar as $k)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $k->blokAsrama->nama_blok }} - {{ $k->nomor_kamar }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $k->kapasitas }} Orang</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <form action="{{ route('pengurus.kamar.destroy', $k->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kamar ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-4 text-center text-slate-500">Belum ada data kamar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
