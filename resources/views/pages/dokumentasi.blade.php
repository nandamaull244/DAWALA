@extends('pages.layouts.main')

@section('content')
    <div class="container-fluid dokumentasi py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Dokumentasi</h4>
                <h1 class="display-4 mb-4">Kegiatan DAWALA PEDULI</h1>
                <p class="mb-0">Berbagai aktivitas dan kontribusi sosial yang dilakukan Dawala Peduli. Melalui
                    program-program inklusif dan berkelanjutan, kami berkomitmen untuk memberikan dampak positif bagi
                    masyarakat, khususnya disabilitas, orang berkebutuhan khusus, dan ODGJ. Saksikan momen-momen berharga
                    dari perjalanan kami dalam memberikan layanan yang ramah, mudah diakses, dan berorientasi pada
                    kepedulian.
                </p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="owl-carousel dokumentasi-carousel">
                    @foreach($articles as $article)
                        <div class="dokumentasi-item">
                            <div class="dokumentasi-img">
                                @if($article->image_name)
                                    <img src="{{ asset('storage/' . $article->image_name) }}" class="img-fluid rounded-top w-100" alt="{{ $article->title }}">
                                @else
                                    <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid rounded-top w-75" alt="No Image">
                                @endif
                            </div>
                            <div class="dokumentasi-content p-4">
                                <div class="dokumentasi-comment d-flex justify-content-between mb-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span> {{ $article->user->full_name }}</div>
                                    <div class="small"><span class="fa fa-calendar text-primary"></span> {{ $article->created_at->format('d F Y') }}</div>
                                </div>
                                <a href="{{ route('page.documentation.detail', $article) }}" class="h4 d-inline-block mb-3">{{ $article->title }}</a>
                                <p class="mb-3">{{ Str::limit(strip_tags(htmlspecialchars_decode($article->body)), 150) }}</p>
                                <a href="{{ route('page.documentation.detail', $article) }}" class="btn p-0">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
