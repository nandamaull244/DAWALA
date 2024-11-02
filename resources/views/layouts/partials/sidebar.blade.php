<div id="sidebar" class="active">
    <div class="sidebar-wrapper active" style="width: 270px !important; max-width: 270px !important;">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href=""><img src="{{ asset('assets') }}/img/logo.png" style="width: 130px; height: 100px;"
                            alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-user-info px-4 py-3">
            <div class="d-flex flex-column">
                <div class="user-role mb-3">
                    @if (Auth::user()->role == 'admin')
                    <span class="badge bg-light-success fs-6">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif
                    @if (Auth::user()->role == 'operator')
                    <span class="badge bg-light-info fs-6">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif
                    @if (Auth::user()->role == 'instance')
                    <span class="badge bg-light-primary fs-6">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif
                    
                    @if (Auth::user()->role == 'user')
                    <span class="badge bg-light-warning fs-6">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif
                </div>
                <div class="user-name ">
                    <h5 class="mb-0">{{ Auth::user()->full_name }}</h5>
                    @if (Auth::user()->role == 'user')
                        <p class="text-muted">NIK: {{ Auth::user()->nik }}</p>
                    @endif
                    @if (Auth::user()->role == 'operator')
                        <p class="text-muted">Kecamatan: {{ Auth::user()->village->district->name }}</p>
                    @endif
                </div>
            </div>
        </div>
        {{-- <div class="notif px-4 py-3">
            <div class="position-relative">
                <button class="btn btn-light w-100 d-flex align-items-center justify-content-between" type="button" id="notificationButton" onclick="toggleNotifications()">
                    <h6 class="mb-0">Notifications</h6>
                    <span class="badge bg-danger">3</span>
                </button>
            </div>
        </div> --}}
        {{-- <div id="notificationPanel" class="notification-panel" style="display: none;">
            <div class="notification-header">
                <h6 class="mb-0">Notifications</h6>
                <button type="button" class="btn-close" onclick="toggleNotifications()"></button>
            </div>
            <div class="notification-body">
                <div class="notification-item">
                    <small class="text-muted">2 minutes ago</small>
                    <p class="mb-0 small">Your service request has been processed</p>
                </div>
                <div class="notification-item">
                    <small class="text-muted">1 hour ago</small>
                    <p class="mb-0 small">Document verification completed</p>
                </div>
                <div class="notification-item">
                    <small class="text-muted">Yesterday</small>
                    <p class="mb-0 small">New service status update available</p>
                </div>
            </div>
        </div> --}}
        <div class="sidebar-menu">
            <ul class="menu" style="margin-left: -20px !important; ">
                <li class="sidebar-title">Menu</li>

                @if (Auth::user()->role == 'admin')
                    @include('layouts.partials.sidebar.sidebar-admin')
                @endif

                @if (Auth::user()->role == 'instance')
                    @include('layouts.partials.sidebar.sidebar-instance')
                @endif

                @if (Auth::user()->role == 'operator')
                    @include('layouts.partials.sidebar.sidebar-operator')
                @endif

                @if (Auth::user()->role == 'user')
                    @include('layouts.partials.sidebar.sidebar-user')
                @endif

               
            </ul>
        </div>
        <div class="sidebar-menu mt-5" style="position: relative; bottom: 0; width: 100%; padding: 1rem;">
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'operator')
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 mb-2">Logout</button>
                </form>
            @endif

            @if (Auth::user()->role == 'user' || Auth::user()->role == 'instance')
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 mb-2">Logout</button>
                </form>
            @endif
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
</div>
