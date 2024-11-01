@push('css')
    <style>
        .bi-check-circle-fill {
            color: #28a745;
        }

        .form-control-plaintext {
            padding: 0.375rem 0;
            margin-bottom: 0;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.5rem;
        }

        #completedStatus {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #messageEdit, #messageDisplay {
            animation: fadeIn 0.3s ease-in-out;
        }

        .btn-outline-primary:hover {
            transform: translateY(-1px);
            transition: transform 0.2s;
        }

        .form-control-plaintext {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.5rem;
        }
    </style>
@endpush

<div class="modal fade" id="workingStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Penyelesaian Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="workingStatusForm" method="POST" action="" novalidate>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div id="completedStatus" style="display: none;">
                        <div class="text-center mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-2">Pengajuan ini telah selesai</h5>
                        </div>
                        <div class="form-group">
                                @if (auth()->user()->role == 'admin')
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0">Pesan untuk Pemohon</label>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnEditMessage">
                                            <i class="bi bi-pencil me-1"></i>Edit Pesan
                                        </button>
                                    </div>
                                @endif
                                <div id="messageDisplay">
                                    <textarea rows="4" id="completedMessage" class="form-control-plaintext" disabled style="font-size: 1.1em;"></textarea>
                                </div>
                                <div id="messageEdit" style="display: none;">
                                    <textarea class="form-control" id="edit_message_for_user" name="message_for_user" rows="4" required style="font-size: 1.1em;"></textarea>
                                </div>
                            </div>
                    </div>
                
                    <div id="inputForm">
                        <div class="form-group">
                            <label for="message_for_user" class="form-label">Pesan untuk Pemohon</label>
                            <textarea class="form-control" id="message_for_user" name="message_for_user" rows="4" placeholder="Masukkan pesan untuk pemohon" required style="font-size: 1.1em;"></textarea>
                        </div>
                        <input type="hidden" name="working_status" value="Done">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-circle me-2"></i>Selesaikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let originalMessage = '';

        $('#workingStatusModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const workingStatus = button.data('working_status');
            const message = button.data('message');
            
            const url = '{{ route((auth()->user()->role == 'admin' ? 'admin' : 'operator') . '.pelayanan.working-status', ":id") }}'.replace(':id', id);
            $('#workingStatusForm').attr('action', url);

            if (workingStatus === 'Done') {
                $('#modalTitle').text('Status Pengerjaan');
                $('#completedStatus').show();
                $('#inputForm').hide();
                $('#submitBtn').hide();
                $('#completedMessage').text(message);
                originalMessage = message;
                
                $('#messageDisplay').show();
                $('#messageEdit').hide();
                $('#btnEditMessage').text('Edit Pesan').removeClass('btn-success').addClass('btn-outline-primary');
            } else {
                $('#modalTitle').text('Status Pengerjaan');
                $('#completedStatus').hide();
                $('#inputForm').show();
                $('#submitBtn').show();
                $('#message_for_user').val('');
            }
        });

        $('#btnEditMessage').click(function(e) {
            e.preventDefault();
            const isEditing = $('#messageEdit').is(':visible');
            
            if (isEditing) {
                let newMessage = $('#edit_message_for_user').val().trim();
                $('textarea[name="message_for_user"]').val(newMessage);
                $('#workingStatusForm').submit();
                table.ajax.reload()
            } else {
                $('#edit_message_for_user').val($('#completedMessage').text());
                $('#messageDisplay').hide();
                $('#messageEdit').show();
                $('#submitBtn').hide();
                $(this).html('<i class="bi bi-check me-1"></i>Simpan').removeClass('btn-outline-primary').addClass('btn-success');
            }
        });

        $('#workingStatusModal').on('hidden.bs.modal', function () {
            $('#workingStatusForm')[0].reset();
            $('#modalTitle').text('Penyelesaian Layanan');
            $('#completedStatus').hide();
            $('#inputForm').show();
            $('#submitBtn').show();
            $('#messageDisplay').show();
            $('#messageEdit').hide();
            $('#btnEditMessage').html('<i class="bi bi-pencil me-1"></i>Edit Pesan').removeClass('btn-success').addClass('btn-outline-primary');
        });

        $('#workingStatusForm').on('submit', function(e) {
            e.preventDefault();
            
            const messageField = $('#messageEdit').is(':visible') ? 
                '#edit_message_for_user' : '#message_for_user';
                
            if (!$(messageField).val().trim()) {
                toastr.warning('Pesan untuk pemohon harus diisi', 'Peringatan');
                return false;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: $('#messageEdit').is(':visible') ? 
                    "Apakah Anda yakin ingin mengubah pesan ini?" : 
                    "Apakah Anda yakin ingin menyelesaikan layanan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = $(this);
                    const url = form.attr('action');
                    const formData = form.serialize();

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#workingStatusModal').modal('hide');
                            toastr.success(response.success, 'Berhasil');
                            table.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Terjadi kesalahan saat memproses permintaan', 'Gagal');
                            console.error(error);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush