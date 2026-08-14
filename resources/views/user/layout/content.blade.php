<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div>
              <h5 class="card-title mb-1">Welcome back, {{ trim(($user->fname ?? '') . ' ' . ($user->lname ?? '')) ?: ($user->userid ?? 'User') }}!</h5>
              <p class="text-muted mb-0">You are logged in as a {{ $user->regtype === 4 ? 'Registered User' : 'User' }}.</p>
            </div>
            <div class="d-flex gap-2">
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Log Out</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-xl-4 col-md-6">
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0">Profile</h6>
          </div>
          <div class="card-body">
            <dl class="row mb-0">
              <dt class="col-sm-4 text-muted">Name</dt>
              <dd class="col-sm-8 mb-3">{{ trim(($user->fname ?? '') . ' ' . ($user->lname ?? '')) ?: 'Not set' }}</dd>

              <dt class="col-sm-4 text-muted">User ID</dt>
              <dd class="col-sm-8 mb-3">{{ $user->userid ?? 'N/A' }}</dd>

              <dt class="col-sm-4 text-muted">Email</dt>
              <dd class="col-sm-8 mb-3">{{ $user->email ?? 'N/A' }}</dd>

              <dt class="col-sm-4 text-muted">Phone</dt>
              <dd class="col-sm-8 mb-0">{{ $user->phone ?? 'N/A' }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6">
        <div class="card h-100">
          <div class="card-header">
            <h6 class="mb-0">Account status</h6>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <span class="badge bg-label-{{ in_array($user->status, ['1', 'active'], true) ? 'success' : 'warning' }}">
                {{ in_array($user->status, ['1', 'active'], true) ? 'Active' : 'Inactive' }}
              </span>
            </div>
            <p class="mb-0 text-muted">regtype: {{ $user->regtype }}</p>
            <p class="text-muted">OTP verification: {{ (string) ($user->isotpverify ?? '0') === '1' ? 'Enabled' : 'Disabled' }}</p>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-12">
        <div class="card h-100">
          <div class="card-header">
            <h6 class="mb-0">Quick actions</h6>
          </div>
          <div class="card-body">
            <div class="d-flex flex-column gap-2">
              <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-primary">Refresh dashboard</a>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();" class="btn btn-sm btn-outline-danger">Sign out</a>
            </div>
            <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->

  <!-- Footer -->
  <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
      <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
          © <script>document.write(new Date().getFullYear());</script>, made with ❤️ by
          <a href="https://themeselection.com" target="_blank" class="footer-link">ThemeSelection</a>
        </div>
        <div class="d-none d-lg-inline-block">
          <a href="https://themeselection.com/item/category/admin-templates/" target="_blank" class="footer-link me-4">Admin Templates</a>
          <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
          <a href="https://themeselection.com/item/category/bootstrap-admin-templates/" target="_blank" class="footer-link me-4">Bootstrap Dashboard</a>
          <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
          <a href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free/issues" target="_blank" class="footer-link">Support</a>
        </div>
      </div>
    </div>
  </footer>
  <!-- / Footer -->

  <div class="content-backdrop fade"></div>
</div>
<!-- / Content wrapper -->
