<footer>
    <div class="footer clearfix mt-5 mb-0 text-muted">
        <div class="float-start">
            <p>2024 &copy; DAWALA PEDULI</p>
        </div>
        <div class="float-end">
           <p>by <a href="https://agenzycreative.com">Agenzy Creative</a></p>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        flatpickr.localize(flatpickr.l10ns.id);
        $(".flatpickr").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d F Y",
            locale: "id",
            disableMobile: "true",
            defaultDate: ""
        });

        $(".flatpickr-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d F Y",
            locale: "id",
            disableMobile: "true",
            defaultDate: "today"
        });

        $(".flatpickr-min-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d F Y",
            locale: "id",
            disableMobile: "true",
            defaultDate: "today",
            minDate: "today", 
            disable: [
                function(date) {
                    return date < new Date().setHours(0,0,0,0);
                }
            ],
        });
        var birthDate = "";
        @if (auth()->user()->role == 'user') 
            var birthDate = "{{ auth()->user()->birth_date }}";
        @endif

        $(".flatpickr-birth-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d F Y",
            locale: "id",
            disableMobile: "true",
            defaultDate: birthDate,
            maxDate: "today",
            parseDate: (datestr, format) => {
                return flatpickr.parseDate(datestr, "Y-m-d");
            },
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
            "className": "custom-larger-toast"
        };

        toastr.options.onShown = function() {
            $('.toast').css({
                'width': '360px',
                'font-size': '18px',
                'min-height': '60px'
            });
            $('.toast .toast-title').css('font-size', '21px');
            $('.toast .toast-message').css('font-size', '17px');
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
    
    function toggleNotifications() {
        const panel = document.getElementById('notificationPanel');
        if (panel.style.display === 'none') {
            panel.style.display = 'block';
            panel.classList.remove('hide');
            panel.classList.add('show');
        } else {
            panel.classList.remove('show');
            panel.classList.add('hide');
            setTimeout(() => {
                panel.style.display = 'none';
            }, 300);
        }
    }

    // Menutup panel ketika mengklik di luar
    document.addEventListener('click', function(event) {
        const panel = document.getElementById('notificationPanel');
        const button = document.getElementById('notificationButton');
        if (!panel.contains(event.target) && !button.contains(event.target) && panel.style.display !== 'none') {
            toggleNotifications();
        }
    });
</script>
@stack('scripts')


