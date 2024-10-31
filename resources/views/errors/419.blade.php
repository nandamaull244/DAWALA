@extends('errors')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">419</h1>
        <p class="text-2xl font-medium text-gray-600 mb-6">Halaman telah kedaluwarsa</p>
        <p class="text-gray-500 mb-6">{{ $message ?? 'Halaman telah kedaluwarsa. Silakan coba lagi.' }}</p>
        <div class="space-x-4">
            <a href="{{ url()->previous() }}" 
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                Kembali
            </a>
            <a href="{{ request()->is('admin*') ? route('login-admin.index') : route('login.index') }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                Login Kembali
            </a>
        </div>
    </div>
</div>
@endsection 