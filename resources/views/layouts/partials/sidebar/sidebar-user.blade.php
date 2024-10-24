<li class="sidebar-item {{ request()->routeIs('user.user.dashboard') ? 'active' : '' }}">
    <a href="{{ route('user.user.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('user.form-ktp.*') ? 'active' : '' }}">
    <a href="{{ route('user.form-ktp.index') }}" class='sidebar-link'>
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>KTP</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('user.form-kk.*') ? 'active' : '' }}">
    <a href="{{ route('user.form-kk.index') }}" class='sidebar-link'>
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>KK</span>
    </a>
</li>
<li class="sidebar-item  ">
    <div class="text-center mb-3 mt-5">
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</li>
