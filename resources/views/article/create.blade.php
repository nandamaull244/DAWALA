@extends('layouts.main')

@push('css')
    <style>
        .image-preview-wrapper {
            width: 220px;
        }

        .image-preview-container {
            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .preview-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .no-image-text {
            text-align: center;
            color: #999;
        }

        .file-info {
            font-size: 1em;
            color: #666;
            text-align: start;
            word-break: break-all;
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
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                    </div>
                    
                    <div class="row mb-2 mt-1">
                        <div class="col-md-6 mt-4">
                            <label for="image" class="form-label">UPLOAD FOTO</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpeg, image/jpg, image/webp">
                            <small class="form-text text-muted">Hanya file PNG, JPG, JPEG, dan WEBP yang diizinkan.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"></label>
                            <div class="image-preview-wrapper">
                                <div id="imagePreview" class="mt-2 image-preview-container">
                                    <p class="no-image-text">Belum ada foto yang diupload!</p>
                                </div>
                                <p id="fileInfo" class="file-info mt-3"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-1">
                        <div class="col-md-12">
                            <label for="body" class="form-label">TEXT</label>
                            <textarea class="form-control summernote" id="body" name="body" rows="3"></textarea>
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
            var fileInfo = $('#fileInfo');
            output.empty();
            fileInfo.empty();
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('<img>', {
                        src: e.target.result,
                        class: 'preview-image'
                    }).appendTo(output);
                    
                    var fileSize = (file.size / 1024).toFixed(2) + ' KB';
                    fileInfo.text('Detail : ' + file.name + ' (' + fileSize + ')');
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
