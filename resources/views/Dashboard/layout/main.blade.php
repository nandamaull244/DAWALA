<!DOCTYPE html>
<html lang="en">
<head>
    @include('Dashboard.partials.header')
</head>

<body>
    <div id="app">
        <div id="main">

            @include('Dashboard.partials.sidebar')

            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            @include('Dashboard.partials.footer')

        </div>
    </body>
</html>