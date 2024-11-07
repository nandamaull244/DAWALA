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
    <style>`
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
@endpush

@section('page-heading')
    Laporan Layanan
@endsection

@section('page-subheading')
    Data Seluruh Layanan 
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="filter-container col-md-12 form-group">
                        <div class="filter-item col-md-2-5">
                            <label for="start_date">Tanggal Awal</label>
                            <input type="text" id="start_date" name="start_date" class="form-control flatpickr-max-date" placeholder="Pilih tanggal awal">
                        </div>
                    
                        <div class="filter-item col-md-2-5">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="text" id="end_date" name="end_date" class="form-control flatpickr-min-date" placeholder="Pilih tanggal akhir">
                        </div>
                    
                        <div class="filter-item col-md-1">
                            <label>&nbsp;</label>
                            <button class="btn btn-danger w-100" onclick="resetFilters()">Reset</button>
                        </div>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'operator')
                            <div class="filter-item col-md-2">
                                <label>&nbsp;</label>
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
                        @endif
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
                                    <th class="text-center" nowrap>Tanggal Pengajuan</th>
                                    <th class="text-center" nowrap>Jenis Pelayanan</th>
                                    <th class="text-center" nowrap>Kategori Layanan</th>
                                    <th class="text-center" nowrap>Tipe Layanan</th>
                                    <th class="text-center" nowrap>Kecamatan</th>
                                    <th class="text-center" nowrap>Desa/Kelurahan</th>
                                </tr>
                            </thead>
                            <tbody>

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
  @include('report.modal_select_paper')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        $(document).ready(function() {
            // Handle Excel download
            $('#downloadExcel').click(function(e) {
                e.preventDefault();
                const url = $(this).data('url')
                
                const filters = {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
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
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
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

        $(document).ready(function() {
            var table = $('#serviceTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route(auth()->user()->role . '.pelayanan.data') }}",
                    method: 'GET',
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.page = 'report';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, className: 'text-center', width: '5%'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'service', name: 'service'},
                    {data: 'service_category', name: 'service_category'},
                    {data: 'service_type', name: 'service_type'},
                    {data: 'district', name: 'district'},
                    {data: 'village', name: 'village'},
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
                const today = "{{ date('Y-m-d') }}";
                $('#startDate, #endDate').val('');
                table.ajax.reload();
            });

            $('#start_date, #end_date').change(function(){
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
    </script>
@endpush