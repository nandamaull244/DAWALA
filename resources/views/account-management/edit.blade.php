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
                    <form id="userForm" action="{{ route("admin.manajemen-akun.update", $user->getHashedId()) }}" method="POST" novalidate>
                        @csrf 
                        @method('PUT')
                        
                        <!-- Role selection -->
                        @if ($user->role != 'operator')
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="sub-category-select">Pilih Kategori Akun</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="perorangan" value="user" onclick="setRole('user')" @if($user->role == 'user') checked @endif required>
                                        <label class="form-check-label" for="perorangan">Perorangan/Untuk Diri Sendiri sendiri</label>
                                        @error('role')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="instance" value="instance" onclick="setRole('instance')" @if($user->role == 'instance') checked @endif required>
                                        <label class="form-check-label" for="instance">Instansi/Lembaga</label>
                                        @error('role')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-1 mt-1">
                            <div class="col-md-6">
                                <div class="form-group" id="instance_name_group" style="display: none;">
                                    <label for="instance_name">Nama Intansi</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-md" data-title="Nama Intansi" id="instance_name" name="instance_name" value="{{ optional($user->instance)->name ?? '' }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-card-text"></i>
                                        </div>
                                    </div>
                                    @error('instance_name')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Sub-category selection (hidden by default) -->
                            <div class="col-md-6">
                                <div id="sub-category" class="form-group mb-4" style="display: none;">
                                    <label for="sub-category-select">Pilih Tipe Registrasi</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Tipe Registrasi" id="registration_type" name="registration_type">
                                            <option value="">Pilih Tipe Registrasi</option>
                                            <option value="Intansi, RT" {{ $user->registration_type == 'Intansi, RT' ? 'selected' : '' }}>RT</option>
                                            <option value="Intansi, RW" {{ $user->registration_type == 'Intansi, RW' ? 'selected' : '' }}>RW</option>
                                            <option value="Intansi, Yayasan" {{ $user->registration_type == 'Intansi, Yayasan' ? 'selected' : '' }}>Yayasan</option>
                                            <option value="Intansi, Instansi" {{ $user->registration_type == 'Intansi, Instansi' ? 'selected' : '' }}>Instansi</option>
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
                        </div>
                        
                        <div class="row mb-1 mt-1">
                            <!-- District selection (hidden by default) -->
                            <div class="col-md-6">
                                <div id="district-select-group" class="form-group mb-4" style="display: none;">
                                    <label for="district-select">Pilih Kecamatan</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Kecamatan" id="district-select" name="district_id">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}" {{ $user->district_id == $district->id ? 'selected' : '' }}>
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
                                <div id="village-select-group" class="form-group mb-4" style="display: none;">
                                    <label for="village-select">Pilih Desa</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Desa" id="village-select" name="village_id">
                                            @foreach($villages as $village)
                                                <option value="{{ $village->id }}" {{ $user->village_id == $village->id ? 'selected' : '' }}>
                                                    {{ $village->name }}
                                                </option>
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
                        </div>

                        <div class="row mb-1 mt-1">
                            <!-- NIK -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="nik">NIK</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-md" data-title="NIK" id="nik" name="nik" value="{{ $user->nik ?? '' }}" minlength="16" required>
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
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="no_kk">No KK</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control form-control-md" data-title="No Kartu Keluarga" id="no_kk" name="no_kk" value="{{ $user->no_kk ?? '' }}" minlength="16" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-card-text"></i>
                                        </div>
                                    </div>
                                    @error('no_kk')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1 mt-1">
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                   <label for="full_name">Nama Lengkap</label>
                                   <div class="form-group position-relative has-icon-left mb-4 form-group">
                                       <input type="text" class="form-control form-control-md" data-title="Nama Lengkap" name="full_name" id="full_name" value="{{ $user->full_name ?? '' }}" required>
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
                                        <input type="email" class="form-control form-control-md" data-title="Email" id="email" name="email" value="{{ $user->email ?? '' }}">
                                        <div class="form-control-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1 mt-1">
                            <!-- Birth Date -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="birth_date" class="mb-2">Tanggal Lahir</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="date" class="form-control form-control-md flatpickr-date" data-title="Tanggal Lahir" id="birth_date" placeholder="Pilih Tanggal Lahir" name="birth_date" value="{{ $user->birth_date ?? '' }}" required>
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
                                        <input type="tel" class="form-control form-control-md" data-title="No Handphone (Whatsapp)" id="phone_number" name="phone_number" value="{{ $user->phone_number ?? '' }}" required>
                                        <div class="form-control-icon">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                    </div>
                                    @error('phone_number')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-1 mt-1">
                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="address">Alamat</label>
                                    <div class="form-group position-relative has-icon-left mb-4 form-group">
                                        <input type="text" class="form-control form-control-md" data-title="Alamat" id="address" name="address" value="{{ $user->address ?? '' }}" required>
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
                                               <option selected value="Laki-Laki" {{ $user->gender == 'Laki-Laki' ? 'selected' : '' }}> Laki-Laki</option>
                                               <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}> Perempuan</option>
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
                        </div>

                        <div class="row mb-1 mt-1">
                            <!-- rt -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="rt">RT</label>
                                    <div class="form-group position-relative has-icon-left mb-4 form-group">
                                        <input type="number" class="form-control form-control-md" data-title="RT" id="rt" name="rt" value="{{ $user->rt ?? '' }}" required>
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
                                        <input type="number" class="form-control form-control-md" data-title="RW" id="rw" name="rw" value="{{ $user->rw ?? '' }}" required>
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

                        <input type="hidden" name="registration_status" id="registration_status" value="completed">

                        <!-- Submit Button -->
                        <button class="btn btn-primary float-end" type="submit">Perbarui Data</button>
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

    setRole('{{ $user->role }}')

    function setRole(role) {
        $('#registration_status').val(role === 'user' ? 'completed' : 'process');
        
        const $subCategory = $('#sub-category');
        const $districtSelect = $('#district-select-group');
        const $villageSelect = $('#village-select-group');
        const $userInput = $('#perorangan');
        const $operatorInput = $('#instance');
        const $instance_name = $('#instance_name_group')
        
        if (role === 'instance') {
            $subCategory.show();
            $districtSelect.show();
            $villageSelect.show();
            $instance_name.show()
        } else {
            $subCategory.hide();
            $districtSelect.hide();
            $villageSelect.hide();
            $instance_name.hide()
        }
        
        if (role === 'user') {
            $operatorInput.prop('required', false);
            $userInput.prop('required', true);
            $('#instance_name').prop('required', false);
            $('#registration_type').prop('required', false);
            $('#district-select').prop('required', false);
            $('#village-select').prop('required', false);
        } else {
            $userInput.prop('required', false);
            $operatorInput.prop('required', true);
            $('#instance_name').prop('required', true);
            $('#registration_type').prop('required', true);
            $('#district-select').prop('required', true);
            $('#village-select').prop('required', true);
        }
    }

    function togglePassword() {
        const $passwordInput = $('#password');
        
        $passwordInput.attr('type', 
            $passwordInput.attr('type') === 'password' ? 'text' : 'password'
        );
    }

    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        var isValid = true;

        $(this).find('input, select, textarea').each(function() {
            var $field = $(this);
            var fieldName = $field.data('title') || 'Field';

            if ($field.prop('required') && !$field.val()) {
                isValid = false;
                toastr.warning(fieldName + ' harus diisi', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
            }

            var maxLength = $field.attr('maxlength');
            if (maxLength && $field.val().length > maxLength) {
                isValid = false;
                toastr.warning(fieldName + ' tidak boleh lebih dari ' + maxLength + ' karakter', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
            }

            var minLength = $field.attr('minlength');
            if (minLength && $field.val().length < minLength) {
                isValid = false;
                toastr.warning(fieldName + ' harus memiliki setidaknya ' + minLength + ' karakter', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
            }
        });

        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        if (password && confirmPassword && password !== confirmPassword) {
            isValid = false;
            toastr.warning('Password dan Konfirmasi Password tidak cocok!', 'Peringatan', {timeOut: 2500, "className": "custom-larger-toast"});
        }

        if (isValid) {
            this.submit();
        }
    });
</script>
@endpush
