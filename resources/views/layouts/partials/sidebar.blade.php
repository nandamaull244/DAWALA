<div id="sidebar" class="active">
    <div class="sidebar-wrapper active" style="width: 270px !important; max-width: 270px !important;">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href=""><img src="{{ asset('assets') }}/img/logo.png" style="width: 100px; height: 70px;"
                            alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-user-info px-4 py-3">
            <div class="d-flex flex-column">
                <div class="user-name mb-1">
                    <h6 class="mb-0">{{ Auth::user()->full_name }}</h6>
                    @if (Auth::user()->role == 'user')
                        <small class="text-muted">NIK: {{ Auth::user()->nik }}</small>
                    @endif
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'operator')
                        <small class="text-muted">Username: {{ Auth::user()->username }}</small>
                    @endif
                </div>
                <div class="user-role">
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'operator')
                        <span class="badge bg-light-success">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif

                    @if (Auth::user()->role == 'instance')
                        <span class="badge bg-light-primary">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif

                    @if (Auth::user()->role == 'user')
                        <span class="badge bg-light-warning">{{ ucfirst(Auth::user()->role) }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="notif px-4 py-3">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle w-100 d-flex align-items-center justify-content-between" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <h6 class="mb-0">Notifications</h6>
                    <span class="badge bg-danger">3</span>
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="notificationDropdown">
                    <li>
                        <div class="dropdown-item notification-item">
                            <small class="text-muted">2 minutes ago</small>
                            <p class="mb-0 small">Your service request has been processed</p>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-item notification-item">
                            <small class="text-muted">1 hour ago</small>
                            <p class="mb-0 small">Document verification completed</p>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-item notification-item">
                            <small class="text-muted">Yesterday</small>
                            <p class="mb-0 small">New service status update available</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu" style="margin-left: -20px !important; ">
                <li class="sidebar-title">Menu</li>

                @if (Auth::user()->role == 'admin')
                    @include('layouts.partials.sidebar.sidebar-admin')
                @endif

                @if (Auth::user()->role == 'institute')
                    @include('layouts.partials.sidebar.sidebar-institute')
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
                <form action="{{ route('logout-admin') }}" method="POST" style="display: inline;">
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
