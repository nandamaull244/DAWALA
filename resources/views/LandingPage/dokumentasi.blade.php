@extends('./layouts.landingPage')

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
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="dokumentasi-item">
                    <div class="dokumentasi-img">
                        <img src="{{asset('assets')}}/img/dokumentasi-1.jpeg" class="img-fluid rounded-top w-100"
                            alt="">

                    </div>
                    <div class="dokumentasi-content p-4">
                        <div class="dokumentasi-comment d-flex justify-content-between mb-3">
                            <div class="small"><span class="fa fa-user text-primary"></span> Tim DAWALA</div>
                            <div class="small"><span class="fa fa-calendar text-primary"></span> 16 Januari 2015</div>

                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Kunjungan Tim DAWALA untuk pembuatan eKTP</a>
                        <p class="mb-3">Tim DAWALA mendatangi langsung ke rumah masyarakat disabilitas untuk pembuatan
                            eKTP.</p>
                        <a href="#" class="btn p-0">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="dokumentasi-item">
                    <div class="dokumentasi-img">
                        <img src="{{asset('assets')}}/img/dokumentasi-2.jpeg" class="img-fluid rounded-top w-100"
                            alt="">

                    </div>
                    <div class="dokumentasi-content p-4">
                        <div class="dokumentasi-comment d-flex justify-content-between mb-3">
                            <div class="small"><span class="fa fa-user text-primary"></span> Tim DAWALA</div>
                            <div class="small"><span class="fa fa-calendar text-primary"></span> 25 Maret 2022</div>

                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Program Baru DAWALA</a>
                        <p class="mb-3">Tim DAWALA berhasil memberikan pelayanan yang sangat baik bagi masyarakat
                            penyandang disabilitas, lansia, maupun ODGJ untuk pembuatan eKTP dan KK.</p>
                        <a href="#" class="btn p-0">Read More <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                <div class="dokumentasi-item">
                    <div class="dokumentasi-img">
                        <img src="{{asset('assets')}}/img/dokumentasi-3.jpeg" class="img-fluid rounded-top w-100"
                            alt="">

                    </div>
                    <div class="dokumentasi-content p-4">
                        <div class="dokumentasi-comment d-flex justify-content-between mb-3">
                            <div class="small"><span class="fa fa-user text-primary"></span> Tim DAWALA</div>
                            <div class="small"><span class="fa fa-calendar text-primary"></span> 13 Juni 2023</div>

                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Kunjungan pelayanan ke rumah Pak Sutisna</a>
                        <p class="mb-3">Tim DAWALA berhasil membantu Pak Sutisna untuk pembuatan eKTP langsung di
                            kediamannya. Diketahui Pak Sutisna adalah seorang penyandang disabilitas..</p>
                        <a href="#" class="btn p-0">Read More <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection