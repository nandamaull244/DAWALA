<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DAWALA PEDULI - Datangi Warga Layani</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap"
        rel="stylesheet">
    <!-- fevicon -->
    <link rel="icon" href="{{ asset('assets') }}/img/logo.png" type="image/gif" />
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="{{ asset('assets') }}/lib/animate/animate.min.css" />
    <link href="{{ asset('assets') }}/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets') }}/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    @include('partialsLandingPage.navbar')

    <!-- Main Content -->
     
    
        @yield('content')
   

    <!-- Footer -->
    @include('partialsLandingPage.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/lib/wow/wow.min.js"></script>
    <script src="{{ asset('assets') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('assets') }}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{ asset('assets') }}/lib/counterup/counterup.min.js"></script>
    <script src="{{ asset('assets') }}/lib/lightbox/js/lightbox.min.js"></script>
    <script src="{{ asset('assets') }}/lib/owlcarousel/owl.carousel.min.js"></script>
    


    <!-- Template Javascript -->
    <script src="{{ asset('assets') }}/js/main.js"></script>
</body>

</html>