@extends('layouts.main')

@section('page-heading')
Tambah Akun Operator
@endsection

@section('page-subheading')
Formulir Registrasi Akun Operator
@endsection

@section('content')
<section class="section">
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form id="userForm" action="{{ route("admin.manajemen-akun.store") }}" method="POST" novalidate>
                        @csrf
                        <div class="row mb-1 mt-1">
                            <!-- Sub-category selection (hidden by default) -->
                            <div class="col-md-6">
                                <div id="sub-category" class="form-group mb-4" hidden>
                                    <label for="sub-category-select" hidden>Pilih Tipe Registrasi</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-md" name="registration_type" value="operator" hidden>
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
                            <!-- District selection -->
                            <div class="col-md-6">
                                <div id="district-select-group" class="form-group mb-4">
                                    <label for="district-select">Pilih Kecamatan</label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-md" data-title="Kecamatan" id="district-select" name="district_id" required>
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" style="display: none;">
                                            Kecamatan ini sudah memiliki operator
                                        </div>
                                        @error('district_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                            <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                   <label for="username">Username</label>
                                   <div class="form-group position-relative has-icon-left mb-4 form-group">
                                       <input type="text" class="form-control form-control-md" data-title="Username" name="username" id="username" value="{{ old('username') }}" required>
                                       <div class="form-control-icon">
                                           <i class="bi bi-person"></i>
                                       </div>
                                   </div>
                                   @error('username')
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
                        </div>

                        <div class="row mb-1 mt-1">
                            <!-- Birth Date -->
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="birth_date" class="mb-2">Tanggal Lahir</label>
                                    <div class="form-group position-relative has-icon-left">
                                        <input type="date" class="form-control form-control-md flatpickr-date" data-title="Tanggal Lahir" id="birth_date" placeholder="Pilih Tanggal Lahir" name="birth_date" value="birth_date" hidden>
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
                                        <input type="tel" class="form-control form-control-md" data-title="No Handphone (Whatsapp)" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
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
                                           <select class="form-control form-control-md" data-title="Jenis Kelamin" id="gender-select" name="gender">
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
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="registration_status" id="registration_status" value="Completed">
                        <input type="hidden" class="form-control form-control-md" data-title="RT" id="rt" name="rt" value="000" >
                        <input type="hidden" class="form-control form-control-md" data-title="RW" id="rw" name="rw" value="000" >
                        <input type="hidden" class="form-control form-control-md" data-title="NIK" id="nik" name="nik" value="1234567890123456" >
                        <input type="hidden" class="form-control form-control-md" data-title="No Kartu Keluarga" id="no_kk" name="no_kk" value="1234567890123456" >
                        <input type="hidden" class="form-control form-control-md"   name="role" value="operator" >
                        <input type="hidden" class="form-control form-control-md"   name="registration_type" value="Operator" >
                        <input type="hidden" class="form-control form-control-md"   name="village_id" value="3203062008" >
            
                        
                        <div class="row mb-1 mt-1">
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


                        <!-- Submit Button -->
                        <button class="btn btn-primary float-end" type="submit">Tambah Akun Operator</button>
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
        const $districtSelect = $('#district-select');
        const $submitButton = $('button[type="submit"]');
        const $invalidFeedback = $districtSelect.siblings('.invalid-feedback');

        $districtSelect.on('change', function() {
            const districtId = $(this).val();
            
            // Reset validation state
            $districtSelect.removeClass('is-invalid');
            $invalidFeedback.hide();
            $submitButton.prop('disabled', false);

            if (!districtId) {
                return;
            }

            // Check district availability
            $.ajax({
                url: "{{ route('admin.check-district-availability') }}",
                method: 'POST',
                data: {
                    district_id: districtId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (!response.available) {
                        // Show error state
                        $districtSelect.addClass('is-invalid');
                        $invalidFeedback.text(response.message).show();
                        $districtSelect.val('');
                        $submitButton.prop('disabled', true);
                        toastr.error(response.message, 'Kecamatan Tidak Tersedia');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('Terjadi kesalahan saat memeriksa ketersediaan kecamatan', 'Error');
                }
            });
        });

        $('#showPassword').on('change', function() {
            const $passwordInput = $('#password');
            $passwordInput.attr('type', $(this).prop('checked') ? 'text' : 'password');
        });

      
 
    });


    function togglePassword() {
        const $passwordInput = $('#password');
        
        $passwordInput.attr('type', 
            $passwordInput.attr('type') === 'password' ? 'text' : 'password'
        );
    }

    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        var isValid = true;

        $(this).find('input:not([type="hidden"]), select:not([type="hidden"]), textarea:not([type="hidden"])').each(function() {
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
