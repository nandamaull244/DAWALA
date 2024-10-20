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
            <script>
                function saveRejection() {
                    const alasanTolak = document.getElementById('alasan_tolak').value;
                    if (alasanTolak.trim() === '') {
                        alert('Mohon masukkan alasan penolakan.');
                        return;
                    }

                    // Here you can add logic to save the rejection reason
                    console.log('Alasan penolakan:', alasanTolak);

                    // Close the modal after saving
                    $('#rejectModal').modal('hide');
                }
            </script>
        </div>
    </div>
</div>
