<li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item  has-sub">
    <span href="#" class='sidebar-link disabled'>
        <i class="bi bi-people"></i>
        <span>Kependudukan</span>
    </span>
    <ul class="submenu ">
        <li class="submenu-item ">
            <a href="{{ route('admin.arsip-kependudukan.index') }}" class='sidebar-link'>
                <i class="bi bi-archive-fill"></i>
                <span>Arsip Kependudukan</span>
            </a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('admin.form-kk.index') }}" class='sidebar-link'>
                <i class="bi bi-file-earmark-text"></i>
                <span>Form KK</span>
            </a>
        </li>
        <li class="submenu-item ">
            <a href="{{ route('admin.form-ktp.index') }}" class='sidebar-link'>
                <i class="bi bi-person-badge"></i>
                <span>Form KTP</span>
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
        <li class="submenu-item ">
            <a href="{{ route('admin.form-artikel.index') }}" class='sidebar-link'>
                <i class="bi bi-file-earmark-text"></i>
                <span>Form Artikel</span>
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
                <a href="{{ route('admin.akun-manajemen.index') }}" class='sidebar-link'>
                    <i class="bi bi-table"></i>
                    <span>Data Akun</span>
                </a>
            </li>
            <li class="submenu-item ">
                <a href="{{ route('admin.akun-manajemen.create') }}" class='sidebar-link'>
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Form Akun</span>
                </a>
            </li>
            <li class="submenu-item ">
                <a href="{{ route('admin.akun-manajemen.verification-table') }}" class='sidebar-link'>
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Verifikasi Akun</span>
                </a>
            </li>
    
           
           
        </ul>
    </li>
</li>
<li class="sidebar-item has-sub">
    <div class="text-center mb-3 mt-5">
        <form action="{{ route('logout-admin') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</li>

