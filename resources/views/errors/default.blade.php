@extends('errors')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">{{ $code ?? 'Error' }}</h1>
        <p class="text-2xl font-medium text-gray-600 mb-6">Oops! Something went wrong</p>
        <p class="text-gray-500 mb-6">{{ $message ?? 'Terjadi kesalahan yang tidak diketahui.' }}</p>
        <div class="space-x-4">
            <a href="{{ url()->previous() }}" 
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                Kembali
            </a>
            <a href="{{ auth('admin')->check() ? route('admin.dashboard.index') : 
                       (auth('admin')->check() ? route('operator.dashboard.index') : 
                       (auth('admin')->check() ? route('instance.dashboard.index') : 
                       (auth('client')->check() ? route('user.dashboard.index') : 
                       url('/')))) }}" 
         class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection 