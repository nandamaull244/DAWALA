@extends('layouts.main')

@push('css')
    <style>
    </style>
@endpush

@section('page-heading')
    @if (session('pelayanan') || session('tipe_layanan'))
        {{ $pelayanan = session('pelayanan') }}
        {{ $tipe_layanan = session('tipe_layanan') }}
    @endif
    Edit Pengajuan Layanan {{ $pelayanan }}
@endsection

@section('page-subheading')
    {{ $service->user->full_name }} - {{ $service->service_category }} ({{ $service->service_type }})
@endsection

@section('content')
    <section class="section">
        <form action="{{ route(auth()->user()->role . '.pelayanan.update', $service->getHashedId()) }}" id="pelayanan-form" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="service" value="{{ $pelayanan }}">
                            <div class="form-group">
                                <label for="full_name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $service->user->full_name ?? '' }}" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat lengkap</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $service->user->address ?? '' }}" required>
                                {{-- <small class="text-muted">Contoh: Jl. Mangunsarkoro, No. 123, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43213</small> --}}
                            </div>

                            <div class="form-group">
                                <label for="district-select">Kecamatan</label>
                                <div class="input-group">
                                    <select id="district-select" class="form-control" name="district_id" required>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" @if ($district->id == $service->user->district_id) selected @endif>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="village-select">Desa/Kelurahan</label>
                                <div class="input-group">
                                    <select id="village-select" class="form-control" name="village_id" required>
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone_number">No. Telepon/HP (Whatsapp)</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="+62" value="{{ $service->user->phone_number ?? '' }}" minlength="10" maxlength="14" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>

                            @php
                                $evidence = $service->service_image()->where('image_type', 'Bukti Keterbatasan')->first() ?? '';
                                $evidence_odgj = $service->service_image()->where('image_type', 'Bukti Keterbatasan ODGJ')->first() ?? '';
                                $ktp = $service->service_image()->where('image_type', 'KTP')->first() ?? '';
                                $kk = $service->service_image()->where('image_type', 'Kartu Keluarga')->first() ?? '';
                            @endphp

                            <div class="form-group">
                                <label for="evidence_of_disability" class="form-label">Foto Bukti Keterbatasan</label>
                                <input class="form-control @if (isset($evidence)) bg-success @endif" type="file" id="evidence_of_disability" name="evidence_of_disability_image" accept="image/*" required>
                            </div>

                            @if ($pelayanan == 'KTP eL')
                                <div class="form-group">
                                    <label for="kk" class="form-label">Foto Kartu Keluarga</label>
                                    <input class="form-control @if (isset($kk)) bg-success @endif" type="file" id="kk" name="kk_image" accept="image/*" value="" required>
                                </div>
                            @elseif ($pelayanan == 'Kartu Keluarga')
                                <div class="form-group">
                                    <label for="ktp" class="form-label">Foto KTP-eL</label>
                                    <input class="form-control @if (isset($ktp)) bg-success @endif" type="file" id="ktp" name="ktp_image" accept="image/*" required>
                                </div>
                            @endif
                            

                            <div class="form-group">
                                <label for="formFile" class="form-label">Upload Formulir</label>
                                <button class="form-control btn btn-outline-primary" type="button" id="formFile" name="formulir_image" data-bs-toggle="modal" data-bs-target="#formulirModal">Upload formulir</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ $service->user->nik ?? '' }}" maxlength="16" required oninput="this.value = this.value.replace(/[^0-9]/g, '')"> 
                            </div>

                            <div class="form-group">
                                <label for="birth_date">Tanggal Lahir</label>
                                <input type="date" class="form-control flatpickr-birth-date" id="birth_date" name="birth_date" value="{{ $service->user->birth_date ?? '' }}" placeholder="-" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control form-control-sm" id="rt" name="rt" value="{{ $service->user->rt ?? '' }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control form-control-sm" id="rw" name="rw" value="{{ $service->user->rw ?? '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control geolocation-input" id="latitude" name="latitude" required readonly value="{{ $service->latitude ?? '' }}">
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control geolocation-input" id="longitude" name="longitude" required readonly value="{{ $service->longitude ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="service_category">Kategori Pelayanan</label>
                                <div class="input-group">
                                    <select id="service_category" class="form-control" name="service_category" required>
                                        @php
                                            $categories = [
                                                'Disabilitas Fisik', 'Disabilitas Netra/Buta', 'Disabilitas Rungu/Bicara',
                                                'Disabilitas Mental/Jiwa', 'Disabilitas Fisik dan Mental', 'Disabilitas Lainnya', 
                                                'Lansia', 'ODGJ', 'Penduduk Sakit', 'Penduduk Terlantar', 'Penduduk Terkena Bencana'
                                            ];
                                        @endphp
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ $service->service_category == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group" id="evidence_of_disability_odgj_image" style="display: none;">
                                <label for="evidence_of_disability_odgj" class="form-label">Foto bukti instansi terkait (jika benar ODGJ)</label>
                                <input class="form-control @if (isset($evidence_odgj)) bg-success @endif" type="file" id="evidence_of_disability_odgj" name="evidence_of_disability_odgj_image" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="reason">Alasan Pengajuan (Opsional)</label>
                                <input type="text" class="form-control" id="reason" name="reason" value="{{ $service->reason ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="service_type">Tipe Pelayanan</label>
                                <div class="input-group">
                                    @php
                                        $serviceTypes = ['Buat baru', 'Pembaruan KK barcode', 'Baru menikah', 'Penambahan anggota keluarga', 'Hilang/rusak', 'Mutasi KK', 'Perekaman KTP', 'Perubahan data KTP'];
                                    @endphp
                                    <select id="service_type" class="form-control" name="service_type" required>
                                        <option value="" disabled {{ is_null($service->service_type) ? 'selected' : '' }}>Pilih Tipe Pelayanan</option>
                                        @foreach($serviceTypes as $type)
                                            <option value="{{ $type }}" {{ $service->service_type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Download Formulir</label>
                                <div class="d-flex">
                                    <a href="{{ asset('path/to/F1.01.pdf') }}" class="btn btn-primary me-2" download>
                                        <i class="bi bi-file-earmark-pdf"></i> F1.01
                                    </a>
                                    <a href="{{ asset('path/to/F1.02.pdf') }}" class="btn btn-primary me-2" download>
                                        <i class="bi bi-file-earmark-pdf"></i> F1.02
                                    </a>
                                    <a href="{{ asset('path/to/F1.03.pdf') }}" class="btn btn-primary me-2" download>
                                        <i class="bi bi-file-earmark-pdf"></i> F1.03
                                    </a>
                                    <a href="{{ asset('path/to/F1.04.pdf') }}" class="btn btn-primary me-2" download>
                                        <i class="bi bi-file-earmark-pdf"></i> F1.04
                                    </a>
                                </div>
                                <ul class="mt-2">
                                    <li>
                                        <small>F1.01 : Jika data/dokumen hilang/rusak (pernah memiliki data/dokumen yang tercatat di disduk)</small>
                                    </li>
                                    <li style="color: red;">
                                        <small>F1.02 : Wajib untuk semua layanan</small>
                                    </li>
                                    <li>
                                        <small class="text-danger mt-1 d-block">F1.03 : Jika pindah alamat</small>
                                    </li>
                                    <li>
                                        <small class="text-danger mt-1 d-block">F1.04 : khusus untuk penduduk yang tidak memiliki data atau dokumen sama sekali</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('main-service.modal_upload_formulir')
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $('#reason').focus();

        // @if ($pelayanan == null)
        //     window.location.href = "{{ route('admin.pelayanan.index') }}";
        // @endif

        $(document).ready(function() {
            function updateODGJField() {
                var isODGJ = $('#service_category').val() === 'ODGJ';
                $('#evidence_of_disability_odgj_image').toggle(isODGJ);
                $('[name="evidence_of_disability_odgj_image"]').attr('required', isODGJ);
            }

            updateODGJField();

            $('#service_category').change(updateODGJField);

            $('#formFile').click(function(e) {
                e.preventDefault();
            });

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    $('#latitude').val(position.coords.latitude.toFixed(6));
                    $('#longitude').val(position.coords.longitude.toFixed(6));
                }, function(error) {
                    console.error("Error: " + error.message);
                    toastr.warning("Tidak dapat mengambil lokasi Anda. Silakan masukkan secara manual.", "Perhatian!");
                });
            } else {
                toastr.error("Layanan lokasi tidak didukung oleh browser Anda. Silakan masukkan lokasi Anda secara manual.", "Perhatian!");
            }

            $('.geolocation-input').on('mouseenter', function() {
                if (!$('#latitude').val() && !$('#longitude').val()) {
                    getGeolocation();
                }
            });

            function getGeolocation() {
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        $('#latitude').val(position.coords.latitude.toFixed(6));
                        $('#longitude').val(position.coords.longitude.toFixed(6));
                    }, function(error) {
                        console.error("Error: " + error.message);
                        toastr.warning("Tidak dapat mengambil lokasi Anda. Pastikan Anda telah mengizinkan akses lokasi!");
                    });
                } else {
                    toastr.error("Layanan lokasi tidak didukung oleh browser Anda. Silakan masukkan lokasi Anda secara manual.", "Perhatian!");
                }
            }
        });

        var nikCheck = false;
        $('#nik').on('keyup change', function() {
            if($('#nik').val().length == 16) {
                $.ajax({
                    url: "{{ route('pelayanan.cekNIK') }}",
                    method: 'GET',
                    data: {
                        nik: $('#nik').val()
                    },
                    success: function(response) {
                        if(response) {
                            toastr.error('NIK sudah terdaftar', 'Astagfirullah' ,{timeOut: 2000, "className": "custom-larger-toast"});
                            nikCheck = true;
                        } else {
                            toastr.success('NIK dapat digunakan', 'Alhamdulillah',{timeOut: 2000, "className": "custom-larger-toast"});
                            nikCheck = false;
                        }
                    }, 
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });

        $(document).ready(function() {
            $('form').on('submit', function(e) {
                var isValid = true;

                $(this).find('input, select, textarea').each(function() {
                    var $field = $(this);
                    var fieldName = $field.closest('.form-group').find('label').text() || 'Field';
                    if(fieldName == 'F1.02') fieldName = 'Formulir F1.02';
                    if(fieldName == 'NIK' && nikCheck) {
                        isValid = false;
                        toastr.error('NIK sudah terdaftar', 'Gagal!' ,{timeOut: 2000, "className": "custom-larger-toast"});
                    }

                    if ($field.attr('type') === 'file') {
                        var dataExist = $field.data('exist');
                        if (dataExist === false && !$field.val() && $field.prop('required')) {
                            isValid = false;
                            toastr.warning(fieldName + ' harus diisi', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
                        }
                    } 
                    else if ($field.prop('required') && !$field.val()) {
                        isValid = false;
                        toastr.warning(fieldName + ' harus diisi', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });

        var userVillageId = "{{ auth()->user()->role == 'user' ? auth()->user()->village_id : null }}"

        $(document).ready(function() {
            function loadVillages(districtId) {
                const $villageSelect = $('#village-select');
                $villageSelect.html('<option value="" disabled ' + (!userVillageId ? 'selected' : '')  + '>Pilih Desa</option>');

                $.ajax({
                    url: "{{ route('get-villages', '') }}/" + districtId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const userVillageId = "{{ $service->user->village_id ?? null }}"
                            
                        $.each(data, function(index, village) {
                            const $option = $('<option>', {
                                value: village.id,
                                text: village.name
                            });
                            
                            if (village.id == userVillageId) {
                                $option.prop('selected', true);
                            }
                            
                            $villageSelect.append($option);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            const initialDistrictId = $('#district-select').val();
            if (initialDistrictId) {
                loadVillages(initialDistrictId);
            }

            $('#district-select').on('change', function() {
                const districtId = $(this).val();
                if (districtId) {
                    loadVillages(districtId);
                } else {
                    $('#village-select').html('<option value="" disabled ' + (!userVillageId ? 'selected' : '')  + '>Pilih Desa</option>');
                }
            });
        });
    </script>
@endpush






