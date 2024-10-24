@extends('layouts.main')

@push('css')
@endpush

@section('page-heading')
    Dashboard Instantiation
@endsection

@section('content')
    <section class="row">
        <div class="col-12 col-lg-12">
            @include('archive-data.index')
        </div>
    </section>
@endsection

@push('scripts')
@endpush
