<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - DAWALA-PEDULI</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="/backend/assets/css/bootstrap.css">
        <link rel="stylesheet" href="/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="/backend/assets/css/app.css">
        <link rel="stylesheet" href="/backend/assets/css/pages/auth.css">
        <link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <style>
            #toast-container .toast {
                width: 400px !important;
            }
            
            #toast-container .toast-message {
                font-size: 20px !important;
            }
            
            #toast-container .toast-title {
                font-size: 18px !important;
            }
            
            #toast-container .toast-message:before {
                font-size: 24px !important;
            }
        </style>
    </head>
    <body>
        <div id="auth">
            <div class="row h-100">
                <div class="col-lg-5 col-12">
                    <div id="auth-left">
                        <div class="auth-logo mb-3 text-center">
                            <a href=""><img src="{{ asset('assets') }}/img/logo.png" alt="Logo" style="width: 150px; height: auto;"></a>
                        </div>

                        <form action="" method="POST" id="loginForm">
                            @csrf
                            <div class="form-group position-relative has-icon-left mb-3 ">
                                <input type="text" class="form-control form-control-lg rounded" name="nik" placeholder="Masukan NIK" id="nik">
                                <input type="hidden" name="username" id="username">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-2">
                                <input type="password" class="form-control form-control-lg rounded" name="password" id="password" placeholder="Password">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" onclick="togglePassword()" id="showPassword">
                                <label class="form-check-label" for="showPassword">Lihat Password</label>
                            </div>

                            <button class="btn btn-primary" type="submit" style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;">Masuk</button>
                        </form>
                        <div class="text-center mt-5 text-lg fs-4">
                            <p class="text-gray-600" style="color: #0164eb; transition: color 0.3s;"
                                onmouseover="this.style.color='#003366'" onmouseout="this.style.color='#0164eb'">Tidak
                                punya
                                akun? <a href="{{ url('/auth/register') }}" class="font-bold"
                                    style="color: #0164eb; transition: color 0.3s;"
                                    onmouseover="this.style.color='#003366'"
                                    onmouseout="this.style.color='#0164eb'">Daftar
                                </a>.</p>
                            <p><a href="{{ url('/auth/forgot-password') }}" class="font-bold"
                                    style="color: #0164eb; transition: color 0.3s;"
                                    onmouseover="this.style.color='#003366'"
                                    onmouseout="this.style.color='#0164eb'">Lupa password?</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right">
                        <img src="/backend/assets/images/cover-login.png" alt="Your Image" class="img-fluid">
                    </div>
                </div>
            </div>

        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>

            // $('#loginForm').submit(function(e) {
            //     e.preventDefault();
            //     this.submit();
            // });


            $(document).ready(function() {
                $('#nik').on('keyup', function() {
                    let nikValue = $(this).val();
                    if (/[a-zA-Z]/.test(nikValue)) {
                        $('#username').val(nikValue);
                        $('#loginForm').attr('action', "{{ route('login-admin.process') }}"); 
                    } else {
                        $('#username').val(''); 
                        $('#loginForm').attr('action', "{{ route('login-user.process') }}"); 
                    }
                });
                
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "onShown": function() {
                        $('.toast').addClass('custom-larger-toast');
                    }
                };

                @if (session('success'))
                    toastr.success("{{ session('success') }}", "Berhasil!");
                @endif

                @if (session('error'))
                    toastr.error("{{ session('error') }}", "Gagal!");
                @endif

                @if (session('warning'))
                    toastr.warning("{{ session('warning') }}", "Perhatian!");
                @endif

                @if (session('info'))
                    toastr.info("{{ session('info') }}", "Informasi");
                @endif
            });

            function togglePassword() {
                var passwordInput = document.getElementById("password");
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }
        </script>
    </body>

</html>
