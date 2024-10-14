<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dawala Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/backend/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/backend/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/backend/assets/css/app.css">
    <link rel="stylesheet" href="/backend/assets/css/pages/auth.css">
    <link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/x-icon">
    <style>
        body {
            background-image: url('{{ asset('assets') }}/img/1.png');
            background-size: cover;
            background-position: center;
        
        }
        #auth-left {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control {
            border-radius: 20px;
        }
        .btn-primary {
            border-radius: 20px;
            background-color: #4e73df;
            border-color: #4e73df;
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row h-100 justify-content-center align-items-center my-5 mb-5"> <!-- Added margin top and bottom -->
            <div class="col-lg-8 col-6">
                <div id="auth-left">
                    <h4 class="auth-title text-center">Registrasi Akun</h4>
                    <p class="auth-subtitle mb-5 text-center">Buat akun untuk urusan pelayanan</p>

                    <form action="index.html">
                        <div class="form-group mb-4">
                            <label for="sub-category-select">Pilih kategori akun:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="perorangan" value="perorangan" onclick="toggleSubCategory(false)">
                                <label class="form-check-label" for="perorangan">Perorangan/umum diri sendiri</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="kolektor" value="kolektor" onclick="toggleSubCategory(true)">
                                <label class="form-check-label" for="kolektor">Kolektor</label>
                            </div>
                        </div>
                        <div id="sub-category" class="form-group mb-4" style="display: none;">
                            <label for="sub-category-select">Pilih Pengelompokan:</label>
                            <div class="position-relative">
                                <select class="form-control form-control-xl" id="sub-category-select">
                                    <option value="rt">RT</option>
                                    <option value="rw">RW</option>
                                    <option value="yayasan">Yayasan</option>
                                    <option value="instansi">Instansi</option>
                                </select>
                                <div class="form-control-icon" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <i class="bi bi-chevron-down" style="font-size: 1.25rem; transition: transform 0.3s; width: 100%; max-width: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Nama Lengkap">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="NIK">
                            <div class="form-control-icon">
                                <i class="bi bi-card-text"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="No Kartu Keluaga">
                            <div class="form-control-icon">
                                <i class="bi bi-card-text"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="tel" class="form-control form-control-xl" placeholder="No. Handphone (Whatsapp)">
                            <div class="form-control-icon">
                                <i class="bi bi-phone"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Ulangi Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Saya menyetujui syarat dan ketentuan
                            </label>
                        </div>
                        <button class="btn btn-primary"
                            style="width: 100%; padding: 10px; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); font-size: 1.25rem;"
                            onmouseover="this.style.backgroundColor='#003366'"
                            onmouseout="this.style.backgroundColor='#0164eb'">Masuk</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p>Sudah punya akun? <a href="{{ url('/login') }}" class="font-bold"  style="color: #0164eb; transition: color 0.3s;" onmouseover="this.style.color='#003366'"
                            onmouseout="this.style.color='#0164eb'">Masuk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleSubCategory(show) {
            document.getElementById('sub-category').style.display = show ? 'block' : 'none';
        }
    </script>
</body>


</html>
