<li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <span href="#" class='sidebar-link disabled'>
        <i class="bi bi-people"></i>
        <span>Pelayanan</span>
    </span>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="{{ route('admin.pelayanan.index') }}" class='sidebar-link'>
                <i class="bi bi-archive-fill"></i>
                <span>Arsip Layanan</span>
            </a>
        </li>
    </ul>
    
</li>
<li class="sidebar-item has-sub">
    <span href="#" class='sidebar-link disabled'>
        <i class="bi bi-newspaper"></i>
        <span>Artikel</span>
    </span>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="{{ route('admin.article.index') }}" class='sidebar-link'>
                <i class="bi bi-table"></i>
                <span>Data Artikel</span>
            </a>
        </li>
    </ul>
    <li class="sidebar-item has-sub">
        <span href="#" class='sidebar-link disabled'>
            <i class="bi bi-people"></i>
            <span>Akun Manajemen</span>
        </span>
        <ul class="submenu ">
            <li class="submenu-item ">
                <a href="{{ route('admin.manajemen-akun.index') }}" class='sidebar-link'>
                    <i class="bi bi-table"></i>
                    <span>Data Akun</span>
                </a>
            </li>
            <li class="submenu-item ">
                <a href="{{ route('admin.manajemen-akun.create') }}" class='sidebar-link'>
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Form Akun</span>
                </a>
            </li>
            <li class="submenu-item ">
                <a href="{{ route('admin.manajemen-akun.verification') }}" class='sidebar-link'>
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Verifikasi Akun</span>
                </a>
            </li>
    
           
           
        </ul>
    </li>
</li>

