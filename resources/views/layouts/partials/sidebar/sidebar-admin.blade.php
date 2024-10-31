<li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item has-sub">
    <span href="#" class='sidebar-link'>
        <i class="bi bi-people"></i>
        <span>Pelayanan</span>
    </span>
    <ul class="submenu {{ request()->routeIs('admin.pelayanan.*') ? 'active' : '' }}">
        <li class="sidebar-item {{ request()->routeIs('admin.pelayanan.index') ? 'active' : '' }}">
            <a href="{{ route('admin.pelayanan.index') }}" class='sidebar-link'>
                <i class="bi bi-archive-fill"></i>
                <span>Arsip Layanan</span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item has-sub">
    <span href="#" class='sidebar-link'>
        <i class="bi bi-newspaper"></i>
        <span>Artikel</span>
    </span>
    <ul class="submenu {{ request()->routeIs('admin.article.*') ? 'active' : '' }}">
        <li class="sidebar-item {{ request()->routeIs('admin.article.index') ? 'active' : '' }}">
            <a href="{{ route('admin.article.index') }}" class='sidebar-link'>
                <i class="bi bi-table"></i>
                <span>Data Artikel</span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item has-sub">
    <span href="#" class='sidebar-link'>
        <i class="bi bi-people"></i>
        <span>Manajemen Akun</span>
    </span>
    <ul class="submenu {{ request()->routeIs('admin.manajemen-akun.*') ? 'active' : '' }}">
        <li class="sidebar-item {{ request()->routeIs('admin.manajemen-akun.index') ? 'active' : '' }}">
            <a href="{{ route('admin.manajemen-akun.index') }}" class='sidebar-link'>
                <i class="bi bi-table"></i>
                <span>Data Akun</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('admin.manajemen-akun.verification') ? 'active' : '' }}">
            <a href="{{ route('admin.manajemen-akun.verification') }}" class='sidebar-link'>
                <i class="bi bi-file-earmark-text"></i>
                <span>Verifikasi Akun</span>
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('admin.manajemen-akun.create-operator') ? 'active' : '' }}">
            <a href="{{ route('admin.manajemen-akun.create-operator') }}" class='sidebar-link'>
                <i class="bi bi-person-plus"></i>
                <span>Akun Operator</span>
            </a>
        </li>
    </ul>
</li>

