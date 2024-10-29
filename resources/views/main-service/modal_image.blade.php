<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="image-title text-center"></h3>
                <img id="modalImage" src="" alt="Image" style="max-width: 100%; height: auto;">
                <br>
                <h3 class="additional-image-title d-none text-center">ODGJ</h3>
                <img class="additional-image d-none" src="" alt="ODGJ Image" style="max-width: 100%; height: auto;">
                <h3 id="noImageMessage text-center" style="display: none;"></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveImageBtn">Save Image</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentImageUrl = '';

            $('#imageModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                const title = button.data('title');
                currentImageUrl = button.data('image');
                $('#imageModalLabel').text(title);
                $('.modal-body .image-title').text(title);
                $('.additional-image').addClass('d-none');
                $('.additional-image-title').addClass('d-none');

                
                if(currentImageUrl && currentImageUrl !== '-') {
                    $('#modalImage').attr('src', "{{ asset('storage') }}/" + currentImageUrl).show();
                    if(title == 'Foto Bukti Keterbatasan') {
                        var odgjImage = button.data('odgj_image');
                        if(odgjImage) {
                            $('.additional-image').attr('src', "{{ asset('storage') }}/" + odgjImage).removeClass('d-none');
                            $('.additional-image-title').removeClass('d-none');
                        }
                    }
                    $('#noImageMessage').hide();
                } else {
                    $('#modalImage').hide();
                    $('#noImageMessage').text('Tidak ada foto').show();
                }
            });

            $('#saveImageBtn').on('click', function() {
                if (currentImageUrl && currentImageUrl !== '-') {
                    var link = document.createElement('a');
                    link.href = currentImageUrl;
                    link.download = 'image.jpg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    alert('No image available to download.');
                }
            });
        });
    </script>
@endpush
