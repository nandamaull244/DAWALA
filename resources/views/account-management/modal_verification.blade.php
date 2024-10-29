<div class="modal fade" id="dataModalVerif" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Verifikasi Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="" method="POST">
                    @csrf

                    <!-- Role selection -->
                    <div class="mb-4">
                        <div class="form-group">
                            <label for="sub-category-select">Kategori Akun:</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="instance"
                                    value="instance" onclick="setRole('instance')" required>
                                <label class="form-check-label" for="instance">Instansi/Lembaga</label>
                                @error('role')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sub-category selection (hidden by default) -->
                    <div id="sub-category" class="form-group mb-4">
                        <label for="sub-category-select">Tipe Registrasi:</label>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-xl" id="sub-category-select"
                                name="registration_type"
                                value="{{ $registration_type ?? '' }}" readonly>
                        </div>
                    </div>

                    <!-- District selection (hidden by default) -->
                    <div id="district-select-group" class="form-group mb-4">
                        <label for="district-select">Kecamatan:</label>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-xl" id="district-select"
                                name="district_id" value="{{ $district_name ?? '' }}"
                                readonly>
                        </div>
                    </div>

                    <!-- Village selection (hidden by default) -->
                    <div id="village-select-group" class="form-group mb-4">
                        <label for="village-select">Desa:</label>
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-xl" id="village-select"
                                name="village_id" value="{{ $village_name ?? '' }}"
                                readonly>
                        </div>
                    </div>

                    <!-- Full Name -->
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

                    <!-- NIK -->
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

                    <!-- No KK -->
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

                    <!-- Birth Date -->
                    <div class="mb-4">
                        <label for="birth_date" class="mb-2">Tanggal Lahir</label>
                        <div class="form-group position-relative has-icon-left">
                            <input type="date" class="form-control form-control-xl" id="birth_date"
                                placeholder="Tanggal Lahir" name="birth_date"
                                value="{{ old('birth_date') }}" required>
                            <div class="form-control-icon">
                                <i class="bi bi-calendar"></i>
                            </div>
                        </div>
                        @error('birth_date')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <div class="form-group position-relative has-icon-left">
                            <input type="email" class="form-control form-control-xl" placeholder="Email" name="email"
                                value="{{ old('email') }}" required>
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
                        <label for="gender-select" class="mb-2">Jenis Kelamin:</label>
                        <div class="form-group ">
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="gender-select" name="gender" required>
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
                </form>
            </div>
            <div class="modal-footer">

                <!-- Verification Button -->
                <button type="button" class="btn btn-success"
                    style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                    onmouseover="this.style.backgroundColor='#218838'" onmouseout="this.style.backgroundColor='#28a745'"
                    onclick="verifyUser()">Verifikasi</button>
            </div>
        </div>
    </div>
</div>
<script>
    function saveChanges() {
        $('#dataModalVerif').modal('hide');
    }

</script>
<script>
    function verifyUser() {
        // Get form data
        const form = document.getElementById('userForm');
        const formData = new FormData(form);

        // Send AJAX request
        fetch('/verify-user', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User verified successfully');
                    // Optionally, close the modal or refresh the page
                    $('#dataModalVerif').modal('hide');
                    location.reload();
                } else {
                    alert('Verification failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during verification');
            });
    }

</script>
