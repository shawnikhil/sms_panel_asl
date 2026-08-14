<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="25" height="auto" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12.0003 2C6.48395 2 2 6.48395 2 12.0003C2 17.5166 6.48395 22 12.0003 22C17.5166 22 22 17.5166 22 12.0003C22 6.48395 17.5166 2 12.0003 2ZM12.0003 20C7.58794 20 4 16.412 4 12.0003C4 7.58794 7.58794 4 12.0003 4C16.412 4 20 7.58794 20 12.0003C20 16.412 16.412 20 12.0003 20Z" />
        </svg>
      </span>
      <span class="app-brand-text demo menu-text fw-bolder">SMS Panel</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="menu-toggle-icon">
        <path d="M19.0043 8.61071L12.8356 2.44206C12.3744 1.98086 11.6256 1.98086 11.1644 2.44206L4.99574 8.61071C4.53454 9.07191 4.53454 9.82069 4.99574 10.2819L11.1644 16.4505C11.6256 16.9117 12.3744 16.9117 12.8356 16.4505L19.0043 10.2819C19.4655 9.82069 19.4655 9.07191 19.0043 8.61071Z" />
      </svg>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1 ps-0">
    <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a href="{{ route('admin.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-dashboard"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.master.company_setup','admin.master.admin_register','admin.master.user_register']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Master">Master</div>
      </a>
      <ul class="menu-sub">
        {{-- <li class="menu-item {{ request()->routeIs('admin.master.company_setup') ? 'active' : '' }}">
          <a href="{{ route('admin.master.company_setup') }}" class="menu-link">
            <div data-i18n="Company Setup">Company Setup</div>
          </a>
        </li> --}}
        <li class="menu-item {{ request()->routeIs('admin.master.admin_register') ? 'active' : '' }}">
          <a href="{{ route('admin.master.admin_register') }}" class="menu-link">
            <div data-i18n="Admin Register">Admin Register</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.master.user_register') ? 'active' : '' }}">
          <a href="{{ route('admin.master.user_register') }}" class="menu-link">
            <div data-i18n="User Register">User Register</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.account.add_bank','admin.account.fund_transfer']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-wallet-alt"></i>
        <div data-i18n="Account">Account</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.account.add_bank') ? 'active' : '' }}">
          <a href="{{ route('admin.account.add_bank') }}" class="menu-link">
            <div data-i18n="Add Bank">Add Bank</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.account.fund_transfer') ? 'active' : '' }}">
          <a href="{{ route('admin.account.fund_transfer') }}" class="menu-link">
            <div data-i18n="Fund Transfer">Fund Transfer</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.package.new_package']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-box"></i>
        <div data-i18n="Package">Package</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.package.new_package') ? 'active' : '' }}">
          <a href="{{ route('admin.package.new_package') }}" class="menu-link">
            <div data-i18n="New Package">New Package</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.scheduler.sms_api']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-time"></i>
        <div data-i18n="Scheduler">Scheduler</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.scheduler.sms_api') ? 'active' : '' }}">
          <a href="{{ route('admin.scheduler.sms_api') }}" class="menu-link">
            <div data-i18n="SMS API">SMS API</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.manage.sender_id','admin.manage.template']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-briefcase"></i>
        <div data-i18n="Manage Item">Manage Item</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.manage.sender_id') ? 'active' : '' }}">
          <a href="{{ route('admin.manage.sender_id') }}" class="menu-link">
            <div data-i18n="Manage Sender ID">Manage Sender ID</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.manage.template') ? 'active' : '' }}">
          <a href="{{ route('admin.manage.template') }}" class="menu-link">
            <div data-i18n="Manage Template">Manage Template</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.reports.sms_details','admin.reports.sms_live_panel','admin.reports.user_details','admin.reports.fund_transfer','admin.reports.all_user_ledger','admin.reports.user_wise_ledger']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-chart"></i>
        <div data-i18n="Reports">Reports</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.reports.sms_details') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.sms_details') }}" class="menu-link">
            <div data-i18n="SMS Details">SMS Details</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.sms_live_panel') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.sms_live_panel') }}" class="menu-link">
            <div data-i18n="SMS Live Panel">SMS Live Panel</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.user_details') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.user_details') }}" class="menu-link">
            <div data-i18n="User Details">User Details</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.fund_transfer') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.fund_transfer') }}" class="menu-link">
            <div data-i18n="Fund Transfer">Fund Transfer</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.all_user_ledger') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.all_user_ledger') }}" class="menu-link">
            <div data-i18n="All User Ledger">All User Ledger</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.reports.user_wise_ledger') ? 'active' : '' }}">
          <a href="{{ route('admin.reports.user_wise_ledger') }}" class="menu-link">
            <div data-i18n="User Wise Ledger">User Wise Ledger</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.help.help_setup','admin.help.notification']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-help-circle"></i>
        <div data-i18n="Help">Help</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.help.help_setup') ? 'active' : '' }}">
          <a href="{{ route('admin.help.help_setup') }}" class="menu-link">
            <div data-i18n="Help Setup">Help Setup</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.help.notification') ? 'active' : '' }}">
          <a href="{{ route('admin.help.notification') }}" class="menu-link">
            <div data-i18n="Notification">Notification</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs(['admin.dashboard.settings.profile','admin.dashboard.settings.api_keys','admin.dashboard.settings.security']) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Settings">Settings</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('admin.dashboard.settings.profile') ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard.settings.profile') }}" class="menu-link">
            <div data-i18n="Profile">Profile</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.dashboard.settings.api_keys') ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard.settings.api_keys') }}" class="menu-link">
            <div data-i18n="API Keys">API Keys</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.dashboard.settings.security') ? 'active' : '' }}">
          <a href="{{ route('admin.dashboard.settings.security') }}" class="menu-link">
            <div data-i18n="Security">Security</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>
<!-- / Menu -->
