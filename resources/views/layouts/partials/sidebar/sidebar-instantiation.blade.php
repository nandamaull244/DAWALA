<li class="sidebar-item {{ request()->routeIs('instantiation.dashboard') ? 'active' : '' }}">
    <a href="{{ route('instantiation.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('instantiation.form-ktp.*') ? 'active' : '' }}">
    <a href="{{ route('instantiation.form-ktp.index') }}" class='sidebar-link'>
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>KTP</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('instantiation.form-kk.*') ? 'active' : '' }}">
    <a href="{{ route('instantiation.form-kk.index') }}" class='sidebar-link'>
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
