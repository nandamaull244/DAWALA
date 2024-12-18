@extends('layouts.main')

@push('css')
    <style>
        .image-preview-wrapper {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .image-preview-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
        }

        .no-image-text {
            color: #999;
        }

        .file-info {
            margin-top: 10px;
            margin-bottom: -10px;
            font-size: 1.03em;
            color: #666;
        }
    </style>
@endpush

@section('page-heading')
    Tambah Artikel
@endsection

@section('page-subheading')
    Formulir Pembuatan Artikel Baru
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <form id="articleForm" action="{{ route('admin.article.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    
                    <div class="row mb-3 mt-1">
                        <input type="text" class="form-control" id="slug" name="slug" hidden>
                        
                        <div class="col-md-12">
                            <label for="title" class="form-label">JUDUL</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                    </div>
                    
                    <div class="row mb-2 mt-1">
                        <div class="col-md-6 mt-4">
                            <label for="image" class="form-label">UPLOAD FOTO</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpeg, image/jpg, image/webp" required>
                            <small class="form-text text-muted">Hanya file PNG, JPG, JPEG, dan WEBP yang diizinkan.</small>
                        </div>
                        <div class="col-md-6">
                            <div class="image-preview-wrapper">
                                <div id="imagePreview" class="image-preview-container">
                                    <p class="no-image-text">Belum ada foto yang diupload!</p>
                                </div>
                                <p class="file-info mt-2"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-1">
                        <div class="col-md-12">
                            <label for="body" class="form-label">TEXT</label>
                            <textarea class="form-control summernote" id="body" name="body" rows="3" required></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-danger" onclick="history.back()">Kembali</button>
                            <button type="submit" class="btn btn-success">Simpan data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#image').on('change', function(event) {
            var output = $('#imagePreview');
            var fileInfo = $('.file-info');
            output.empty();
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('<img>', {
                        src: e.target.result,
                        class: 'preview-image'
                    }).appendTo(output);
                    
                    var fileSizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                    var fileSizeText = fileSizeInMB + ' MB';

                    if (fileSizeInMB < 0.01) {
                        var fileSizeInKB = (file.size / 1024).toFixed(2);
                        fileSizeText = fileSizeInKB + ' KB';
                    }

                    fileInfo.text(file.name + ' (' + fileSizeText + ')');
                }
                reader.readAsDataURL(file);
            } else {
                output.html('<p class="no-image-text">Belum ada foto yang diupload!</p>');
                fileInfo.text('');
            }
        });
    });

    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Tulis artikel Anda di sini...',
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    $(document).ready(function() {
        $('#title').on('keyup', function() {
            var title = $(this).val();
            var slug = createSlug(title);
            $('#slug').val(slug);
        });

        function createSlug(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }
    });
</script>
@endpush
