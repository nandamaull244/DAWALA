<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>

    @if(Auth::user()->role == 'admin')
        Admin Dashboard - Dawala
    @elseif(Auth::user()->role == 'user')
        User Dashboard - Dawala
    @elseif(Auth::user()->role == 'operator')
        Operator Dashboard - Dawala
    @elseif(Auth::user()->role == 'instantiation')
        Instantiation Dashboard - Dawala
    @else
        Dashboard - Dawala
    @endif

</title>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/backend/assets/css/bootstrap.css">
<link rel="stylesheet" href="/backend/assets/vendors/sweetalert2/sweetalert2.min.css">
<!-- fevicon -->
<link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/gif" />

<link rel="stylesheet" href="/backend/assets/vendors/iconly/bold.css">

<link rel="stylesheet" href="/backend/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
<link rel="stylesheet" href="/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="/backend/assets/css/app.css">
<link rel="shortcut icon" href="/backend/assets/images/favicon.svg" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
    }

    thead {
        background-color: #f2f2f2;
    }

    <blade media|%20(min-width%3A%20768px)%20%7B%0D>.col-md-2-5 {
        width: 20.83333333%;
    }
    }

</style>
@stack('css')
