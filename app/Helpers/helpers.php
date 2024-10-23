<?php

function redirectByRole($role, $page, $function, $flashMessage) {
    return redirect()->route($role . '.' .$page. '.' .$function)->with($flashMessage);
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
