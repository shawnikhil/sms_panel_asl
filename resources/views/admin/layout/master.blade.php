<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Console | ASL SMS HUB</title>
    <meta name="description" content="Enterprise Administration Console for ASL SMS HUB." />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- Boxicons & Font Awesome -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Sneat Core Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Anti-flicker Admin Theme Initialization -->
    <script>
      (function() {
        const savedTheme = localStorage.getItem('admin_theme');
        if (savedTheme === 'dark') {
          document.documentElement.classList.add('dark');
          document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else {
          document.documentElement.classList.remove('dark');
          document.documentElement.setAttribute('data-bs-theme', 'light');
        }
      })();
    </script>

    <!-- Global Theme Polish & Custom Color Palettes (Dark + Light Modes) -->
    <style>
      /* ==============================================================
         GLOBAL THEME VARIABLES & FOUNDATION
         ============================================================== */
      :root {
        --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        --font-mono: 'JetBrains Mono', monospace;

        /* Light Mode Defaults */
        --bg-body: #f4f6fb;
        --bg-surface: #ffffff;
        --bg-sidebar: #ffffff;
        --bg-navbar: rgba(255, 255, 255, 0.9);
        --bg-input: #ffffff;
        --bg-table-head: #f8fafc;
        --bg-table-hover: #f8fafc;
        --bg-action-bar: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        --bg-card-header: #ffffff;

        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #64748b;
        --text-sidebar: #475569;
        --text-sidebar-hover: #0f172a;

        --border-color: #e2e8f0;
        --border-subtle: #f1f5f9;
        --border-input: #cbd5e1;
        
        --brand-primary: #4f46e5;
        --brand-secondary: #0ea5e9;
        --shadow-card: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
        --shadow-dropdown: 0 10px 30px -5px rgba(15, 23, 42, 0.12);
      }

      /* Dark Mode Overrides */
      html.dark, [data-bs-theme="dark"] {
        --bg-body: #090d16;
        --bg-surface: #111a2e;
        --bg-sidebar: #0b1120;
        --bg-navbar: rgba(17, 26, 46, 0.85);
        --bg-input: #0a0f1d;
        --bg-table-head: #16223b;
        --bg-table-hover: #16223d;
        --bg-action-bar: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        --bg-card-header: #111a2e;

        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --text-sidebar: #94a3b8;
        --text-sidebar-hover: #f8fafc;

        --border-color: rgba(255, 255, 255, 0.08);
        --border-subtle: rgba(255, 255, 255, 0.04);
        --border-input: rgba(255, 255, 255, 0.14);

        --brand-primary: #6366f1;
        --brand-secondary: #38bdf8;
        --shadow-card: 0 10px 30px -5px rgba(0, 0, 0, 0.5);
        --shadow-dropdown: 0 20px 40px -5px rgba(0, 0, 0, 0.7);
      }

      body {
        font-family: var(--font-sans);
        background-color: var(--bg-body) !important;
        color: var(--text-primary);
        transition: background-color 0.3s ease, color 0.3s ease;
      }

      /* ==============================================================
         SIDEBAR NAVIGATION POLISH
         ============================================================== */
      #layout-menu.bg-menu-theme {
        background-color: var(--bg-sidebar) !important;
        border-right: 1px solid var(--border-color) !important;
        box-shadow: none !important;
        transition: all 0.3s ease;
      }

      .app-brand {
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem !important;
        margin-bottom: 0.5rem;
      }

      .menu-inner .menu-item .menu-link {
        color: var(--text-sidebar) !important;
        border-radius: 0.75rem !important;
        margin: 0.2rem 0.75rem !important;
        padding: 0.65rem 1rem !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease !important;
      }

      .menu-inner .menu-item .menu-link:hover {
        background-color: var(--border-subtle) !important;
        color: var(--text-sidebar-hover) !important;
      }

      html.dark .menu-inner .menu-item .menu-link:hover {
        background-color: rgba(255, 255, 255, 0.06) !important;
      }

      .menu-inner .menu-item.active > .menu-link {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #3b82f6 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35) !important;
      }

      .menu-inner .menu-item.active > .menu-link i,
      .menu-inner .menu-item.active > .menu-link div {
        color: #ffffff !important;
      }

      .menu-sub .menu-item .menu-link {
        padding-left: 2.75rem !important;
        font-size: 0.8125rem !important;
      }

      /* ==============================================================
         NAVBAR POLISH
         ============================================================== */
      .layout-navbar {
        background-color: var(--bg-navbar) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: var(--shadow-card) !important;
        border-radius: 1rem !important;
        margin: 0.75rem 1.5rem 0.5rem !important;
        transition: all 0.3s ease;
      }

      .dropdown-menu {
        background-color: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: var(--shadow-dropdown) !important;
        border-radius: 1rem !important;
        padding: 0.5rem !important;
      }

      .dropdown-item {
        color: var(--text-secondary) !important;
        border-radius: 0.5rem !important;
        padding: 0.6rem 1rem !important;
        font-weight: 500 !important;
        font-size: 0.85rem !important;
      }

      .dropdown-item:hover {
        background-color: var(--border-subtle) !important;
        color: var(--text-primary) !important;
      }

      html.dark .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.06) !important;
      }

      .dropdown-divider {
        border-color: var(--border-color) !important;
        margin: 0.4rem 0 !important;
      }

      /* ==============================================================
         CARD, PANELS & UI ELEMENTS
         ============================================================== */
      .card {
        background-color: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: var(--shadow-card) !important;
        border-radius: 1rem !important;
        transition: all 0.3s ease;
      }

      .card-header {
        background-color: var(--bg-card-header) !important;
        border-bottom: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
      }

      .card-title {
        color: var(--text-primary) !important;
        font-weight: 700 !important;
      }

      /* Form Inputs */
      .form-control, .form-select {
        background-color: var(--bg-input) !important;
        border: 1px solid var(--border-input) !important;
        color: var(--text-primary) !important;
        border-radius: 0.65rem !important;
        padding: 0.6rem 0.9rem !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease;
      }

      .form-control:focus, .form-select:focus {
        border-color: var(--brand-primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
      }

      .form-label {
        color: var(--text-secondary) !important;
        font-weight: 600 !important;
        font-size: 0.8125rem !important;
        margin-bottom: 0.4rem !important;
      }

      /* Tables */
      .table {
        color: var(--text-secondary) !important;
        border-color: var(--border-color) !important;
      }

      .table-light, thead.table-light th, .table thead th {
        background-color: var(--bg-table-head) !important;
        color: var(--text-primary) !important;
        border-color: var(--border-color) !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em !important;
        text-transform: uppercase !important;
      }

      .table tbody tr {
        border-color: var(--border-color) !important;
        transition: background-color 0.15s ease;
      }

      .table-hover tbody tr:hover {
        background-color: var(--bg-table-hover) !important;
      }

      .table td {
        border-color: var(--border-color) !important;
        color: var(--text-secondary) !important;
        font-size: 0.85rem !important;
        vertical-align: middle !important;
      }

      /* Modal Polish */
      .modal-content {
        background-color: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: var(--shadow-dropdown) !important;
        border-radius: 1.25rem !important;
        overflow: hidden;
      }

      .modal-header {
        border-bottom: 1px solid var(--border-color) !important;
        background-color: var(--bg-table-head) !important;
        color: var(--text-primary) !important;
      }

      .modal-footer {
        border-top: 1px solid var(--border-color) !important;
        background-color: var(--bg-table-head) !important;
      }

      .modal-title {
        color: var(--text-primary) !important;
        font-weight: 700 !important;
      }

      /* ==============================================================
         GLOBAL FORM SHELLS (USER REGISTER, FUND TRANSFER, BANK, ETC.)
         ============================================================== */
      .admin-form-shell,
      .bank-register-shell,
      .fund-transfer-shell,
      .package-register-shell {
        background: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 1rem !important;
        overflow: hidden !important;
        box-shadow: var(--shadow-card) !important;
        margin-bottom: 2rem;
      }

      .top-action-bar {
        background: var(--bg-action-bar) !important;
        padding: 0.85rem 1.25rem !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        border-bottom: 1px solid var(--border-color) !important;
      }

      .action-btn, .package-footer-btn, .bank-footer-btn {
        border-radius: 0.5rem !important;
        font-weight: 700 !important;
        font-size: 0.8125rem !important;
        padding: 0.5rem 1rem !important;
        transition: all 0.2s ease !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
      }

      .save-btn, .primary-btn {
        background: #10b981 !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3) !important;
      }

      .save-btn:hover, .primary-btn:hover {
        background: #059669 !important;
        transform: translateY(-1px);
      }

      .edit-btn {
        background: #3b82f6 !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
      }

      .delete-btn {
        background: #ef4444 !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important;
      }

      .clear-btn, .secondary-btn {
        background: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        backdrop-filter: blur(10px);
      }

      .bank-breadcrumb-bar, .package-breadcrumb-bar, .fund-transfer-breadcrumb {
        background: var(--bg-table-head) !important;
        border-bottom: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        padding: 0.75rem 1.25rem !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
      }

      .crumb-current {
        color: var(--brand-primary) !important;
        font-weight: 700 !important;
      }

      .user-register-card, .bank-card, .fund-transfer-card, .package-card {
        background: var(--bg-surface) !important;
        border: none !important;
        padding: 1.25rem !important;
      }

      .form-section-title {
        background: var(--bg-table-head) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--brand-primary) !important;
        font-weight: 800 !important;
        font-size: 0.8125rem !important;
        letter-spacing: 0.05em !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 1rem !important;
        margin-bottom: 1.25rem !important;
      }

      .user-form-label, .bank-form-label, .fund-transfer-form-label, .package-form-label {
        color: var(--text-secondary) !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        background: transparent !important;
      }

      .user-form-control, .bank-form-control, .fund-transfer-form-control, .package-form-control {
        background: var(--bg-input) !important;
        border: 1px solid var(--border-input) !important;
        color: var(--text-primary) !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 0.875rem !important;
      }

      .user-form-control:focus, .bank-form-control:focus, .fund-transfer-form-control:focus, .package-form-control:focus {
        border-color: var(--brand-primary) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
      }

      .user-form-row, .bank-form-row, .fund-transfer-form-row, .package-form-row {
        border-color: var(--border-color) !important;
      }

      .bank-page-footer, .package-page-footer, .fund-transfer-page-footer, .user-page-footer {
        background: var(--bg-table-head) !important;
        border-top: 1px solid var(--border-color) !important;
        color: var(--text-muted) !important;
        font-size: 0.8125rem !important;
        padding: 1rem !important;
        text-align: center !important;
        font-weight: 600 !important;
      }

      /* ==============================================================
         FOOTER
         ============================================================== */
      .layout-page {
        display: flex !important;
        flex-direction: column !important;
        min-height: 100vh;
      }

      .content-wrapper {
        flex: 1 0 auto;
      }

      .content-footer {
        flex-shrink: 0;
        background-color: var(--bg-surface) !important;
        color: var(--text-muted) !important;
        border-top: 1px solid var(--border-color) !important;
        padding: 0.875rem 1.5rem !important;
      }
    </style>

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        @include('admin.layout.sidebar')

        <div class="layout-page">
          @include('admin.layout.navbar')
          <div class="content-wrapper">
            @yield('content')
          </div>

          <!-- Global Site Footer -->
          <footer class="content-footer footer">
            <div class="container-xxl d-flex align-items-center justify-content-between py-2 flex-md-row flex-column gap-2">
              <div class="text-muted" style="font-size:0.8125rem;font-weight:600;">
                &copy; {{ date('Y') }} <strong class="text-primary">ASL SMS HUB</strong>. All Rights Reserved.
              </div>
              <div class="d-flex align-items-center gap-2" style="font-size:0.8125rem;">
                <span class="badge badge-dot bg-success me-1"></span>
                <span class="text-muted" style="font-weight:500;">Production Gateway Environment</span>
              </div>
            </div>
          </footer>
          <!-- / Global Site Footer -->
        </div>
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Theme Switcher Script -->
    <script>
      (function () {
        const toggleBtn = document.getElementById('admin-theme-toggle');
        const icon = document.getElementById('admin-theme-icon');

        function setAdminTheme(isDark) {
          if (isDark) {
            document.documentElement.classList.add('dark');
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            localStorage.setItem('admin_theme', 'dark');
            if (icon) {
              icon.className = 'bx bx-sm bx-sun text-warning';
              icon.setAttribute('title', 'Switch to Light Mode');
            }
          } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.setAttribute('data-bs-theme', 'light');
            localStorage.setItem('admin_theme', 'light');
            if (icon) {
              icon.className = 'bx bx-sm bx-moon text-secondary';
              icon.setAttribute('title', 'Switch to Dark Mode');
            }
          }
        }

        const savedTheme = localStorage.getItem('admin_theme');
        const isDark = savedTheme === 'dark';
        setAdminTheme(isDark);

        if (toggleBtn) {
          toggleBtn.addEventListener('click', function () {
            const currentDark = document.documentElement.classList.contains('dark') || document.documentElement.getAttribute('data-bs-theme') === 'dark';
            setAdminTheme(!currentDark);
          });
        }
      })();
    </script>
  </body>
</html>
