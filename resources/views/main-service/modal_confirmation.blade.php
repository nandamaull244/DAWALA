@push('scripts')
    <style>
        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .btn:disabled:hover::after {
            content: "Anda tidak memiliki akses";
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px;
            background: rgba(0,0,0,0.8);
            color: white;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
        }
    </style>
@endpush
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
                    @php
                        $isAdminOrOperator = in_array(auth()->user()->role, ['admin', 'operator']);
                    @endphp

                        <div class="row">
                            <div class="d-flex gap-2 mb-3 justify-content-center">
                                <button type="button" class="btn btn-outline-danger w-50" style="margin:0 !important;" id="btnTolak" @if(!$isAdminOrOperator) style="cursor: default;" @endif>Tolak</button>
                                <button type="button" class="btn btn-outline-success w-50" id="btnTerima" @if(!$isAdminOrOperator) style="cursor: default;" @endif>Terima</button>
                            </div>
                        </div>

                        <div class="mb-3" id="visitScheduleContainer" style="display: none;">
                            <label for="visit_schedule" class="form-label">Tanggal Kunjungan</label>
                            <input type="date" class="form-control flatpickr-date" id="visit_schedule" name="visit_schedule" required readonly @if(!$isAdminOrOperator) disabled @endif>
                        </div>

                        <div id="alasanTolakContainer" style="display: none;">
                            <div class="form-group">
                                <label for="alasan_tolak" class="form-label">Alasan Penolakan</label>
                                <textarea class="form-control" id="alasan_tolak" name="rejected_reason" rows="3"
                                    placeholder="Masukkan alasan penolakan"
                                    {{ !$isAdminOrOperator ? 'readonly' : '' }}></textarea>
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
                $('#visitScheduleContainer').show();
                $('#alasanTolakContainer').hide();

                $('#confirmationStatus').val('approved');
                @if($isAdminOrOperator)
                    $('#btnSubmit').show();
                @endif

                $('#visit_schedule').prop('required', true);
                $('#alasan_tolak').prop('required', false);
            });

            $('#btnTolak').click(function() {
                $(this).removeClass('btn-outline-danger').addClass('btn-danger active');
                $('#btnTerima').addClass('btn-outline-success').removeClass('btn-success active');
                $('#visitScheduleContainer').hide();
                $('#alasanTolakContainer').show();

                $('#confirmationStatus').val('rejected');
                @if($isAdminOrOperator)
                    $('#btnSubmit').show();
                @endif

                $('#visit_schedule').prop('required', false);
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
                const visitSchedule = button.data('visit_schedule');
                // console.log(visitSchedule);

                const approvalBy = button.data('approval_by');
                if(approvalBy) {
                    $('#approvalByContainer').show();
                }
                
                if(reason) { // Status ditolak
                    $('#approvalByLabel').text('Ditolak Oleh ' + approvalBy);
                    $('#btnTolak').addClass('btn-danger active').removeClass('btn-outline-danger').text('Ditolak').show();
                    $('#alasanTolakContainer').show();
                    $('#alasan_tolak').val(reason);
                    $('#btnTerima').hide();
                    $('#visitScheduleContainer').hide();
                    $('#confirmationModalLabel').text('Status Pengajuan Layanan ini ditolak')
                } 
                if(visitSchedule) { // Status diterima
                    $('#approvalByLabel').text('Disetujui Oleh ' + approvalBy);
                    $('#btnTerima').addClass('btn-success active').removeClass('btn-outline-success').text('Diterima').show();
                    $('#visitScheduleContainer').show();
                    $('#btnTolak').hide();
                    $('#confirmationModalLabel').text('Pengajuan Layanan ini diterima');

                    const visitScheduleFlatpickr = $('#visit_schedule')[0]._flatpickr;

                    visitScheduleFlatpickr.setDate(visitSchedule);
                    $('#visit_schedule').each(function() {
                        this._flatpickr.setDate(visitSchedule);
                    });
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


