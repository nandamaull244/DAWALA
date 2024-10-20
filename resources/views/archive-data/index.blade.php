@extends('layout.main')

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
    Arsip Data Kependudukan
@endsection

@section('content')
    <section class="section">
        <div class="filter-container">
            <div class="filter-item">
                <label for="tanggal">Tanggal</label>
                <select id="tanggal" name="tanggal">
                    <option value="">Semua</option>
                    <!-- Add date options here -->
                </select>
            </div>
            <div class="filter-item">
                <label for="tipe_layanan">Tipe Layanan</label>
                <select id="tipe_layanan" name="tipe_layanan">
                    <option value="">Semua</option>
                    <option value="Persamaan KTP">Persamaan KTP</option>
                    <option value="Pembuatan KK">Pembuatan KK</option>
                    <!-- Add more service types as needed -->
                </select>
            </div>
            <div class="filter-item">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">Semua</option>
                    <option value="completed">Completed</option>
                    <option value="processing">Processing</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <button class="reset-filter" onclick="resetFilters()">Reset Filter</button>
            <button class="btn btn-primary add-new-btn" data-bs-toggle="modal" data-bs-target="#dataModal">
                <i class="bi bi-plus-circle"></i> Tambah Baru
            </button>

        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NO. TIKET</th>
                        <th>NAMA</th>
                        <th>KATEGORI</th>
                        <th>TANGGAL</th>
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
                        <th class="sticky-column">STATUS</th>
                        <th class="sticky-column">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>00001</td>
                        <td>Christine Brooks</td>
                        <td>Disabilitas</td>
                        <td>04 Sep 2024</td>
                        <td>Persamaan KTP</td>
                        <td>01 Jan 1990</td>
                        <td>Jl. Contoh No. 123</td>
                        <td>001</td>
                        <td>002</td>
                        <td>Kelurahan Contoh</td>
                        <td>Kecamatan Contoh</td>
                        <td>081234567890</td>
                        <td>Perubahan Data</td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Formulir</a></td>
                        <td class="sticky-column"><span class="status rejected">Telat H+1</span></td>
                        <td class="sticky-column"><span class="status completed">Completed</span></td>
                        <td class="sticky-column action-icons">
                            <span data-bs-toggle="modal" data-bs-target="#dataModalEdit" style="cursor: pointer;">✏️</span>
                            <span data-bs-toggle="modal" data-bs-target="#deleteModal" style="cursor: pointer;">🗑️</span>
                        </td>
                    </tr>
                    <tr>
                        <td>00002</td>
                        <td>Rosie Pearson</td>
                        <td>Disabilitas</td>
                        <td>28 May 2024</td>
                        <td>Persamaan KTP</td>
                        <td>01 Jan 1995</td>
                        <td>Jl. Contoh No. 456</td>
                        <td>003</td>
                        <td>004</td>
                        <td>Kelurahan Sample</td>
                        <td>Kecamatan Sample</td>
                        <td>087654321098</td>
                        <td>Pembaruan Data</td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Formulir</a></td>
                        <td class="sticky-column"><span class="status rejected">Telat H+1</span></td>
                        <td class="sticky-column"><span class="status completed">Completed</span></td>
                        <td class="sticky-column action-icons">
                            <span data-bs-toggle="modal" data-bs-target="#dataModalEdit" style="cursor: pointer;">✏️</span>
                            <span data-bs-toggle="modal" data-bs-target="#deleteModal" style="cursor: pointer;">🗑️</span>
                        </td>
                    </tr>
                    <tr>
                        <td>00003</td>
                        <td>Darrell Caldwell</td>
                        <td>Tertantar</td>
                        <td>23 Nov 2024</td>
                        <td>Pembuatan KK</td>
                        <td>01 Jan 1985</td>
                        <td>Jl. Contoh No. 789</td>
                        <td>005</td>
                        <td>006</td>
                        <td>Kelurahan Test</td>
                        <td>Kecamatan Test</td>
                        <td>089876543210</td>
                        <td>Pembuatan Baru</td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Foto</a></td>
                        <td><a href="#">Lihat Formulir</a></td>
                        <td class="sticky-column"><span class="status rejected">Telat H+1</span></td>
                        <td class="sticky-column"><span class="status completed">Completed</span></td>
                        <td class="sticky-column action-icons">
                            <span data-bs-toggle="modal" data-bs-target="#dataModalEdit" style="cursor: pointer;">✏️</span>
                            <span data-bs-toggle="modal" data-bs-target="#deleteModal" style="cursor: pointer;">🗑️</span>
                        </td>
                    </tr>
                    <!-- Tambahkan baris lainnya sesuai dengan data pada gambar -->
                </tbody>
            </table>
        </div>
    </section>

    @include('archive-data.modal_data')
    @include('archive-data.modal_edit')
    @include('archive-data.modal_reject')
    @include('archive-data.delete_modal')
@endsection

@push('scripts')
    <script>
        function resetFilters() {
            document.getElementById('tanggal').value = '';
            document.getElementById('tipe_layanan').value = '';
            document.getElementById('status').value = '';
            // Add logic to refresh the table data if needed
        }
    </script>
@endpush
