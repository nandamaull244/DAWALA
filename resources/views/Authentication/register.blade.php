<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DAWALA-PEDULI</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/backend/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/backend/assets/css/app.css">
    <link rel="stylesheet" href="/backend/assets/css/pages/auth.css">
    <link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            background-image: url('{{ asset('assets') }}/img/1.png');
            background-size: cover;
            background-position: center;

        }

        #auth-left {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-primary {
            border-radius: 20px;
            background-color: #4e73df;
            border-color: #4e73df;
        }
    </style>
    <style>
        /* Container */
        #toast-container > div {
            width: 340px !important;
            padding: 15px 15px 15px 50px !important;
            opacity: 1 !important;
        }
        
        /* Message */
        #toast-container > div.toast-message {
            font-size: 16px !important;phone
            line-height: 1.5 !important;
        }
        
        /* Title */
        .toast-title {
            font-size: 22px !important;
            font-weight: bold !important;
            margin-bottom: 8px !important;
        }

        .toast-message{
            font-size: 16px;
        }
        
        /* Close button */
        .toast-close-button {
            font-size: 20px !important;
            font-weight: bold !important;
            right: 8px !important;
            top: 8px !important;
        }
        
        /* Icons */
        .toast:before {
            font-size: 24px !important;
            line-height: 24px !important;
            position: absolute !important;
            left: 15px !important;
        }
        
        /* Animation */
        .toast {
            transition: all 0.3s ease-in-out !important;
        }
        
        /* Optional: Different colors for different types */
        .toast-success {
            background-color: #51A351 !important;
        }
        
        .toast-error {
            background-color: #BD362F !important;
        }
        
        .toast-info {
            background-color: #2F96B4 !important;
        }
        
        .toast-warning {
            background-color: #F89406 !important;
        }
        
        /* Optional: Hover effect */
        #toast-container > div:hover {
            box-shadow: 0 0 12px rgba(0,0,0,0.3) !important;
            opacity: 1 !important;
        }
    </style>
    <style>
        /* Existing styles tetap sama */
        body {
            background-image: url('{{ asset('assets') }}/img/1.png');
            background-size: cover;
            background-position: center;
        }

        #auth-left {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-primary {
            border-radius: 20px;
            background-color: #4e73df;
            border-color: #4e73df;
        }

        /* Tambahkan CSS responsif */
        @media (max-width: 768px) {
            #auth-left {
                padding: 1.5rem;
                margin: 1rem;
            }

            /* Sembunyikan icon pada input */
            .form-control-icon {
                display: none !important;
            }

            /* Reset padding input karena tidak ada icon */
            .form-control, 
            .form-control-xl,
            .form-select, 
            select.form-control-xl {
                font-size: 16px !important;
                height: auto !important;
                padding: 0.5rem 1rem !important;
                padding-left: 1rem !important; /* Reset padding kiri */
            }

            .auth-title {
                font-size: 1.5rem !important;
            }

            .auth-subtitle {
                font-size: 0.9rem;
            }

            /* Sesuaikan margin form groups */
            .form-group {
                margin-bottom: 1rem !important;
            }

            /* Sesuaikan padding container */
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Sesuaikan ukuran tombol */
            .btn {
                padding: 0.75rem 1rem;
                font-size: 1rem !important;
            }

            /* Reset position relative pada form group */
            .form-group.position-relative {
                position: static !important;
            }
        }

        /* Perbaikan untuk layar sangat kecil */
        @media (max-width: 375px) {
            #auth-left {
                padding: 1rem;
                margin: 0.5rem;
            }

            .form-control, 
            .form-control-xl {
                padding: 0.4rem 0.8rem !important;
            }
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row h-100 justify-content-center align-items-center my-3 my-md-5 mb-5">
            <div class="col-12 col-lg-8 px-3 px-lg-0">
                <div id="auth-left">
                    <h4 class="auth-title text-center">Registrasi Akun</h4>
                    <p class="auth-subtitle mb-5 text-center">Buat akun untuk urusan pelayanan</p>

                    <form action="{{ route('register.process') }}" method="POST" id="register-form" novalidate>
                        @csrf
                        <div class="mb-4">
                            <div class="form-group">
                                <label for="sub-category-select">Pilih kategori akun</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="perorangan" selected 
                                        value="user" onclick="setRole('user')" required>
                                    <label class="form-check-label" for="perorangan">Perorangan/Untuk Diri Sendiri</label>
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
                        </div>
                        <div id="sub-category" class="form-group mb-4" style="display: none;">
                            <label for="sub-category-select">Pilih Tipe Registrasi</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="sub-category-select" name="registration_type" data-title="Tipe Registrasi">
                                    <option value="">Pilih Tipe Registrasi</option>
                                    <option value="Intansi, RT"
                                        {{ old('registration_type') == 'Intansi, RT' ? 'selected' : '' }}>
                                        RT</option>
                                    <option value="Intansi, RW"
                                        {{ old('registration_type') == 'Intansi, RW' ? 'selected' : '' }}>
                                        RW</option>
                                    <option value="Intansi, Yayasan"
                                        {{ old('registration_type') == 'Intansi, Yayasan' ? 'selected' : '' }}>
                                        Yayasan</option>
                                    <option value="Intansi, Instansi"
                                        {{ old('registration_type') == 'Intansi, Instansi' ? 'selected' : '' }}>
                                        Instansi</option>
                                    <option value="Intansi, Desa"
                                        {{ old('registration_type') == 'Intansi, Desa' ? 'selected' : '' }}>
                                        Desa</option>
                                    <option value="Intansi, Lembaga"
                                        {{ old('registration_type') == 'Intansi, Lembaga' ? 'selected' : '' }}>
                                        Lembaga</option>
                                </select>
                                @error('registration_type')
                                    <span>{{ $message }}</span>
                                @enderror
                                <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div id="instansi-select-group" class="mb-4" style="display: none;">
                            <div class="form-group position-relative has-icon-left mb-4"  >
                                <input type="text" class="form-control " placeholder="Nama Instansi" name="instansi" value="{{ old('instansi') }}" data-title="Nama Intansi">
                                <div class="form-control-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                            </div>
                            @error('instansi')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div id="district-select-group" class="form-group mb-4">
                            <label for="district-select">Pilih Kecamatan</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="district-select" name="district_id" data-title="Kecamatan">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('district_id')
                                    <span>{{ $message }}</span>
                                @enderror
                                <div class="form-control-icon"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <i class="bi bi-chevron-down"
                                        style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div id="village-select-group" class="form-group mb-4">
                            <label for="village-select">Pilih Desa</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="village-select" name="village_id" data-title="Desa">
                                    <option value="">Pilih Desa</option>
                                </select>
                                @error('village_id')
                                    <span>{{ $message }}</span>
                                @enderror
                                <div class="form-control-icon"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <i class="bi bi-chevron-down"
                                        style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- rt -->
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="number" class="form-control form-control-xl" placeholder="RT contoh(01)" name="rt" value="{{ old('rt') }}" required data-title="RT">
                                <div class="form-control-icon">
                                    <i class="bi bi-house"></i>
                                </div>
                            </div>
                            @error('rt')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- rw -->
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="number" class="form-control form-control-xl" placeholder="RW contoh(03)" name="rw" value="{{ old('rw') }}" required data-title="RW">
                                <div class="form-control-icon">
                                    <i class="bi bi-house"></i>
                                </div>
                            </div>
                            @error('rw')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- address -->
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl" placeholder="Alamat" name="address" value="{{ old('address') }}" required data-title="Alamat">
                                <div class="form-control-icon">
                                    <i class="bi bi-house"></i>
                                </div>
                            </div>
                            @error('address')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap" name="full_name" value="{{ old('full_name') }}" required data-title="Nama Lengkap">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            @error('full_name')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4" id="nik_container">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-xl" placeholder="NIK" id="nik" name="nik" value="{{ old('nik') }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-title="NIK" maxlength="16">
                                <div class="form-control-icon">
                                    <i class="bi bi-card-text"></i>
                                </div>
                            </div>
                            @error('nik')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4" id="no_kk_container">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-xl" placeholder="No Kartu Keluaga" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-title="No Kartu Keluarga" maxlength="16">
                                <div class="form-control-icon">
                                    <i class="bi bi-card-text"></i>
                                </div>
                            </div>
                            @error('no_kk')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4" id="birth_date_container">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-xl flatpickr" id="birth_date" placeholder="Pilih Tanggal Lahir" name="birth_date" value="{{ old('birth_date') }}" readonly="true" data-title="Tanggal Lahir">
                                <div class="form-control-icon">
                                    <i class="bi bi-calendar"></i>
                                </div>
                            </div>
                            @error('birth_date')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left">
                                <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" value="{{ old('email') }}" data-title="Email">
                                <div class="form-control-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left">
                                <input type="tel" class="form-control form-control-xl" placeholder="No. Handphone (Whatsapp)" name="phone_number" value="{{ old('phone_number') }}" minlength="10" maxlength="14" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-title="No. Telepon/HP (Whatsapp)">
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                            </div>
                            @error('phone_number')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-group ">
                                <div class="position-relative">
                                    <select class="form-control form-control-xl" id="gender-select" name="gender" required>
                                        <option value="Laki-Laki" selected
                                            {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki</option>
                                        <option value="Perempuan"
                                            {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
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

                        <input type="hidden" name="registration_status" id="registration_status" value="completed" onchange="setRole(this.value)">
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left ">
                                <input type="password" data-match="#password_confirmation" class="form-control form-control-xl" placeholder="Password" name="password" id="password" required data-title="Password">

                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>
                            <small class="form-text text-muted mb-2">Centang kotak di bawah untuk melihat password sebelum disubmit.</small>
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" onclick="togglePassword()" id="showPassword">
                                <label class="form-check-label" for="showPassword">Lihat Password</label>
                            </div>
                            <label for="password">Minimal 8 karakter</label>
                            @error('password')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Ulangi Password" name="password_confirmation" required data-title="Ulangi Password" id="password_confirmation">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Daftar</button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p>Sudah punya akun? <a href="{{ url('/auth/login') }}" class="font-bold"
                                style="color: #0164eb; transition: color 0.3s;" onmouseover="this.style.color='#003366'"
                                onmouseout="this.style.color='#0164eb'">Masuk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function generateRandomNumber() {
            let randomNumber = '';
            for (let i = 0; i < 16; i++) {
                randomNumber += Math.floor(Math.random() * 10);
            }
            return randomNumber;
        }

        $('[name="role"]').on('change', function() {
            let role = $(this).val()

            if(role == 'instance') {
                $('#no_kk_container, #nik_container, #birth_date_container').hide().attr('required', false)
                $('#no_kk').val(generateRandomNumber())
                $('#nik').val(generateRandomNumber())
                $('#birth_date').val('').attr('required', false)
            } else {
                $('#no_kk_container, #nik_container, #birth_date_container').show().attr('required', true)
                $('#no_kk, #nik, #birth_date').val('').attr('required', true)
            }
        });

        $(".flatpickr").flatpickr({
            dateFormat: "Y-m-d",
            maxDate: "today",
            altInput: true,
            altFormat: "d F Y",
            clickOpens: true,
            disableMobile: "true",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember'
                    ]
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                const birthDate = new Date(dateStr);
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
                        progressBar: true
                    });
                    instance.clear();
                    return false;
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


        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "className": "custom-larger-toast"
        };

        $(document).ready(function () {
            @if(session('success'))
                toastr.success("{{ session('success') }}", "Berhasil!");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}", "Gagal!");
            @endif

            @if(session('warning'))
                toastr.warning("{{ session('warning') }}", "Perhatian!");
            @endif

            @if(session('info'))
                toastr.info("{{ session('info') }}", "Informasi");
            @endif

            $('#district-select').on('change', function () {
                const districtId = $(this).val();
                const $villageSelect = $('#village-select');
                $villageSelect.html('<option value="">Pilih Desa</option>');

                if (districtId) {
                    $.ajax({
                        url: "{{ route('get-villages', '') }}/" +
                            districtId,
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (index, village) {
                                $villageSelect.append($('<option>', {
                                    value: village.id,
                                    text: village.name
                                }));
                            });
                            $('#village-select-group').show();
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    $('#village-select-group').hide();
                }
            });
        });

        function setRole(role) {
            document.getElementById('registration_status').value = role === 'user' ? 'completed' : 'process';
            
            // Get DOM elements
            const subCategory = document.getElementById('sub-category');
            const userInput = document.getElementById('perorangan');
            const operatorInput = document.getElementById('instance');
            const instansiInput = document.getElementById('instansi-select-group');

            // Handle display and requirements based on role
            if (role === 'user') {
                // User role settings
                subCategory.style.display = 'none';
                userInput.required = true;
                operatorInput.required = false;
                instansiInput.style.display = 'none';
                
                // Reset instansi input if it exists
                const instansiInputField = instansiInput.querySelector('input[name="instansi"]');
                if (instansiInputField) {
                    instansiInputField.required = false;
                    instansiInputField.value = '';
                }
            } else {
                // Instance role settings
                subCategory.style.display = 'block';
                userInput.required = false;
                operatorInput.required = true;
            }
        }

        document.getElementById('sub-category-select').addEventListener('change', function() {
            const selectedValue = this.value;
            const instansiGroup = document.getElementById('instansi-select-group');
            const instansiInput = instansiGroup.querySelector('input[name="instansi"]');
            
            if (selectedValue === 'Intansi, Yayasan' || 
                selectedValue === 'Intansi, Lembaga' || 
                selectedValue === 'Intansi, Instansi') {
                instansiGroup.style.display = 'block';
                
                // Set placeholder sesuai pilihan
                switch(selectedValue) {
                    case 'Intansi, Yayasan':
                        instansiInput.placeholder = 'Nama Yayasan';
                        break;
                    case 'Intansi, Lembaga':
                        instansiInput.placeholder = 'Nama Lembaga';
                        break;
                    case 'Intansi, Instansi':
                        instansiInput.placeholder = 'Nama Instansi';
                        break;
                }
            } else {
                instansiGroup.style.display = 'none';
                instansiInput.placeholder = 'Nama Instansi';
            }
        });

        function togglePassword() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

    </script>
</body>

</html>