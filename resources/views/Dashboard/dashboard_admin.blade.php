@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">
@endpush

@section('page-heading')
    Dashboard Admin
@endsection

@section('content')
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
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

                <div class="col-6 col-lg-3 col-md-6">
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

                <div class="col-6 col-lg-3 col-md-6">
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

                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldDocument"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Dokumen diterima</h6>
                                    <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['document_recieved_visit'] }}">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Pengajuan Berdasarkan Kecamatan</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
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
                            <h6 class="font-extrabold mb-0 increment-number" data-count="{{ $data['completed_visit']  }}">0</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Report User</h4>
                </div>
                <div class="card-body">
                    <div id="chart-visitors-profile"></div>
                </div>
            </div>
            
        </div>
        
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
            events: [
                { title: 'Kunjungan', date: '2024-10-15' },
                { title: 'Kunjungan', date: '2024-10-22' },
            ],
            eventColor: '#435ebe',
            eventTextColor: '#ffffff'
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
        annotations: {
            position: 'back'
        },
        dataLabels: {
            enabled: false
        },
        chart: {
            type: 'bar',
            height: 300,
            scrollX: true
        },
        fill: {
            opacity: 1
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        series: [{
            name: 'Total Pengajuan',
            data: [@foreach ($data['services_by_district'] as $item) {{ $item->total }}, @endforeach]
        }],
        colors: '#435ebe',
        xaxis: {
            categories: [@foreach ($data['services_by_district'] as $item) "{{ $item->name }}", @endforeach],
            tickPlacement: 'on',
            labels: {
                rotate: -45,
                rotateAlways: true,
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Jumlah Pengajuan'
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " pengajuan"
                }
            }
        }
    }

    let optionsVisitorsProfile  = {
        series: [@foreach ($data['services_by_category'] as $item) {{ $item->total }}, @endforeach],
        labels: [@foreach ($data['services_by_category'] as $item) "{{ $item->service_category }}", @endforeach],
        colors: ['#435ebe','#55c6e8'],
        chart: {
            type: 'donut',
            width: '100%',
            height:'350px'
        },
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '30%'
                }
            }
        }
    }


    var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
    var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)

    chartProfileVisit.render();
    chartVisitorsProfile.render()

</script>
@endpush
