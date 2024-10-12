@extends('LandingPage.layouts.landingPage')


@section('content')
<!-- layanan Start -->
<div class="container-fluid layanan bg-light py-4">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">

            <h1 class="display-4 mb-4">Layanan DAWALA PEDULI</h1>
            <p class="mb-0">Dawala Peduli hadir untuk mempermudah layanan pembuatan KTP dan KK bagi disabilitas, orang
                berkebutuhan khusus, serta ODGJ. Kami menyediakan akses yang mudah dan cepat, dengan layanan ramah yang
                mengutamakan kenyamanan serta penghormatan terhadap setiap individu. Tim kami siap membantu dengan
                sepenuh hati, memastikan proses administrasi berjalan lancar tanpa hambatan.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="layanan-item p-4 pt-0">
                    <div class="layanan-icon p-4 mb-4">
                        <i class="fa fa-id-card fa-3x" aria-hidden="true"></i>
                    </div>
                    <h4 class="mb-4">Layanan eKTP</h4>
                    <p class="mb-4">Layanan kami membantu Anda dalam pembuatan atau pembaruan eKTP dengan proses yang
                        cepat dan efisien. Kami memastikan data Anda tercatat secara akurat dan terintegrasi dengan
                        sistem kependudukan, sehingga memudahkan akses ke berbagai layanan publik. Dengan layanan
                        profesional dan ramah, kami siap membantu seluruh proses dari awal hingga selesai.
                    </p>
                    <a class="btn btn-success rounded-pill py-2 px-4" href="{{ url('/detail-persyaratan') }}">Pelajari</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="layanan-item p-4 pt-0">
                    <div class="layanan-icon p-4 mb-4">
                        <i class="fas fa-file-alt fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Layanan Kartu Keluarga (KK)</h4>
                    <p class="mb-4">Kami menyediakan layanan pengurusan Kartu Keluarga (KK) untuk pembuatan baru,
                        perubahan data, atau penambahan anggota keluarga. Dengan prosedur yang jelas dan mudah, tim kami
                        memastikan setiap tahap pengurusan KK berjalan lancar, membantu Anda memenuhi kebutuhan
                        administrasi kependudukan tanpa hambatan.
                    </p>
                    <a class="btn btn-success rounded-pill py-2 px-4" href="{{ url('/detail-persyaratan') }}">Pelajari</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- layanan End -->

@endsection
