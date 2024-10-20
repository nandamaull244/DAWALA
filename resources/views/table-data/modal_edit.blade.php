<div class="modal fade" id="dataModalEdit" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_tiket" class="form-label">NO. TIKET</label>
                            <input type="text" class="form-control" id="no_tiket" name="no_tiket" value="{{ $data->no_tiket ?? '' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nama" class="form-label">NAMA</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama ?? '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kategori" class="form-label">KATEGORI</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="Disabilitas" {{ ($data->kategori ?? '') == 'Disabilitas' ? 'selected' : '' }}>Disabilitas</option>
                                <option value="Tertantar" {{ ($data->kategori ?? '') == 'Tertantar' ? 'selected' : '' }}>Tertantar</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">TANGGAL</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal ?? '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipe_layanan" class="form-label">TIPE LAYANAN</label>
                            <select class="form-select" id="tipe_layanan" name="tipe_layanan">
                                <option value="Persamaan KTP" {{ ($data->tipe_layanan ?? '') == 'Persamaan KTP' ? 'selected' : '' }}>Persamaan KTP</option>
                                <option value="Pembuatan KK" {{ ($data->tipe_layanan ?? '') == 'Pembuatan KK' ? 'selected' : '' }}>Pembuatan KK</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">TANGGAL LAHIR</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $data->tanggal_lahir ?? '' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">ALAMAT</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $data->alamat ?? '' }}">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" value="{{ $data->rt ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" value="{{ $data->rw ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="desa_kelurahan" class="form-label">DESA/KELURAHAN</label>
                            <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="{{ $data->desa_kelurahan ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="kecamatan" class="form-label">KECAMATAN</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $data->kecamatan ?? '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">NO HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $data->no_hp ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="alasan_pengajuan" class="form-label">ALASAN PENGAJUAN</label>
                            <input type="text" class="form-control" id="alasan_pengajuan" name="alasan_pengajuan" value="{{ $data->alasan_pengajuan ?? '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">FOTO BUKTI KETERBATASAN</label>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-sm btn-primary me-2" onclick="viewDocument('bukti_keterbatasan')">Lihat Foto</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">FOTO KTP</label>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-sm btn-primary me-2" onclick="viewDocument('ktp')">Lihat Foto</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">FOTO KK</label>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-sm btn-primary me-2" onclick="viewDocument('kk')">Lihat Foto</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">FORMULIR</label>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-sm btn-primary me-2" onclick="viewDocument('formulir')">Lihat Formulir</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status_pengerjaan" class="form-label">STATUS PENGERJAAN</label>
                            <input type="text" class="form-control" id="status_pengerjaan" name="status_pengerjaan" value="Telat H+1" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">STATUS</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Completed" {{ ($data->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Processing" {{ ($data->status ?? '') == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Rejected" {{ ($data->status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" onclick="$('#dataModalEdit').modal('hide')">Tolak Pengajuan</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
@include('table-data.modal_reject')
<script>
    function saveChanges() {
        // Add logic to save the form data
        console.log('Saving changes...');
        // You can use AJAX to send the form data to the server
        // After saving, close the modal:
        $('#dataModalEdit').modal('hide');
    }
</script>
