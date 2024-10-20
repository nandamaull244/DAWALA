<li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('admin.form-ktp.*') ? 'active' : '' }}">
    <a href="{{ route('admin.form-ktp.index') }}" class='sidebar-link'>
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>KTP</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('admin.form-kk.*') ? 'active' : '' }}">
    <a href="{{ route('admin.form-kk.index') }}" class='sidebar-link'>
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>KK</span>
    </a>
</li>
<li class="sidebar-item {{ request()->routeIs('admin.arsip-kependudukan.*') ? 'active' : '' }}">
    <a href="{{ route('admin.arsip-kependudukan.index') }}" class='sidebar-link'>
        <i class="bi bi-file-earmark-text-fill"></i>
        <span>Data table</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link'>
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Layouts</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="layout-default.html">Default Layout</a>
        </li>
        <li class="submenu-item ">
            <a href="layout-vertical-1-column.html">1 Column</a>
        </li>
        <li class="submenu-item ">
            <a href="layout-vertical-navbar.html">Vertical with Navbar</a>
        </li>
        <li class="submenu-item ">
            <a href="layout-horizontal.html">Horizontal Menu</a>
        </li>
    </ul>
</li>
