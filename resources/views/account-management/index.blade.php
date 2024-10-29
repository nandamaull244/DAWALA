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

        #userTable {
            table-layout: auto;
            width: 100%;
        }

        #fixed-controls {
            position: fixed;
            top: 70px; /* Sesuaikan dengan header Anda */
            right: 20px;
            z-index: 1000;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .table-container {
            position: relative;
            margin-top: 30px;
            padding-top: 50px; 
            padding-bottom: 50px;
        }

        #search-container {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            z-index: 1000;
        }

        #pagination-container {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 10px;
            z-index: 1000;
        }

        .dataTables_filter input {
            width: 200px !important;
        }

        .dataTables_paginate .pagination {
            margin-bottom: 0;
        }

        .card-body {
            padding-right: 250px; /* Sesuaikan dengan lebar fixed controls */
        }

        @media (max-width: 768px) {
            #fixed-controls, #pagination-container {
                position: static;
                margin-bottom: 20px;
            }

            .card-body {
                padding-right: 15px;
            }

            .table-container {
                padding-top: 0;
                padding-bottom: 0;
            }

            #search-container, #pagination-container {
                position: static;
                margin-bottom: 10px;
            }
        }
    </style>
    <style>
        #userTable_length {
            margin-top: -40px !important;
        }

        #userTable_length select {
            width: 70px !important; 
            height: 35px !important;
            margin: -5px 5px 5px 5px !important;
        }

        #userTable_length label {
            display: flex !important;
            margin: 0.75rem 0.75rem 0.2rem 0.75rem !important;
            width: 25% !important;
        }

        #userTable_filter select {
            width: 70px !important; 
            height: 35px !important;
            margin: -5px 5px 5px 5px !important;
        }

        #userTable_filter label {
            display: flex !important;
            gap: 10px;
            margin: 0.65rem 0.75rem 0.2rem 0.75rem !important;
            width: 25% !important;
        }

        #userTable_info {
            margin-top: 20px !important;
        }

        #userTable_paginate {
            margin-top: -68px !important;
        }
    </style>
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
                    <div class="col-md-6 col-sm-12 mb-2 mb-md-0 row">
                        <div class="col-md-3">
                            <button class="btn btn-secondary w-100 text-white" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-danger w-100" id="reset">
                                <i class="bi bi-arrow-repeat"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="col-md-5 float-end">
                            <a class="btn btn-primary w-100" href="{{ route('admin.manajemen-akun.create') }}">
                                <i class="bi bi-plus-circle"></i> Tambah User
                            </a>
                        </div>
                    </div>

                    <div class="table-container">
                        <div class="col-md-12">
                            <div id="length-container"></div>
                        </div>
                        <div class="col-md-12">
                            <div id="search-container"></div>
                        </div>
    
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="userTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>No KK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Gender</th>
                                        <th>Alamat</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Kecamatan</th>
                                        <th>Desa</th>
                                        <th>Registration Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
    
                        <div class="col-md-12">
                            <div id="info-container"></div>
                        </div>
                        <div class="col-md-12">
                            <div id="pagination-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('account-management.modal_edit_akun')
@include('account-management.delete_modal_akun')
@include('account-management.modal_filter')
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("admin.user.data") }}',
                    type: 'GET',
                    data: function (d) {
                        d.time = $('#selectedTime').val();
                        d.gender = $('#selectedGenders').val();
                        d.types = $('#selectedTypes').val();
                        d.kecamatan = $('#selectedDistricts').val();
                        d.desa = $('#desa').val();
                        d.rt = $('#selectedRT').val();
                        d.rw = $('#selectedRW').val();
                    },
                    error: function (xhr, error, thrown) {
                        console.error('Data Tables error:', error);
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nik', name: 'nik', orderable: false },
                    { data: 'no_kk', name: 'no_kk', orderable: false },
                    { data: 'full_name', name: 'full_name', orderable: true },
                    { data: 'email', name: 'email', orderable: true },
                    { data: 'phone_number', name: 'phone_number', orderable: true },
                    { data: 'birth_date', name: 'birth_date', orderable: true },
                    { data: 'gender', name: 'gender', orderable: true },
                    { data: 'address', name: 'address', orderable: false },
                    { data: 'rt', name: 'rt', orderable: true },
                    { data: 'rw', name: 'rw', orderable: true },
                    { data: 'district_name', name: 'district.name', orderable: true },
                    { data: 'village_name', name: 'village.name', orderable: true },
                    { data: 'registration_type', name: 'registration_type', orderable: true },
                    { data: 'registration_status', name: 'registration_status', orderable: true},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                order: [
                    [0, 'desc']
                ],
                ordering: true,
                drawCallback: function(settings) {
                    $('#search-container').html($('.dataTables_filter').detach());
                    $('#pagination-container').html($('.dataTables_paginate').detach());
                    $('#length-container').html($('.dataTables_length').detach());
                    $('#info-container').html($('.dataTables_info').detach());

                    var $searchInput = $('#search-container input[type="search"]');
                    var searchValue = $searchInput.val();
                    $searchInput.focus().val('').val(searchValue).addClass('hover-effect');
                }
            });

            $('#reset').on('click', function() {
                $('#selectedTime, #selectedGenders, #selectedTypes, #selectedDistricts, #selectedRW, #selectedRT').val('');
                
                $('#kecamatan, #desa, #rt, #rw').val('').trigger('change');

                $('.time-btn, .gender-btn, .type-btn').removeClass('btn-primary').addClass('btn-outline-primary');
                
                table.ajax.reload();
                $('#filterModal').modal('hide');
            });

            // Add change event listeners to all filters
            $('#desa, #kecamatan').change(function () {
                table.ajax.reload();
            });

            let focusedElement = null;

            $('#rt, #rw').on('keyup', function () {
                focusedElement = this;
                selectRtRw(this.id === 'rw' ? '#rw' : '#rt');
                table.ajax.reload(function() {
                    if (focusedElement) {
                        $(focusedElement).focus();
                    }
                });
            });

            $('.time-btn, .gender-btn, .type-btn').click(function () {
                table.ajax.reload();
            });

            $(document).on('change', '#kecamatan', function() {
                selectDistricts(this);
                table.ajax.reload();
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

        function getVillages(e) {
            var districtId = $(e).val();
            if(districtId) {
                $.ajax({
                    url: "{{ route('get-villages', '') }}/" + districtId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#desa').empty();
                        $('#desa').append('<option value="">Pilih Desa</option>');
                        $.each(data, function(key, value) {
                            $('#desa').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#desa').empty();
                $('#desa').append('<option value="">Pilih Desa</option>');
            }
        };
    </script>
@endpush
