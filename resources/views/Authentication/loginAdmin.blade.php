<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DAWALA-PEDULI</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/backend/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/backend/assets/css/app.css">
    <link rel="stylesheet" href="/backend/assets/css/pages/auth.css">
    <link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/x-icon">
</head>

<body>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    @endif

    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img src="/backend/assets/images/login-admin.png" alt="Your Image" class="img-fluid">

                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-3 text-center">
                        <a href=""><img src="{{ asset('assets') }}/img/logo.png" alt="Logo"
                                style="width: 150px; height: auto;"></a>
                    </div>
                    <div class="auth-logo mb-3 text-center">
                        <h4>Login Admin</h4>
                    </div>



                    <form action="{{ route('login-admin.process') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-3 ">
                            <input type="text" class="form-control form-control-lg rounded" name="username"
                                placeholder="Masukan Username">
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


                        <button class="btn btn-primary" type="submit"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Masuk</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        
                        <p><a href="{{ url('/forgot-password') }}" class="font-bold"
                                style="color: #0164eb; transition: color 0.3s;" onmouseover="this.style.color='#003366'"
                                onmouseout="this.style.color='#0164eb'">Lupa password?</a></p>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
    <script>
        setTimeout(function () {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(function () {
                    alert.remove();
                }, 150); // Delay for fade out effect
            }
        }, 2000); // 2 seconds

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
