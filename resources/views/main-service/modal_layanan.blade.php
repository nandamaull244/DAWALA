<div class="modal fade" id="layananModal" tabindex="-1" aria-labelledby="layananModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="layananModalLabel">Tambah Pelayanan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-start mb-2"><b>Pilih Pelayanan</b></p>
                <div class="d-flex flex-wrap justify-content-start gap-2 mb-5">
                    <button class="btn btn-outline-primary pelayanan-btn" data-pelayanan="KTP eL" onclick="selectPelayanan(this, 'pelayanan')">KTP-eL</button>
                    <button class="btn btn-outline-primary pelayanan-btn" data-pelayanan="Kartu Keluarga" onclick="selectPelayanan(this, 'pelayanan')">Kartu Keluarga</button>
                </div>
                <p class="text-start mb-2"><b>Pilih Tipe Pelayanan</b></p>
                <p><small>Pilih Salah Satu Tipe Pelayanan</small></p>
                <div class="d-flex flex-wrap justify-content-start gap-2">
                    <button class="btn btn-outline-primary tipe-layanan-btn" data-tipe="Buat baru" onclick="selectPelayanan(this, 'tipe')">Buat baru</button>
                    <button class="btn btn-outline-primary tipe-layanan-btn" data-tipe="Pembaruan KK barcode" onclick="selectPelayanan(this, 'tipe')">Pembaruan KK barcode</button>
                    <button class="btn btn-outline-primary tipe-layanan-btn" data-tipe="Baru menikah" onclick="selectPelayanan(this, 'tipe')">Baru menikah</button>
                    <button class="btn btn-outline-primary tipe-layanan-btn" data-tipe="Penambahan anggota keluarga" onclick="selectPelayanan(this, 'tipe')">Penambahan anggota keluarga</button>
                    <button class="btn btn-outline-primary tipe-layanan-btn" data-tipe="Hilang/rusak" onclick="selectPelayanan(this, 'tipe')">Hilang/rusak</button>
                    <button class="btn btn-outline-primary tipe-layanan-btn" data-tipe="Mutasi KK" onclick="selectPelayanan(this, 'tipe')">Mutasi KK</button>
                </div>
                <input type="hidden" id="selectedPelayanan" name="pelayanan">
                <input type="hidden" id="selectedTipeLayanan" name="tipe_layanan">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="createPelayanan()" class="btn btn-primary w-100">Buat Pelayanan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function selectPelayanan(button, type) {
            let $button = $(button);
            if (type === 'pelayanan') {
                $('.pelayanan-btn').removeClass('btn-primary');
                $($button).addClass('btn-primary');

                $('#selectedPelayanan').val($button.data('pelayanan'));
            } else if (type === 'tipe') {
                $('.tipe-layanan-btn').removeClass('btn-primary');
                $($button).addClass('btn-primary');
                
                $('#selectedTipeLayanan').val($button.data('tipe'));
            }
        }

        function createPelayanan() {
            const pelayanan = $('#selectedPelayanan').val();
            const tipeLayanan = $('#selectedTipeLayanan').val();
            
            if (!pelayanan) {
                toastr.warning("Silakan pilih tipe layanan terlebih dahulu", "Perhatian!");
                return;
            }

            if (!tipeLayanan) {
                toastr.warning("Silakan pilih kategori layanan terlebih dahulu", "Perhatian!");
                return;
            }

            const routes = {
                admin: '{{ route("admin.pelayanan.create") }}',
                user: '{{ route("user.pelayanan.create") }}',
                instance: '{{ route("instance.pelayanan.create") }}',
                operator: '{{ route("operator.pelayanan.create") }}'
            };

            const userRole = '{{ auth()->user()->role }}'; // Assuming you have a role field
            const baseRoute = routes[userRole] || routes.user; // Default to user route if role not found

            window.location.href = baseRoute + 
                                '?pelayanan=' + encodeURIComponent(pelayanan) + 
                                '&tipe_layanan=' + encodeURIComponent(tipeLayanan);
        };
    </script>
@endpush
