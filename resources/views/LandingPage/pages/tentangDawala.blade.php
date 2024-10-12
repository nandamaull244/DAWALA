@extends('LandingPage.layouts.landingPage')

@section('content')
        <!-- About Start -->
        <div class="container-fluid bg-light about pb-5 pt-5">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-item-content bg-white rounded p-5 h-100">
                            <h4 class="text-primary">Tentang</h4>
                            <h1 class="display-4 mb-4">DAWALA PEDULI</h1>
                            <p>Dawala Peduli adalah sebuah inisiatif sosial yang berfokus pada memberikan akses mudah dan layanan inklusif bagi disabilitas, orang berkebutuhan khusus, dan ODGJ. Dengan komitmen kuat terhadap kesetaraan, Dawala Peduli hadir untuk membantu dalam pengurusan dokumen kependudukan, seperti KTP dan KK, serta layanan sosial lainnya. Kami mengedepankan layanan yang ramah, profesional, dan penuh empati, memastikan setiap individu mendapatkan hak dan pelayanan yang layak tanpa diskriminasi.
                            </p>
                            
                            <div class="row g-3">
                                <div class="tentang-btn d-flex">
                                    <a class="btn btn-md-square rounded-circle me-3" href="#"><i
                                            class="fa fa-phone-alt"></i></a>
                                    <a class="btn btn-md-square rounded-circle me-3" href="#"><i
                                            class="fab fa-youtube"></i></a>
                                    <a class="btn btn-md-square rounded-circle me-3" href="#"><i
                                            class="fab fa-instagram"></i></a>
                                    <a class="btn btn-md-square rounded-circle me-0" href="#"><i
                                            class="fab fa-tiktok"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-white rounded p-5 h-100">
                            <div class="row g-4 justify-content-center">
                                <div class="col-12">
                                    <div class="rounded bg-light">
                                        <img src="{{ asset('assets') }}/img/dokumentasi-3.jpeg" class="img-fluid rounded w-100" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="counter-item bg-light rounded p-3 h-100">
                                        <div class="counter-counting">
                                            <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">129</span>
                                            <span class="h1 fw-bold text-primary">+</span>
                                        </div>
                                        <h4 class="mb-0 text-dark">Kunjungan</h4>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="counter-item bg-light rounded p-3 h-100">
                                        <div class="counter-counting">
                                            <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">99</span>
                                            <span class="h1 fw-bold text-primary">+</span>
                                        </div>
                                        <h4 class="mb-0 text-dark">Total Pengguna</h4>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="counter-item bg-light rounded p-3 h-100">
                                        <div class="counter-counting">
                                            <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">556</span>
                                            <span class="h1 fw-bold text-primary">+</span>
                                        </div>
                                        <h4 class="mb-0 text-dark">Prestasi</h4>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="counter-item bg-light rounded p-3 h-100">
                                        <div class="counter-counting">
                                            <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">967</span>
                                            <span class="h1 fw-bold text-primary">+</span>
                                        </div>
                                        <h4 class="mb-0 text-dark">Total Bantuan</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->
@endsection