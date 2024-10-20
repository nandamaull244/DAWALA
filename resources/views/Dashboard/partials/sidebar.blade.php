<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{asset('assets')}}/img/logo.png"  style="width: 100px; height: 70px;" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item active ">
                    <a href="" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="{{ route('admin.form-ktp.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>KTP</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="{{ route('admin.form-kk.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>KK</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="{{ url('admin/table-data') }}" class='sidebar-link'>
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
                <li class="sidebar-item  ">
                    <div class="text-center mb-3 mt-5">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </li>


                
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>