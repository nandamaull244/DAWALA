@push('css')
<style>
    .form-label {
        font-weight: bold;
        
    }
</style>
@endpush
<!-- Modal Tiket -->
<div class="modal fade" id="modalTiket" tabindex="-1" aria-labelledby="modalTiketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTiketLabel">Pengajuan Pelayanan Dawala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Data Pengaduan Section -->
                <div class="mb-4">
                    <h4 class="text-primary mb-4">Data Pengajuan Pelayanan Dawala</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Nama</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="nama" class="mb-0">Ujang Sutisna</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">NIK</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="nik" class="mb-0">3201234567890123</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Pengajuan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="tanggal" class="mb-0">2024-01-01</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenis Pelayanan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="jenisPelayanan" class="mb-0">KTP-eL</p>
                                </div>
                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Desa</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="desa" class="mb-0">Suka Makmur</p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Alasan Pengajuan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="alasanPengajuan" class="mb-0">Malas aja sih</p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Alasan Ditolak</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="alasanPengajuan" class="mb-0">akwkwkwkkwk kemayunye</p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Pelayanan selesai</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="alasanPengajuan" class="mb-0">Besok datang ya wak ke kantor aku</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Kategori Pelayanan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="kategoriPelayanan" class="mb-0">Disabilitas fisik</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tipe Pelayanan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="tipePelayanan" class="mb-0">Perekaman KTP</p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Alamat</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="alamat" class="mb-0">Jl. Raya No. 123, Kel. Suka Makmur, Kec. Suka Makmur, Kota Suka Makmur</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Kecamatan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="kecamatan" class="mb-0">Suka Munjur</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Status Pengejerjaan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="statusPengerjaan" class="mb-0 text-success">Process</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Status Pelayanan</label>
                                </div>
                                <div class="col-md-8">
                                    <p id="statusPelayanan" class="mb-0">Diterima</p>
                                </div>
                            </div>
                        </div>
                    </div>
     
                    
                </div>

             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" text-white data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
