(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top shadow-sm').css('top', '0px');
        } else {
            $('.nav-bar').removeClass('sticky-top shadow-sm').css('top', '-100px');
        }
    });

    // nav link active
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua link navbar
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
        // Dapatkan path dari URL saat ini
        const currentPath = window.location.pathname;
    
        console.log('Current Path:', currentPath); // Debugging untuk memeriksa current path
    
        // Fungsi untuk menghapus kelas active dari semua link
        function removeActiveClass() {
            navLinks.forEach(link => {
                link.classList.remove('active');
            });
        }
    
        // Set active pada link sesuai path saat ini
        navLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;
            
            console.log('Checking link:', linkPath); // Debugging untuk memeriksa tiap-tiap path link
    
            // Jika URL dari link sama dengan path saat ini atau path dimulai dengan /dokumentasi, tambahkan kelas active
            if (currentPath === linkPath || (currentPath.startsWith('/dokumentasi') && linkPath === '/dokumentasi')) {
                console.log('Matched Path:', linkPath); // Debugging jika ada path yang match
                removeActiveClass();
                link.classList.add('active');
            }
        });
    
        // Tambahkan kelas active pada link "Profil" jika berada di salah satu halaman dropdown
        const dropdownPaths = ['/tentang-dawala', '/visi-misi', '/tim-dawala'];
        const profileDropdown = document.querySelector('.navbar-nav .dropdown > .nav-link');
    
        if (dropdownPaths.includes(currentPath)) {
            console.log('Dropdown Path Matched:', currentPath); // Debugging jika ada path yang match di dropdown
            removeActiveClass();
            if (profileDropdown) {
                profileDropdown.classList.add('active');
            }
        }
        // Tambahkan kelas active pada link "layanan" jika berada di salah satu halaman dropdown
        const pathLayanan = ['/layanan', '/layanan-cepat'];
        const layananDropdown = document.querySelector('.navbar-nav .layanan > .nav-link');
    
        if (pathLayanan.includes(currentPath)) {
            console.log('Dropdown Path Matched:', currentPath); // Debugging jika ada path yang match di dropdown
            removeActiveClass();
            if (layananDropdown) {
                layananDropdown.classList.add('active');
            }
        }
       
        
    });
    
    
    
    
    
    
    
    // Header carousel
    $(".header-carousel").owlCarousel({
        animateOut: 'fadeOut',
        items: 1,
        margin: 0,
        stagePadding: 0,
        autoplay: true,
        smartSpeed: 500,
        dots: true,
        loop: true,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
    });



    // testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: true,
        dots: false,
        loop: true,
        margin: 10,
        nav: false,
        navText: [
            '<i class="fa fa-arrow-right"></i>',
            '<i class="fa fa-arrow-left"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 2
            },
            1200: {
                items: 2
            }
        }
    });

    

    // statistik carousel
    $(document).ready(function(){
        var owl = $(".statistik-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            center: true,
            dots: false,
            loop: true,
            nav: false, // Disable default nav
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });

        // Custom navigation
        $('#prevBtn').click(function() {
            owl.trigger('prev.owl.carousel');
        });
        $('#nextBtn').click(function() {
            owl.trigger('next.owl.carousel');
        });
    });
    // dokumentasi carousel
    $(document).ready(function(){
        $(".dokumentasi-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 200,
            margin: 25,
            loop: true,
            center: true,
            dots: false,
            nav: false,
            navText : [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ],
            responsive: {
                0:{
                    items:1
                },
                768:{
                    items:2
                },
                992:{
                    items:3
                }
            }
        });
    });

    // team carousel
    $(document).ready(function(){
        $(".team-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 200,
            margin: 25,
            loop: true,
            center: true,
            dots: false,
            nav: false,
            navText : [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ],
            responsive: {
                0:{
                    items:1
                },
                576:{
                    items:1
                },
                768:{
                    items:2
                },
                992:{
                    items:3
                }
            }
        });
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 5,
        time: 2000
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });


})(jQuery);