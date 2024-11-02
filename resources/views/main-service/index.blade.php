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

        #serviceTable {
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
            padding-top: 50px;  /* Memberikan ruang untuk search box */
            padding-bottom: 50px;  /* Memberikan ruang untuk pagination */
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
        #serviceTable_length {
            margin-top: -40px !important;
        }

        #serviceTable_length select {
            width: 70px !important; 
            height: 35px !important;
            margin: -5px 5px 5px 5px !important;
        }

        #serviceTable_length label {
            display: flex !important;
            margin: 0.75rem 0.75rem 0.2rem 0.75rem !important;
            width: 25% !important;
        }

        #serviceTable_filter select {
            width: 70px !important; 
            height: 35px !important;
            margin: -5px 5px 5px 5px !important;
        }

        #serviceTable_filter label {
            display: flex !important;
            gap: 10px;
            margin: 0.65rem 0.75rem 0.2rem 0.75rem !important;
            width: 25% !important;
        }

        #serviceTable_info {
            margin-top: 20px !important;
        }

        #serviceTable_paginate {
            margin-top: -68px !important;
        }
    </style>
    <style>
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-item i {
            font-size: 1.1em;
        }
        
        /* Warna ikon spesifik */
        .bi-file-earmark-excel {
            color: #217346; /* Warna Excel */
        }
        
        .bi-file-earmark-pdf {
            color: #FF0000; /* Warna PDF */
        }
    </style>
    <style>
        .dropdown-item.active {
            background-color: #0d6efd;
            color: white;
        }

        .dropdown-item.active i {
            color: white;
        }
    </style>
@endpush

@section('page-heading')
    Arsip Layanan
@endsection

@section('page-subheading')
    Data Seluruh Layanan 
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
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
                        <div class="col-md-5">
                            <div class="dropdown">
                                <button class="btn btn-info w-100 dropdown-toggle text-white" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-filter"></i> Kategori Pelayanan
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Disabilitas Fisik" onclick="categoryFilter(this, 'Categories')" data-value="Disabilitas Fisik">
                                            <i class="bi bi-person-wheelchair"></i> Disabilitas Fisik
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Disabilitas Netra/Buta" onclick="categoryFilter(this, 'Categories')" data-value="Disabilitas Netra/Buta">
                                            <i class="bi bi-person-cane"></i> Disabilitas Netra/Buta
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Disabilitas Rungu/Bicara" onclick="categoryFilter(this, 'Categories')" data-value="Disabilitas Rungu/Bicara">
                                            <i class="bi bi-person-hearts"></i> Disabilitas Rungu/Bicara
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Disabilitas Mental/Jiwa" onclick="categoryFilter(this, 'Categories')" data-value="Disabilitas Mental/Jiwa">
                                            <i class="bi bi-person-hearts"></i> Disabilitas Mental/Jiwa
                                        </a>
                                    </li>   
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Disabilitas Fisik dan Mental" onclick="categoryFilter(this, 'Categories')" data-value="Disabilitas Fisik dan Mental">
                                            <i class="bi bi-person-hearts"></i> Disabilitas Fisik dan Mental
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Disabilitas Lainnya" onclick="categoryFilter(this, 'Categories')" data-value="Disabilitas Lainnya">
                                            <i class="bi bi-person-hearts"></i> Disabilitas Lainnya
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Lansia" onclick="categoryFilter(this, 'Categories')" data-value="Lansia">
                                            <i class="bi bi-person-hearts"></i> Lansia
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="ODGJ" onclick="categoryFilter(this, 'Categories')" data-value="ODGJ">
                                            <i class="bi bi-person-hearts"></i> ODGJ
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Penduduk Sakit" onclick="categoryFilter(this, 'Categories')" data-value="Penduduk Sakit">
                                            <i class="bi bi-person-hearts"></i> Penduduk Sakit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Penduduk Terlantar" onclick="categoryFilter(this, 'Categories')" data-value="Penduduk Terlantar">
                                            <i class="bi bi-person-hearts"></i> Penduduk Terlantar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item category-filter" href="#" data-category="Penduduk Terkena Bencana" onclick="categoryFilter(this, 'Categories')" data-value="Penduduk Terkena Bencana">
                                            <i class="bi bi-person-hearts"></i> Penduduk Terkena Bencana
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        {{-- @if (auth()->user()->role == 'admin' || auth()->user()->role == 'operator')
                            <div class="col-md-4">
                                <div class="dropdown">
                                <button class="btn btn-success w-100 dropdown-toggle" type="button" id="reportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-text"></i> Laporan
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="reportDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#" id="downloadExcel" data-url="{{ route(auth()->user()->role . '.pelayanan.export.excel') }}">
                                            <i class="bi bi-file-earmark-excel"></i> Download Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="btnDownloadPDF" data-bs-toggle="modal" data-bs-target="#selectPaperModal"> 
                                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                                        </a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        @endif --}}

                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="col-md-5 float-end">
                            <a class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#layananModal">
                                <i class="bi bi-plus-circle"></i> Daftar Pelayanan
                            </a>
                        </div>
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
                        <table id="serviceTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" nowrap>No</th>
                                        <th class="text-center" nowrap>Nama</th>
                                        <th class="text-center" nowrap>Tanggal Pengajuan</th>
                                        <th class="text-center" nowrap>Jenis Pelayanan</th>
                                        <th class="text-center" nowrap>Kategori Layanan</th>
                                        <th class="text-center" nowrap>Tipe Layanan</th>
                                        <th class="text-center" nowrap>Tanggal Lahir</th>
                                        <th class="text-center" nowrap>Alamat</th>
                                        <th class="text-center" nowrap>Rt</th>
                                        <th class="text-center" nowrap>Rw</th>
                                        <th class="text-center" nowrap>Kecamatan</th>
                                        <th class="text-center" nowrap>Desa/Kelurahan</th>
                                        <th class="text-center" nowrap>No Hp</th>
                                        <th class="text-center" nowrap>Alasan Pengajuan</th>
                                        <th class="text-center" nowrap>Foto Bukti Keterbatasan</th>
                                        <th class="text-center" nowrap>Foto Ktp</th>
                                        <th class="text-center" nowrap>Foto Kk</th>
                                        <th class="text-center" nowrap>Formulir</th>
                                        <th class="text-center" nowrap>Status Pengerjaan</th>
                                        <th class="text-center" nowrap>Status Pelayanan</th>
                                        <th class="text-center" nowrap>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh DataTables -->
                            </tbody>
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
    </section>

    @include('main-service.modal_layanan')
    @include('main-service.modal_confirmation')
    @include('main-service.delete_modal')
    @include('main-service.modal_filter')
    @include('main-service.modal_image')
    @include('main-service.modal_download_formulir')
    @include('main-service.modal_select_paper')
    @include('main-service.modal_working_status')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function saveChanges() {
                $('#dataModalEdit').modal('hide');
            }

            function saveRejection() {
                const alasanTolak = $('#alasan_tolak').val().trim();
                if (alasanTolak === '') {
                    alert('Mohon masukkan alasan penolakan.');
                    return;
                }
                $('#rejectModal').modal('hide');
            }

            $('.layanan-btn').on('click', function() {
                toggleLayanan(this);
            });

            $('.pelayanan-btn').on('click', function() {
                selectPelayanan(this);
            });

            $('#saveChangesBtn').on('click', saveChanges);
            $('#saveRejectionBtn').on('click', saveRejection);

            // Handle Excel download
            $('#downloadExcel').click(function(e) {
                e.preventDefault();
                const url = $(this).data('url')
                
                const filters = {
                    start_date: $('#startDate').val(),
                    end_date: $('#endDate').val(),
                    time: $('#selectedTime').val(),
                    categories: $('#selectedCategories').val(),
                    types: $('#selectedTypes').val(),
                    kecamatan: $('#selectedDistricts').val(),
                    desa: $('#desa').val(),
                    service_statuses: $('#selectedServiceStatuses').val(),
                    work_statuses: $('#selectedWorkStatuses').val()
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: filters,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        responseType: 'blob' 
                    },
                    success: function(response, status, xhr) {
                        const blob = new Blob([response], { type: xhr.getResponseHeader('content-type') });
                        const url = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        
                        const filename = xhr.getResponseHeader('content-disposition')?.split('filename=')[1] || 'services.xlsx';
                        link.download = filename;
                        
                        document.body.appendChild(link);
                        link.click();
                        
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(link);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Gagal mengunduh file', 'Error');
                        console.error(error);
                    }
                });
            });

            // Handle PDF download
            $('#downloadPDF').click(function(e) {
                e.preventDefault();
                const url = $(this).data('url')

                const filters = {
                    start_date: $('#startDate').val(),
                    end_date: $('#endDate').val(),
                    time: $('#selectedTime').val(),
                    categories: $('#selectedCategories').val(),
                    types: $('#selectedTypes').val(),
                    kecamatan: $('#selectedDistricts').val(),
                    desa: $('#desa').val(),
                    service_statuses: $('#selectedServiceStatuses').val(),
                    work_statuses: $('#selectedWorkStatuses').val(),
                    paper: $('#paper').val(),
                    orientation: $('#orientation').val(),
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: filters,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response, status, xhr) {
                        const blob = new Blob([response], { type: 'application/pdf' });
                        const url = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        
                        const filename = xhr.getResponseHeader('content-disposition')?.split('filename=')[1] || 'services.pdf';
                        link.download = filename;
                        
                        document.body.appendChild(link);
                        link.click();
                        
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(link);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Gagal mengunduh file', 'Error');
                        console.error(error);
                    }
                });
            });
        });

        var table;
        $(document).ready(function() {
            table = $('#serviceTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route(auth()->user()->role . '.pelayanan.data') }}",
                    method: 'GET',
                    data: function(d) {
                        d.start_date = $('#startDate').val();
                        d.end_date = $('#endDate').val(); 
                        d.time = $('#selectedTime').val();
                        d.services = $('#selectedServices').val();
                        d.categories = $('#selectedCategories').val();
                        d.types = $('#selectedTypes').val();
                        d.kecamatan = $('#selectedDistricts').val();
                        d.desa = $('#desa').val();
                        d.service_statuses = $('#selectedServiceStatuses').val();
                        d.work_statuses = $('#selectedWorkStatuses').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, className: 'text-center', width: '5%'},
                    {data: 'name', name: 'name'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'service', name: 'service'},
                    {data: 'service_category', name: 'service_category'},
                    {data: 'service_type', name: 'service_type'},
                    {data: 'birth_date', name: 'birth_date'},
                    {data: 'address', name: 'address'},
                    {data: 'rt', name: 'rt'},
                    {data: 'rw', name: 'rw'},
                    {data: 'district', name: 'district'},
                    {data: 'village', name: 'village'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'reason', name: 'reason'},
                    {data: 'evidence_of_disability_image', name: 'evidence_of_disability_image', orderable: false, searchable: false},
                    {data: 'ktp_image', name: 'ktp_image', orderable: false, searchable: false},
                    {data: 'kk_image', name: 'kk_image', orderable: false, searchable: false},
                    {data: 'formulir', name: 'formulir', orderable: false, searchable: false},
                    {data: 'working_status', name: 'working_status', orderable: false, searchable: false},
                    {data: 'service_status', name: 'service_status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false, width: '25%'},
                ],
                order: [[1, 'asc']],
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
                $('#selectedTime, #selectedCategories, #selectedTypes, #selectedDistricts, #selectedServiceStatuses, #selectedWorkStatuses').val('');
                
                $('#kecamatan, #desa').val('').trigger('change');
                
                const today = "{{ date('Y-m-d') }}";
                // $('#startDate')[0]._flatpickr.setDate(today);
                // $('#endDate')[0]._flatpickr.setDate(today);

                $('#startDate, #endDate').val('');
                
                $('.time-btn, .category-btn, .type-btn, .service-status-btn, .work-status-btn')
                    .removeClass('btn-primary')
                    .addClass('btn-outline-primary');
                
                table.ajax.reload();
                $('#filterModal').modal('hide');
            });
            
            $('.category-btn, .type-btn, .service-status-btn, .work-status-btn').on('click', function() {
                table.ajax.reload();
            });

            $(document).on('change', '#kecamatan', function() {
                selectDistricts(this);
                table.ajax.reload();
            });

            $(document).on('change', '.time-select', function() {
                selectTime(this);
                table.ajax.reload();
            });

            $(document).on('change', '#desa, #startDate, #endDate', function() {
                table.ajax.reload();
            });

            $(window).scroll(function() {
                var scrollTop = $(window).scrollTop();
                var headerHeight = $('header').outerHeight(); 
                
                $('#fixed-controls').css('top', Math.max(headerHeight, scrollTop + 20) + 'px');
            });
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

        function categoryFilter(button, type, multiple = false) {
            const $button = $(button);
            let value = $button.data('value');
            const $input = $('#selected' + type);

            if (multiple) {
                let selectedValues = $input.val() ? $input.val().split(',') : [];
              
                if ($button.hasClass('active')) {
                    $button.removeClass('active');
                    selectedValues = selectedValues.filter(v => v !== value);
                } else {
                    $button.addClass('active');
                    if (!selectedValues.includes(value)) {
                        selectedValues.push(value);
                    }
                }
                
                $input.val(selectedValues.join(','));
            } else {
                $('.category-filter').removeClass('active');
                $button.addClass('active');
                $input.val(value);
            }

            // Trigger table reload
            $input.trigger('change');
            table.ajax.reload();
        }
    </script>
@endpush