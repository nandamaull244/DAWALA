<div class="modal fade" id="dataModalEditArticle" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
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
                            <input type="file" class="form-control" id="image" name="image"
                                value="{{ $data->image ?? '' }}">
                        </div>
                        <div class="col-md-12">
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
                   
                </form>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script>
    function saveChanges() {
        $('#dataModalEditArticle').modal('hide');
    }
</script>
