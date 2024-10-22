@extends('layouts.main')

@push('css')
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
                            <input type="text" id="start_date" name="start_date" class="form-control flatpickr-date" placeholder="Pilih tanggal awal">
                        </div>
                    
                        <div class="filter-item col-md-2-5">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="text" id="end_date" name="end_date" class="form-control flatpickr-date" placeholder="Pilih tanggal akhir">
                        </div>
                    
                        <div class="filter-item col-md-2">
                            <label for="time">Waktu</label>
                            <select id="time" name="time" class="form-control">
                                <option value="">Semua</option>
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
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Slug</th>
                                    <th>Judul</th>
                                    <th>Image</th>
                                    <th>Isi Artikel</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>artikel-pertama</td>
                                    <td>Artikel Pertama</td>
                                    <td><img src="path/to/image1.jpg" alt="Artikel Pertama" width="50"></td>
                                    <td>Ini adalah isi dari artikel pertama...</td>
                                    <td class="sticky-column action-icons">
                                        <span data-bs-toggle="modal" data-bs-target="#dataModalEditArticle"
                                            style="cursor: pointer;">✏️</span>
                                        <span data-bs-toggle="modal" data-bs-target="#deleteModalArticle"
                                            style="cursor: pointer;">🗑️</span>
                                    </td>
                                </tr>
                            </tbody>
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
            flatpickr.localize(flatpickr.l10ns.id);
            $(".flatpickr-date").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true,
                altInput: true,
                altFormat: "d F Y",
                locale: "id",
                disableMobile: "true"
            });
        });
    </script>
@endpush
