@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Pengguna Baru</h1>
        <a href="{{ route('pengurus.users.index') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form method="POST" action="{{ route('pengurus.users.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nomor Identitas (NIM/NIK)</label>
                    <input type="text" name="nomor_identitas" value="{{ old('nomor_identitas') }}" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Role</label>
                    <select name="role" required class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <option value="penghuni" {{ old('role') == 'penghuni' ? 'selected' : '' }}>Penghuni</option>
                        <option value="keamanan" {{ old('role') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                        <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nomor Telepon (Opsional)</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Kamar Asrama (Khusus Penghuni)</label>
                    <select name="kamar_id" class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <option value="">-- Tidak Memiliki Kamar --</option>
                        @foreach($kamarList as $kamar)
                            <option value="{{ $kamar->id }}" {{ old('kamar_id') == $kamar->id ? 'selected' : '' }}>
                                {{ $kamar->blokAsrama->nama_blok }} - Kamar {{ $kamar->nomor_kamar }} (Kapasitas: {{ $kamar->kapasitas }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-700">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
