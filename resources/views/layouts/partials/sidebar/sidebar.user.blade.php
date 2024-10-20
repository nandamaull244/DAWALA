<li class="sidebar-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
    <a href="{{ route('user.dashboard') }}" class='sidebar-link'>
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
