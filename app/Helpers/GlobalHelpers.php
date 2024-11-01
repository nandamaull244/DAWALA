<?php

function redirectByRole($prefix, $page, $flashMessage) {
    return redirect()->route($prefix . '.' .$page)->with($flashMessage);
}

function dashboardRedirect($role) {
    if ($role == 'admin') {
        return route('admin.dashboard');
    } elseif ($role == 'instantiation') {
        return route('instantiation.dashboard');
    } elseif ($role == 'operator') {
        return route('operator.dashboard');
    } else {
        return route('user.dashboard');
    }
}

function containsLetter($str) {
    return preg_match('/[a-zA-Z]/', $str);
}

function formatNumber($number) {
    return number_format($number, 0, ',', '.');
}

function generate16DigitNumber() {
    $number = '';
    for ($i = 0; $i < 16; $i++) {
        $number .= mt_rand(0, 9);
    }
    return $number;
}

function formatWorkingStatus($status) {
    switch($status) {
        case '-':
            return ['text' => '-', 'color' => 'secondary'];
        break;
        case 'Not Yet':
            return ['text' => 'Menunggu', 'color' => 'secondary'];
        break;
        case 'Process':
            return ['text' => 'Sedang Diproses', 'color' => 'warning'];
        break;
        case 'Completed':
            return ['text' => 'Selesai', 'color' => 'success'];
        break;
    }
}

function formatServiceStatus($status) {
    switch($status) {
        case 'Not Yet':
            return ['text' => 'Menunggu', 'color' => 'secondary'];
        break;
        case 'Rejected':
            return ['text' => 'Ditolak', 'color' => 'danger'];
        break;
        case 'Process':
            return ['text' => 'Sedang Diproses', 'color' => 'warning'];
        break;
        case 'Completed':
            return ['text' => 'Selesai', 'color' => 'success'];
        break;
    }
}