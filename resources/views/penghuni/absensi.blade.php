@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Absensi Kehadiran</h1>
        <a href="{{ route('penghuni.dashboard') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">← Kembali ke Dashboard</a>
    </div>

    @if($sudahAbsen)
        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-full p-2 text-white">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-green-800">Anda sudah absen hari ini!</h3>
                    <p class="mt-1 text-green-700">Terima kasih telah melakukan absensi. Semoga hari Anda menyenangkan.</p>
                </div>
            </div>
        </div>
    @else
        <div x-data="{ tab: 'gps', loading: false, message: '', isSuccess: false }" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-slate-200">
                <button @click="tab = 'gps'" :class="{ 'border-primary-500 text-primary-600 bg-primary-50': tab === 'gps', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'gps' }" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                    GPS Location
                </button>
                <button @click="tab = 'qr'" :class="{ 'border-primary-500 text-primary-600 bg-primary-50': tab === 'qr', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'qr' }" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                    Scan QR Code
                </button>
                <button @click="tab = 'manual'" :class="{ 'border-primary-500 text-primary-600 bg-primary-50': tab === 'manual', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'manual' }" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors">
                    Manual (Fallback)
                </button>
            </div>

            <div class="p-8">
                <!-- Message Alert -->
                <div x-show="message" x-transition x-cloak :class="isSuccess ? 'bg-green-50 text-green-800 border-green-200' : 'bg-red-50 text-red-800 border-red-200'" class="mb-6 p-4 rounded-lg border">
                    <p class="text-sm font-medium" x-text="message"></p>
                </div>

                <!-- Tab GPS -->
                <div x-show="tab === 'gps'" x-transition x-cloak class="text-center py-6">
                    <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Absensi via Lokasi</h3>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto">Pastikan Anda berada di area asrama (dalam radius 50 meter dari titik asrama) dan izinkan akses lokasi.</p>
                    
                    <button @click="doGpsCheck()" :disabled="loading" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 transition-colors">
                        <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="loading ? 'Memeriksa Lokasi...' : 'Lakukan Absen Sekarang'"></span>
                    </button>
                </div>

                <!-- Tab QR -->
                <div x-show="tab === 'qr'" x-transition x-cloak class="text-center py-6">
                    <div class="w-24 h-24 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Scan QR Code Lokasi</h3>
                    <p class="text-slate-500 mb-6 max-w-sm mx-auto">Arahkan kamera Anda ke QR Code yang tertempel di area asrama.</p>
                    
                    <div class="bg-slate-50 p-4 border rounded-lg max-w-xs mx-auto text-sm text-slate-500 mb-6 border-dashed">
                        (Integrasi dengan HTML5-QRCode scanner akan di-load di sini)
                    </div>

                    <form method="POST" action="{{ route('penghuni.absensi.qr') }}">
                        @csrf
                        <!-- Simulated Input for now -->
                        <input type="text" name="qr_code" placeholder="Simulasi: Masukkan Teks QR" class="border rounded px-3 py-2 w-full max-w-xs mb-3 text-sm">
                        <br>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700">Simulasi Submit QR</button>
                    </form>
                </div>

                <!-- Tab Manual -->
                <div x-show="tab === 'manual'" x-transition x-cloak class="text-center py-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Absen Manual</h3>
                    <p class="text-slate-500 mb-8 max-w-sm mx-auto">Gunakan opsi ini hanya jika GPS atau QR bermasalah. Pengurus mungkin akan memeriksa log Anda.</p>
                    
                    <form method="POST" action="{{ route('penghuni.absensi.manual') }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Anda yakin menggunakan absen manual?')" class="inline-flex items-center px-6 py-3 border border-slate-300 text-base font-medium rounded-lg shadow-sm text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                            Submit Absen Manual
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('gpsCheck', () => ({
            doGpsCheck() {
                this.loading = true;
                this.message = '';
                
                if (!navigator.geolocation) {
                    this.message = 'Browser Anda tidak mendukung geolokasi.';
                    this.isSuccess = false;
                    this.loading = false;
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        // Dummy send to server
                        fetch('{{ route('penghuni.absensi.gps') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.isSuccess = data.success;
                            this.message = data.message;
                            this.loading = false;
                            if (data.success) {
                                setTimeout(() => window.location.reload(), 1500);
                            }
                        })
                        .catch(err => {
                            this.isSuccess = false;
                            this.message = 'Terjadi kesalahan jaringan.';
                            this.loading = false;
                        });
                    },
                    (error) => {
                        this.isSuccess = false;
                        this.message = 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan diizinkan.';
                        this.loading = false;
                    }
                );
            }
        }))
    });
</script>
@endpush
