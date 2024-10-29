<div class="modal fade" id="dataModalEditUser" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                   
                    <input type="hidden" id="userId" name="user_id">
                    <!-- Sub-category selection (hidden by default) -->
                  <div id="sub-category" class="form-group mb-4" style="display: none;">
                        <label for="sub-category-select">Tipe Registrasi:</label>
                        <div class="position-relative">
                            <select class="form-control form-control-xl" id="sub-category-select" name="registration_type">
                                
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
                    <div id="district-select-group" class="form-group mb-4">
                        <label for="district-select">Kecamatan:</label>
                        <div class="position-relative">
                            <select class="form-control form-control-xl" id="district-select" name="district_id">
                               
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
                    <div id="village-select-group" class="form-group mb-4">
                        <label for="village-select">Desa:</label>
                        <div class="position-relative">
                            <select class="form-control form-control-xl" id="village-select" name="village_id">
                                @foreach ($villages as $village)
                                    <option value="{{ $village->id }}" {{ old('village_id') == $village->id ? 'selected' : '' }}>
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
                                value="{{ old('birth_date') }}" required >
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
            
                    {{-- <input type="hidden" name="registration_status" id="registration_status" value="completed"> --}}
            
            
                  
                </form>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script>
    function saveChanges() {
        var formData = $('#userForm').serialize();
        var userId = $('#userId').val();
        var url = '/admin/akun-manajemen/' + userId;

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#dataModalEditUser').modal('hide');
                $('#usersTable').DataTable().ajax.reload();
                toastr.success('Data berhasil diperbarui');
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    toastr.error(errors[key][0]);
                }
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    });

    function setRole(role) {
        document.getElementById('registration_status').value = role === 'user' ? 'completed' : 'process';
        const subCategory = document.getElementById('sub-category');
        const districtSelect = document.getElementById('district-select-group');
        const villageSelect = document.getElementById('village-select-group');

        if (role === 'instance') {
            subCategory.style.display = 'block';
            districtSelect.style.display = 'block';
            villageSelect.style.display = 'block';
        } else {
            subCategory.style.display = 'none';
            districtSelect.style.display = 'none';
            villageSelect.style.display = 'none';
        }

        const userInput = document.getElementById('perorangan');
        const operatorInput = document.getElementById('instance');
        if (role === 'user') {
            operatorInput.required = false;
            userInput.required = true;
        } else {
            userInput.required = false;
            operatorInput.required = true;
        }
    }


   

    function openEditModal(userData) {
        // Set the form action URL
        const form = document.getElementById('userForm');
        form.action = `/admin/admin/user/${userData.id}`;
        
        // Set user ID
        document.getElementById('userId').value = userData.id;
        
        // Populate form fields
        if(userData.role == 'instance'){
            document.getElementById('sub-category').style.display = 'block';
            
            document.querySelector('select[name="registration_type"]').value = userData.registration_type;
        } else {
            document.getElementById('sub-category').style.display = 'none';
            document.getElementById('district-select-group').style.display = 'none'; 
            document.getElementById('village-select-group').style.display = 'none';
        }
        document.querySelector('input[name="rt"]').value = userData.rt;
        document.querySelector('input[name="rw"]').value = userData.rw;
        document.querySelector('input[name="address"]').value = userData.address;
        document.querySelector('input[name="full_name"]').value = userData.full_name;
        document.querySelector('input[name="nik"]').value = userData.nik;
        document.querySelector('input[name="no_kk"]').value = userData.no_kk;
        document.querySelector('input[name="birth_date"]').value = userData.birth_date;
        document.querySelector('input[name="email"]').value = userData.email;
        document.querySelector('input[name="phone_number"]').value = userData.phone_number;
        document.querySelector('select[name="gender"]').value = userData.gender;
        
        // If you have district and village selects
        if (userData.district_id) {
            const districtSelect = document.querySelector('select[name="district_id"]');
            districtSelect.value = userData.district_id;
            
            // Get villages for selected district via AJAX
            fetch(`/api/districts/${userData.district_id}/villages`)
                .then(response => response.json())
                .then(villages => {
                    const villageSelect = document.querySelector('select[name="village_id"]');
                    villageSelect.innerHTML = ''; // Clear existing options
                    
                    villages.forEach(village => {
                        const option = document.createElement('option');
                        option.value = village.id;
                        option.textContent = village.name;
                        if (userData.village_id == village.id) {
                            option.selected = true;
                        }
                        villageSelect.appendChild(option);
                    });
                });
        }
        
        // Show the modal
        $('#dataModalEditUser').modal('show');
    }
</script>


