<li class="sidebar-item {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
    <a href="{{ route('operator.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item has-sub">
    <span href="#" class='sidebar-link'>
        <i class="bi bi-people"></i>
        <span>Pelayanan</span>
    </span>
    <ul class="submenu {{ request()->routeIs('operator.pelayanan.*') ? 'active' : '' }}" style="list-style-type: none;">
        <li class="sidebar-item {{ request()->routeIs('operator.pelayanan.index') ? 'active' : '' }}">
            <a href="{{ route('operator.pelayanan.index') }}" class='sidebar-link'>
                <i class="bi bi-archive-fill"></i>
                <span>Arsip Layanan</span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item has-sub">
    <a href="javascript:void(0)" class='sidebar-link'>
        <i class="bi bi-people"></i>
        <span>Manajemen Akun</span>
    </a>
    <ul class="submenu {{ request()->routeIs('operator.manajemen-akun.*') ? 'active' : '' }}" style="list-style-type: none;">
        <li class="sidebar-item {{ request()->routeIs('operator.manajemen-akun.index') ? 'active' : '' }}">
            <a href="{{ route('operator.manajemen-akun.index') }}" class='sidebar-link'>
                <i class="bi bi-table"></i>
                <span>Data Akun</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('operator.manajemen-akun.verification') ? 'active' : '' }}">
            <a href="{{ route('operator.manajemen-akun.verification') }}" class='sidebar-link'>
                <i class="bi bi-file-earmark-text"></i>
                <span>Verifikasi Akun</span>
            </a>
        </li>
    </ul>
</li>