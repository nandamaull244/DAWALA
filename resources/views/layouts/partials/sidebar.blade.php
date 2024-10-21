<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('assets') }}/img/logo.png" style="width: 100px; height: 70px;"
                            alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                @if (Auth::user()->role == 'admin')
                    @include('layouts.partials.sidebar.sidebar-admin')
                @endif

                @if (Auth::user()->role == 'instantiation')
                    @include('layouts.partials.sidebar.sidebar-instantiation')
                @endif

                @if (Auth::user()->role == 'operator')
                    @include('layouts.partials.sidebar.sidebar-operator')
                @endif

                @if (Auth::user()->role == 'user')
                    @include('layouts.partials.sidebar.sidebar-user')
                @endif

                <li class="sidebar-item  ">
                    <div class="text-center mb-3 mt-5">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
