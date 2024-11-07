<style>
    .text-center {
        text-align: center;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <td colspan="16" rowspan="3" style="text-align: center; vertical-align: middle;">
                @if ($startDate && $endDate)
                    <h3>Laporan Pelayanan Periode {{ $startDate ?? '-' }} s/d {{ $endDate ?? '-' }}</h3>
                @else 
                    <h3>Laporan Pelayanan</h3>
                @endif
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th nowrap class="text-center">NO</th>
            <th nowrap class="text-center">NAMA</th>
            <th nowrap class="text-center">TANGGAL PENGAJUAN</th>
            <th nowrap class="text-center">JENIS PELAYANAN</th>
            <th nowrap class="text-center">KATEGORI LAYANAN</th>
            <th nowrap class="text-center">TIPE LAYANAN</th> 
            <th nowrap class="text-center">TANGGAL LAHIR</th> 
            <th nowrap class="text-center">ALAMAT</th> 
            <th nowrap class="text-center">RT</th> 
            <th nowrap class="text-center">RW</th>
            <th nowrap class="text-center">KECAMATAN</th>
            <th nowrap class="text-center">DESA/KELURAHAN</th>
            <th nowrap class="text-center">NO HP</th> 
            <th nowrap class="text-center">ALASAN PENGAJUAN</th> 
            {{-- <th nowrap class="text-center">FOTO BUKTI KETERBATASAN</th>
            <th nowrap class="text-center">FOTO KTP</th>
            <th nowrap class="text-center">FOTO KK</th>  --}}
            <th nowrap class="text-center">STATUS PENGERJAAN</th> 
            <th nowrap class="text-center">STATUS PELAYANAN</th>
        </tr>
    </thead>
    <tbody>
        @if ($services->count() > 0)
            @foreach($services as $index => $service)
                {{-- @php
                    $evidence = $service->service_image()->where('image_type', 'Bukti Keterbatasan')->first();
                    $evidence_odgj = $service->service_image()->where('image_type', 'Bukti Keterbatasan ODGJ')->first();
                    $ktp = $service->service_image()->where('image_type', 'KTP')->first();
                    $kk = $service->service_image()->where('image_type', 'Kartu Keluarga')->first();
                @endphp --}}
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $service->user->full_name }}</td>
                    <td class="text-center">{{ getFlatpickrDate(date('Y-m-d', strtotime($service->created_at))) }}</td>
                    <td class="text-center">{{ $service->service_list->service_name }}</td>
                    <td class="text-center">{{ $service->service_category }}</td>
                    <td class="text-center">{{ $service->service_type }}</td>
                    <td class="text-center">{{ getFlatpickrDate($service->user->birth_date) }}</td>
                    <td class="text-center">{{ $service->user->address }}</td>
                    <td class="text-center">{{ $service->user->rt }}</td>
                    <td class="text-center">{{ $service->user->rw }}</td>
                    <td class="text-center">{{ $service->user->district->name }}</td>
                    <td class="text-center">{{ $service->user->village->name }}</td>
                    <td class="text-center">{{ $service->user->phone_number }}</td>
                    <td class="text-center">{{ $service->reason }}</td>
                    {{-- <td class="text-center">
                        @if ($evidence || $evidence_odgj)
                            <img src="{{ asset('storage/' . $evidence->image_path) }}" alt="Bukti Keterbatasan">
                            <br>
                            <img src="{{ asset('storage/' . $evidence_odgj->image_path) }}" alt="Bukti Keterbatasan ODGJ">
                        @else 
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($ktp)
                            <img src="{{ asset('storage/' . $ktp->image_path) }}" alt="KTP">
                        @else 
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($kk)
                            <img src="{{ asset('storage/' . $kk->image_path) }}" alt="Kartu Keluarga">
                        @else 
                            -
                        @endif
                    </td> --}}
                    <td class="text-center">
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
                    <td class="text-center">
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
