<div class="modal fade" id="formulirDownloadModal" tabindex="-1"  aria-labelledby="formulirDownloadModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formulirModalLabel">Lihat Formulir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <div class="position-relative form-group">
                        <a href="#" download="" class="btn btn-outline-primary mb-0" id="f101-download">F1.01</a>
                        <span id="f101-status" class="position-absolute top-0 end-0 translate-middle p-1 text-white border border-light rounded-circle"></span>
                    </div>
                    
                    <div class="position-relative form-group">
                        <a href="#" download="" class="btn btn-outline-primary mb-0" id="f102-download">F1.02</a>
                        <span id="f102-status" class="position-absolute top-0 end-0 translate-middle p-1 text-white border border-light rounded-circle"></span>
                    </div>
                    
                    <div class="position-relative form-group">
                        <a href="#" download="" class="btn btn-outline-primary mb-0" id="f104-download">F1.04</a>
                        <span id="f104-status" class="position-absolute top-0 end-0 translate-middle p-1 text-white border border-light rounded-circle"></span>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentImageUrl = '';

            $('#formulirDownloadModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                const title = button.data('title');
                const f101 = button.data('imagef101');
                const f102 = button.data('imagef102');
                const f104 = button.data('imagef104');

                const baseStoragePath = "{{ asset('storage') }}/";

                if (f101 !== '-') {
                    $('#f101-download')
                        .attr('href', baseStoragePath + f101)
                        .attr('download', f101.replace('uploads/f101/', ''));  // Mengganti "uploads/f101/" dengan string kosong
                    $('#f101-status').addClass('bg-success').removeClass('bg-danger');
                } else {
                    $('#f101-download').removeAttr('href download');
                    $('#f101-status').removeClass('bg-success').addClass('bg-danger');
                }

                if (f102 !== '-') {
                    $('#f102-download')
                        .attr('href', baseStoragePath + f102)
                        .attr('download', f102.replace('uploads/f102/', ''));  // Mengganti "uploads/f102/" dengan string kosong
                    $('#f102-status').addClass('bg-success').removeClass('bg-danger');
                } else {
                    $('#f102-download').removeAttr('href download');
                    $('#f102-status').removeClass('bg-success').addClass('bg-danger');
                }

                if (f104 !== '-') {
                    $('#f104-download')
                        .attr('href', baseStoragePath + f104)
                        .attr('download', f104.replace('uploads/f104/', ''));  // Mengganti "uploads/f104/" dengan string kosong
                    $('#f104-status').addClass('bg-success').removeClass('bg-danger');
                } else {
                    $('#f104-download').removeAttr('href download');
                    $('#f104-status').removeClass('bg-success').addClass('bg-danger');
                }

            });
        });
    </script>
@endpush
