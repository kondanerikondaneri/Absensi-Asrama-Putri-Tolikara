@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto" x-data="curfewApp({{ json_encode($checkedUsers) }})">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sweeping: {{ $blok->nama_blok }}</h1>
            <p class="text-slate-500 text-sm mt-1">Tanggal: {{ now()->format('d F Y') }}</p>
        </div>
        <a href="{{ route('keamanan.curfew') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali ke Daftar Blok</a>
    </div>

    <form method="POST" action="{{ route('keamanan.curfew.batch') }}">
        @csrf
        <div class="space-y-6">
            @foreach($kamarList as $kamar)
                @if($kamar->users->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 font-bold text-slate-700 flex justify-between">
                            <span>Kamar {{ $kamar->nomor_kamar }}</span>
                            <span class="text-sm font-normal text-slate-500">{{ $kamar->users->count() }} Penghuni</span>
                        </div>
                        <ul class="divide-y divide-slate-100">
                            @foreach($kamar->users as $penghuni)
                                <li class="px-6 py-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $penghuni->nama_lengkap }}</p>
                                        <p class="text-xs text-slate-500">ID: {{ $penghuni->nomor_identitas }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <!-- Hidden Inputs for batch submit -->
                                        <input type="hidden" name="checks[{{ $penghuni->id }}][user_id]" value="{{ $penghuni->id }}">
                                        
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="checks[{{ $penghuni->id }}][is_hadir]" value="1" required class="form-radio text-green-600" :checked="checkedData[{{ $penghuni->id }}] === true || checkedData[{{ $penghuni->id }}] === 1">
                                            <span class="ml-2 text-sm text-green-800 font-medium">Hadir di Kamar</span>
                                        </label>
                                        
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="checks[{{ $penghuni->id }}][is_hadir]" value="0" class="form-radio text-red-600" :checked="checkedData[{{ $penghuni->id }}] === false || checkedData[{{ $penghuni->id }}] === 0">
                                            <span class="ml-2 text-sm text-red-800 font-medium">Tidak Ada</span>
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-8 flex justify-end sticky bottom-6 z-10">
            <button type="submit" class="bg-primary-600 text-white px-8 py-3 rounded-lg shadow-lg font-bold hover:bg-primary-700 transition">
                Simpan Hasil Sweeping {{ $blok->nama_blok }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('curfewApp', (initialData) => ({
            checkedData: initialData || {}
        }))
    });
</script>
@endpush
