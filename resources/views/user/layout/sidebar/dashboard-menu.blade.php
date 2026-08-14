<!-- Dashboard Menu Item -->
<li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
  <a href="{{ route('user.dashboard') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-home-circle"></i>
    <div class="text-truncate">Dashboard</div>
  </a>
</li>
