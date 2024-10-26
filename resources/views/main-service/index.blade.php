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
                <div class="row">
                    <div class="filter-container col-md-12 form-group">
                        <div class="filter-item col-md-2-5">
                            <label for="start_date">Tanggal Awal</label>
                            <input type="text" id="start_date" name="start_date" class="form-control flatpickr-date" placeholder="Pilih tanggal awal">
                        </div>
                    
                        <div class="filter-item col-md-2-5">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="text" id="end_date" name="end_date" class="form-control flatpickr-date" placeholder="Pilih tanggal akhir">
                        </div>
                    
                        <div class="filter-item col-md-2" style="margin-top: -1px;">
                            <label for="time">Waktu</label>
                            <select id="time" name="time" class="form-select" style="height: 38px !important;">
                                <option value="Terbaru">Terbaru</option>
                                <option value="Terlama">Terlama</option>
                            </select>
                        </div>
                    
                        <div class="filter-item col-md-1">
                            <label>&nbsp;</label>
                            <button class="btn btn-danger w-100" onclick="resetFilters()">Reset</button>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="filter-item col-md-2-5">
                            <label>&nbsp;</label>
                            <a class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#layananModal"><i class="bi bi-plus-circle"></i> Daftar Pelayanan
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="serviceTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA</th>
                                    <th>KATEGORI LAYANAN</th>
                                    <th>TANGGAL PENGAJUAN</th>
                                    <th>TIPE LAYANAN</th>
                                    <th>TANGGAL LAHIR</th>
                                    <th>ALAMAT</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th>DESA/KELURAHAN</th>
                                    <th>KECAMATAN</th>
                                    <th>NO HP</th>
                                    <th>ALASAN PENGJUAN</th>
                                    <th>FOTO BUKTI KETERBATASAN</th>
                                    <th>FOTO KTP</th>
                                    <th>FOTO KK</th>
                                    <th>FORMULIR</th>
                                    <th class="sticky-column">STATUS Pengerjaan</th>
                                    <th class="sticky-column">STATUS Pelayanan</th>
                                    <th class="sticky-column">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('main-service.modal_layanan')
    @include('main-service.modal_edit')
    @include('main-service.modal_reject')
    @include('main-service.delete_modal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function resetFilters() {
                $('#tanggal, #tipe_layanan, #status').val('');
            }

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
        });

        $(document).ready(function() {
            var table = $('#serviceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pelayanan.data') }}",
                    method: 'GET',
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.time = $('#time').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, className: 'text-center', width: '5%'},
                    {data: 'name', name: 'name'},
                    {data: 'service_category', name: 'service_category'},
                    {data: 'tanggal', name: 'tanggal'},
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
                order: [[1, 'asc']] 
            });

            $('#start_date, #end_date, #time').change(function(){
                table.ajax.reload();
            });

            window.resetFilters = function() {
                $('#start_date').val('').trigger('change');
                $('#end_date').val('').trigger('change');
                $('#time').val('').trigger('change');
                table.ajax.reload();
            }

            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                var url = "{{ route('admin.article.destroy', ':id') }}";
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteModalArticle').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.success);
                    },
                    error: function(xhr) {
                        toastr.error('Terjadi kesalahan: ' + xhr.statusText);
                    }
                });
            });
        });
    </script>
@endpush
