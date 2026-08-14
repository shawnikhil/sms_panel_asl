<!-- Reports Menu -->
<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
    <div class="text-truncate">Reports</div>
  </a>
  <ul class="menu-sub">
    <li class="menu-item {{ request()->routeIs('user.dashboard.reports.delivery_summary') ? 'active' : '' }}">
      <a href="{{ route('user.dashboard.reports.delivery_summary') }}" class="menu-link">
        <div class="text-truncate">SMS DETAILS</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('user.dashboard.reports.billing_history') ? 'active' : '' }}">
      <a href="{{ route('user.dashboard.reports.billing_history') }}" class="menu-link">
        <div class="text-truncate">SMS LIVE PANEL</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('user.dashboard.reports.api_usage') ? 'active' : '' }}">
      <a href="{{ route('user.dashboard.reports.api_usage') }}" class="menu-link">
        <div class="text-truncate">USER DETAILS</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('user.dashboard.reports.api_usage') }}" class="menu-link">
        <div class="text-truncate">FUND TRANSFER</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('user.dashboard.reports.api_usage') }}" class="menu-link">
        <div class="text-truncate">ALL USER LEDGER</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('user.dashboard.reports.api_usage') }}" class="menu-link">
        <div class="text-truncate">USER WISE LEDGER</div>
      </a>
    </li>
  </ul>
</li>
