@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="text-center mb-10 flex flex-col items-center">
            <div class="h-28 w-28 rounded-full overflow-hidden shadow-md border-4 border-white mb-4 bg-white flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo AMPT" class="h-full w-full object-cover object-center">
            </div>
            <h1 class="text-4xl font-extrabold text-primary-700 tracking-tight">AMPT.</h1>
            <p class="mt-3 text-slate-500 font-medium">Sistem Absensi Asrama Mahasiswi Putri Tolikara</p>
        </div>
        
        <div class="glass-panel rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Masuk ke Akun Anda</h2>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="username" name="username" type="text" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-200" placeholder="Masukkan username" value="{{ old('username') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="password" name="password" type="password" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-200" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-slate-600">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-xs text-slate-500">
            Hubungi pengurus asrama jika Anda lupa detail login Anda.
        </p>
    </div>
</div>
@endsection
