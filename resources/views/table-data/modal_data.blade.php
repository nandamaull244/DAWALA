<div class="modal fade" id="dataModal" tabindex="-1"  aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Tambah data baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-start mb-2"><b>Pilih Layanan</b></p>
                <div class="d-flex flex-wrap justify-content-start gap-2 mb-5">
                    <button class="btn btn-outline-primary layanan-btn" onclick="toggleLayanan(this)">KTP-eL</button>
                    <button class="btn btn-outline-primary layanan-btn" onclick="toggleLayanan(this)">Kartu Keluarga</button>
                </div>
                <p class="text-start mb-2"><b>Pilih tipe pelayanan</b></p>
                <p><small>pilih salah satu tipe pelayanan</small></p>
                <div class="d-flex flex-wrap justify-content-start gap-2">
                    <button class="btn btn-outline-primary pelayanan-btn" onclick="selectPelayanan(this)">Buat baru</button>
                    <button class="btn btn-outline-primary pelayanan-btn" onclick="selectPelayanan(this)">Pembaruan KK barcode</button>
                    <button class="btn btn-outline-primary pelayanan-btn" onclick="selectPelayanan(this)">Baru menikah</button>
                    <button class="btn btn-outline-primary pelayanan-btn" onclick="selectPelayanan(this)">Penambahan anggota keluarga</button>
                    <button class="btn btn-outline-primary pelayanan-btn" onclick="selectPelayanan(this)">Hilang/rusak</button>
                    <button class="btn btn-outline-primary pelayanan-btn" onclick="selectPelayanan(this)">Mutasi KK</button>
                </div>
            </div>
            <script>
                function toggleLayanan(button) {
                    const buttons = document.querySelectorAll('.layanan-btn');
                    buttons.forEach(btn => btn.classList.remove('btn-primary'));
                    button.classList.add('btn-primary');
                }

                function selectPelayanan(button) {
                    const buttons = document.querySelectorAll('.pelayanan-btn');
                    buttons.forEach(btn => btn.classList.remove('btn-primary'));
                    button.classList.add('btn-primary');
                }
            </script>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </div>
</div>