<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - DAWALA-PEDULI</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/backend/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/backend/assets/css/app.css">
    <link rel="stylesheet" href="/backend/assets/css/pages/auth.css">
    <link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/x-icon">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="/backend/assets/images/cover-login.png" alt="Your Image" class="img-fluid">

                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-3 text-center">
                        <a href=""><img src="{{ asset('assets') }}/img/logo.png" alt="Logo"
                                style="width: 150px; height: auto;"></a>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible show fade">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="emailCheckForm" action="{{ route('check-email') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="email" class="form-control form-control-lg" name="email" placeholder="Masukan Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Cek Email</button>
                    </form>

                    <form id="resetPasswordForm" action="{{ route('reset-password') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="email" id="hiddenEmail">
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" class="form-control form-control-lg" name="password" id="newPassword" placeholder="Password Baru" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" onclick="togglePasswordVisibility('newPassword')" id="showNewPassword">
                            <label class="form-check-label" for="showNewPassword">Lihat Password</label>
                        </div>
                        
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Konfirmasi Password Baru" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Reset Password</button>
                    </form>

                    
                </div>
            </div>
            
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#emailCheckForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.exists) {
                            $('#hiddenEmail').val($('input[name="email"]').val());
                            $('#emailCheckForm').hide();
                            $('#resetPasswordForm').show();
                        } else {
                            alert('Email tidak ditemukan.');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });

      
                            function togglePasswordVisibility(passwordFieldId) {
                                var passwordInput = document.getElementById(passwordFieldId);
                                if (passwordInput.type === "password") {
                                    passwordInput.type = "text";
                                } else {
                                    passwordInput.type = "password";
                                }
                            }
                       
    </script>
</body>

</html>
