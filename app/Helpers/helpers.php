<?php

function message($type = null, $message = null) {
    switch ($type) {
        case 'login':
            return 'login' . ', ' . isset($message) ? $message : 'Berhasil Login';
        case 'logout':
            return 'logout' . ', ' . isset($message) ? $message : 'Berhasil Logout';
        case 'success':
            return 'success' . ', ' . isset($message) ? $message : 'Data Berhasil Disimpan';
        case 'warning':
            return 'warning' . ', ' . isset($message) ? $message : 'Yakin untuk menghapus data ini?';
        case 'error':
            return 'error' . ', ' . isset($message) ? $message : 'Gagal Menyimpan Data';
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

function getVillagesByDistrict($districtId)
{
    $villages = Village::where('district_id', $districtId)->get();
    return response()->json($villages);
}

