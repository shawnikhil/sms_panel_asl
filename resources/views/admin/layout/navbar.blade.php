<!-- Top Modern Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center modern-top-navbar" id="layout-navbar">
  <div class="container-fluid d-flex align-items-center justify-content-between px-3 px-md-4">
    
    {{-- LEFT: Mobile Toggle & Brand / Welcome Info --}}
    <div class="d-flex align-items-center gap-3">
      {{-- Mobile Sidebar Drawer Toggle --}}
      <button type="button" class="btn btn-icon btn-sm text-white d-xl-none modern-mobile-toggle" onclick="toggleAdminSidebar()" aria-label="Toggle Sidebar">
        <i class="bx bx-menu fs-3"></i>
      </button>

      {{-- Brand Logo & Welcome Badge --}}
      <div class="d-flex align-items-center gap-2">
        <div class="modern-brand-badge d-flex align-items-center gap-2">
          <div class="brand-icon-box">
            <i class="bx bx-message-rounded-dots text-white fs-5"></i>
          </div>
          <div class="d-flex flex-column">
            <div class="d-flex align-items-center gap-2">
              <span class="brand-title fw-bold text-white">ASL SMS <span class="text-info">HUB</span></span>
              <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0 rounded-pill d-none d-sm-inline-flex align-items-center gap-1" style="font-size: 0.68rem; font-weight: 600;">
                <span class="live-pulse-dot"></span> LIVE
              </span>
            </div>
            <span class="text-white-50 d-none d-md-block" style="font-size: 0.72rem; letter-spacing: 0.02em;">
              WELCOME, <strong>{{ strtoupper(Auth::user()->admin_username ?? Auth::user()->name ?? 'ADMIN') }}</strong>
            </span>
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT: Actions, Theme Switcher & Admin Profile --}}
    <div class="d-flex align-items-center gap-2 gap-sm-3">
      
      {{-- Theme Mode Switcher --}}
      <button type="button" class="btn btn-icon modern-nav-btn" id="admin-theme-toggle" title="Toggle Light / Dark Mode">
        <i class="bx bx-moon fs-5 text-white" id="admin-theme-icon"></i>
      </button>

      {{-- User Profile Pill Dropdown --}}
      <div class="dropdown">
        <button class="btn modern-user-pill d-flex align-items-center gap-2 py-1 ps-1 pe-3 border-0 dropdown-toggle" 
                type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="user-avatar-circle">
            <span class="fw-bold text-white">{{ strtoupper(substr(Auth::user()->admin_username ?? Auth::user()->name ?? 'A', 0, 1)) }}</span>
          </div>
          <div class="d-none d-sm-flex flex-column text-start" style="line-height: 1.15;">
            <span class="text-white fw-bold user-name-label" style="font-size: 0.8rem;">
              {{ Auth::user()->name ?? Auth::user()->admin_username ?? 'Administrator' }}
            </span>
            <span class="text-info user-role-label" style="font-size: 0.68rem; font-weight: 600;">
              SUPER ADMIN
            </span>
          </div>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 modern-dropdown mt-2 p-2" style="min-width: 220px; border-radius: 12px;">
          <li class="px-3 py-2 border-bottom mb-1">
            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ Auth::user()->name ?? 'Admin User' }}</div>
            <div class="text-muted small" style="font-size: 0.72rem;">{{ Auth::user()->email ?? 'admin@sms.com' }}</div>
            <div class="text-primary small mt-1 d-flex align-items-center gap-1 font-monospace" style="font-size: 0.72rem; font-weight: 600;">
              <i class="bx bx-time fs-6"></i>
              <span>Login: {{ session('admin_login_time', \Carbon\Carbon::now('Asia/Kolkata')->format('d/m/Y h:i A')) }}</span>
            </div>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 rounded-2" href="{{ route('admin.master.admin_register') }}">
              <i class="bx bx-user-circle fs-5 text-primary"></i>
              <span class="fw-semibold">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2 rounded-2" href="{{ route('admin.scheduler.sms_api') }}">
              <i class="bx bx-chip fs-5 text-info"></i>
              <span class="fw-semibold">SMS Gateway Setup</span>
            </a>
          </li>
          <li><hr class="dropdown-divider my-1"></li>
          <li>
            <form method="POST" action="{{ route('admin.logout') }}" id="logoutFormNav" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 rounded-2 text-danger">
                <i class="bx bx-power-off fs-5"></i>
                <span class="fw-bold">Sign Out</span>
              </button>
            </form>
          </li>
        </ul>
      </div>

    </div>

  </div>
</nav>

<style>
  .modern-top-navbar {
    background: #0f172a !important;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
    min-height: 56px;
    height: 56px;
    padding: 0 !important;
    margin: 0 !important;
    border-radius: 0 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.25) !important;
    position: sticky !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    z-index: 1050 !important;
  }

  .brand-icon-box {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
  }

  .brand-title {
    font-size: 0.92rem;
    letter-spacing: -0.01em;
  }

  .live-pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #22c55e;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.3);
    animation: pulseDot 1.8s infinite;
  }

  @keyframes pulseDot {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
  }

  .modern-nav-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }
  .modern-nav-btn:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-1px);
  }

  .modern-user-pill {
    background: rgba(255, 255, 255, 0.08) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    border-radius: 30px !important;
    transition: all 0.2s ease !important;
  }
  .modern-user-pill:hover {
    background: rgba(255, 255, 255, 0.15) !important;
  }

  .user-avatar-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
  }

  .modern-dropdown {
    background: #ffffff !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
  }
  html.dark .modern-dropdown {
    background: #1e293b !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
  }
  html.dark .modern-dropdown .text-dark {
    color: #f8fafc !important;
  }
  html.dark .modern-dropdown .dropdown-item {
    color: #cbd5e1 !important;
  }
  html.dark .modern-dropdown .dropdown-item:hover {
    background: rgba(255, 255, 255, 0.08) !important;
    color: #ffffff !important;
  }
</style>
