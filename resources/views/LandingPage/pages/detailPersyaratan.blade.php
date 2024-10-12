@extends('LandingPage.layouts.landingPage')


@section('content')
<!-- layanan Start -->
<div class="container-fluid layanan bg-light py-4">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">

            <h1 class="display-4 mb-4">Layanan DAWALA PEDULI</h1>
            <p class="mb-0">Pembuatan pengajuan pembuatan e-KTP dan Kartu Keluarga ada beberapa syarat yang harus diisi dan dipenuhi
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="layanan-item p-4 pt-0">
                    <div class="layanan-icon p-4 mb-4">
                        <i class="fa fa-id-card fa-3x" aria-hidden="true"></i>
                    </div>
                    <h4 class="mb-4">Syarat eKTP</h4>
                    <ul>
                        <li>Usia minimal 17 th
                        </li>
                        <li>Fotokopi KK atau asli
                        </li>
                        <li>
                            Surat pengantar kelurahan/ desa (optional, tergantung kebijakan setempat) domisili tidak punya data

                        </li>
                        <li>Akte Kelahiran atau Surat Nikah (jika diperlukan) perubahan
                        </li>
                        <li>
                            Untuk pengambilan e-KTP: Menunggu ketersediaan blangko, jika blangko kosong pemohon bisa mendapatkan (Surat Ket) sebagai pengganti sementara e--KTP yang sah secara hukum.

                        </li>
                    </ul>
                   
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.4s">
                <div class="layanan-item p-4 pt-0">
                    <div class="layanan-icon p-4 mb-4">
                        <i class="fas fa-file-alt fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Syarat Kartu Keluarga (KK)</h4>
                    <p class="mb-4">(bagi yang baru menikah):
                    </p>
                    <ul>
                        <li>Surat pengantar RT/RW
                        </li>
                        <li>Fotocopy akta nikah atau Surat Nikah
                        </li>
                        <li>Fotocopy KTP kedua mempelai
                        </li>
                        <li>Fotocopy KK orang tua masing-masing sebagai dokumen pendukung
                        </li>
                    </ul>
                    <p class="mb-4">Penambahan Anggota Keluarga:</p>
                    <ul>
                        <li>Fotocopy KK (lama)
                        </li>
                        <li>Fotocopy Akta Kelahiran anak
                        </li>
                        <li>Surat bukti kelahiran(desa, bidan, puskesmas)
                        </li>
                        <li>Fotocopy KTP anggota keluarga yang ditambahkan diatas 17tahun</li>
                        <li>KK lama dan ijazah</li>
                        <li>Surat ket pindah datang (jika penambahan anggota karna pindah domisili dari wilayah lain) </li>
                    </ul>
                    <p class="mb-4">Penggantian KK hilang atau Rusak: - Surat Keterangan kehilangan dari kepolisian (jika KK hilang) :
                    </p>
                    <ul>
                        <li>KK yang rusak (jika pergantian karena rusak)

                        </li>
                        <li>Fotocopy KTP kepala keluarga

                        </li>
                        <li> Fotocopy Akta Kelahiran (seluruh angota keluarga)

                        </li>
                        <li>Surat pengantar dari RT/RW</li>
                        
                    </ul>
                    <p class="mb-4">Penambahan Anggota Keluarga:</p>
                    <ul>
                        <li>Fotocopy KK (lama)
                        </li>
                        <li>Fotocopy Akta Kelahiran anak
                        </li>
                        <li>Surat bukti kelahiran(desa, bidan, puskesmas)
                        </li>
                        <li>Fotocopy KTP anggota keluarga yang ditambahkan diatas 17tahun</li>
                        <li>KK lama dan ijazah</li>
                        <li>Surat ket pindah datang (jika penambahan anggota karna pindah domisili dari wilayah lain) </li>
                    </ul>
                    <p class="mb-4">Pindah datang (mutasi KK) :</p>
                    <ul>
                        <li>Surat Ket Pindah (SKP) dari daerah asal

                        </li>
                        <li>KK asli dari daerah asal

                        </li>
                        <li>Fotocopy KTP anggota keluarga yang pindah
                        </li>
                        <li>Surat pengantar dari RT/RW di daerah tujuan pindah.
                        </li>
                        
                    </ul>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!-- layanan End -->

@endsection
