@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <style>
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
            margin-bottom: 15px;
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

        .form-control, .flatpickr-input {
            height: 38px; 
        }
    </style>
@endpush

@section('page-heading')
    Artikel
@endsection

@section('page-subheading')
    Data Seluruh Artikel
@endsection

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="filter-container col-md-12 form-group">
                        <div class="filter-item col-md-2-5">
                            <label for="start_date">Tanggal Awal</label>
                            <input type="text" id="start_date" name="start_date" class="form-control flatpickr-first-day-in-month" placeholder="Pilih tanggal awal">
                        </div>
                    
                        <div class="filter-item col-md-2-5">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="text" id="end_date" name="end_date" class="form-control flatpickr-date" placeholder="Pilih tanggal akhir">
                        </div>
                    
                        <div class="filter-item col-md-2">
                            <label for="time">Waktu</label>
                            <select id="time" name="time" class="form-control form-select">
                                <option value="Terbaru">Terbaru</option>
                                <option value="Terlama">Terlama</option>
                            </select>
                        </div>
                    
                        <div class="filter-item col-md-1">
                            <label>&nbsp;</label>
                            <button class="btn btn-danger w-100" onclick="resetFilters()">Reset</button>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="filter-item col-md-2">
                            <label>&nbsp;</label>
                            <a class="btn btn-primary w-100" href="{{ route('admin.article.create') }}">
                                <i class="bi bi-plus-circle"></i> Tambah Artikel
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="articlesTable" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center" nowrap>No</th>
                                    <th class="text-center" nowrap>Judul</th>
                                    <th class="text-center" nowrap>Isi Artikel</th>
                                    {{-- <th class="text-center" nowrap>Foto</th> --}}
                                    <th class="text-center" nowrap>Penulis</th>
                                    <th class="text-center" nowrap>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('article.modal_delete')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#articlesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.article.data') }}",
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.time = $('#time').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, className: 'text-center', width: '5%'},
                    {data: 'title', name: 'title', width: '30%'},
                    {data: 'body', name: 'body', width: '40%'},
                    // {data: 'image', name: 'image', width: '15%'},
                    {data: 'author', name: 'author', width: '15%'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, width: '25%'},
                ]
            });

            $('#start_date, #end_date, #time').change(function() {
                let startDate = new Date($('#start_date').val());
                let endDate = new Date($('#end_date').val());

                table.ajax.reload();
            });

            window.resetFilters = function() {
                $('#start_date, #end_date').val('');
                $('#time').val('').trigger('change');

                var today = new Date();
                var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1); 

                $('#start_date').flatpickr({
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    altInput: true,
                    altFormat: "d F Y",
                    locale: "id",
                    disableMobile: true,
                    defaultDate: firstDayOfMonth  
                });

                $('#end_date').flatpickr({
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    altInput: true,
                    altFormat: "d F Y",
                    locale: "id",
                    disableMobile: true,
                    defaultDate: today 
                });

                table.ajax.reload();
            };


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
