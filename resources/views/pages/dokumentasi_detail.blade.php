@extends('pages.layouts.main')

@section('content')
    <div class="container-fluid dokumentasi py-5">
        <div class="container py-5">
            <!-- Header section -->
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Dokumentasi</h4>
                <h1 class="display-4 mb-4">{{ $article->title }}</h1>
                <div class="d-flex justify-content-center gap-3 text-muted mb-4">
                    <small><i class="fa fa-calendar me-2"></i>{{ $article->created_at->format('d M Y') }}</small>
                    <small><i class="fa fa-user me-2"></i>{{ $article->user->full_name }}</small>
                </div>
            </div>

            <!-- Article content -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Featured Image -->
                    @if($article->image_name)
                        <div class="mb-5 text-center">
                            <img src="{{ asset('storage/' . $article->image_name) }}" alt="{{ $article->title }}" 
                                class="img-fluid rounded w-75">
                        </div>
                    @endif
                        
                    <!-- Article Body -->
                    <div class="article-content wow fadeInUp" data-wow-delay="0.2s">
                        <h6 class="mb-3">{{ Str::limit(strip_tags(htmlspecialchars_decode($article->body)), 150) }}</h6>
                    </div>

                    <!-- Tags if any -->
                    @if($article->tags)
                        <div class="mt-4">
                            @foreach($article->tags as $tag)
                                <span class="badge bg-light text-dark me-2">#{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Share buttons -->
                    <div class="mt-5 pt-3 border-top">
                        <h5 class="mb-3">Bagikan artikel ini:</h5>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                                class="btn btn-primary btn-sm" target="_blank">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" 
                                class="btn btn-info btn-sm" target="_blank">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ url()->current() }}" 
                                class="btn btn-success btn-sm" target="_blank">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .article-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
    }
    .article-content h2, 
    .article-content h3 {
        margin: 2rem 0 1rem;
    }
</style>
@endpush
