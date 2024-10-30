<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>

    @if(Auth::user()->role == 'admin')
        Dashboard Admin - Dawala
    @elseif(Auth::user()->role == 'user')
        Dashboard User - Dawala
    @elseif(Auth::user()->role == 'operator')
        Dashboard Operator - Dawala
    @elseif(Auth::user()->role == 'institute')
        Dashboard Instansi - Dawala
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<style>
    body {
        font-family: Arial, sans-serif;
    }

    thead {
        background-color: #f2f2f2;
    }

    .col-md-2-5 {
        width: 20.83333333%;
    }

    .bg-warning {
        background-color: #f1b90e !important; 
        color: #ffffff !important;
    }

    .notification-panel {
        position: fixed;
        right: 20px;
        top: 20px;
        width: 300px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        overflow: hidden;
    }

    .notification-header {
        padding: 12px 15px;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-body {
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    /* Animasi untuk panel notifikasi */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    .notification-panel.show {
        animation: slideIn 0.3s ease forwards;
    }

    .notification-panel.hide {
        animation: slideOut 0.3s ease forwards;
    }

</style>
<style>
    .custom-larger-toast {
        width: 400px !important; 
        font-size: 20px !important;  
    }

    .custom-larger-toast .toast-message {
        font-size: 48px !important; 
    }

    .custom-larger-toast .toast-title {
        font-size: 40px !important;
    }

    .custom-larger-toast .toast-message:before {
        font-size: 24px !important;  
    }
</style>
@stack('css')
