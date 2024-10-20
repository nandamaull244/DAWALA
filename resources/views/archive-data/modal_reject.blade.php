<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex flex-wrap justify-content-start gap-2 mb-5">
                    <input type="text" class="form-control" id="alasan_tolak" name="alasan_tolak"
                        placeholder="Masukkan alasan tolak pengajuan">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" onclick="saveRejection()">Submit</button>
            </div>
        </div>
    </div>
</div>
