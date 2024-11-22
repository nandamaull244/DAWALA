@extends('pages.layouts.main')

@section('content')
<!-- visi misi start -->
<div class="container-fluid bg-light about pb-5 pt-5">
    <div class="container pb-5">
        <div class="row g-5">
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">

                <div class="about-item-content bg-white rounded p-5 h-100">
                    <div class="col-12">
                        <div class="rounded bg-light">
                            <img src="{{ asset('assets') }}/img/dokumentasi-3.jpeg" class="img-fluid rounded w-100"
                                alt="">
                        </div>
                    </div>
                    <h4 class="text-primary pt-4">Visi Misi</h4>
                    <h1 class="display-4 mb-4">DAWALA PEDULI</h1>
                    <p>DAWALA (DATANGI WARGA LAYANI) merupakan program inovatif yang diluncurkan oleh Dinas Kependudukan
                        dan Pencatatan Sipil (Disdukcapil) Kabupaten Cianjur pada tahun 2021. Program ini bertujuan
                        untuk meningkatkan aksesibilitas layanan administrasi kependudukan bagi masyarakat rentan di
                        wilayah Kabupaten Cianjur. Dengan mendatangi langsung masyarakat rentan di rumah atau tempat
                        tinggal mereka untuk mengurus dokumen kependudukan.

                    </p>


                </div>
            </div>
            <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                <div class="bg-white rounded p-5 h-100">
                    <div class="row g-4 justify-content-center">

                        <div class="col-12">
                            <p>
                                Visi : Mewujudkan aksesibilitas layanan administrasi kependudukan yang setara dan
                                bermartabat bagi seluruh warga Cianjur, terutama kelompok rentan, guna membangun
                                masyarakat yang inklusif dan berdaya.

                            </p>
                            <p>Misi :</p>
                            <ul>

                                <li>
                                    Meningkatkan kualitas dan kuantitas layanan administrasi kependudukan bagi kelompok
                                    rentan melalui inovasi dan adaptasi teknologi.

                                </li>
                                <li>
                                    Membangun jaringan kerjasama dengan berbagai pihak terkait, seperti lembaga sosial,
                                    komunitas, dan pemerintah daerah, untuk memperluas jangkauan layanan.

                                </li>
                                <li>
                                    Membangun jaringan kerjasama dengan berbagai pihak terkait, seperti lembaga sosial,
                                    komunitas, dan pemerintah daerah, untuk memperluas jangkauan layanan.

                                </li>
                                <li>
                                    Mengembangkan sistem pendataan dan pemantauan yang komprehensif untuk memastikan
                                    efektivitas program dan mencapai target yang telah ditetapkan.

                                </li>
                                <li>
                                    Menjadi pusat unggulan dalam memberikan layanan administrasi kependudukan bagi
                                    kelompok rentan di wilayah Cianjur.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- visi misi end -->
 <!-- Team Start -->
 <div class="container-fluid team pb-5 pt-5">
    <div class="container pb-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Tim DAWALA</h4>
            <h1 class="display-4 mb-4">Kenalan dengan tim DAWALA-PEDULI</h1>
            <p class="mb-0">Sekumpulan individu berdedikasi yang memiliki semangat tinggi dalam memberikan pelayanan
                inklusif dan ramah. Kami bekerja secara profesional dengan hati, memastikan setiap proses berjalan
                lancar, dan setiap kebutuhan disabilitas, orang berkebutuhan khusus, serta ODGJ terpenuhi dengan penuh
                kepedulian dan empati.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="team-item">
                    <div class="team-img">
                        <img src="{{ asset('assets') }}/img/team-1.jpg" class="img-fluid rounded-top w-100"
                            alt="">
                        <div class="team-icon">
                           
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="https://www.youtube.com/@dawalapeduli"><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="https://www.instagram.com/dawalapeduli?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href="https://wa.me/6281387295920"><i
                                    class="fa fa-phone-alt"></i></a>
                        </div>
                    </div>
                    <div class="team-title p-4">
                        <h4 class="mb-0">Yudi Nugraha</h4>
                        <p class="mb-0">Kepala Bagian DISDUKCAPIL Cianjur</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="team-item">
                    <div class="team-img">
                        <img src="{{ asset('assets') }}/img/team-1.jpg" class="img-fluid rounded-top w-100"
                            alt="">
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-title p-4">
                        <h4 class="mb-0">Ari Julian Umbara</h4>
                        <p class="mb-0">IT support</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="team-item">
                    <div class="team-img">
                        <img src="{{ asset('assets') }}/img/team-2.jpg" class="img-fluid rounded-top w-100"
                            alt="">
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-title p-4">
                        <h4 class="mb-0">Agus Merdekawanto</h4>
                        <p class="mb-0">Sekertaris</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.6s">
                <div class="team-item">
                    <div class="team-img">
                        <img src="{{ asset('assets') }}/img/team-3.jpg" class="img-fluid rounded-top w-100"
                            alt="">
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-title p-4">
                        <h4 class="mb-0">Sandika</h4>
                        <p class="mb-0">Humas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                <div class="team-item">
                    <div class="team-img">
                        <img src="{{ asset('assets') }}/img/team-4.jpg" class="img-fluid rounded-top w-100"
                            alt="">
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-title p-4">
                        <h4 class="mb-0">Della Riyagung</h4>
                        <p class="mb-0">Bendahara</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- Team End -->
    <!-- tentang dawala start -->
    <div class="container-fluid bg-light about pb-5 pt-5">
        <div class="container pb-5">
            <div class="row g-5">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item-content bg-white rounded p-5 h-100">
                        <h4 class="text-primary">Tentang</h4>
                        <h1 class="display-4 mb-4">DAWALA PEDULI</h1>
                        <p>Dawala Peduli adalah sebuah inisiatif sosial yang berfokus pada memberikan akses mudah dan
                            layanan inklusif bagi disabilitas, orang berkebutuhan khusus, dan ODGJ. Dengan komitmen kuat
                            terhadap kesetaraan, Dawala Peduli hadir untuk membantu dalam pengurusan dokumen kependudukan,
                            seperti KTP dan KK, serta layanan sosial lainnya. Kami mengedepankan layanan yang ramah,
                            profesional, dan penuh empati, memastikan setiap individu mendapatkan hak dan pelayanan yang
                            layak tanpa diskriminasi.
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
                                    <img src="{{ asset('assets') }}/img/dokumentasi-3.jpeg" class="img-fluid rounded w-100"
                                        alt="">
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
    <!-- tentang dawala end -->
     
   
@endsection
