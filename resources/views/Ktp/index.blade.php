@extends('Dashboard.layout.main')

@push('css')
    
@endpush

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
    <div class="page-heading">
        <h3>Input layanan KTP-eL</h3>
    </div>

    <div class="page-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                      
                        <p class="text-subtitle text-muted">Silahkan mengisi form dibawah ini untuk mengajukan layanan KTP-eL</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form KTP</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicInput">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="namaLengkap" name="namaLengkap"
                                         required> 
                                </div>

                                <div class="form-group">
                                    <label for="helpInputTop">Alamat lengkap</label>
                                    <input type="text" class="form-control" id="alamatLengkap" name="alamatLengkap" required>
                                    <p><small class="text-muted">contoh: Jl. Mangunsarkoro, No. 123, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43213</small>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="helpInputTop">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude" required readonly>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="helpInputTop">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude" required readonly>
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="desaKelurahan">Desa/Kelurahan</label>
                                    <div class="input-group">
                                        <select id="desaKelurahan" class="form-control" name="desaKelurahan" required>
                                            <option value="" disabled selected>Pilih Desa/Kelurahan</option>
                                            <option value="desa1">Desa 1</option>
                                            <option value="desa2">Desa 2</option>
                                            <option value="desa3">Desa 3</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                        <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="basicInput">No. Telepon/HP (Whatsapp)</label>
                                    <input type="text" class="form-control" id="noHp" name="noHp"
                                        placeholder="+62">
                                </div>
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Foto bukti keterbatasan</label>
                                    <input class="form-control" type="file" id="formFile" name="fotoKeterbatasan">
                                </div>
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Foto kartu keluaga</label>
                                    <input class="form-control" type="file" id="formFile" name="fotoKartuKeluaga">
                                </div>
                                <div class="form-group">
                                    <label for="formFile" class="form-label">Upload formulir</label>
                                
                                    <button class="form-control btn btn-outline-primary" type="button" id="formFile" name="fotoKeterbatasan" data-bs-toggle="modal" data-bs-target="#formulirModal">Upload formulir</button>
                                </div>

                               
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicInput">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rt">RT</label>
                                            <input type="text" class="form-control form-control-sm" id="rt" name="rt"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rw">RW</label>
                                            <input type="text" class="form-control form-control-sm" id="rw" name="rw"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <div class="input-group">
                                        <select id="kecamatan" class="form-control" name="kecamatan" required>
                                            <option value="" disabled selected>Pilih Kecamatan</option >
                                            <option value="kecamatan1">Kecamatan 1</option>
                                            <option value="kecamatan2">Kecamatan 2</option>
                                            <option value="kecamatan3">Kecamatan 3</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                        <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kategoriPelayanan">Kategori Pelayanan</label>
                                    <div class="input-group">
                                        <select id="kategoriPelayanan" class="form-control" name="kategoriPelayanan" required>
                                            <option value="" disabled selected>Pilih Kategori Pelayanan</option>
                                            <option value="disabilitasFisik">Disabilitas fisik</option>
                                            <option value="disabilitasNetraButa">Disabilitas netra/buta</option>
                                            <option value="disabilitasRunguBicara">Disabilitas rungu/bicara</option>
                                            <option value="disabilitasMentalJiwa">Disabilitas mental/jiwa</option>
                                            <option value="disabilitasFisikDanMental">Disabilitas fisik dan mental</option>
                                            <option value="disabilitasLainnya">Disabilitas lainnya</option>
                                            <option value="lansia">Lansia</option>
                                            <option value="odgj">ODGJ</option>
                                            <option value="pendudukSakit">Penduduk sakit</option>
                                            <option value="pendudukTerlantar">Penduduk terlantar</option>
                                            <option value="pendudukTerkenaBencana">Penduduk terkena bencana</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                        <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="form-group" id="fotoBuktiKeterbatasan" style="display: none;">
                                    <label for="formFile" class="form-label">Foto bukti instansi terkait (jika benar ODGJ)</label>
                                    <input class="form-control" type="file" id="formFile" name="fotoKeterbatasan">
                                </div>

                           
                                <div class="form-group">
                                    <label for="basicInput">Alasan Pengajuan</label>
                                    <input type="text" class="form-control" id="alasanPengajuan" name="alasanPengajuan"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="tipePelayanan">Tipe Pelayanan</label>
                                    <div class="input-group">
                                        <select id="tipePelayanan" class="form-control" name="tipePelayanan">
                                            <option value="" disabled selected>Pilih Tipe Pelayanan</option>
                                            <option value="tipePelayanan1">Tipe Pelayanan 1</option>
                                            <option value="tipePelayanan2">Tipe Pelayanan 2</option>
                                            <option value="tipePelayanan3">Tipe Pelayanan 3</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                        <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Download Formulir</label>
                                    <div class="d-flex">
                                        <a href="{{ asset('path/to/F1.02.pdf') }}" class="btn btn-primary me-2" download>
                                            <i class="bi bi-file-earmark-pdf"></i> F1.02
                                        </a>
                                        <a href="{{ asset('path/to/F1.04.pdf') }}" class="btn btn-primary" download>
                                            <i class="bi bi-file-earmark-pdf"></i> F1.04
                                        </a>
                                    </div>
                                    <small class="text-danger mt-2 d-block">*Formulir F1.04 khusus untuk penduduk yang tidak memiliki data atau dokumen sama sekali</small>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @include('Ktp.modal_upload_formulir')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriPelayanan = document.getElementById('kategoriPelayanan');
            const fotoBuktiKeterbatasan = document.getElementById('fotoBuktiKeterbatasan');

            kategoriPelayanan.addEventListener('change', function() {
                if (this.value === 'odgj') {
                    fotoBuktiKeterbatasan.style.display = 'block';
                } else {
                    fotoBuktiKeterbatasan.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent the file input from opening when clicked
            document.getElementById('formFile').addEventListener('click', function(e) {
                e.preventDefault();
            });
        });

        document.getElementById('formFile').addEventListener('click', function(e) {
            e.preventDefault();
        });


    </script>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if geolocation is supported by the browser
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    
                    // Set the values in the input fields
                    document.getElementById('latitude').value = latitude.toFixed(6);
                    document.getElementById('longitude').value = longitude.toFixed(6);
                }, function(error) {
                    console.error("Error: " + error.message);
                    alert("Tidak dapat mengambil lokasi Anda. Silakan masukkan secara manual.");
                });
            } else {
                alert("Geolokasi tidak didukung oleh browser Anda. Silakan masukkan lokasi Anda secara manual.");
            }
        });
    </script>
    @endpush
    
@endsection
