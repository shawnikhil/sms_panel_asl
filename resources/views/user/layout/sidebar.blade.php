<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  @include('user.layout.sidebar.brand')

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @include('user.layout.sidebar.dashboard-menu')
    @include('user.layout.sidebar.master-menu')
    @include('user.layout.sidebar.account-menu')
    @include('user.layout.sidebar.package-menu')
    @include('user.layout.sidebar.scheduler-menu')
    @include('user.layout.sidebar.manage-menu')
    @include('user.layout.sidebar.reports-menu')
    @include('user.layout.sidebar.help-menu')
  </ul>
</aside>
<!-- / Menu -->
