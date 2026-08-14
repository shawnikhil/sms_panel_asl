<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached bg-navbar-light" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-md"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    @if(request()->routeIs('admin.dashboard'))
      <!-- Search -->
      <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
          <i class="bx bx-search fs-4 lh-0"></i>
          <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search..." />
        </div>
      </div>
      <!-- /Search -->
    @endif

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online d-flex align-items-center">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard.settings.profile') }}">
              <div class="d-flex">
                <div class="flex-grow-1">
                  <span class="fw-medium d-block">{{ $user->name ?? 'Admin' }}</span>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard.settings.profile') }}">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard.settings.security') }}">
              <i class="bx bx-lock me-2"></i>
              <span class="align-middle">Security</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li>
            <form action="{{ route('admin.logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </button>
            </form>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>
<!-- / Navbar -->
