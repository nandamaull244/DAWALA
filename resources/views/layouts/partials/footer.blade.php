<footer>
    <div class="footer clearfix mt-5 mb-0 text-muted">
        <div class="float-start">
            <p>2021 &copy; Mazer</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                    href="http://ahmadsaugi.com">A. Saugi</a></p>
        </div>
    </div>
</footer>

<script src="/backend/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/backend/assets/js/bootstrap.bundle.min.js"></script>

<script src="/backend/assets/vendors/apexcharts/apexcharts.js"></script>
<script src="/backend/assets/js/pages/dashboard.js"></script>

<script src="/backend/assets/js/main.js"></script>
{{-- <script src="{{ asset('assets/js/bootstrap.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/app.js') }}"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
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
            "hideMethod": "fadeOut"
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
</script>
@stack('scripts')
