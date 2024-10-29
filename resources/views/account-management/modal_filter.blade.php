<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <p class="text-start mb-2"><b>Kecamatan</b></p>
                            <select class="form-select" id="kecamatan" name="kecamatan" onchange="getVillages(this)">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" data-value="{{ $district->id }}">{{ $district->name }}</option>
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
                        <p class="text-start mb-2"><b>RT</b></p>
                        <input type="text" name="rt" id="rt" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <p class="text-start mb-2"><b>RW</b></p>
                        <input type="text" name="rw" id="rw" class="form-control">
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-4">
                        <p class="text-start mb-2"><b>Waktu</b></p>
                        <div class="d-flex gap-2">
                            <button class="time btn btn-primary time-btn" data-value="Terbaru" onclick="selectFilter(this, 'Time')">Terbaru</button>
                            <button class="time btn btn-outline-primary time-btn" data-value="Terlama" onclick="selectFilter(this, 'Time')">Terlama</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p class="text-start mb-2"><b>Jenis Kelamin</b></p>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary gender-btn" data-value="Laki-Laki" onclick="selectFilter(this, 'Genders', true)">Laki-Laki</button>
                            <button class="btn btn-outline-primary gender-btn" data-value="Perempuan" onclick="selectFilter(this, 'Genders', true)">Perempuan</button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <p class="text-start mb-2"><b>Tipe Registrasi</b></p>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary type-btn" data-value="operator" onclick="selectFilter(this, 'Types', true)">Operator</button>
                            <button class="btn btn-outline-primary type-btn" data-value="instance" onclick="selectFilter(this, 'Types', true)">Intansi</button>
                            <button class="btn btn-outline-primary type-btn" data-value="user" onclick="selectFilter(this, 'Types', true)">User</button>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="selectedTime" name="time">
                <input type="hidden" id="selectedDistricts" name="districts">
                <input type="hidden" id="selectedGenders" name="genders">
                <input type="hidden" id="selectedCategories" name="categories[]">
                <input type="hidden" id="selectedTypes" name="types[]">
                <input type="hidden" id="selectedRW" name="rw">
                <input type="hidden" id="selectedRT" name="rt">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="applyFilter()" class="btn btn-primary w-100">Selesai</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function selectDistricts(input) {
            const $input = $(input);
            const value = $input.val();
            $('#selectedDistricts').val(value);
        }

        function selectFilter(button, type, multiple = false) {
            const $button = $(button);
            let value = $button.data('value');
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
                time: $('#selectedTime').val(),
                genders: $('#selectedGenders').val(),
                types: $('#selectedTypes').val(),
                kecamatan: $('#selectedDistricts').val(),
                desa: $('#desa').val(),
                rt: $('#selectedRT').val(),
                rw: $('#selectedRW').val()
            };

            $('#filterModal').modal('hide');
        }
    </script>
@endpush
