<!DOCTYPE html>
<html lang="en">
    @include('pages.layouts.partials.header')

    <body>
        @include('pages.layouts.partials.navbar')

        @yield('content')

        @include('pages.layouts.partials.footer')
    </body>

</html>
