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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush

@section('page-heading')
Akun Manajemen
@endsection

@section('page-subheading')
Data Seluruh Akun
@endsection

@section('content')
<section class="section">
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="filter-container">
                        <div class="filter-item">
                            <label for="role">ROLE</label>
                            <select id="role" name="role">
                                <option value="">Semua</option>
                                <option value="user">User</option>
                                <option value="admin">Operator</option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label for="registration_type">TIPE REGISTRASI</label>
                            <select id="registration_type" name="registration_type">
                                <option value="">Semua</option>
                                <option value="Intansi, RT">RT</option>
                                <option value="Intansi, RW">RW</option>
                                <option value="Intansi, Yayasan">Yayasan</option>
                                <option value="Intansi, Instansi">Instansi</option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label for="status">STATUS</label>
                            <select id="status" name="status">
                                <option value="">Semua</option>
                                <option value="completed">Completed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label for="district_id">KECAMATAN</label>
                            <select id="district_id" name="district_id">
                                <option value="">Semua</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-item">
                            <label for="village_id">DESA</label>
                            <select id="village_id" name="village_id">
                                <option value="">Semua</option>
                                @foreach($villages as $village)
                                    <option value="{{ $village->id }}">{{ $village->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="reset-filter" onclick="resetFilters()">Reset Filter</button>
                        <a href="{{ route('admin.akun-manajemen.create') }}"
                            class="btn btn-primary add-new-btn">
                            <i class="bi bi-plus-circle"></i> Tambah Akun
                        </a>

                    </div>

                    <div class="table-responsive">
                        <table id="usersTable" class="table">
                            <thead>
                                <tr>
                                    <th nowrap>No</th>
                                    <th nowrap>NIK</th>
                                    <th nowrap>No KK</th>
                                    <th nowrap>Username</th>
                                    <th nowrap>Email</th>
                                    <th nowrap>No HP</th>
                                    <th nowrap>Nama Lengkap</th>
                                    <th nowrap>Tanggal Lahir</th>
                                    <th nowrap>Gender</th>
                                    <th nowrap>Alamat</th>
                                    <th nowrap>RT</th>
                                    <th nowrap>RW</th>
                                    <th nowrap>Kecamatan</th>
                                    <th nowrap>Desa</th>
                                    <th nowrap>Role</th>
                                    <th nowrap>Registration Type</th>
                                    <th nowrap>Status</th>
                                    <th nowrap>Action</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('akun-manajemen.modal_edit_akun')
@include('akun-manajemen.delete_modal_akun')
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            let table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("admin.admin.user.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.role = $('#role').val();
                        d.registration_type = $('#registration_type').val();
                        d.status = $('#status').val();
                        d.district_id = $('#district_id').val();
                        d.village_id = $('#village_id').val();
                    },
                    error: function (xhr, error, thrown) {
                        console.error('Data Tables error:', error);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'birth_date',
                        name: 'birth_date'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'rt',
                        name: 'rt'
                    },
                    {
                        data: 'rw',
                        name: 'rw'
                    },
                    {
                        data: 'district_name',
                        name: 'district.name'
                    },
                    {
                        data: 'village_name',
                        name: 'village.name'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'registration_type',
                        name: 'registration_type'
                    },
                    {
                        data: 'registration_status',
                        name: 'registration_status',
                        render: function (data) {
                            if (data === 'Process') {
                                return '<span class="badge bg-primary">' + data + '</span>';
                            } else if (data === 'Rejected') {
                                return '<span class="badge bg-danger">' + data + '</span>';
                            } else if (data === 'Completed') {
                                return '<span class="badge bg-success">' + data + '</span>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                order: [
                    [0, 'desc']
                ]
            });

            // Add change event listeners to all filters
            $('#role, #registration_type, #status, #district_id, #village_id').change(function () {
                table.draw();
            });

            // Fungsi reset filter
            window.resetFilters = function () {
                $('#role').val('');
                $('#registration_type').val('');
                $('#status').val('');
                $('#district_id').val('');
                $('#village_id').val('');
                table.draw();
            };
        });

    </script>
@endpush
