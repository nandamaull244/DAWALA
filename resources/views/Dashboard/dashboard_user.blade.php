@extends('layouts.main')

@push('css')
@endpush

@section('page-heading')
    Data Pengajuan Pelayanan
@endsection

@section('content')
    <section class="row">
        <div class="col-12 col-lg-12">
            @include('main-service.index')
        </div>
    </section>
@endsection

@push('scripts')
@endpush
