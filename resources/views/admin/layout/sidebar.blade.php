<!-- Modern Enterprise Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical menu modern-asl-sidebar">
  
  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-3 ps-0">
    
    {{-- Section: Core --}}
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">MAIN</span>
    </li>

    {{-- 1. DASHBOARD --}}
    <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a href="{{ route('admin.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-dashboard"></i>
        <div class="menu-text-label">Dashboard</div>
      </a>
    </li>

    {{-- Section: Management --}}
    <li class="menu-header small text-uppercase mt-2">
      <span class="menu-header-text">MANAGEMENT</span>
    </li>

    {{-- 2. MASTER --}}
    <li class="menu-item {{ request()->routeIs(['admin.master.admin_register','admin.master.user_register']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
        <div class="menu-text-label">Master</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.master.admin_register') ? 'active' : '' }}">
          <a href="{{ route('admin.master.admin_register') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Admin Profile</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.master.user_register') ? 'active' : '' }}">
          <a href="{{ route('admin.master.user_register') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">User Register</div>
          </a>
        </li>
      </ul>
    </li>

    {{-- 3. ACCOUNT --}}
    <li class="menu-item {{ request()->routeIs(['admin.account.add_bank','admin.account.fund_transfer']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-wallet"></i>
        <div class="menu-text-label">Account</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.account.add_bank') ? 'active' : '' }}">
          <a href="{{ route('admin.account.add_bank') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Add Bank</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.account.fund_transfer') ? 'active' : '' }}">
          <a href="{{ route('admin.account.fund_transfer') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Fund Transfer</div>
          </a>
        </li>
      </ul>
    </li>

    {{-- 4. PACKAGE --}}
    <li class="menu-item {{ request()->routeIs(['admin.package.new_package']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cube"></i>
        <div class="menu-text-label">Package</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.package.new_package') ? 'active' : '' }}">
          <a href="{{ route('admin.package.new_package') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">New Package</div>
          </a>
        </li>
      </ul>
    </li>

    {{-- Section: Gateway & Configuration --}}
    <li class="menu-header small text-uppercase mt-2">
      <span class="menu-header-text">GATEWAYS</span>
    </li>

    {{-- 5. SCHEDULER --}}
    <li class="menu-item {{ request()->routeIs(['admin.scheduler.sms_api']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-chip"></i>
        <div class="menu-text-label">Scheduler</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.scheduler.sms_api') ? 'active' : '' }}">
          <a href="{{ route('admin.scheduler.sms_api') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">SMS API Setup</div>
          </a>
        </li>
      </ul>
    </li>

    {{-- 6. MANAGE ITEM --}}
    <li class="menu-item {{ request()->routeIs(['admin.manage.sender_id','admin.manage.template']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-slider-alt"></i>
        <div class="menu-text-label">Manage Item</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.manage.sender_id') ? 'active' : '' }}">
          <a href="{{ route('admin.manage.sender_id') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Sender ID</div>
          </a>
        </li>
        <!-- <li class="menu-item {{ request()->routeIs('admin.manage.template') ? 'active' : '' }}">
          <a href="{{ route('admin.manage.template') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Templates</div>
          </a>
        </li> -->
      </ul>
    </li>

    {{-- Section: Reports --}}
    <li class="menu-header small text-uppercase mt-2">
      <span class="menu-header-text">REPORTS</span>
    </li>

    {{-- 7. REPORT --}}
    <li class="menu-item {{ request()->routeIs(['admin.reports.sms_details','admin.reports.sms_live_panel','admin.reports.user_details','admin.reports.fund_transfer','admin.reports.all_user_ledger','admin.reports.user_wise_ledger']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
        <div class="menu-text-label">Reports</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.reports.sms_details') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.sms_details') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">SMS Details</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.sms_live_panel') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.sms_live_panel') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">SMS Live Panel</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.user_details') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.user_details') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">User Details</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.fund_transfer') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.fund_transfer') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Fund Transfer</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.all_user_ledger') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.all_user_ledger') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">All User Ledger</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.user_wise_ledger') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.user_wise_ledger') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">User Wise Ledger</div>
          </a>
        </li>
      </ul>
    </li>

    {{-- 8. HELP --}}
    <!-- <li class="menu-item {{ request()->routeIs(['admin.help.help_setup','admin.help.notification']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-help-circle"></i>
        <div class="menu-text-label">Help Center</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.help.help_setup') ? 'active' : '' }}">
          <a href="{{ route('admin.help.help_setup') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Help Setup</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.help.notification') ? 'active' : '' }}">
          <a href="{{ route('admin.help.notification') }}" class="menu-link">
            <div class="sub-dot"></div>
            <div class="sub-menu-text">Notifications</div>
          </a>
        </li>
      </ul>
    </li> -->

    {{-- Section: System --}}
    <li class="menu-header small text-uppercase mt-2">
      <span class="menu-header-text">SYSTEM</span>
    </li>

    {{-- 9. SIGNOUT --}}
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link text-danger" onclick="document.getElementById('sidebarLogoutForm').submit();">
        <i class="menu-icon tf-icons bx bx-power-off text-danger"></i>
        <div class="menu-text-label fw-bold">Sign Out</div>
      </a>
    </li>

  </ul>

  {{-- Hidden Logout Form --}}
  <form id="sidebarLogoutForm" action="{{ route('admin.logout') }}" method="POST" class="d-none">
    @csrf
  </form>

  {{-- Collapse Button --}}
  <div class="sidebar-footer-toggle d-none d-xl-flex align-items-center justify-content-between px-3 py-2">
    <span class="text-muted small" style="font-size: 0.72rem;">v2.6 Enterprise</span>
    <button type="button" class="btn btn-sm btn-icon text-muted" id="collapseSidebarBtn" title="Toggle Sidebar Collapse">
      <i class="bx bx-chevron-left fs-5" id="collapseSidebarIcon"></i>
    </button>
  </div>

</aside>

<style>
  /* ── Modern Obsidian Sidebar Styles ── */
  .modern-asl-sidebar {
    background-color: #0b1329 !important;
    color: #e2e8f0 !important;
    width: 235px !important;
    min-width: 235px !important;
    border-right: 1px solid rgba(255, 255, 255, 0.07) !important;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.25s ease !important;
  }
  
  .modern-asl-sidebar .menu-header {
    padding: 0.5rem 1.25rem 0.25rem !important;
    color: #64748b !important;
    font-size: 0.65rem !important;
    font-weight: 800 !important;
    letter-spacing: 0.08em !important;
  }

  .modern-asl-sidebar .menu-item .menu-link {
    color: #94a3b8 !important;
    padding: 0.55rem 0.95rem !important;
    font-size: 0.82rem !important;
    font-weight: 600 !important;
    letter-spacing: 0.01em !important;
    border-radius: 8px !important;
    margin: 0.15rem 0.65rem !important;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
  }

  .modern-asl-sidebar .menu-item .menu-link:hover {
    background-color: rgba(255, 255, 255, 0.06) !important;
    color: #ffffff !important;
    transform: translateX(2px);
  }

  .modern-asl-sidebar .menu-item.active > .menu-link {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35) !important;
  }

  .modern-asl-sidebar .menu-item.active > .menu-link i,
  .modern-asl-sidebar .menu-item.active > .menu-link .menu-text-label {
    color: #ffffff !important;
  }

  .modern-asl-sidebar .menu-icon {
    font-size: 1.15rem !important;
    color: #94a3b8 !important;
    margin-right: 0.65rem !important;
    width: 22px !important;
    text-align: center;
    transition: color 0.2s ease;
  }

  .modern-asl-sidebar .menu-item:hover .menu-icon {
    color: #38bdf8 !important;
  }

  .modern-asl-sidebar .menu-sub {
    background: rgba(0, 0, 0, 0.2) !important;
    border-radius: 8px;
    margin: 0.2rem 0.65rem !important;
    padding: 0.35rem 0 !important;
  }

  .modern-asl-sidebar .menu-sub .menu-item .menu-link {
    padding: 0.42rem 0.75rem 0.42rem 1rem !important;
    font-size: 0.78rem !important;
    font-weight: 500 !important;
    color: #94a3b8 !important;
    margin: 0.1rem 0.35rem !important;
    border-radius: 6px !important;
  }

  .modern-asl-sidebar .sub-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background-color: #64748b;
    margin-right: 8px;
    transition: all 0.2s ease;
  }

  .modern-asl-sidebar .menu-sub .menu-item.active .sub-dot,
  .modern-asl-sidebar .menu-sub .menu-item:hover .sub-dot {
    background-color: #38bdf8;
    box-shadow: 0 0 6px rgba(56, 189, 248, 0.6);
  }

  .modern-asl-sidebar .menu-sub .menu-item.active > .menu-link {
    background: rgba(59, 130, 246, 0.18) !important;
    color: #38bdf8 !important;
    font-weight: 700 !important;
    box-shadow: none !important;
  }

  .modern-asl-sidebar .menu-toggle::after {
    border-color: #64748b !important;
  }

  .sidebar-footer-toggle {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
  }
</style>
