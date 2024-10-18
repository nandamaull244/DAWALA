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
</head>

<body>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div id="auth">
        <div class="row h-100 justify-content-center align-items-center my-5 mb-5">
            <!-- Added margin top and bottom -->
            <div class="col-lg-8 col-6">
                <div id="auth-left">
                    <h4 class="auth-title text-center">Registrasi Akun</h4>
                    <p class="auth-subtitle mb-5 text-center">Buat akun untuk urusan pelayanan</p>

                    <form action="{{ route('register.process') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <div class="form-group">
                                <label for="sub-category-select">Pilih kategori akun:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="perorangan"
                                        value="user" onclick="setRole('user')" required>
                                    <label class="form-check-label" for="perorangan">Perorangan/Untuk Diri Sendiri
                                        sendiri</label>
                                    @error('role')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="instantiation"
                                        value="instantiation" onclick="setRole('instantiation')" required>
                                    <label class="form-check-label" for="instantiation">Instansi/Lembaga</label>
                                    @error('role')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div id="sub-category" class="form-group mb-4" style="display: none;">
                            <label for="sub-category-select">Pilih Tipe Registrasi:</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="sub-category-select"
                                    name="registration_type">
                                    <option value="">Pilih Tipe Registrasi</option>
                                    <option value="Collector, RT"
                                        {{ old('registration_type') == 'Collector, RT' ? 'selected' : '' }}>
                                        RT</option>
                                    <option value="Collector, RW"
                                        {{ old('registration_type') == 'Collector, RW' ? 'selected' : '' }}>
                                        RW</option>
                                    <option value="Collector, Yayasan"
                                        {{ old('registration_type') == 'Collector, Yayasan' ? 'selected' : '' }}>
                                        Yayasan</option>
                                    <option value="Collector, Instansi"
                                        {{ old('registration_type') == 'Collector, Instansi' ? 'selected' : '' }}>
                                        Instansi</option>
                                </select>
                                @error('registration_type')
                                    <span>{{ $message }}</span>
                                @enderror
                                <div class="form-control-icon"
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <i class="bi bi-chevron-down"
                                        style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div id="district-select-group" class="form-group mb-4" style="display: none;">
                            <label for="district-select">Pilih Kecamatan:</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="district-select" name="district_id">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
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
                        <div id="village-select-group" class="form-group mb-4" style="display: none;">
                            <label for="village-select">Pilih Desa:</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="village-select"
                                    name="village_id">
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
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap"
                                    name="full_name" value="{{ old('full_name') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            @error('full_name')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-xl" placeholder="NIK" name="nik"
                                    value="{{ old('nik') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-card-text"></i>
                                </div>
                            </div>
                            @error('nik')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-xl" placeholder="No Kartu Keluaga"
                                    name="no_kk" value="{{ old('no_kk') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-card-text"></i>
                                </div>
                            </div>
                            @error('no_kk')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="tanggal" class="mb-2">Tanggal Lahir</label>
                            <div class="form-group position-relative has-icon-left">
                                <input type="date" class="form-control form-control-xl" placeholder="Tanggal Lahir"
                                    name="birth_date" value="{{ old('birth_date') }}" required>
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
                                <input type="email" class="form-control form-control-xl" placeholder="Email"
                                    name="email" value="{{ old('email') }}" required>
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
                                <input type="tel" class="form-control form-control-xl"
                                    placeholder="No. Handphone (Whatsapp)" name="phone_number"
                                    value="{{ old('phone_number') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                            </div>
                            @error('phone_number')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gender-select" class="mb-2">Pilih Jenis Kelamin:</label>
                            <div class="form-group ">

                                <div class="position-relative">
                                    <select class="form-control form-control-xl" id="gender-select" name="gender"
                                        required>
                                        <option value="Laki-Laki"
                                            {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki</option>
                                        <option value="Perempuan"
                                            {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    <div class="form-control-icon"
                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                        <i class="bi bi-chevron-down"
                                            style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>



                        <input type="hidden" name="registration_status" id="registration_status" value="completed"
                            onchange="setRole(this.value)">
                        <div class="mb-4">
                            <div class="form-group position-relative has-icon-left ">
                                <input type="password" class="form-control form-control-xl" placeholder="Password"
                                    name="password" id="password" required>

                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>

                            </div>
                            <small class="form-text text-muted mb-2">Centang kotak di bawah untuk melihat password sebelum
                                disubmit.</small>
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" onclick="togglePassword()"
                                    id="showPassword">
                                <label class="form-check-label" for="showPassword">Lihat Password</label>
                            </div>
                            <label for="password">Minimal 8 karakter</label>
                            @error('password')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>




                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Ulangi Password"
                                name="password_confirmation" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>



                        <button class="btn btn-primary"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Daftar</button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p>Sudah punya akun? <a href="{{ url('/login') }}" class="font-bold"
                                style="color: #0164eb; transition: color 0.3s;" onmouseover="this.style.color='#003366'"
                                onmouseout="this.style.color='#0164eb'">Masuk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setRole(role) {
            document.getElementById('registration_status').value = role === 'user' ? 'completed' : 'process';
            const subCategory = document.getElementById('sub-category');
            const districtSelect = document.getElementById('district-select').closest('.form-group');
            const villageSelect = document.getElementById('village-select').closest('.form-group');
            
            if (role === 'instantiation') {
                subCategory.style.display = 'block';
                districtSelect.style.display = 'block';
                villageSelect.style.display = 'block';
            } else {
                subCategory.style.display = 'none';
                districtSelect.style.display = 'none';
                villageSelect.style.display = 'none';
            }
            
            const userInput = document.getElementById('perorangan');
            const operatorInput = document.getElementById('instantiation');
            if (role === 'user') {
                operatorInput.required = false;
                userInput.required = true;
            } else {
                userInput.required = false;
                operatorInput.required = true;
            }
        }


        document.querySelector('form').addEventListener('submit', function (event) {
            const passwordInput = document.querySelector('input[name="password"]');
            const passwordConfirmationInput = document.querySelector('input[name="password_confirmation"]');
            const allInputs = document.querySelectorAll('input[required]');
            let isValid = true;

            allInputs.forEach(input => {
                if (!input.value) {
                    input.classList.add('is-invalid');
                    input.setCustomValidity('wajib diisi');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.setCustomValidity('');
                }
            });

            const password = passwordInput.value;
            const passwordConfirmation = passwordConfirmationInput.value;
            if (password !== passwordConfirmation) {
                event.preventDefault();
                passwordInput.classList.add('is-invalid');
                passwordConfirmationInput.classList.add('is-invalid');
                passwordConfirmationInput.setCustomValidity('konfirmasi password tidak cocok!');
                passwordConfirmationInput.reportValidity();
                isValid = false;
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordConfirmationInput.classList.remove('is-invalid');
                passwordConfirmationInput.setCustomValidity('');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });


        setTimeout(function () {
            var alert = document.getElementById('error-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(function () {
                    alert.remove();
                }, 150); // Delay for fade out effect
            }
        }, 2000); // 2 seconds


        function togglePassword() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        document.getElementById('district-select').addEventListener('change', function() {
            const districtId = this.value;
            const villageSelect = document.getElementById('village-select');
            villageSelect.innerHTML = '<option value="">Pilih Desa</option>';

            if (districtId) {
                fetch(`/api/villages/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(village => {
                            const option = document.createElement('option');
                            option.value = village.id;
                            option.textContent = village.name;
                            villageSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

    </script>

</body>


</html>
