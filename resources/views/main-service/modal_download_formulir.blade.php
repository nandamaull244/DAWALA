<div class="modal fade" id="formulirModal" tabindex="-1"  aria-labelledby="formulirModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formulirModalLabel">Pilih Formulir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center mb-4">*Pilih formulir yang akan diupload</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="position-relative form-group">
                        <input type="file" id="f101-input" class="d-none" accept="image/*,.pdf" name="f101_file" data-exist="{{ !empty($f101) ? 'true' : 'false' }}">
                        <label for="f101-input" class="btn btn-outline-primary mb-0">F1.01 {{ $f102->form_path ?? '' }}</label>
                        <span id="f101-status" class="position-absolute top-0 end-0 translate-middle p-1 @if (!empty($f101)) bg-success @else bg-danger @endif text-white border border-light rounded-circle"></span>
                    </div>
                    <div class="position-relative form-group">
                        <input type="file" id="f102-input" class="d-none" accept="image/*,.pdf" name="f102_file" required data-exist="{{ !empty($f102) ? 'true' : 'false' }}">
                        <label for="f102-input" class="btn btn-outline-primary mb-0">F1.02</label>
                        <span id="f102-status" class="position-absolute top-0 end-0 translate-middle p-1 @if (!empty($f102)) bg-success @else bg-danger @endif text-white border border-light rounded-circle"></span>
                    </div>
                    <div class="position-relative form-group">
                        <input type="file" id="f104-input" class="d-none" accept="image/*,.pdf" name="f104_file" data-exist="{{ !empty($f104) ? 'true' : 'false' }}">
                        <label for="f104-input" class="btn btn-outline-primary mb-0">F1.04</label>
                        <span id="f104-status" class="position-absolute top-0 end-0 translate-middle p-1 @if (!empty($f104)) bg-success @else bg-danger @endif text-white border border-light rounded-circle"></span>
                    </div>
                </div>

                <ul class="mt-3">
                    <li>F1.01 : Jika data/dokumen hilang/rusak (pernah memiliki data/dokumen yang tercatat di disduk)</li>
                    <li style="color: red;">F1.02 : Wajib untuk semua layanan</li>
                    <li style="color: red;">F1.03 : Jika pindah alamat</li>
                    <li>F1.04 : Jika tidak memiliki data/dokumen sama sekali</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            function initializeFileInputs() {
                $('input[type="file"]').each(function() {
                    var fileId = $(this).attr('id');
                    var statusId = fileId.replace('-input', '-status');
                    var $statusElement = $('#' + statusId);

                    $(this).on('change', function(e) {
                        if (e.target.files.length > 0) {
                            $statusElement.removeClass('bg-danger').addClass('bg-success text-white');
                        } else {
                            $statusElement.removeClass('bg-success').addClass('bg-danger text-white');
                        }
                    });
                });
            }

            // Panggil fungsi saat halaman dimuat
            initializeFileInputs();
        });
    </script>
@endpush
