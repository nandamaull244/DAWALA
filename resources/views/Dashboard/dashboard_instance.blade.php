@extends('layouts.main')

@push('css')
@endpush

@section('page-heading')
    Dashboard Instansi
@endsection

@section('content')
    <section class="row">
        <div class="col-12 col-lg-12">
            @include('instance.pelayanan.index')
        </div>
    </section>
@endsection

@push('scripts')
@endpush
