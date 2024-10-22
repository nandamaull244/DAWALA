@extends('layouts.main')

@push('css')
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }

        .completed {
            background-color: #e6fff2;
            color: #00cc66;
        }

        .processing {
            background-color: #e6e6ff;
            color: #6666ff;
        }

        .rejected {
            background-color: #ffe6e6;
            color: #ff6666;
        }

        .action-icons {
            display: flex;
            gap: 10px;
        }

        .action-icons span {
            cursor: pointer;
        }

        /* FILTER */
        .filter-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-item select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .reset-filter {
            align-self: flex-end;
            padding: 8px 16px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* BUTTON */
        .add-new-btn {
            margin-left: auto;
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .add-new-btn {
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
        }

        .bi-plus-circle {
            margin-right: 5px;
        }
    </style>
@endpush

@section('page-heading')
    Verifikasi Akun
@endsection

@section('page-subheading')
    Verifikasi akun yang telah terdaftar (instansi, yayasan, rt, rw)
@endsection

@section('content')
    <section class="section">
       <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="filter-container">
                    
                        <div class="filter-item">
                            <label for="registration_type">TIPE REGISTRASI</label>
                            <select id="registration_type" name="registration_type">
                                <option value="">Semua</option>
                                <option value="RT">RT</option>
                                <option value="RW">RW</option>
                                <option value="YAYASAN">YAYASAN</option>
                                <!-- Add more service types as needed -->
                            </select>
                        </div>
                        
                        <div class="filter-item">
                            <label for="kecamatan">KECAMATAN</label>
                            <select id="kecamatan" name="kecamatan">
                                <option value="">Semua</option>
                                <!-- Add more kecamatan options here -->
                            </select>
                        </div>
                        <div class="filter-item">
                            <label for="desa">DESA</label>
                            <select id="desa" name="desa">
                                <option value="">Semua</option>
                                <!-- Add more desa options here -->
                            </select>
                        </div>
                        <button class="reset-filter" onclick="resetFilters()">Reset Filter</button>
                        

                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NIK</th>
                                    <th>NO KK</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>NO HP</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>TANGGAL LAHIR</th>
                                    <th>GENDER</th>
                                    <th>ALAMAT</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th>KECAMATAN</th>
                                    <th>DESA</th>
                                    <th>ROLE</th>
                                    <th>REGISTRATION TYPE</th>
                                    <th>STATUS</th>
                                    <th>Action</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>3275021234567890</td>
                                    <td>3275021234567890</td>
                                    <td>johndoe</td>
                                    <td>johndoe@example.com</td>
                                    <td>081234567890</td>
                                    <td>John Doe</td>
                                    <td>1990-01-01</td>
                                    <td>Laki-laki</td>
                                    <td>Jl. Contoh No. 123</td>
                                    <td>001</td>
                                    <td>002</td>
                                    <td>Kecamatan A</td>
                                    <td>Desa B</td>
                                    <td>Instansi</td>
                                    <td>RT</td>
                                    <td><span class="status completed">Completed</span></td>
                                    <td class="sticky-column action-icons">
                                        <span data-bs-toggle="modal" data-bs-target="#dataModalVerif"
                                            style="cursor: pointer;">✏️</span>
                                        <span data-bs-toggle="modal" data-bs-target="#deleteModalVerif"
                                            style="cursor: pointer;">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>3275021234567891</td>
                                    <td>3275021234567891</td>
                                    <td>janedoe</td>
                                    <td>janedoe@example.com</td>
                                    <td>081234567891</td>
                                    <td>Jane Doe</td>
                                    <td>1992-05-15</td>
                                    <td>Perempuan</td>
                                    <td>Jl. Contoh No. 456</td>
                                    <td>003</td>
                                    <td>004</td>
                                    <td>Kecamatan C</td>
                                    <td>Desa D</td>
                                    <td>Instansi</td>
                                    <td>RW</td>
                                    <td><span class="status processing">Processing</span></td>
                                    <td class="sticky-column action-icons">
                                        <span data-bs-toggle="modal" data-bs-target="#dataModalVerif"
                                            style="cursor: pointer;">✏️</span>
                                        <span data-bs-toggle="modal" data-bs-target="#deleteModalVerif"
                                            style="cursor: pointer;">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>3275021234567892</td>
                                    <td>3275021234567892</td>
                                    <td>bobsmith</td>
                                    <td>bobsmith@example.com</td>
                                    <td>081234567892</td>
                                    <td>Bob Smith</td>
                                    <td>1988-11-30</td>
                                    <td>Laki-laki</td>
                                    <td>Jl. Contoh No. 789</td>
                                    <td>005</td>
                                    <td>006</td>
                                    <td>Kecamatan E</td>
                                    <td>Desa F</td>
                                    <td>Instansi</td>
                                    <td>YAYASAN</td>
                                    <td><span class="status rejected">Rejected</span></td>
                                    <td class="sticky-column action-icons">
                                        <span data-bs-toggle="modal" data-bs-target="#dataModalVerif"
                                            style="cursor: pointer;">✏️</span>
                                        <span data-bs-toggle="modal" data-bs-target="#deleteModalVerif"
                                            style="cursor: pointer;">🗑️</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </section>


   @include('akun-manajemen.modal_verification')
   @include('akun-manajemen.delete_modal_verif')
@endsection

@push('scripts')
 
@endpush
