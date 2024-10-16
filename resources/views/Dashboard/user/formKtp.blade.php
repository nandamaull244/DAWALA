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
                                <li class="breadcrumb-item"><a href="{{ route('dashboardUser.dashboardUser') }}">Dashboard</a></li>
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
                                        placeholder="Isi Nama Lengkap Anda">
                                </div>

                                <div class="form-group">
                                    <label for="helpInputTop">Alamat lengkap</label>
                                    <input type="text" class="form-control" id="alamatLengkap" name="alamatLengkap">
                                    <p><small class="text-muted">contoh: Jl. Mangunsarkoro, No. 123, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43213</small>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="desaKelurahan">Desa/Kelurahan</label>
                                    <div class="input-group">
                                        <select id="desaKelurahan" class="form-control" name="desaKelurahan">
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
                                    <input class="form-control" type="file" id="formFile" name="fotoKeterbatasan">
                                </div>

                               
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicInput">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rt">RT</label>
                                            <input type="text" class="form-control form-control-sm" id="rt" name="rt" placeholder="Nomor RT">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rw">RW</label>
                                            <input type="text" class="form-control form-control-sm" id="rw" name="rw" placeholder="Nomor RW">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <div class="input-group">
                                        <select id="kecamatan" class="form-control" name="kecamatan">
                                            <option value="" disabled selected>Pilih Kecamatan</option>
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
                                        <select id="kategoriPelayanan" class="form-control" name="kategoriPelayanan">
                                            <option value="" disabled selected>Pilih Kategori Pelayanan</option>
                                            <option value="kategoriPelayanan1">Kategori Pelayanan 1</option>
                                            <option value="kategoriPelayanan2">Kategori Pelayanan 2</option>
                                            <option value="kategoriPelayanan3">Kategori Pelayanan 3</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                        <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="basicInput">Alasan Pengajuan</label>
                                    <input type="text" class="form-control" id="alasanPengajuan" name="alasanPengajuan"
                                        placeholder="Isi Alasan Pengajuan Anda">
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

           
        </div>
    </div>
@endsection

@push('scripts')
    
@endpush
