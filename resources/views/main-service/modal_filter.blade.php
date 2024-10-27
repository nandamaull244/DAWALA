<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Pelayanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-start mb-2"><b>Tanggal Pengajuan</b></p>
                        </div>
                        <div class="col-md-6 mb-2 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text">Dari</span>
                                <input type="date" class="form-control flatpickr-date" id="startDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Sampai</span>
                                <input type="date" class="form-control flatpickr-date" id="endDate">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <p class="text-start mb-2"><b>Kecamatan</b></p>
                            <select class="form-select" id="kecamatan" name="kecamatan" onchange="getVillages(this)">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <p class="text-start mb-2"><b>Desa</b></p>
                            <select class="form-select" id="desa" name="desa">
                                <option value="">Pilih Desa</option>
                                <!-- Options will be loaded dynamically -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <p class="text-start mb-2"><b>Waktu</b></p>
                        <div class="d-flex gap-2">
                            <button class="time btn btn-primary time-btn" data-value="Terbaru" onclick="selectFilter(this, 'Time')">Terbaru</button>
                            <button class="time btn btn-outline-primary time-btn" data-value="Terlama" onclick="selectFilter(this, 'Time')">Terlama</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-start mb-2"><b>Kategori Layanan</b></p>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary category-btn" data-value="KTP eL" onclick="selectFilter(this, 'Categories', true)">KTP-eL</button>
                            <button class="btn btn-outline-primary category-btn" data-value="Kartu Keluarga" onclick="selectFilter(this, 'Categories', true)">Kartu Keluarga</button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                   
                </div>

                <div class="mb-3">
                    <p class="text-start mb-2"><b>Tipe Layanan</b></p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary type-btn" data-value="Buat baru" onclick="selectFilter(this, 'Types', true)">Buat baru</button>
                        <button class="btn btn-outline-primary type-btn" data-value="Pembaruan KK barcode" onclick="selectFilter(this, 'Types', true)">Pembaruan KK barcode</button>
                        <button class="btn btn-outline-primary type-btn" data-value="Baru menikah" onclick="selectFilter(this, 'Types', true)">Baru menikah</button>
                        <button class="btn btn-outline-primary type-btn" data-value="Penambahan anggota keluarga" onclick="selectFilter(this, 'Types', true)">Penambahan anggota keluarga</button>
                        <button class="btn btn-outline-primary type-btn" data-value="Hilang/rusak" onclick="selectFilter(this, 'Types', true)">Hilang/rusak</button>
                        <button class="btn btn-outline-primary type-btn" data-value="Mutasi KK" onclick="selectFilter(this, 'Types', true)">Mutasi KK</button>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="text-start mb-2"><b>Status Layanan</b></p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary service-status-btn" data-value="Not Yet" onclick="selectFilter(this, 'ServiceStatuses', true)">Menunggu</button>
                        <button class="btn btn-outline-primary service-status-btn" data-value="Process" onclick="selectFilter(this, 'ServiceStatuses', true)">Proses</button>
                        <button class="btn btn-outline-primary service-status-btn" data-value="Rejected" onclick="selectFilter(this, 'ServiceStatuses', true)">Ditolak</button>
                        <button class="btn btn-outline-primary service-status-btn" data-value="Completed" onclick="selectFilter(this, 'ServiceStatuses', true)">Selesai</button>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="text-start mb-2"><b>Status Pengerjaan</b></p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary work-status-btn" data-value="Not Yet" onclick="selectFilter(this, 'WorkStatuses', true)">Menunggu</button>
                        <button class="btn btn-outline-primary work-status-btn" data-value="Process" onclick="selectFilter(this, 'WorkStatuses', true)">Proses</button>
                        <button class="btn btn-outline-primary work-status-btn" data-value="Late" onclick="selectFilter(this, 'WorkStatuses', true)">Telat</button>
                        <button class="btn btn-outline-primary work-status-btn" data-value="Completed" onclick="selectFilter(this, 'WorkStatuses', true)">Selesai</button>
                    </div>
                </div>

                <input type="hidden" id="selectedTime" name="time">
                <input type="hidden" id="selectedCategories" name="categories[]">
                <input type="hidden" id="selectedTypes" name="types[]">
                <input type="hidden" id="selectedServiceStatuses" name="serviceStatuses[]">
                <input type="hidden" id="selectedWorkStatuses" name="workStatuses[]">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="applyFilter()" class="btn btn-primary w-100">Selesai</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function selectFilter(button, type, multiple = false) {
            const $button = $(button);
            const value = $button.data('value');
            const $input = $('#selected' + type);
            
            if (multiple) {
                let selectedValues = $input.val() ? $input.val().split(',') : [];
                
                if ($button.hasClass('btn-primary')) {
                    $button.removeClass('btn-primary').addClass('btn-outline-primary');
                    selectedValues = selectedValues.filter(v => v !== value);
                } else {
                    $button.addClass('btn-primary').removeClass('btn-outline-primary');
                    if (!selectedValues.includes(value)) {
                        selectedValues.push(value);
                    }
                }
                
                $input.val(selectedValues.join(','));
            } else {
                $('.' + type.toLowerCase() + '-btn').removeClass('btn-primary').addClass('btn-outline-primary');
                $button.addClass('btn-primary').removeClass('btn-outline-primary');
                $input.val(value);
            }

            $input.trigger('change');
        }

        function applyFilter() {
            const filters = {
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                time: $('#selectedTime').val(),
                categories: $('#selectedCategories').val(),
                types: $('#selectedTypes').val(),
                kecamatan: $('#kecamatan').val(),
                desa: $('#desa').val(),
                serviceStatuses: $('#selectedServiceStatuses').val(),
                workStatuses: $('#selectedWorkStatuses').val()
            };

            $('#filterModal').modal('hide');
        }
    </script>
@endpush
