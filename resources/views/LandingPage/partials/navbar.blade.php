  <!-- Navbar & Hero Start -->
  <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light"> 
                    <a href="#" class="navbar-brand p-0">
                        <img src="{{asset('assets')}}/img/logo.png" alt="Logo">
                     
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-0 mx-lg-auto ">
                            <a href="{{ url('/') }}" class="nav-item nav-link active">Beranda</a>
                            <div class="nav-item dropdown">
                                <a href="{{ url('/profile') }}" class="nav-item nav-link " data-bs-toggle="dropdown">
                                    <span class="dropdown-toggle">Profil</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ url('/tentang-dawala') }}" class="dropdown-item">Tentang Dawala</a>
                                    <a href="{{ url('/visi-misi') }}" class="dropdown-item">Visi Misi</a>
                                    <a href="{{ url('/tim-dawala') }}" class="dropdown-item">Tim Dawala</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown layanan">
                                <a href="{{ url('/layanan') }}" class="nav-item nav-link " data-bs-toggle="dropdown">
                                    <span class="dropdown-toggle">Layanan</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ url('/layanan') }}" class="dropdown-item">Semua Layanan</a>
                                    <a href="{{ url('/layanan-cepat') }}" class="dropdown-item">Layanan Cepat</a>
                                </div>
                            </div>
                            <a href="{{ url('/dokumentasi') }}" class="nav-item nav-link ">Dokumentasi</a>
                            <a href="{{ url('/FAQ') }}" class="nav-item nav-link ">FAQ</a>
                            
                            <div class="nav-btn px-2">
                                <a href="{{ url('/login') }}" class="btn btn-primary rounded-pill py-2 px-4 ms-3 flex-shrink-0"> Masuk Dawala</a>
                                <a href="{{ url('/register') }}" class="btn btn-success rounded-pill py-2 px-4 ms-3 flex-shrink-0"> Daftar Dawala</a>
                            </div>
                        </div>
                    </div>

                </nav>
            </div>
        </div>
        <!-- Navbar & Hero End -->
