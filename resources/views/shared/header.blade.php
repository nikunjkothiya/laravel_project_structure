<!-- ======= Header ======= -->

<header id="header" class="header fixed-top d-flex align-items-center no-print">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('public/assets/img/logo.png')}}" alt="logo">
        </a>
    </div>

    <nav id="navbar" class="navbar ms-auto">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('projects.index') }}"
                    class="nav-link {{ Route::is('projects.index', 'projects.show') ? 'active' : '' }}">
                    <span>Projects</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('managers.index') }}" class="nav-link {{ Route::is('managers.index') ? 'active' : '' }}">
                    Managers / Users
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('staffs.index') }}" class="nav-link {{ Route::is('staffs.index') ? 'active' : '' }}">
                    Staff
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative;">
                    <i class="bi bi-bell"></i>
                    <span id="notification-count" class="badge bg-danger" style="position: absolute; top: -5px; right: -5px; font-size: 10px; padding: 2px 4px; border-radius: 50%;">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 250px; max-height: 300px; padding: 0; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow-y: auto;">
                    <ul id="notifications-list" class="list-group list-group-flush">
                        <li class="list-group-item text-center">No new notifications</li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

</header>
<!-- End Header -->