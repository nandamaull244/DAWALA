@extends('layouts.main')

@push('css')
    <style>
    </style>
@endpush

@section('page-heading')
    Pengajuan Layanan {{ $pelayanan }}
@endsection

@section('page-subheading')
    Formulir Pengajuan Layanan {{ $pelayanan }}
@endsection

@section('content')
    <section class="section">
        <form action="{{ route(auth()->user()->role . '.pelayanan.store') }}" id="pelayanan-form" method="POST" enctype="multipart/form-data" novalidate>
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="service" value="{{ $pelayanan }}">
                            <div class="form-group">
                                <label for="full_name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="@if (auth()->user()->role == 'user') {{ auth()->user()->full_name }} @endif" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat lengkap</label>
                                <input type="text" class="form-control" id="address" name="address" value="@if (auth()->user()->role == 'user') {{ auth()->user()->address }} @endif" required>
                                {{-- <small class="text-muted">Contoh: Jl. Mangunsarkoro, No. 123, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43213</small> --}}
                            </div>

                            <div class="form-group">
                                <label for="district-select">Kecamatan</label>
                                <div class="input-group">
                                    <select id="district-select" class="form-control" name="district_id" required>
                                        <option value="" disabled @if (auth()->user()->role != 'user' || !isset(auth()->user()->district_id)) selected @endif>Pilih Kecamatan</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}" @if (auth()->user()->role == 'user' && $district->id == auth()->user()->district_id) selected @endif>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="village-select">Desa/Kelurahan</label>
                                <div class="input-group">
                                    <select id="village-select" class="form-control" name="village_id" required>
                                        <option value="" disabled @if (auth()->user()->role != 'user' || !isset(auth()->user()->village_id)) selected @endif>Pilih Desa/Kelurahan</option>
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone_number">No. Telepon/HP (Whatsapp)</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="+62" value="@if (auth()->user()->role == 'user') {{ auth()->user()->phone_number }} @endif" maxlength="14" required>
                            </div>

                            <div class="form-group">
                                <label for="evidence_of_disability" class="form-label">Foto Bukti Keterbatasan</label>
                                <input class="form-control" type="file" id="evidence_of_disability" name="evidence_of_disability_image" accept="image/*" required>
                            </div>

                            @if ($pelayanan == 'KTP eL')
                                <div class="form-group">
                                    <label for="kk" class="form-label">Foto Kartu Keluarga</label>
                                    <input class="form-control" type="file" id="kk" name="kk_image" accept="image/*" required>
                                </div>
                            @elseif ($pelayanan == 'Kartu Keluarga')
                                <div class="form-group">
                                    <label for="ktp" class="form-label">Foto KTP-eL</label>
                                    <input class="form-control" type="file" id="ktp" name="ktp_image" accept="image/*" required>
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
                                <input type="text" class="form-control" id="nik" name="nik" 
                                    value="@if (auth()->user()->role == 'user'){{ str_replace(' ', '', auth()->user()->nik) }}@endif" 
                                    maxlength="16" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>

                            <div class="form-group">
                                <label for="birth_date">Tanggal Lahir</label>
                                <input type="date" class="form-control flatpickr-birth-date" id="birth_date" name="birth_date" value="@if (auth()->user()->role == 'user') {{ auth()->user()->birth_date }} @endif" placeholder="-" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control form-control-sm" id="rt" name="rt" value="@if (auth()->user()->role == 'user') {{ auth()->user()->rt }} @endif" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control form-control-sm" id="rw" name="rw" value="@if (auth()->user()->role == 'user') {{ auth()->user()->rw }} @endif" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control geolocation-input" id="latitude" name="latitude" required readonly>
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control geolocation-input" id="longitude" name="longitude" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="service_category">Kategori Pelayanan</label>
                                <div class="input-group">
                                    <select id="service_category" class="form-control" name="service_category" required>
                                        <option value="" disabled selected>Pilih Kategori Pelayanan</option>
                                        <option value="Disabilitas Fisik">Disabilitas Fisik</option>
                                        <option value="Disabilitas Netra/Buta">Disabilitas Netra/Buta</option>
                                        <option value="Disabilitas Rungu/Bicara">Disabilitas Rungu/Bicara</option>
                                        <option value="Disabilitas Mental/Jiwa">Disabilitas Mental/Jiwa</option>
                                        <option value="Disabilitas Fisik dan Mental">Disabilitas Fisik dan Mental</option>
                                        <option value="Disabilitas Lainnya">Disabilitas Lainnya</option>
                                        <option value="Lansia">Lansia</option>
                                        <option value="ODGJ">ODGJ</option>
                                        <option value="Penduduk Sakit">Penduduk Sakit</option>
                                        <option value="Penduduk Terlantar">Penduduk Terlantar</option>
                                        <option value="Penduduk Terkena Bencana">Penduduk Terkena Bencana</option>
                                    </select>
                                    <span class="input-group-text"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="form-group" id="evidence_of_disability_odgj_image" style="display: none;">
                                <label for="evidence_of_disability_odgj" class="form-label">Foto bukti instansi terkait (jika benar ODGJ)</label>
                                <input class="form-control" type="file" id="evidence_of_disability_odgj" name="evidence_of_disability_odgj_image" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="reason">Alasan tidak bisa datang ke kantor (Opsional)</label>
                                <input type="text" class="form-control" id="reason" name="reason">
                            </div>

                            <div class="form-group" hidden>
                                <label for="service_type">Tipe Pelayanan</label>
                                <div class="input-group">
                                    <select id="service_type" class="form-control" name="service_type" required hidden>
                                        <option value="" disabled>Pilih Tipe Pelayanan</option>
                                        <option value="Buat baru" @if ($tipe_layanan == 'Buat baru') selected @endif>Buat baru</option>
                                        <option value="Pembaruan KK barcode" @if ($tipe_layanan == 'Pembaruan KK barcode') selected @endif>Pembaruan KK barcode</option>
                                        <option value="Baru menikah" @if ($tipe_layanan == 'Baru menikah') selected @endif>Baru menikah</option>
                                        <option value="Penambahan anggota keluarga" @if ($tipe_layanan == 'Penambahan anggota keluarga') selected @endif>Penambahan anggota keluarga</option>
                                        <option value="Hilang/rusak" @if ($tipe_layanan == 'Hilang/rusak') selected @endif>Hilang/rusak</option>
                                        <option value="Mutasi KK" @if ($tipe_layanan == 'Mutasi KK') selected @endif>Mutasi KK</option>
                                        <option value="Perekaman KTP" @if ($tipe_layanan == 'Perekaman KTP') selected @endif>Perekaman KTP</option>
                                        <option value="Perubahan data KTP" @if ($tipe_layanan == 'Perubahan data KTP') selected @endif>Perubahan data KTP</option>
                                        <option value="Hilang/rusak" @if ($tipe_layanan == 'Hilang/rusak') selected @endif>Hilang/rusak</option>
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
        @if(auth()->user()->role == 'user')
            $('#reason').focus();
        @endif

        // @if ($pelayanan == null)
        //     window.location.href = "{{ route('admin.pelayanan.index') }}";
        // @endif

        $(document).ready(function() {
            $('#service_category').change(function() {
                var isODGJ = $(this).val() === 'ODGJ';
                $('#evidence_of_disability_odgj_image').toggle(isODGJ);
                if(isODGJ) {
                    $('[name="evidence_of_disability_odgj_image"]').attr('required', true);
                } else {
                    $('[name="evidence_of_disability_odgj_image"]').attr('required', false);
                }
            });

            $('#formFile').click(function(e) {
                e.preventDefault();
            });

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    $('#latitude').val(position.coords.latitude.toFixed(6));
                    $('#longitude').val(position.coords.longitude.toFixed(6));
                }, function(error) {
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
                    url: "{{ route(auth()->user()->role . '.pelayanan.cekNIK') }}",
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

        $('#pelayanan-form').on('submit', function(e) {
            e.preventDefault();
            var isValid = true;

            $(this).find('input, select, textarea').each(function() {
                var $field = $(this);
                var fieldName = $field.closest('.form-group').find('label').text() || 'Field';
                if(fieldName == 'F1.02') fieldName = 'Formulir F1.02';
                if(fieldName == 'NIK') $field.val($field.val().replace(/\s+/g, ''));

                if(fieldName == 'NIK' && nikCheck) {
                    isValid = false;
                    toastr.error('NIK sudah terdaftar', 'Astagfirullah' ,{timeOut: 2000, "className": "custom-larger-toast"});
                }

                if ($field.prop('required') && !$field.val()) {
                    isValid = false;
                    toastr.warning(fieldName + ' harus diisi', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
                }

                var maxLength = $field.attr('maxlength');
                if (maxLength && $field.val().length > maxLength) {
                    isValid = false;
                    toastr.warning(fieldName + ' tidak boleh lebih dari ' + maxLength + ' karakter', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
                }
            });

            if (isValid) {
                this.submit();
            }
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
                        const userVillageId = "{{ auth()->user()->role == 'user' ? auth()->user()->village_id : null }}"
                            
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



