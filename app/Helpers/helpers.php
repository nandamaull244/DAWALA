<?php

function redirectByRole($role, $function, $type, $message) {
    return redirect()->route($role.'.article.'.$function)->with($type, $message);
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
