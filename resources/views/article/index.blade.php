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
                    <div class="filter-container">
                        <div class="filter-item">
                            <label for="tanggal">Tanggal</label>
                            <select id="tanggal" name="tanggal">
                                <option value="">Semua</option>
                                <!-- Add date options here -->
                            </select>
                        </div>
                        <div class="filter-item">
                            <label for="tipe_layanan">Waktu</label>
                            <select id="tipe_layanan" name="tipe_layanan">
                                <option value="">Semua</option>
                                <option value="Terbaru">Terbaru</option>
                                <option value="Terlama">Terlama</option>
                                <!-- Add more service types as needed -->
                            </select>
                        </div>
                        <button class="reset-filter" onclick="resetFilters()">Reset Filter</button>
                        <button class="btn btn-primary add-new-btn" data-bs-toggle="modal" data-bs-target="#dataModalAddArticle">
                            <i class="bi bi-plus-circle"></i> Tambah Artikel
                        </button>

                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO</th>
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
                                <tr>
                                    <td>2</td>
                                    <td>artikel-kedua</td>
                                    <td>Artikel Kedua</td>
                                    <td><img src="path/to/image2.jpg" alt="Artikel Kedua" width="50"></td>
                                    <td>Ini adalah isi dari artikel kedua...</td>
                                    <td class="sticky-column action-icons">
                                        <span data-bs-toggle="modal" data-bs-target="#dataModalEditArticle"
                                            style="cursor: pointer;">✏️</span>
                                        <span data-bs-toggle="modal" data-bs-target="#deleteModalArticle"
                                            style="cursor: pointer;">🗑️</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>artikel-ketiga</td>
                                    <td>Artikel Ketiga</td>
                                    <td><img src="path/to/image3.jpg" alt="Artikel Ketiga" width="50"></td>
                                    <td>Ini adalah isi dari artikel ketiga...</td>
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


    @include('article.modal_edit_artikel')
    @include('article.delete_modal_artikel')
@endsection

@push('scripts')
 
@endpush
