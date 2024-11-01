@extends('errors')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">403</h1>
        <p class="text-2xl font-medium text-gray-600 mb-6">Akses Ditolak</p>
        <p class="text-gray-500 mb-6">{{ $message ?? 'Akses ditolak. Silakan coba kembali.' }}</p>
        <a href="{{ url('/') }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Kembali
        </a>
    </div>
</div>
@endsection 