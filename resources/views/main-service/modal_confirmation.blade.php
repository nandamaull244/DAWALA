@push('css')
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

        .no-click {
            pointer-events: none;
            opacity: 0.7;
        }

        textarea, h5 {
            font-size: 1.2em !important;
        }
    </style>
@endpush
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Status @if(auth()->user()->role != 'user' && auth()->user()->role != 'instance') Konfirmasi @endif Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="confirmationForm" method="POST" novalidate>
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    @php
                        $isAdminOrOperator = in_array(auth()->user()->role, ['admin', 'operator']);
                    @endphp
                        <div class="text-center mb-4" id="waitingApproval" style="display: none;">
                            <h5 class="mt-2">Menunggu untuk pengajuan diterima</h5>
                        </div>

                        <div class="text-center mb-4" id="approved" style="display: none;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-2">Pengajuan telah disetujui</h5>
                        </div>

                        <div class="text-center mb-4" id="rejected" style="display: none;">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-2">Pengajuan ditolak</h5>
                        </div>


                        <div class="row">
                            <div class="d-flex gap-2 mb-3 justify-content-center" id="confirmation-button">
                                <button type="button" class="btn btn-outline-danger w-50" style="margin:0 !important;" id="btnTolak">Tolak</button>
                                <button type="button" class="btn btn-outline-success w-50" id="btnTerima">Terima</button>
                            </div>
                        </div>

                        <div class="mb-3" id="visitScheduleContainer" style="display: none;">
                            <label for="visit_schedule" class="form-label">Tanggal Kunjungan</label>
                            <input type="date" class="form-control flatpickr-min-date" id="visit_schedule" name="visit_schedule" required readonly @if(!$isAdminOrOperator) disabled @endif>
                        </div>

                        <div id="alasanTolakContainer" style="display: none;">
                            <div class="form-group">
                                <label for="alasan_tolak" class="form-label">Alasan Penolakan</label>
                                <textarea class="form-control" id="alasan_tolak" name="rejected_reason" rows="3" placeholder="Masukkan alasan penolakan" {{ !$isAdminOrOperator ? 'readonly' : '' }}></textarea>
                            </div>
                        </div>

                        @if (auth()->user()->role == 'user' || auth()->user()->role == 'instance')
                            <br>
                            <div id="messageDisplay">
                                <div class="form-group">
                                    <label for="completedMessage" class="form-label">Status Pengerjaan : <span id="workingStatusText" class="text-success">Selesai</span></label>
                                    <textarea rows="4" id="completedMessage" class="form-control-plaintext" disabled></textarea>
                                </div>
                            </div>
                        @endif

                        <br>
                        @if (auth()->user()->role == 'user' || auth()->user()->role == 'instance')
                            <div id="documentConfirmation">
                                <div class="form-group">
                                    <label for="completedMessage" class="form-label">Status Dokumen : <span id="documentStatusText" class=""></span></label>
                                    <div class="row" id="document-confirmation-button">
                                        <div class="d-flex gap-2 mb-3 justify-content-center" >
                                            {{-- <button type="button" class="btn btn-outline-danger w-50" style="margin:0 !important;" id="btnNotRecieved">Belum Diterima</button> --}}
                                            <button type="button" class="btn btn-outline-success w-50" id="btnRecieved">Sudah Terima</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    <input type="hidden" name="status" id="confirmationStatus">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btnRequestAgain" style="display: none;">Ajukan Pengajuan Lagi</button>
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
            var isAdminOrOperator = true;
            @if(!$isAdminOrOperator)
                $('#confirmation-button').hide();
                isAdminOrOperator = false;
            @endif

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
                $('#btnTerima').removeClass('btn-success active').addClass('btn-outline-success');
                $('#btnTolak').removeClass('btn-danger active').addClass('btn-outline-danger')
                
                $('#alasanTolakContainer').hide();
                $('#btnSubmit').hide();
                $('#alasan_tolak').val('');
                $('#confirmationStatus').val('');
            });

            $('#confirmationModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const serviceStatus = button.data('service_status');
                const id = button.data('id');
                const url = `{{ route(auth()->user()->role . '.pelayanan.destroy', ':id') }}`.replace(':id', id);
                $('#confirmationForm').attr('action', url);

                const workingStatus = button.data('working_status');
                const message_for_user = button.data('message_for_user');

                $('#completedMessage').text(message_for_user);
                // $('#workingStatusText').removeClass('text-danger text-warning text-success text-secondary')

                switch(workingStatus) {
                    case '-':
                        $('#workingStatusText').addClass('text-secondary').text('Tidak ada Status');
                    break;
                    case 'Not Yet':
                        $('#workingStatusText').addClass('text-secondary').text('Menunggu');
                    break;
                    case 'Process':
                        $('#workingStatusText').addClass('text-warning').text('Sedang Diproses');
                    break;
                    case 'Completed':
                        $('#workingStatusText').addClass('text-success').text('Selesai');
                    break;
                }
                
                const documentRecievedStatus = button.data('document_recieved_status');
                if(serviceStatus == 'Process') {
                    $('#document-confirmation-button').show();
                } else {
                    $('#documentStatusText').addClass('text-danger').text('Belum Diterima');
                    $('#document-confirmation-button').hide();
                }
                if(documentRecievedStatus == 'Recieved') {
                    $('#document-confirmation-button').hide();
                    switch(documentRecievedStatus) {
                        case 'Not Yet Recieved':
                            $('#documentStatusText').addClass('text-danger').text('Belum Diterima');
                        break;
                        case 'Recieved':
                            $('#documentStatusText').addClass('text-success').text('Sudah Diterima');
                        break;
                    }
                } else {
                    $('#btnRecieved').off('click').on('click', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Konfirmasi',
                            text: 'Apakah anda yakin sudah menerima dokumen?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Sudah Terima',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                sendDocumentConfirmation(id, 'Recieved');
                            }
                        });
                    });

                    // $('#btnNotRecieved').off('click').on('click', function(e) {
                    //     e.preventDefault();
                    //     Swal.fire({
                    //         title: 'Konfirmasi',
                    //         text: 'Apakah anda yakin belum menerima dokumen?',
                    //         icon: 'question',
                    //         showCancelButton: true,
                    //         confirmButtonText: 'Ya, Sudah Terima',
                    //         cancelButtonText: 'Batal',
                    //         reverseButtons: true
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             sendDocumentConfirmation(id, 'Not Yet Recieved');
                    //         }
                    //     });
                    // });

                    @if(auth()->user()->role == 'user' || auth()->user()->role == 'instance') 
                        function sendDocumentConfirmation(id, status) {
                            let documentConfirmationUrl = "{{ route(auth()->user()->role . '.pelayanan.document-confirmation') }}";
                            $.ajax({
                                url: documentConfirmationUrl,
                                type: 'POST',
                                data: {
                                    id: id,
                                    document_recieved_status: status,
                                    _token: '{{ csrf_token() }}' 
                                },
                                success: function(response) {
                                    $('#confirmationModal').modal('hide');
                                    toastr.success(response.success, 'Berhasil');
                                    table.ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    toastr.error("Gagal memperbarui status dokumen", 'Gagal');
                                }
                            });
                        }
                    @endif
                }

                const reason = button.data('reason');
                const visitSchedule = button.data('visit_schedule');
                const approvalBy = button.data('approval_by');

                $('#btnTolak').removeClass('btn-danger active').addClass('btn-outline-danger').show();
                $('#btnTerima').removeClass('btn-success active').addClass('btn-outline-success').show();
                $('#rejected, #approved, #waitingApproval, #approvalByContainer, #alasanTolakContainer, #visitScheduleContainer').hide();
                $('#btnRequestAgain').hide();

                if (serviceStatus != 'Not Yet' || !isAdminOrOperator) {
                    $('#btnTolak, #btnTerima').hide();

                    if (serviceStatus === 'Rejected') {
                        $('#rejected').show();
                        $('#alasanTolakContainer').show();
                        $('#alasan_tolak').val(reason);
                        $('#btnRequestAgain').show();
                    } else if (serviceStatus === 'Completed' || serviceStatus === 'Process') {
                        $('#approved').show();
                        $('#visitScheduleContainer').show();
                        const visitScheduleFlatpickr = $('#visit_schedule')[0]._flatpickr;
                        visitScheduleFlatpickr.setDate(visitSchedule);
                    } else {
                        $('#waitingApproval').show();
                    }
                } else {
                    if (approvalBy) {
                        $('#approvalByContainer').show();
                        $('#approvalByLabel').text(serviceStatus === 'Rejected' ? `Ditolak Oleh ${approvalBy}` : `Disetujui Oleh ${approvalBy}`);
                    }

                    if (reason) { 
                        $('#btnTolak').addClass('btn-danger active').text('Ditolak').show();
                        $('#alasanTolakContainer').show();
                        $('#alasan_tolak').val(reason);
                        $('#btnTerima').hide();
                        $('#confirmationModalLabel').text('Status Pengajuan Layanan ini ditolak');
                    } 
                    if (visitSchedule) { 
                        $('#btnTerima').addClass('btn-success active').text('Diterima').show();
                        $('#visitScheduleContainer').show();
                        $('#btnTolak').hide();
                        $('#confirmationModalLabel').text('Pengajuan Layanan ini diterima');
                        const visitScheduleFlatpickr = $('#visit_schedule')[0]._flatpickr;
                        visitScheduleFlatpickr.setDate(visitSchedule);
                    }
                }

                @if(auth()->user()->role == 'user' || auth()->user()->role == 'instance')
                    $('#btnRequestAgain').off('click').on('click', function(e) {
                        e.preventDefault()
                        sendServiceRequestAgain(id);
                    });
                @endif

                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'operator') 
                    $('#visit_schedule').change(function() {
                        const url = `{{ route(auth()->user()->role . '.pelayanan.update-visit-schedule', ':id') }}`.replace(':id', id);
                        let val = $(this).val();
                        $.ajax({
                            url: url,
                            type: 'PATCH',
                            data: {
                                id: id,
                                visit_schedule: val,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                toastr.success(response.success, 'Berhasil');
                                table.ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                toastr.error("Gagal memperbarui jadwal kunjungan", 'Gagal');
                            }
                        })
                    })
                @endif
            });

            @if(auth()->user()->role == 'user' || auth()->user()->role == 'instance')
                function sendServiceRequestAgain(id) {
                    $.ajax({
                        url: `{{ route(auth()->user()->role . '.pelayanan.request-again') }}`,
                        type: 'POST',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                            $('#confirmationModal').modal('hide');
                            toastr.success(response.success, 'Berhasil');
                            table.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            toastr.error("Gagal mengirim permintaan ulang", 'Gagal');
                        }
                    });
                }
            @endif

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


