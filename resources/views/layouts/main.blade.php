<!DOCTYPE html>
<html lang="en">

    <head>
        @include('layouts.partials.header')
    </head>

    <body>
        <div id="app">
            <div id="main">

                @include('layouts.partials.sidebar')

                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>

                @php
                    $pageHeading = trim($__env->yieldContent('page-heading'));
                    $pageSubheading = trim($__env->yieldContent('page-subheading'));
                @endphp
                <div class="page-heading" style="margin: 0 -10px 0 -5px !important;">
                    <h2>{{ $pageHeading }}</h2>

                    @if ($pageHeading && $pageHeading !== 'Dashboard')
                        <div class="page-title">
                            <div class="row">
                                <div class="col-12 col-md-7 order-md-1 order-last">
                                    @if (!empty($pageSubheading))
                                        <p class="text-subtitle text-muted">{{ $pageSubheading }}</p>
                                    @endif
                                </div>
                                <div class="col-12 col-md-5 order-md-2 order-first">
                                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a
                                                    href="{{ dashboardRedirect(Auth::user()->role) }}">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item">{{ $pageHeading }}</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="page-content" style="margin: 0 -15px 0 -50px !important;">
                    @yield('content')
                </div>

                @include('layouts.partials.footer')

            </div>
    </body>

</html>
