@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Artikel</h1>
    <form id="articleForm" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row mb-3">
            <input type="text" class="form-control" id="slug" name="slug"
                value="{{ $data->slug ?? '' }}" hidden>
            
            <div class="col-md-12">
                <label for="title" class="form-label">JUDUL</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ $data->title ?? '' }}">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="body" class="form-label">TEXT</label>
                <textarea class="form-control" id="body" name="body" rows="5">{{ $data->body ?? '' }}</textarea>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="col-md-12 mt-3">
                <label class="form-label">Preview Image</label>
                <div id="imagePreview" class="mt-2">
                    @if(isset($data->image) && !empty($data->image))
                        <img src="{{ asset('storage/' . $data->image) }}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                    @else
                        <p>No image uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Simpan data</button>
                
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // Add any additional JavaScript here, such as image preview functionality
    document.getElementById('image').addEventListener('change', function(event) {
        var output = document.getElementById('imagePreview');
        output.innerHTML = '';
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                output.appendChild(img);
            }
            reader.readAsDataURL(file);
        } else {
            output.innerHTML = '<p>No image uploaded yet.</p>';
        }
    });
</script>
@endpush
