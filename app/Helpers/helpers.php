<?php

function message($type = null, $message = null) {
    switch ($type) {
        case 'login':
            return 'login' . ', ' . isset($message) ? $message : 'Berhasil Login';
        case 'logout':
            return 'logout' . ', ' . isset($message) ? $message : 'Berhasil Logout';
        case 'success':
            return 'success' . ', ' . 'Data '. $message . ' Berhasil Disimpan';
        case 'warning':
            return 'warning' . ', ' . 'Yakin untuk menghapus data '. $message . ' ini?';
        case 'error':
            return 'error' . ', ' . 'Gagal Menyimpan Data '. $message;
    }
}

function dashboardRedirect($role) {
    if ($role == 'admin') {
        return route('admin.dashboard');
    } elseif ($role == 'instantiation') {
        return route('form-ktp.index');
    } elseif ($role == 'operator') {
        return route('operator.dashboard');
    } else {
        return route('user.dashboard');
    }
}
