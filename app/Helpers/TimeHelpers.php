<?php
function getFlatpickrDate($date) {
    if (strpos($date, ':') !== false) {
        $datetime = explode(' ', $date);
        $date = explode('-', $datetime[0]);
        $time = $datetime[1];
        
        return $date[2] . ' ' . getMonth($date[1]) . ' ' . $date[0] . ' Jam : ' . substr($time, 0, 5);
    }
    
    $date = explode('-', $date);
    return $date[2] . ' ' . getMonth($date[1]) . ' ' . $date[0];
}

function getMonth($month) {
    $months = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    return $months[$month];
}

function getDay($day) {
    $days = [
        '01' => 'Senin',
        '02' => 'Selasa',
        '03' => 'Rabu',
        '04' => 'Kamis',
        '05' => 'Jumat',
        '06' => 'Sabtu',
        '07' => 'Minggu',
    ];

    return $days[$day];
}

function getLateWorkingStatus($date) {
    $dateTimestamp = strtotime($date);
    $diffDays = floor((time() - $dateTimestamp) / (60 * 60 * 24));

    if ($diffDays > 7) {
        $lateDay = $diffDays - 7;
        return ['true' => "Telat H + {$lateDay}"];
    }

    return ['false' => null];
}
