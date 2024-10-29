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
                    <form id="userForm" action="{{ route('admin.manajemen-akun.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <!-- Role selection -->
                                <div class="mb-4">
                                    <div class="form-group">
                                        <label for="sub-category-select">Pilih kategori akun:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="perorangan"
                                                value="user" onclick="setRole('user')" required>
                                            <label class="form-check-label" for="perorangan">Perorangan/Untuk Diri Sendiri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" id="instance"
                                                value="instance" onclick="setRole('instance')" required>
                                            <label class="form-check-label" for="instance">Instansi/Lembaga</label>
                                        </div>
                                        @error('role')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                    
                                <!-- Sub-category selection -->
                                <div id="sub-category" class="form-group mb-4" style="display: none;">
                                    <label for="sub-category-select">Pilih Tipe Registrasi:</label>
                                    <select class="form-control form-control-xl" id="sub-category-select" name="registration_type">
                                        <option value="">Pilih Tipe Registrasi</option>
                                        <!-- Options -->
                                    </select>
                                    @error('registration_type')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- District selection -->
                                <div id="district-select-group" class="form-group mb-4" style="display: none;">
                                    <label for="district-select">Pilih Kecamatan:</label>
                                    <select class="form-control form-control-xl" id="district-select" name="district_id">
                                        <option value="">Pilih Kecamatan</option>
                                        <!-- Options -->
                                    </select>
                                    @error('district_id')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- rt -->
                                <div class="form-group mb-4">
                                    <input type="number" class="form-control form-control-xl" placeholder="RT contoh(01)" name="rt" value="{{ old('rt') }}" required>
                                    @error('rt')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- address -->
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control form-control-xl" placeholder="Alamat" name="address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- Full Name -->
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap" name="full_name" value="{{ old('full_name') }}" required>
                                    @error('full_name')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- No KK -->
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control form-control-xl" placeholder="No Kartu Keluaga" name="no_kk" value="{{ old('no_kk') }}" required>
                                    @error('no_kk')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                    
                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <!-- Village selection -->
                                <div id="village-select-group" class="form-group mb-4" style="display: none;">
                                    <label for="village-select">Pilih Desa:</label>
                                    <select class="form-control form-control-xl" id="village-select" name="village_id">
                                        <!-- Options -->
                                    </select>
                                    @error('village_id')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- rw -->
                                <div class="form-group mb-4">
                                    <input type="number" class="form-control form-control-xl" placeholder="RW contoh(03)" name="rw" value="{{ old('rw') }}" required>
                                    @error('rw')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- NIK -->
                                <div class="form-group mb-4">
                                    <input type="text" class="form-control form-control-xl" placeholder="NIK" name="nik" value="{{ old('nik') }}" required>
                                    @error('nik')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- Tanggal Lahir -->
                                <div class="form-group mb-4">
                                    <input type="date" class="form-control form-control-xl" id="birth_date" placeholder="Pilih Tanggal Lahir" name="birth_date" value="{{ old('birth_date') }}" required>
                                    @error('birth_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- Email -->
                                <div class="form-group mb-4">
                                    <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- Phone Number -->
                                <div class="form-group mb-4">
                                    <input type="tel" class="form-control form-control-xl" placeholder="No. Handphone (Whatsapp)" name="phone_number" value="{{ old('phone_number') }}" required>
                                    @error('phone_number')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                    
                                <!-- Gender -->
                                <div class="form-group mb-4">
                                    <label for="gender-select">Pilih Jenis Kelamin:</label>
                                    <select class="form-control form-control-xl" id="gender-select" name="gender" required>
                                        <option value="Laki-Laki" {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <button class="btn btn-primary w-100 mt-4" type="submit">Tambah Akun</button>
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
    });

    function setRole(role) {
        $('#registration_status').val(role === 'user' ? 'completed' : 'process');
        
        const $subCategory = $('#sub-category');
        const $districtSelect = $('#district-select-group');
        const $villageSelect = $('#village-select-group');
        const $userInput = $('#perorangan');
        const $operatorInput = $('#instance');
        
        if (role === 'instance') {
            $subCategory.show();
            $districtSelect.show();
            $villageSelect.show();
        } else {
            $subCategory.hide();
            $districtSelect.hide();
            $villageSelect.hide();
        }
        
        if (role === 'user') {
            $operatorInput.prop('required', false);
            $userInput.prop('required', true);
        } else {
            $userInput.prop('required', false);
            $operatorInput.prop('required', true);
        }
    }

    function togglePassword() {
        const $passwordInput = $('#password');
        
        $passwordInput.attr('type', 
            $passwordInput.attr('type') === 'password' ? 'text' : 'password'
        );
    }
</script>
@endpush
