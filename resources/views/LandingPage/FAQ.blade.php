@extends('./layouts.landingPage')

@section('content')
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
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Q: Dokumen apa saja yang bisa diurus melalui aplikasi DAWALA?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    A: Melalui aplikasi DAWALA, masyarakat dapat mengurus dokumen eKTP dan KK (Kartu
                                    Keluarga).
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
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
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
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
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    Q: Apa syarat untuk pengurusan e-KTP melalui DAWALA?


                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                                data-bs-parent="#accordionExample">
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
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    Q: Bagaimana jika saya ingin mengurus Kartu Keluarga (KK)?



                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                                data-bs-parent="#accordionExample">
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
@endsection