@extends('errors')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">503</h1>
        <p class="text-2xl font-medium text-gray-600 mb-6">Layanan tidak tersedia</p>
        <p class="text-gray-500 mb-6">{{ $message ?? 'Layanan sedang dalam pemeliharaan. Silakan coba beberapa saat lagi.' }}</p>
        <a href="{{ auth('admin')->check() ? route('admin.dashboard.index') : 
                  (auth('operator')->check() ? route('operator.dashboard.index') : 
                  (auth('instance')->check() ? route('instance.dashboard.index') : 
                  (auth('user')->check() ? route('user.dashboard.index') : 
                  url('/')))) }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection 