@extends('layouts.main')

@section('page-heading')
Tambah Akun
@endsection

@section('page-subheading')
Formulir Registrasi Akun
@endsection

@section('content')
<section class="section">
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form id="register-form" action="{{ route("admin.manajemen-akun.store") }}" method="POST" novalidate>
                        @csrf
                        
                        <!-- Role selection -->
                        <div class="form-group col-md-6">
                            <label for="sub-category-select">Pilih Kategori Akun</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="perorangan" value="user" onclick="setRole('user')" checked required>
                                <label class="form-check-label" for="perorangan">Perorangan/Untuk Diri Sendiri sendiri</label>
                                @error('role')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="instance" value="instance" onclick="setRole('instance')" required>
                                <label class="form-check-label" for="instance">Instansi/Lembaga</label>
                                @error('role')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4 mb-1">
                            <!-- Sub-category selection (hidden by default) -->
                            <div class="col-md-6" id="sub-category" style="display: none;">
                                <div class="form-group mb-4">
                                    <label for="sub-category-select">Pilih Tipe Registrasi</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Tipe Registrasi" id="registration_type" name="registration_type">
                                            <option value="">Pilih Tipe Registrasi</option>
                                            <option value="Intansi, RT" {{ old('registration_type') == 'Intansi, RT' ? 'selected' : '' }}>RT</option>
                                            <option value="Intansi, RW" {{ old('registration_type') == 'Intansi, RW' ? 'selected' : '' }}>RW</option>
                                            <option value="Intansi, Yayasan" {{ old('registration_type') == 'Intansi, Yayasan' ? 'selected' : '' }}>Yayasan</option>
                                            <option value="Intansi, Instansi" {{ old('registration_type') == 'Intansi, Instansi' ? 'selected' : '' }}>Instansi</option>
                                            <option value="Intansi, Lembaga" {{ old('registration_type') == 'Intansi, Lembaga' ? 'selected' : '' }}>Lembaga</option>
                                            <option value="Intansi, Desa" {{ old('registration_type') == 'Intansi, Desa' ? 'selected' : '' }}>Desa</option>
                                        </select>
                                        @error('registration_type')
                                            <span>{{ $message }}</span>
                                        @enderror
                                        <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                            <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="display: none;" id="instance_name_group">
                                <div class="form-group">
                                    <label for="instance_name">Nama Intansi</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-md" data-title="Nama Intansi" id="instance_name" name="instance_name" value="{{ old('nama_intansi') }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-card-text"></i>
                                        </div>
                                    </div>
                                    @error('no_kk')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- District selection (hidden by default) -->
                            <div class="col-md-6">
                                <div id="district-select-group" class="form-group mb-4">
                                    <label for="district-select">Pilih Kecamatan</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Kecamatan" id="district-select" name="district_id">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('district_id')
                                            <span>{{ $message }}</span>
                                        @enderror
                                        <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                            <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Village selection (hidden by default) -->
                            <div class="col-md-6">
                                <div id="village-select-group" class="form-group mb-4">
                                    <label for="village-select">Pilih Desa</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Desa" id="village-select" name="village_id">
                                            @foreach($villages as $village)
                                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('village_id')
                                            <span>{{ $message }}</span>
                                        @enderror
                                        <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                            <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- NIK -->
                            <div class="col-md-6" id="nik_container">
                                <div class="mb-4 form-group">
                                    <label for="nik">NIK</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-md" data-title="NIK" id="nik" name="nik" maxlength="16" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <div class="form-control-icon">
                                            <i class="bi bi-card-text"></i>
                                        </div>
                                    </div>
                                    @error('nik')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- No KK -->
                            <div class="col-md-6" id="no_kk_container">
                                <div class="mb-4 form-group">
                                    <label for="no_kk">No KK</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-md" data-title="No Kartu Keluarga" id="no_kk" name="no_kk" maxlength="16" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <div class="form-control-icon">
                                            <i class="bi bi-card-text"></i>
                                        </div>
                                    </div>
                                    @error('no_kk')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="full_name">Nama Lengkap</label>
                                    <div class="form-group position-relative has-icon-left mb-4 form-group">
                                        <input type="text" class="form-control form-control-md" data-title="Nama Lengkap" name="full_name" id="full_name" value="{{ old('full_name') }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                    @error('full_name')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="email">Email (Opsional)</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="email" class="form-control form-control-md" data-title="Email" id="email" name="email" value="{{ old('email') }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Birth Date -->
                            <div class="col-md-6" id="birth_date_container">
                                <div class="mb-4 form-group">
                                    <label for="birth_date" class="mb-2">Tanggal Lahir</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="date" class="form-control form-control-md flatpickr-birth-date-check" data-title="Tanggal Lahir" id="birth_date" placeholder="Pilih Tanggal Lahir" name="birth_date">
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar"></i>
                                        </div>
                                    </div>
                                    @error('birth_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Phone Number -->
                                <div class="mb-4 form-group">
                                    <label for="phone_number">No. Handphone (Whatsapp)</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="tel" class="form-control form-control-md" data-title="No Handphone (Whatsapp)" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required minlength="9" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <div class="form-control-icon">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                    </div>
                                    @error('phone_number')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="address">Alamat</label>
                                    <div class="form-group position-relative has-icon-left mb-4 form-group">
                                        <input type="text" class="form-control form-control-md" data-title="Alamat" id="address" name="address" value="{{ old('address') }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-house"></i>
                                        </div>
                                    </div>
                                    @error('address')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="gender-select" class="mb-2">Pilih Jenis Kelamin</label>
                                    <div class="form-group ">
                                        <div class="position-relative">
                                            <select class="form-control form-control-md" data-title="Jenis Kelamin" id="gender-select" name="gender" required>
                                                <option selected value="Laki-Laki" {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}> Laki-Laki</option>
                                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}> Perempuan</option>
                                            </select>
                                            <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                                <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- rt -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="rt">RT</label>
                                    <div class="form-group position-relative has-icon-left mb-4 form-group">
                                        <input type="number" class="form-control form-control-md" data-title="RT" id="rt" name="rt" value="{{ old('rt') }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-house"></i>
                                        </div>
                                    </div>
                                    @error('rt')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- rw -->
                                <div class="mb-4 form-group">
                                    <label for="rw">RW</label>
                                    <div class="form-group position-relative has-icon-left mb-4 form-group">
                                        <input type="number" class="form-control form-control-md" data-title="RW" id="rw" name="rw" value="{{ old('rw') }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-house"></i>
                                        </div>
                                    </div>
                                    @error('rw')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="password" class="mb-2">Password (Minimal 8 karakter)</label>
                                    <div class="form-group position-relative has-icon-left ">
                                        <input type="password" class="form-control form-control-md" data-title="Password" placeholder="Password" name="password" id="password" minlength="8" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-shield-lock"></i>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted mb-2">Centang kotak di bawah untuk melihat password sebelum disubmit.</small>
                                    <div class="form-check mb-4">
                                        <input type="checkbox" class="form-check-input" onclick="togglePassword()"
                                            id="showPassword">
                                        <label class="form-check-label" for="showPassword">Lihat Password</label>
                                    </div>
                                    @error('password')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Confirmation -->
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation" class="mb-2">Konfirmasi Password</label>
                                <div class="form-group position-relative has-icon-left mb-4 form-group">
                                    <input type="password" class="form-control form-control-md" data-title="Konfirmasi Password" id="password_confirmation" placeholder="Ulangi Password" minlength="8" name="password_confirmation" required>
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="registration_status" id="registration_status" value="completed">
                        <button class="btn btn-primary float-end" type="submit">Tambah Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#district-select').on('change', function() {
            const districtId = $(this).val();
            const $villageSelect = $('#village-select');
            $villageSelect.html('<option value="">Pilih Desa</option>');

            if (districtId) {
                $.ajax({
                    url: "{{ route('get-villages', '') }}/" + districtId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(index, village) {
                            $villageSelect.append($('<option>', {
                                value: village.id,
                                text: village.name
                            }));
                        });
                        $('#village-select-group').show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                $('#village-select-group').hide();
            }
        });

        $('form').on('submit', function(event) {
            const villageId = $('#village-select').val();
            let $hiddenVillageInput = $('#hidden-village-id');

            if (villageId && $hiddenVillageInput.length === 0) {
                $hiddenVillageInput = $('<input>', {
                    type: 'hidden',
                    name: 'village_id',
                    value: villageId
                });
                $(this).append($hiddenVillageInput);
            }
        });

        $('#showPassword').on('change', function() {
            const $passwordInput = $('#password');
            $passwordInput.attr('type', $(this).prop('checked') ? 'text' : 'password');
        });

        $('#registration_type').on('change', function() {
            const selectedType = $(this).val();
            const $instanceNameGroup = $('#instance_name_group');
            const $instanceNameInput = $('#instance_name');
            
            const showInstanceTypes = ['Intansi, Yayasan', 'Intansi, Instansi', 'Intansi, Lembaga'];
            const isShowInstance = showInstanceTypes.includes(selectedType);
            
            if (isShowInstance) {
                $instanceNameGroup.show();
                $instanceNameInput.prop('required', true);
                
                const placeholders = {
                    'Intansi, Yayasan': 'Masukkan nama yayasan',
                    'Intansi, Instansi': 'Masukkan nama instansi',
                    'Intansi, Lembaga': 'Masukkan nama lembaga'
                };
                
                $instanceNameInput.attr('placeholder', placeholders[selectedType] || '');
            } else {
                $instanceNameGroup.hide();
                $instanceNameInput.prop('required', false);
                $instanceNameInput.val('').attr('placeholder', '');
            }
        });

        $('#registration_type').trigger('change');
    });

    function setRole(role) {
        const isInstance = role === 'instance';
        const elements = {
            status: $('#registration_status'),
            subCategory: $('#sub-category'),
            userInput: $('#perorangan'),
            operatorInput: $('#instance'),
            instanceName: $('#instance_name_group')
        };
        
        elements.status.val(isInstance ? 'process' : 'completed');
        elements.subCategory[isInstance ? 'show' : 'hide']();
        elements.instanceName.hide();
        
        const requiredFields = {
            user: {
                '#perorangan': true,
                '#instance': false,
                '#instance_name': false,
                '#registration_type': false,
               
            },
            instance: {
                '#perorangan': false,
                '#instance': true,
                '#registration_type': true,
                
            }
        };
        
        const fields = requiredFields[isInstance ? 'instance' : 'user'];
        Object.entries(fields).forEach(([selector, required]) => {
            $(selector).prop('required', required);
        });

        if (!isInstance) {
            $('#registration_type').val('');
            $('#instance_name').val('').prop('required', false);
        }
    }

    function togglePassword() {
        const $passwordInput = $('#password');
        
        $passwordInput.attr('type', 
            $passwordInput.attr('type') === 'password' ? 'text' : 'password'
        );
    }

    function generateRandom16Digits() {
        let randomNumber = '';
        for (let i = 0; i < 16; i++) {
            randomNumber += Math.floor(Math.random() * 10);
        }
        return randomNumber;
    }

    $('[name="role"]').on('change', function() {
        let role = $(this).val()

        if(role == 'instance') {
            $('#no_kk_container, #nik_container, #birth_date_container').hide()
            $('#no_kk').val(generateRandom16Digits())
            $('#nik').val(generateRandom16Digits())
            $('#no_kk, #nik, #birth_date').val('').attr('required', false)
        } else {
            $('#no_kk_container, #nik_container, #birth_date_container').show()
            $('#no_kk, #nik, #birth_date').val('').attr('required', true)
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
                        toastr.error('NIK sudah terdaftar', 'Gagal!' ,{timeOut: 2000, "className": "custom-larger-toast"});
                        nikCheck = true;
                    } else {
                        toastr.success('NIK dapat digunakan', 'Berhasil!',{timeOut: 2000, "className": "custom-larger-toast"});
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
        $('#register-form').on('submit', function(event) {
            event.preventDefault();
            let isValid = true;

            $(this).find('input, select, textarea').each(function() {
                const $field = $(this);
                
                let fieldName = $field.data('title');
                if (fieldName === 'NIK') $field.val($field.val().replace(/\s+/g, ''));

                if (fieldName === 'NIK' && nikCheck) {
                    isValid = false;
                    toastr.error('NIK sudah terdaftar', 'Astagfirullah', { timeOut: 2000, className: "custom-larger-toast" });
                }

                if ($field.prop('required') && !$field.val()) {
                console.log(this);
                    isValid = false;
                    toastr.warning(`${fieldName} harus diisi`, 'Peringatan', { timeOut: 2500, className: "custom-larger-toast" });
                }

                const maxLength = $field.attr('maxlength');
                if (maxLength && $field.val().length > maxLength) {
                    isValid = false;
                    toastr.warning(`${fieldName} tidak boleh lebih dari ${maxLength} karakter`, 'Peringatan', { timeOut: 2500, className: "custom-larger-toast" });
                }
            });

            const villageId = $('#village-select').val();
            let $hiddenVillageInput = $('#hidden-village-id');
            if (villageId && $hiddenVillageInput.length === 0) {
                $hiddenVillageInput = $('<input>', {
                    type: 'hidden',
                    name: 'village_id',
                    value: villageId
                });
                $(this).append($hiddenVillageInput);
            }

            const birthDateStr = $('#birth_date').val();
            const role = $('input[name="role"]:checked').val();
            const password = $('#password').val();
            const passwordConfirmation = $('#password_confirmation').val();
            if(password !== passwordConfirmation) {
                isValid = false;
                toastr.error('Password tidak cocok', 'Gagal!', { timeOut: 2000, className: "custom-larger-toast" });
            }

            if (role === 'instance') {
                if (isValid) this.submit();
                return;
            }

            if (role === 'user') {
                if (!birthDateStr) {
                    toastr.error('Tanggal lahir harus diisi', 'Gagal!', {
                        timeOut: 3000,
                        closeButton: true,
                        progressBar: true,
                        className: "custom-larger-toast"
                    });
                    return;
                }

                // Age validation
                const birthDate = new Date(birthDateStr);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                if (age < 17) {
                    toastr.error('Anda harus berusia minimal 17 tahun untuk mendaftar', 'Gagal!', {
                        timeOut: 3000,
                        closeButton: true,
                        progressBar: true,
                        className: "custom-larger-toast"
                    });
                    return;
                }
            }

            if (isValid) this.submit();
        });
    });
    
</script>
@endpush
