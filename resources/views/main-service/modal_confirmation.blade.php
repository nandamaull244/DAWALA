<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="confirmationForm" method="POST" novalidate>
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex gap-2 mb-3">
                            <button type="button" class="btn btn-outline-danger w-50" id="btnTolak">Tolak</button>
                            <button type="button" class="btn btn-outline-success w-50" id="btnTerima">Terima</button>
                        </div>
                    </div>
                    
                    <div id="alasanTolakContainer" style="display: none;">
                        <div class="form-group">
                            <label for="alasan_tolak" class="form-label">Alasan Penolakan</label>
                            <textarea class="form-control" id="alasan_tolak" name="deleted_reason" 
                                rows="3" placeholder="Masukkan alasan penolakan"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="status" id="confirmationStatus">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit" style="display: none;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let selectedStatus = '';

            $('#btnTerima').click(function() {
                $(this).removeClass('btn-outline-success').addClass('btn-success active');
                $('#btnTolak').addClass('btn-outline-danger').removeClass('btn-danger active');
                $('#alasanTolakContainer').hide();
                $('#confirmationStatus').val('approved');
                $('#btnSubmit').show();
                $('#alasan_tolak').prop('required', false);
            });

            $('#btnTolak').click(function() {
                $(this).removeClass('btn-outline-danger').addClass('btn-danger active');
                $('#btnTerima').addClass('btn-outline-success').removeClass('btn-success active');
                $('#alasanTolakContainer').show();
                $('#confirmationStatus').val('rejected');
                $('#btnSubmit').show();
                $('#alasan_tolak').prop('required', true);
            });

            $('#confirmationModal').on('hidden.bs.modal', function () {
                $('#btnTerima')
                    .removeClass('btn-success active')
                    .addClass('btn-outline-success');
                $('#btnTolak')
                    .removeClass('btn-danger active')
                    .addClass('btn-outline-danger');
                
                $('#alasanTolakContainer').hide();
                $('#btnSubmit').hide();
                $('#alasan_tolak').val('');
                $('#confirmationStatus').val('');
            });

            $('#confirmationModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const id = button.data('id');
                const url = `{{ route('admin.pelayanan.destroy', ':id') }}`.replace(':id', id);
                $('#confirmationForm').attr('action', url);
                
                const reason = button.data('reason');
                if(reason) {
                    $('#alasanTolakContainer').show();
                    $('#alasan_tolak').val(reason);
                }
            });

            $('#confirmationForm').on('submit', function(e) {
                e.preventDefault();
                var isValid = true;

                const status = $('#confirmationStatus').val();
                if (status === 'rejected' && !$('#alasan_tolak').val().trim()) {
                    isValid = false;
                    toastr.warning('Alasan penolakan harus diisi', 'Peringatan', {
                        timeOut: 2500,
                        "className": "custom-larger-toast"
                    });
                }

                $(this).find('input, textarea').each(function() {
                    var $field = $(this);
                    if ($field.prop('required') && !$field.val().trim()) {
                        var fieldName = $field.closest('.form-group').find('label').text() || 'Field';
                        isValid = false;
                        toastr.warning(fieldName + ' harus diisi', 'Peringatan', {
                            timeOut: 2500,
                            "className": "custom-larger-toast"
                        });
                    }
                });

                if (isValid) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
