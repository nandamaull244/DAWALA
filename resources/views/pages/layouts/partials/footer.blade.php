<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-2">
        <div class="row g-5">
            <div class="col-xl-9">
                <div class="mb-5">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-6 col-xl-5">
                            <div class="footer-item">
                                <a href="index.html" class="p-0">
                                    <h3 class="text-white">DAWALA PEDULI</h3>
                                    <!-- <img src="img/logo.png" alt="Logo"> -->
                                </a>
                                <p class="text-white mb-4 mt-3">Program DAWALA (Datangi Warga Layani) merupakan program
                                    inovatif yang diluncurkan oleh Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)
                                    Kabupaten Cianjur pada tahun 2021.</p>

                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="footer-item">
                                <h4 class="text-white mb-4">Menu</h4>
                                <a href="#"><i class="fas fa-angle-right me-2"></i> Tentang DAWALA</a>
                                <a href="#"><i class="fas fa-angle-right me-2"></i> Visi Misi</a>
                                <a href="#"><i class="fas fa-angle-right me-2"></i> Tim DAWALA</a>
                                <a href="{{ url('/layanan') }}"><i class="fas fa-angle-right me-2"></i> Layanan</a>
                                <a href="{{ url('/FAQ') }}"><i class="fas fa-angle-right me-2"></i> FAQ's</a>

                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="footer-item">
                                <h4 class="mb-4 text-white">Sosial Media DAWALA</h4>
                                <div class="row g-3">
                                    <div class="footer-btn d-flex">
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
                    </div>
                </div>

            </div>

            <div class="col-xl-3">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Alamat</h4>
                    <p class="text-white mb-3">Jl. Raya Bandung No.KM 4.5, Bojong, Kec. Karangtengah, Kabupaten Cianjur,
                        Jawa Barat 43281.</p>
                    <div class="position-relative rounded-pill mb-4">
                        <div class="d-flex">
                            <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">
                                <i class="fa fa-phone-alt fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="text-white">Contact Us</h4>
                                <p class="mb-0">08934324453</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-8 text-center text-md-end mb-md-0">
                <span class="text-body"><a href="#" class=" text-white"><i
                            class="fas fa-copyright text-light me-2"></i>DAWALA PEDULI</a> 2024 All right
                    reserved.</span>
            </div>

        </div>
    </div>
</div>

<a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/lib/wow/wow.min.js"></script>
<script src="{{ asset('assets') }}/lib/easing/easing.min.js"></script>
<script src="{{ asset('assets') }}/lib/waypoints/waypoints.min.js"></script>
<script src="{{ asset('assets') }}/lib/counterup/counterup.min.js"></script>
<script src="{{ asset('assets') }}/lib/lightbox/js/lightbox.min.js"></script>
<script src="{{ asset('assets') }}/lib/owlcarousel/owl.carousel.min.js"></script>

<script src="{{ asset('assets') }}/js/main.js"></script>
@stack('scripts')