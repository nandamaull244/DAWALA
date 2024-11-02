@extends('layouts.main')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">
    <style>
        .col-lg-1-5 {
            max-width: 20%;
        }
    </style>
    <style>
        .fc {
            font-size: 0.9em;
        }

        .fc-toolbar-title {
            font-size: 1.2em !important;
        }

        .fc-event {
            border: none;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .fc-daygrid-day {
            height: 100px !important;
        }

        .fc-day-today {
            background: rgba(67, 94, 190, 0.05) !important;
        }

        .fc-button {
            padding: 4px 8px !important;
            font-size: 0.9em !important;
        }
    </style>
@endpush

@section('page-heading')
    Dashboard Admin
@endsection

@section('content')
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-1-5 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldDownload"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pengajuan Masuk</h6>
                                    <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['incoming_visit'] }}">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-6 col-lg-1-5 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pengajuan Proses</h6>
                                    <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['process_visit'] }}">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-6 col-lg-1-5 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldCalendar"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Jadwal Kunjungan</h6>
                                    <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['visit_scheduled'] }}">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-6 col-lg-1-5 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldDocument"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Dokumen Belum Diterima</h6>
                                    <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['document_recieved_visit'] }}">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-6 col-lg-1-5 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldTick-Square"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pengajuan Selesai</h6>
                                    <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['completed_visit'] }}">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Pengajuan yang Masuk dan Selesai Berdasarkan Kecamatan</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-12 col-lg-3 col-md-6"> --}}
            {{-- <div class="card">
                <div class="card-header">
                    <h4>Report User</h4>
                </div>
                <div class="card-body">
                    <div id="chart-visitors-profile"></div>
                </div>
            </div> --}}
        {{-- </div> --}}
        
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Jadwal Kunjungan</h4>
                </div>
                <div class="card-body">
                    <div id="visit-calendar"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('visit-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($data['visit_schedule']),
            eventColor: '#435ebe',
            eventTextColor: '#ffffff',
            height: 'auto',
            contentHeight: 500, 
            eventDisplay: 'block',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            },
            eventDidMount: function(info) {
                info.el.style.fontSize = '11px';         // Ukuran font lebih kecil
                info.el.style.padding = '2px 5px';       // Padding lebih kecil
                info.el.style.margin = '1px 0';          // Margin lebih kecil
                info.el.style.lineHeight = '1.2';        // Line height lebih kecil
                info.el.style.borderRadius = '3px';      // Border radius lebih kecil
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            views: {
                dayGridMonth: {
                    dayMaxEventRows: 4,    // Maksimal 4 event per hari
                    dayMaxEvents: true     // Tampilkan "+more" jika lebih
                }
            }
        });
        calendar.render();
    });

    $(document).ready(function () {
        $('.increment-number').each(function () {
            var $this = $(this);
            var countTo = $this.data('count'); 

            $({ countNum: 0 }).animate({ countNum: countTo }, {
                duration: 1500, 
                easing: 'swing',
                step: function () {
                    $this.text(formatNumber(Math.floor(this.countNum)));
                },
                complete: function () {
                    $this.text(formatNumber(this.countNum)); 
                }
            });
        });
    });

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var optionsProfileVisit = {
        series: @json($data['chart_data']['series']), 
        chart: {
            type: 'bar',
            height: 520,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'last', 
                dataLabels: {
                total: {
                        enabled: true,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        xaxis: {
            type: 'category',
            categories: @json($data['chart_data']['categories']),
        },
        yaxis: {
            decimalsInFloat: 0, 
            labels: {
                formatter: function (value) {
                    return Math.round(value); // Membulatkan nilai
                }
            }
        },
        legend: {
            position: 'right',
            offsetY: 40
        },
        fill: {
            opacity: 1
        },
    };

    var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
    chartProfileVisit.render();

    // var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)
    // chartVisitorsProfile.render()
</script>
@endpush
