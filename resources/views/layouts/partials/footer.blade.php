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
        var today = new Date();

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

        $(".flatpickr-first-day-in-month").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d F Y",
            locale: "id",
            disableMobile: "true",
            defaultDate: today.setDate(1)
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

        $(".flatpickr-max-date").flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d F Y",
            locale: "id",
            disableMobile: "true",
            defaultDate: "today",
            maxDate: "today"
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

        const date17YearsAgo = new Date(today.setFullYear(today.getFullYear() - 17));
        $(".flatpickr-birth-date-check").flatpickr({
            dateFormat: "Y-m-d",
            maxDate: date17YearsAgo,
            altInput: true,
            altFormat: "d F Y",
            clickOpens: true,
            disableMobile: "true",
            defaultDate: date17YearsAgo,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September', 'Oktober', 'November', 'Desember'
                    ]
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                const birthDate = new Date(dateStr);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                if (age < 17) {
                    toastr.error('Anda harus berusia minimal 17 tahun untuk mendaftar', 'Gagal!', {
                        timeOut: 3000,
                        closeButton: true,
                        progressBar: true
                    });
                    instance.clear();
                    return false;
                }
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

    $(document).ready(function() {
        $(document).on('click', function(event) {
            const $panel = $('#notificationPanel');
            const $button = $('#notificationButton');

            if ($panel.length && $button.length) {
                if (!$panel.is(event.target) && !$button.is(event.target) && $panel.is(':visible')) {
                    toggleNotifications();
                }
            }
        });
    });

</script>
@stack('scripts')


