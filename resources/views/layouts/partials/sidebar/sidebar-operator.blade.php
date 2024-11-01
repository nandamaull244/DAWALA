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
    <ul class="submenu {{ request()->routeIs('operator.report.*') ? 'active' : '' }}" style="list-style-type: none;">
        <li class="sidebar-item {{ request()->routeIs('operator.report.index') ? 'active' : '' }}">
            <a href="{{ route('operator.report.index') }}" class='sidebar-link'>
                <i class="bi bi-archive-fill"></i>
                <span>Laporan Layanan</span>
            </a>
        </li>
    </ul>
</li>