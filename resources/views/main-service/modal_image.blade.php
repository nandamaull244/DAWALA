@push('css')
    <style>
        .image-frame {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .image-description {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 14px;
            color: #666;
        }
    </style>
@endpush

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <h3 class="image-title text-center mb-3"></h3>
                    
                    <div class="image-frame d-none" id="mainImageFrame">
                        <img id="modalImage" src="" alt="Image" style="max-width: 100%; height: auto; display: block; margin: auto; border-radius: 4px;">
                        <div class="image-description">
                            <p class="mb-1" id="imageCreatedAt"><strong>Tanggal Upload:</strong> 12 Maret 2024</p>
                            <p class="mb-1" id="imageName"><strong>Jenis Dokumen:</strong> KTP</p>
                            <p class="mb-0" id="imageDescription"><strong>Deskripsi:</strong> Dokumen ini adalah foto KTP yang diupload sebagai persyaratan pembuatan dokumen kependudukan.</p>
                        </div>
                    </div>

                    <div class="mt-4 additional-image-container">
                        <h3 class="additional-image-title d-none text-center">ODGJ</h3>
                        <div class="image-frame d-none" id="additionalImageFrame">
                            <img class="additional-image" src="" alt="ODGJ Image" style="max-width: 100%; height: auto; display: block; margin: auto; border-radius: 4px;">
                            <div class="image-description">
                                <p class="mb-1" id="imageCreatedAtODGJ"><strong>Tanggal Upload:</strong> 12 Maret 2024</p>
                                <p class="mb-1" id="imageNameODGJ"><strong>Jenis Dokumen:</strong> Surat Keterangan ODGJ</p>
                                <p class="mb-0" id="imageDescriptionODGJ"><strong>Deskripsi:</strong> Dokumen pendukung berupa surat keterangan ODGJ dari instansi kesehatan terkait.</p>
                            </div>
                        </div>
                    </div>

                    <h3 id="noImageMessage" class="text-center mt-3" style="display: none;"></h3>
                </div>
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
        let currentImageUrl = '';

        $('#imageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            const title = button.data('title');
            currentImageUrl = button.data('image');
            let imageName = button.data('image_name');
            let imageCreatedAt = button.data('image_created_at');
            
            $('#imageModalLabel').text(title);
            $('.modal-body .image-title').text(title);
            
            // Reset semua elemen
            $('#mainImageFrame').addClass('d-none');
            $('#additionalImageFrame').addClass('d-none');
            $('.additional-image-title').addClass('d-none');
            $('#noImageMessage').hide();

            // Set deskripsi berdasarkan jenis dokumen
            let description = '';
            switch(title) {
                case 'Foto KTP':
                    description = 'Dokumen ini adalah foto KTP yang diupload sebagai persyaratan pembuatan dokumen kependudukan.';
                    break;
                case 'Foto Kartu Keluarga':
                    description = 'Dokumen ini adalah foto Kartu Keluarga yang diupload sebagai persyaratan layanan kependudukan.';
                    break;
                case 'Foto Bukti Keterbatasan':
                    description = 'Dokumen ini adalah foto bukti keterbatasan yang diupload sebagai persyaratan tambahan.';
                    break;
                default:
                    description = 'Dokumen pendukung untuk layanan kependudukan.';
            }

            if(currentImageUrl && currentImageUrl !== '-') {
                $('#modalImage').attr('src', "{{ asset('storage') }}/" + currentImageUrl);
                $('#mainImageFrame').removeClass('d-none');
                
                // Update informasi dokumen
                $('#imageCreatedAt').html('<strong>Tanggal Upload:</strong> ' + imageCreatedAt);
                $('#imageName').html('<strong>Nama File:</strong> ' + imageName);
                $('#imageDescription').html('<strong>Deskripsi:</strong> ' + description);
                
                if(title === 'Foto Bukti Keterbatasan') {
                    const odgjImage = button.data('odgj_image');
                    if(odgjImage && odgjImage !== '-') {
                        $('.additional-image').attr('src', "{{ asset('storage') }}/" + odgjImage);
                        $('.additional-image-title').removeClass('d-none');
                        $('#additionalImageFrame').removeClass('d-none');

                        imageName = button.data('odgj_image_name');
                        imageCreatedAt = button.data('odgj_image_created_at');
                        
                        $('#imageCreatedAtODGJ').html('<strong>Tanggal Upload : </strong> ' + imageCreatedAt);
                        $('#imageNameODGJ').html('<strong>Nama File : </strong> ' + imageName);
                        $('#imageDescriptionODGJ').html('<strong>Deskripsi : </strong> ' + description);
                    }
                }
            } else {
                $('#noImageMessage').text('Tidak ada foto').show();
            }
        });

        $('#modalImage, .additional-image').on('error', function() {
            console.log('Image failed to load:', $(this).attr('src'));
            $(this).closest('.image-frame').addClass('d-none');
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
    </script>
@endpush
