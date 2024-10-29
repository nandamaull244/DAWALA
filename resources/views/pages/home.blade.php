@extends('pages.layouts.main')

@section('content')
    <!--banner header -->
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-7 animated fadeInLeft">
                            <div class="text-sm-center text-md-start">
                                <h4 class="text-white text-uppercase fw-bold mb-4">Melayani sepenuh hati</h4>
                                <h1 class="display-1 text-white mb-4">DAWALA-PEDULI</h1>
                                <p class="mb-5 fs-5">Program DAWALA (Datangi Warga Layani) merupakan program
                                    inovatif yang diluncurkan oleh Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)
                                    Kabupaten Cianjur pada tahun 2021.
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                    <a class="btn btn-success rounded-pill py-3 px-4 px-md-5 me-2"
                                        href="{{ url('/register') }}">Daftar
                                        DAWALA</a>
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 ms-2" href="#"><i
                                            class="fas fa-play-circle me-2"></i> Tutorial Video</a>
                                </div>

                                <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-2">
                                    <form class="d-flex align-items-center">
                                        <div class="input-group">
                                            <!-- Button Search Icon -->
                                            <span class="input-group-text bg-white border-0 rounded-start"
                                                id="search-addon">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <!-- Input Field -->
                                            <input class="form-control border-0 rounded-end" type="text"
                                                placeholder="Masukan nomor tiket Anda" aria-label="Order Number"
                                                aria-describedby="search-addon">
                                            <!-- Button Cek Tiket -->
                                            <button class="btn btn-primary rounded-pill px-4 ms-2" type="submit">Cek Tiket
                                                <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-5 animated fadeInRight ">
                            <div class="calrousel-img" style="object-fit: cover;">
                                <img src="{{ asset('assets') }}/img/header-banner.png" class="img-fluid w-100"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- banner header End -->
    <!-- statistik start -->
    <div class="container-fluid statistik bg-light py-5">
        <div class="container py-5">
            <div class="position-relative">
                <div class="owl-carousel statistik-carousel wow fadeInUp" data-wow-delay="0.2s">
                    <!-- Stat 1 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="fas fa-map-marker-alt fa-2x"></i> <!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">250+</h3>
                            <p class="text-muted">Total Kunjungan</p>
                        </div>
                    </div>
                    <!-- Stat 2 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="fas fa-blind fa-2x"></i> <!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">600+</h3>
                            <p class="text-muted">Total Lansia</p>
                        </div>
                    </div>
                    <!-- Stat 3 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="fas fa-wheelchair fa-2x"></i> <!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">1.8K+</h3>
                            <p class="text-muted">Total Disabilitas</p>
                        </div>
                    </div>
                    <!-- Stat 4 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="fas fa-users fa-2x"></i> <!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">500+</h3>
                            <p class="text-muted">Total Pengguna</p>
                        </div>
                    </div>
                    <!-- Stat 5 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="fas fa-heart fa-2x"></i> <!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">300+</h3>
                            <p class="text-muted">Total Bantuan</p>
                        </div>
                    </div>
                    <!-- Stat 6 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="far fa-file-alt fa-2x"></i> <!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">300+</h3>
                            <p class="text-muted">Total Dokumen Masuk</p>
                        </div>
                    </div>
                    <!-- Stat 7 -->
                    <div class="item">
                        <div class="card border-0 shadow-sm p-4">
                            <div class="icon mb-3">
                                <i class="fas fa-smile fa-2x"></i><!-- Ikon -->
                            </div>
                            <h3 class="fw-bold">300+</h3>
                            <p class="text-muted">Masyarakat Puas</p>
                        </div>
                    </div>
                    <!-- Tambahan statistik lainnya -->
                </div>
                
                <!-- Navigation buttons -->
                <div class="owl-nav d-none d-md-block">
                    <button class="btn btn-primary position-absolute top-50 start-0 translate-middle-y ms-n5" id="prevBtn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-primary position-absolute top-50 end-0 translate-middle-y me-n5" id="nextBtn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- statistik end -->
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
                        <a class="btn btn-success rounded-pill py-2 px-4"
                            href="{{ url('/detail-persyaratan') }}">Pelajari</a>
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
                        <a class="btn btn-success rounded-pill py-2 px-4"
                            href="{{ url('/detail-persyaratan') }}">Pelajari</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- layanan End -->

    <!-- Dokumentasi start -->
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
    </div>
    <!-- Dokumentasi End -->
    <!-- FAQs Start -->
    <div class="container-fluid faq-section bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-xl-12 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="h-100">
                        <div class="mb-5">
                            <h4 class="text-primary">Pertanyaan </h4>
                            <h1 class="display-4 mb-0">Pertanyaan Umum yang Sering Diajukan</h1>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button  border-0" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Q: Apa itu Aplikasi DAWALA?

                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show active"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body rounded">
                                        A: DAWALA adalah aplikasi layanan yang memfasilitasi masyarakat Kabupaten Cianjur,
                                        terutama mereka yang berkebutuhan khusus, orang terlantar, korban bencana
                                        alam/sosial, ODGJ (Orang Dengan Gangguan Jiwa), dan lansia, untuk mendapatkan
                                        kunjungan langsung dari petugas Disdukcapil ke rumah dalam pengurusan dokumen
                                        kependudukan seperti e-KTP, Kartu Keluarga (KK), Akta Kematian, dan Surat Keterangan
                                        Domisili.

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Q: Siapa saja yang bisa menggunakan aplikasi DAWALA?

                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A: Aplikasi DAWALA dapat digunakan oleh:
                                        <ul>
                                            <li>Masyarakat yang membutuhkan layanan kunjungan langsung karena keterbatasan
                                                fisik atau kondisi khusus.</li>
                                            <li>Perangkat desa (RT/RW).</li>
                                            <li>Rumah sakit atau fasilitas kesehatan yang memiliki MOU dengan Disdukcapil.
                                            </li>
                                            <li>Instansi pemerintah atau organisasi masyarakat yang memiliki MOU dengan
                                                Disdukcapil.</li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Q: Dokumen apa saja yang bisa diurus melalui aplikasi DAWALA?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A: Melalui aplikasi DAWALA, masyarakat dapat mengurus dokumen eKTP dan KK (Kartu
                                        Keluarga).
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Q: Bagaimana cara mendaftar di aplikasi DAWALA untuk mendapatkan kunjungan langsung
                                        dari petugas?

                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A: Berikut langkah-langkahnya:
                                        <ul>
                                            <li>Unduh dan instal aplikasi DAWALA dari Google Play Store (jika tersedia).
                                            </li>
                                            <li>Registrasi akun dengan memasukkan data diri lengkap.
                                            </li>
                                            <li>Pilih jenis layanan yang dibutuhkan (e-KTP, KK, Akta Kematian, Surat
                                                Keterangan Domisili).

                                            </li>
                                            <li>Isi formulir permohonan dengan informasi tambahan, seperti alasan kunjungan
                                                (misalnya karena lansia, sakit, ODGJ, atau korban bencana).
                                            </li>
                                            <li>Pilih tanggal dan waktu untuk kunjungan petugas, sesuai jadwal yang
                                                tersedia.

                                            </li>
                                            <li>Kirim permohonan, dan tunggu konfirmasi dari Disdukcapil.

                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        Q: Apakah layanan DAWALA hanya untuk individu yang berkebutuhan khusus?


                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A: Ya, layanan ini difokuskan untuk masyarakat yang memiliki keterbatasan fisik atau
                                        kondisi khusus, seperti lansia, orang dengan gangguan jiwa (ODGJ), korban bencana
                                        alam/sosial, dan orang terlantar. Namun, perangkat desa, rumah sakit, serta instansi
                                        yang sudah bekerja sama (MOU) dengan Disdukcapil juga dapat mengajukan permohonan
                                        bagi mereka yang membutuhkan.



                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Q: Apakah ada biaya untuk layanan ini?



                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A: Layanan melalui aplikasi DAWALA adalah gratis, dan tidak ada biaya tambahan yang
                                        dikenakan untuk kunjungan petugas ke rumah.




                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        Q: Apa syarat untuk pengurusan e-KTP melalui DAWALA?


                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse"
                                    aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A: Untuk pengurusan e-KTP melalui aplikasi DAWALA, syarat yang perlu disiapkan
                                        adalah:

                                        <ul>
                                            <li>Fotokopi Kartu Keluarga (KK).

                                            </li>
                                            <li>Fotokopi Akta Kelahiran (jika diperlukan).

                                            </li>
                                            <li>Surat pengantar dari RT/RW (opsional, tergantung kebijakan daerah).


                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseEight" aria-expanded="false"
                                        aria-controls="collapseEight">
                                        Q: Bagaimana jika saya ingin mengurus Kartu Keluarga (KK)?



                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse"
                                    aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A:Untuk pengurusan KK melalui DAWALA, syarat yang diperlukan adalah:


                                        <ul>
                                            <li>Surat pengantar dari RT/RW.


                                            </li>
                                            <li>Fotokopi KTP Kepala Keluarga.


                                            </li>
                                            <li>Fotokopi Akta Nikah (untuk pasangan yang baru menikah).

                                            </li>
                                            <li>Dokumen pendukung lainnya (jika ada perubahan anggota keluarga, seperti
                                                kelahiran atau kematian).


                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- FAQs End -->
    <script>
        let images = [
            "{{ asset('assets') }}/img/1.png",
            "{{ asset('assets') }}/img/2.png",
            "{{ asset('assets') }}/img/3.png"
        ];

        let currentIndex = 0;
        const headerItem = document.querySelector('.header-carousel-item');

        // Function to change background
        function changeBackground() {
            headerItem.style.backgroundImage = `url('${images[currentIndex]}')`;
            currentIndex = (currentIndex + 1) % images.length;
        }

        // Change background every 5 seconds
        setInterval(changeBackground, 5000);

        // Initial background load
        changeBackground();
    </script>
@endsection
