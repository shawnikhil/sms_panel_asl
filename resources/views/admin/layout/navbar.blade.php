@php
  $pageMap = [
    'admin.dashboard'                    => ['icon' => 'bxs-dashboard',     'section' => 'Home',      'title' => 'Dashboard'],
    'admin.master.admin_register'        => ['icon' => 'bx-user-plus',      'section' => 'Master',    'title' => 'Admin Register'],
    'admin.master.user_register'         => ['icon' => 'bx-user-check',     'section' => 'Master',    'title' => 'User Register'],
    'admin.master.company_setup'         => ['icon' => 'bx-building',       'section' => 'Master',    'title' => 'Company Setup'],
    'admin.account.add_bank'             => ['icon' => 'bx-bank',           'section' => 'Account',   'title' => 'Add Bank'],
    'admin.account.fund_transfer'        => ['icon' => 'bx-transfer-alt',   'section' => 'Account',   'title' => 'Fund Transfer'],
    'admin.package.new_package'          => ['icon' => 'bx-package',        'section' => 'Package',   'title' => 'New Package'],
    'admin.scheduler.sms_api'           => ['icon' => 'bx-chip',            'section' => 'Scheduler', 'title' => 'SMS API Setup'],
    'admin.manage.sender_id'             => ['icon' => 'bx-id-card',        'section' => 'Manage',    'title' => 'Sender ID'],
    'admin.manage.template'              => ['icon' => 'bx-file',           'section' => 'Manage',    'title' => 'Templates'],
    'admin.reports.sms_details'          => ['icon' => 'bx-bar-chart-alt-2','section' => 'Reports',   'title' => 'SMS Details'],
    'admin.reports.sms_live_panel'       => ['icon' => 'bx-broadcast',      'section' => 'Reports',   'title' => 'SMS Live Panel'],
    'admin.reports.user_details'         => ['icon' => 'bx-group',          'section' => 'Reports',   'title' => 'User Details'],
    'admin.reports.fund_transfer'        => ['icon' => 'bx-money',          'section' => 'Reports',   'title' => 'Fund Transfer Report'],
    'admin.reports.all_user_ledger'      => ['icon' => 'bx-spreadsheet',    'section' => 'Reports',   'title' => 'All User Ledger'],
    'admin.reports.user_wise_ledger'     => ['icon' => 'bx-list-ul',        'section' => 'Reports',   'title' => 'User Wise Ledger'],
    'admin.help.help_setup'              => ['icon' => 'bx-help-circle',    'section' => 'Help',      'title' => 'Help Setup'],
    'admin.help.notification'            => ['icon' => 'bx-bell',           'section' => 'Help',      'title' => 'Notifications'],
    'admin.dashboard.settings.profile'  => ['icon' => 'bx-user-circle',    'section' => 'Settings',  'title' => 'My Profile'],
    'admin.dashboard.settings.api_keys' => ['icon' => 'bx-key',            'section' => 'Settings',  'title' => 'API Keys'],
    'admin.dashboard.settings.security' => ['icon' => 'bx-shield-quarter', 'section' => 'Settings',  'title' => 'Security'],
  ];
  $route   = request()->route()?->getName() ?? '';
  $page    = $pageMap[$route] ?? ['icon' => 'bx-circle', 'section' => 'Admin', 'title' => 'Console'];
@endphp

<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center" id="layout-navbar"
     style="background:var(--bg-navbar);backdrop-filter:blur(16px);border:1px solid var(--border-color);
            box-shadow:var(--shadow-card);border-radius:1rem;margin:0.75rem 1.5rem 0.5rem;
            padding:0 1.25rem;min-height:60px;transition:all .3s ease;">

  {{-- Mobile toggle --}}
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 d-xl-none">
    <a class="nav-item nav-link px-0" href="javascript:void(0)">
      <i class="bx bx-menu bx-md"></i>
    </a>
  </div>

  {{-- LEFT: Page identity (hidden on dashboard where search fills this space) --}}
  @if(!request()->routeIs('admin.dashboard'))
    <div class="d-flex align-items-center gap-2 me-auto">
      {{-- Icon badge --}}
      <div style="width:36px;height:36px;border-radius:.6rem;
                  background:linear-gradient(135deg,#4f46e5 0%,#3b82f6 100%);
                  display:flex;align-items:center;justify-content:center;flex-shrink:0;
                  box-shadow:0 4px 10px rgba(79,70,229,.28);">
        <i class="bx {{ $page['icon'] }}" style="color:#fff;font-size:1.1rem;"></i>
      </div>
      {{-- Title --}}
      <div class="d-flex flex-column" style="line-height:1.1;">
        <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--brand-primary);">
          {{ $page['section'] }}
        </span>
        <span style="font-size:.9rem;font-weight:700;color:var(--text-primary);">
          {{ $page['title'] }}
        </span>
      </div>
    </div>
  @endif

  {{-- RIGHT: Search (dashboard only) + theme toggle + user --}}
  <div class="navbar-nav-right d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? '' : 'ms-auto' }}" id="navbar-collapse">

    @if(request()->routeIs('admin.dashboard'))
      <div class="navbar-nav align-items-center me-auto">
        <div class="nav-item d-flex align-items-center">
          <i class="bx bx-search fs-4 lh-0"></i>
          <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search..." />
        </div>
      </div>
    @endif

    <ul class="navbar-nav flex-row align-items-center ms-auto gap-1">
      {{-- Theme toggle --}}
      <li class="nav-item">
        <a class="nav-link style-switcher-toggle hide-arrow px-2" href="javascript:void(0);"
           id="admin-theme-toggle" title="Toggle Light / Dark Mode">
          <i class="bx bx-sm bx-moon" id="admin-theme-icon"></i>
        </a>
      </li>

      {{-- User --}}
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
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
          <li><hr class="dropdown-divider" /></li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard.settings.profile') }}">
              <i class="bx bx-user me-2"></i><span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard.settings.security') }}">
              <i class="bx bx-lock me-2"></i><span class="align-middle">Security</span>
            </a>
          </li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <form action="{{ route('admin.logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="bx bx-power-off me-2"></i><span class="align-middle">Log Out</span>
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- / Navbar -->
