<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder mb-0" style="font-size: 35px;">@yield('title')</h6>
        </nav>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link text-dark" href="{{ route('logout') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i> <!-- تغيير الأيقونة إلى logout -->
                    </div>
                    <span class="nav-link-text ms-1">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navbar -->
