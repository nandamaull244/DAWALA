<li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <span href="#" class='sidebar-link disabled'>
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Kependudukan</span>
    </span>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="{{ route('admin.arsip-kependudukan.index') }}" class='sidebar-link'>
                Arsip Kependudukan
            </a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('admin.form-kk.index') }}" class='sidebar-link'>
                Form KK
            </a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('admin.form-ktp.index') }}" class='sidebar-link'>
                Form KTP
            </a>
        </li>
    </ul>
</li>
