<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dawala Dashboard</title>
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
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-3 text-center">
                        <a href=""><img src="{{ asset('assets') }}/img/logo.png" alt="Logo"
                                style="width: 150px; height: auto;"></a>
                    </div>



                    <form action="index.html">
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="Masukan no NIK">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" class="form-control form-control-lg" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Masuk</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600" style="color: #0164eb; transition: color 0.3s;"
                            onmouseover="this.style.color='#003366'" onmouseout="this.style.color='#0164eb'">Tidak punya akun? <a href="{{ url('/register') }}" class="font-bold"
                                style="color: #0164eb; transition: color 0.3s;" onmouseover="this.style.color='#003366'"
                                onmouseout="this.style.color='#0164eb'">Daftar
                                </a>.</p>
                        <p><a class="font-bold" href="auth-forgot-password.html"
                                style="color: #0164eb; transition: color 0.3s;" onmouseover="this.style.color='#003366'"
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
</body>

</html>
