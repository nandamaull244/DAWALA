<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelayanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #E2EFDA;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h3>Laporan Pelayanan 
        @if ($startDate && $endDate)
            Periode {{ $startDate }} s/d {{ $endDate }}
        @endif
    </h3>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA</th>
                <th>TANGGAL PENGAJUAN</th>
                <th>JENIS PELAYANAN</th>
                <th>KATEGORI LAYANAN</th>
                <th>TIPE LAYANAN</th>
                <th>TANGGAL LAHIR</th> 
                <th>ALAMAT</th>
                <th>RT</th>
                <th>RW</th>
                <th>KECAMATAN</th>
                <th>DESA/KELURAHAN</th>
                <th>NO HP</th>
                <th>ALASAN PENGAJUAN</th>
                <th>STATUS PENGERJAAN</th>
                <th>STATUS PELAYANAN</th>
            </tr>
        </thead>
        <tbody>
            @if ($services->count() > 0)
                @foreach($services as $index => $service)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $service->user->full_name }}</td>
                        <td>{{ getFlatpickrDate(date('Y-m-d', strtotime($service->created_at))) }}</td>
                        <td>{{ $service->service_list->service_name }}</td>
                        <td>{{ $service->service_category }}</td>
                        <td>{{ $service->service_type }}</td>
                        <td>{{ getFlatpickrDate($service->user->birth_date) }}</td>
                        <td>{{ $service->user->address }}</td>
                        <td>{{ $service->user->rt }}</td>
                        <td>{{ $service->user->rw }}</td>
                        <td>{{ $service->user->district->name }}</td>
                        <td>{{ $service->user->village->name }}</td>
                        <td>{{ $service->user->phone_number }}</td>
                        <td>{{ $service->reason }}</td>
                        <td>
                            @switch($service->working_status)
                                @case('Not Yet')
                                    Menunggu
                                    @break
                                @case('Late')
                                    Terlambat
                                    @break
                                @case('Process')
                                    Proses
                                    @break
                                @case('Done')
                                    Selesai
                                    @break
                                @default
                                    {{ $service->working_status }}
                            @endswitch
                        </td>
                        <td>
                            @switch($service->service_status)
                                @case('Not Yet')
                                    Belum Dikerjakan
                                    @break
                                @case('Process')
                                    Proses
                                    @break
                                @case('Rejected')
                                    Ditolak
                                    @break
                                @case('Completed')
                                    Selesai
                                    @break
                                @default
                                    {{ $service->service_status }}
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            @else 
                <tr>
                    <td colspan="16" class="text-center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
