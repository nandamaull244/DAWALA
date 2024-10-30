<div class="modal fade" id="instanceModal" tabindex="-1" aria-labelledby="instanceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instanceModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>
                    <strong class="text-center" id="instanceName"></strong>
                </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#instanceModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var instanceName = button.data('instance_name');
                $('#instanceName').text('Nama Intansi : ' + instanceName);
            });
        });
    </script>
@endpush
