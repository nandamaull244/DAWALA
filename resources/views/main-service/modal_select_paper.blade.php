<div class="modal fade" id="selectPaperModal" tabindex="-1" aria-labelledby="selectPaperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paperModalLabel">Pilih Ukuran dan Orientasi Kertas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="paper" class="form-label">Pilih Format Ukuran Kertas</label>
                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-outline-secondary w-50 paper-btn" id="a3" data-value="a3">A3</button>
                        <button type="button" class="btn btn-primary w-50 paper-btn" id="a4" data-value="a4">A4</button>
                        <button type="button" class="btn btn-outline-secondary w-50 paper-btn" id="f4" data-value="f4">F4</button>
                    </div>
                </div>
                
                <div class="row">
                    <label for="orientation" class="form-label">Pilih Orientasi Kertas</label>
                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-outline-primary w-50 orientation-btn" id="portrait" data-value="portrait">Potrait</button>
                        <button type="button" class="btn btn-outline-primary w-50 orientation-btn" id="landscape" data-value="landscape">Landscape</button>
                    </div>
                </div>
                <input type="hidden" name="paper" id="paper" value="a4">
                <input type="hidden" name="orientation" id="orientation" value="portrait">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="downloadPDF">Submit</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('.paper-btn').click(function() {
            $('.paper-btn').removeClass('btn-primary btn-danger btn-success')
                           .addClass('btn-outline-secondary');
            
            $(this).removeClass('btn-outline-primary btn-outline-danger btn-outline-success');
            
            switch($(this).attr('id')) {
                case 'a3':
                    $(this).addClass('btn-danger');
                    break;
                default:
                    $(this).addClass('btn-primary');
            }
            
            $('#paper').val($(this).data('value'));
        });
    
        $('.orientation-btn').click(function() {
            $('.orientation-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
            
            $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
            
            $('#orientation').val($(this).data('value'));
        });
    
        $('#a4').click();
        $('#portrait').click(); 
    });
    </script>
@endpush