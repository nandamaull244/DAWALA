@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah User</h1>
    <form id="userForm" action="{{ route("admin.admin.user.store") }}" method="POST">
        @csrf
        
        <!-- Role selection -->
        <div class="mb-4">
            <div class="form-group">
                <label for="sub-category-select">Pilih kategori akun:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="perorangan"
                        value="user" onclick="setRole('user')" required>
                    <label class="form-check-label" for="perorangan">Perorangan/Untuk Diri Sendiri sendiri</label>
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

        <!-- Sub-category selection (hidden by default) -->
        <div id="sub-category" class="form-group mb-4" style="display: none;">
            <label for="sub-category-select">Pilih Tipe Registrasi:</label>
            <div class="position-relative">
                <select class="form-control form-control-xl" id="sub-category-select" name="registration_type">
                    <option value="">Pilih Tipe Registrasi</option>
                    <option value="Intansi, RT" {{ old('registration_type') == 'Intansi, RT' ? 'selected' : '' }}>RT</option>
                    <option value="Intansi, RW" {{ old('registration_type') == 'Intansi, RW' ? 'selected' : '' }}>RW</option>
                    <option value="Intansi, Yayasan" {{ old('registration_type') == 'Intansi, Yayasan' ? 'selected' : '' }}>Yayasan</option>
                    <option value="Intansi, Instansi" {{ old('registration_type') == 'Intansi, Instansi' ? 'selected' : '' }}>Instansi</option>
                </select>
                @error('registration_type')
                    <span>{{ $message }}</span>
                @enderror
                <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                    <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <!-- District selection (hidden by default) -->
        <div id="district-select-group" class="form-group mb-4" style="display: none;">
            <label for="district-select">Pilih Kecamatan:</label>
            <div class="position-relative">
                <select class="form-control form-control-xl" id="district-select" name="district_id">
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

        <!-- Village selection (hidden by default) -->
        <div id="village-select-group" class="form-group mb-4" style="display: none;">
            <label for="village-select">Pilih Desa:</label>
            <div class="position-relative">
                <select class="form-control form-control-xl" id="village-select" name="village_id">
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

        <!-- rt -->
        <div class="mb-4">
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="number" class="form-control form-control-xl"
                    placeholder="RT contoh(01)" name="rt" value="{{ old('rt') }}"
                    required>
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
                <input type="number" class="form-control form-control-xl"
                    placeholder="RW contoh(03)" name="rw" value="{{ old('rw') }}"
                    required>
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
                <input type="text" class="form-control form-control-xl"
                    placeholder="Alamat" name="address" value="{{ old('address') }}"
                    required>
                <div class="form-control-icon">
                    <i class="bi bi-house"></i>
                </div>
            </div>
            @error('address')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- Full Name -->
        <div class="mb-4">
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="text" class="form-control form-control-xl"
                    placeholder="Nama Lengkap" name="full_name" value="{{ old('full_name') }}"
                    required>
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            @error('full_name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- NIK -->
        <div class="mb-4">
            <div class="form-group position-relative has-icon-left">
                <input type="text" class="form-control form-control-xl" placeholder="NIK"
                    name="nik" value="{{ old('nik') }}" required>
                <div class="form-control-icon">
                    <i class="bi bi-card-text"></i>
                </div>
            </div>
            @error('nik')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- No KK -->
        <div class="mb-4">
            <div class="form-group position-relative has-icon-left">
                <input type="text" class="form-control form-control-xl"
                    placeholder="No Kartu Keluaga" name="no_kk" value="{{ old('no_kk') }}"
                    required>
                <div class="form-control-icon">
                    <i class="bi bi-card-text"></i>
                </div>
            </div>
            @error('no_kk')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- Birth Date -->
        <div class="mb-4">
            <label for="birth_date" class="mb-2">Tanggal Lahir</label>
            <div class="form-group position-relative has-icon-left">
                <input type="date" class="form-control form-control-xl"
                    id="birth_date" placeholder="Pilih Tanggal Lahir" name="birth_date"
                    value="{{ old('birth_date') }}" required>
                <div class="form-control-icon">
                    <i class="bi bi-calendar"></i>
                </div>
            </div>
            @error('birth_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
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

        <!-- Phone Number -->
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

        <!-- Gender -->
        <div class="mb-4">
            <label for="gender-select" class="mb-2">Pilih Jenis Kelamin:</label>
            <div class="form-group ">
                <div class="position-relative">
                    <select class="form-control form-control-xl" id="gender-select"
                        name="gender" required>
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

        <input type="hidden" name="registration_status" id="registration_status" value="completed">

        <!-- Password -->
        <div class="mb-4">
            <div class="form-group position-relative has-icon-left ">
                <input type="password" class="form-control form-control-xl"
                    placeholder="Password" name="password" id="password" required>
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
            <label for="password">Minimal 8 karakter</label>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!-- Password Confirmation -->
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl"
                placeholder="Ulangi Password" name="password_confirmation" required>
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>

        <!-- Submit Button -->
        <button class="btn btn-primary"
            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
            onmouseover="this.style.backgroundColor='#003366'"
            onmouseout="this.style.backgroundColor='#0164eb'" type="submit">Tambah Akun</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
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
        }
    });

    $(document).ready(function() {
        // ... (toastr options and session messages) ...

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
    });

    function setRole(role) {
        document.getElementById('registration_status').value = role === 'user' ? 'completed' : 'process';
        const subCategory = document.getElementById('sub-category');
        const districtSelect = document.getElementById('district-select-group');
        const villageSelect = document.getElementById('village-select-group');

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

    document.querySelector('form').addEventListener('submit', function(event) {
        // ... (form validation logic) ...
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
@endpush
