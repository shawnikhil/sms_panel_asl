<!-- Account Menu -->
<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon tf-icons bx bx-send"></i>
    <div class="text-truncate">Account</div>
  </a>
  <ul class="menu-sub">
    <li class="menu-item">
      <a href="{{ route('user.dashboard.send_sms') }}" class="menu-link">
        <div class="text-truncate">Add Bank</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('user.dashboard.campaigns') }}" class="menu-link">
        <div class="text-truncate">Fund Transfer</div>
      </a>
    </li>
  </ul>
</li>
