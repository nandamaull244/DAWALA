@extends('errors')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-800">500</h1>
        <p class="text-2xl font-medium text-gray-600 mb-6">Server Error</p>
        <p class="text-gray-500 mb-6">{{ $message ?? 'Server Error. Silakan coba kembali.' }}</p>
        <a href="{{ url()->previous() }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Kembali
        </a>
    </div>
</div>
@endsection 