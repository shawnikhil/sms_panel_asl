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
    <!-- Toastr Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Select2 Searchable Dropdown Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

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
         COMMON RESPONSIVE FLUID SPACING FOR ALL PAGES & REPORTS
         ============================================================== */
      .layout-page {
        padding-right: 0 !important;
        width: 100% !important;
        min-width: 0 !important;
        transition: padding-left 0.25s ease;
      }

      @media (min-width: 1200px) {
        .layout-page {
          padding-left: 235px !important;
        }
        .layout-menu-collapsed .layout-page {
          padding-left: 70px !important;
        }
      }

      @media (max-width: 1199.98px) {
        .layout-page {
          padding-left: 0 !important;
        }
      }

      #layout-menu.modern-asl-sidebar {
        top: 56px !important;
        height: calc(100vh - 56px) !important;
        z-index: 1025 !important;
      }

      .content-wrapper {
        padding: 0 !important;
        width: 100% !important;
        min-width: 0 !important;
      }

      .container-xxl,
      .container-xl,
      .container-lg,
      .container-md,
      .container-sm,
      .content-wrapper > .container-xxl,
      .content-wrapper > [class*="container"] {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }

      @media (max-width: 768px) {
        .container-xxl,
        .content-wrapper > .container-xxl,
        .content-wrapper > [class*="container"] {
          padding-left: 0.85rem !important;
          padding-right: 0.85rem !important;
        }
      }

      /* ==============================================================
         MODERN ENTERPRISE CARD & FORM STYLING
         ============================================================== */
      .sms-card-shell,
      .card {
        background-color: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05) !important;
        border-radius: 12px !important;
        overflow: hidden;
        transition: all 0.3s ease;
      }

      .sms-breadcrumb-wrapper {
        font-size: 0.88rem;
        font-weight: 600;
      }
      .crumb-section { color: #64748b; }
      .crumb-sep { color: #94a3b8; font-weight: 400; }
      .crumb-active { color: #0f172a; font-weight: 700; }
      html.dark .crumb-active { color: #f8fafc; }

      .help-top-action-bar {
        background: #1e293b !important;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 0.65rem 1rem !important;
      }

      .btn-orange-action {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        color: #ffffff !important;
        border: none !important;
        font-weight: 700 !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 6px rgba(234, 88, 12, 0.3) !important;
        transition: all 0.2s ease !important;
      }
      .btn-orange-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(234, 88, 12, 0.4) !important;
        color: #ffffff !important;
      }

      .help-field-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        letter-spacing: 0.03em;
        text-transform: uppercase;
      }
      html.dark .help-field-label {
        color: #94a3b8;
      }

      .sms-input,
      .form-control,
      .form-select {
        border-radius: 8px !important;
        border: 1px solid var(--border-input) !important;
        background-color: var(--bg-input) !important;
        color: var(--text-primary) !important;
        font-size: 0.85rem !important;
        padding: 0.45rem 0.75rem !important;
        transition: all 0.2s ease !important;
      }

      .sms-input:focus,
      .form-control:focus,
      .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
      }
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

      /* Standardized Global Modal Sizing Across All Pages */
      .modal-dialog {
        max-width: 860px !important;
        width: 92% !important;
        margin: 1.75rem auto !important;
      }

      /* Confirmation / Small Modals */
      .modal-dialog.modal-sm,
      .modal-dialog.modal-confirm,
      .modal-dialog.package-confirm-modal-dialog,
      .modal-dialog.bank-confirm-modal-dialog,
      .modal-dialog.fund-transfer-clear-modal-dialog,
      .modal-dialog[id*="delete"],
      .modal-dialog[id*="clear"],
      .modal-dialog[id*="Confirm"] {
        max-width: 440px !important;
        width: 92% !important;
      }

      /* Large Detail / Table / Edit Modals */
      .modal-dialog.modal-lg,
      .modal-dialog.modal-xl,
      .modal-dialog.edit-user-modal-dialog,
      .modal-dialog.bank-edit-modal-dialog,
      .modal-dialog.package-edit-modal-dialog,
      .modal-dialog.fund-transfer-modal-dialog {
        max-width: 860px !important;
        width: 92% !important;
      }

      /* Modal Polish */
      .modal-content {
        background-color: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        border-radius: 6px !important;
        overflow: hidden;
      }

      .modal-header {
        border-bottom: 1px solid var(--border-color) !important;
        background-color: var(--bg-surface) !important;
        color: var(--text-primary) !important;
        padding: 0.85rem 1.25rem !important;
      }

      .modal-body {
        background-color: var(--bg-surface) !important;
        padding: 1.25rem !important;
      }

      .modal-footer {
        border-top: 1px solid var(--border-color) !important;
        background-color: var(--bg-table-head) !important;
        padding: 0.75rem 1.25rem !important;
      }

      .modal-title {
        color: var(--text-primary) !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        letter-spacing: 0.02em;
      }

      /* ==============================================================
         GLOBAL ENTERPRISE SHELLS & COMPONENTS
         ============================================================== */
      .sms-card-shell,
      .admin-form-shell,
      .bank-register-shell,
      .fund-transfer-shell,
      .package-register-shell {
        background: var(--bg-surface) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 4px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden !important;
        margin-bottom: 1.5rem !important;
      }

      .sms-breadcrumb-wrapper {
        font-size: 0.9rem;
        font-weight: 500;
        margin-top: 0.75rem;
        margin-bottom: 1.5rem !important;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
      }

      .sms-breadcrumb-wrapper .crumb-section {
        color: #64748b;
        font-weight: 600;
      }

      .sms-breadcrumb-wrapper .crumb-sep {
        color: #94a3b8;
        font-weight: 400;
      }

      .sms-breadcrumb-wrapper .crumb-active {
        color: #0f172a;
        font-weight: 700;
      }

      html.dark .sms-breadcrumb-wrapper .crumb-active {
        color: #f8fafc;
      }

      .help-top-action-bar {
        background: #1a4f78 !important;
        padding: 0.6rem 1rem !important;
        border-bottom: 1px solid var(--border-color) !important;
      }

      html.dark .help-top-action-bar {
        background: #1e293b !important;
      }

      .sms-card-header {
        background: #6c757d !important;
        color: #ffffff !important;
        padding: 0.75rem 1.25rem !important;
        font-weight: 600 !important;
      }

      html.dark .sms-card-header {
        background: #334155 !important;
      }

      .help-field-label,
      .sms-field-label {
        font-size: 0.78rem !important;
        font-weight: 700 !important;
        color: #475569 !important;
        letter-spacing: 0.03em !important;
        text-transform: uppercase !important;
        white-space: nowrap !important;
      }

      html.dark .help-field-label,
      html.dark .sms-field-label {
        color: #cbd5e1 !important;
      }

      .sms-input {
        border-radius: 3px !important;
        border: 1px solid #ced4da !important;
        padding: 0.45rem 0.75rem !important;
        font-size: 0.8125rem !important;
        background-color: #ffffff !important;
        color: #1e293b !important;
      }

      html.dark .sms-input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
      }

      .btn-orange-action {
        background-color: #f97316 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.04em !important;
        border-radius: 3px !important;
        padding: 0.35rem 0.85rem !important;
        border: none !important;
        box-shadow: 0 2px 4px rgba(249, 115, 22, 0.3) !important;
        transition: all 0.2s ease !important;
      }

      .btn-orange-action:hover {
        background-color: #ea580c !important;
        color: #ffffff !important;
        transform: translateY(-1px);
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

      /* ==============================================================
         GLOBAL TOASTR NOTIFICATION POLISH (SOLID & HIGH CONTRAST)
         ============================================================== */
      #toast-container {
        z-index: 999999 !important;
      }
      #toast-container > div {
        opacity: 1 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3) !important;
        border-radius: 8px !important;
        padding: 14px 14px 14px 50px !important;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
        font-size: 0.85rem !important;
      }
      #toast-container > .toast-success {
        background-color: #16a34a !important;
        color: #ffffff !important;
        border-left: 5px solid #14532d !important;
      }
      #toast-container > .toast-error {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        border-left: 5px solid #7f1d1d !important;
      }
      #toast-container > .toast-warning {
        background-color: #d97706 !important;
        color: #ffffff !important;
        border-left: 5px solid #78350f !important;
      }
      #toast-container > .toast-info {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-left: 5px solid #1e3a8a !important;
      }
      #toast-container .toast-title {
        font-weight: 700 !important;
        font-size: 0.875rem !important;
        margin-bottom: 3px !important;
        color: #ffffff !important;
      }
      #toast-container .toast-message {
        font-weight: 500 !important;
        color: #ffffff !important;
        line-height: 1.4 !important;
      }
      #toast-container .toast-close-button {
        color: #ffffff !important;
        text-shadow: none !important;
        opacity: 0.9 !important;
        font-size: 1.2rem !important;
      }
      #toast-container .toast-progress {
        background-color: rgba(255, 255, 255, 0.5) !important;
        opacity: 0.9 !important;
      }

      /* ==============================================================
         SELECT2 SEARCHABLE DROPDOWNS & MAGNIFYING SEARCH ICON
         ============================================================== */
      .select2-container--default .select2-selection--single {
        height: 36px !important;
        border: 1px solid #ced4da !important;
        border-radius: 3px !important;
        background-color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
      }
      html.dark .select2-container--default .select2-selection--single {
        background-color: #0f172a !important;
        border-color: #334155 !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        padding-left: 0.75rem !important;
        line-height: normal !important;
      }
      html.dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f8fafc !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px !important;
        right: 8px !important;
      }
      .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 4px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12) !important;
        background-color: #ffffff !important;
        z-index: 1060 !important;
      }
      html.dark .select2-dropdown {
        background-color: #1e293b !important;
        border-color: #334155 !important;
      }
      .select2-container--default .select2-search--dropdown {
        padding: 6px 8px !important;
      }
      .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #cbd5e1 !important;
        border-radius: 3px !important;
        padding: 0.4rem 0.6rem 0.4rem 2rem !important;
        font-size: 0.8125rem !important;
        background-color: #f8fafc !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'%3E%3C/line%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: 8px center !important;
        background-size: 14px 14px !important;
        outline: none !important;
      }
      html.dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
      }
      .select2-container--default .select2-results__option {
        font-size: 0.8125rem !important;
        padding: 0.45rem 0.75rem !important;
        color: #334155 !important;
      }
      html.dark .select2-container--default .select2-results__option {
        color: #cbd5e1 !important;
      }
      .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #e0e7ff !important;
        color: #4338ca !important;
      }
      html.dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #312e81 !important;
        color: #e0e7ff !important;
      }
      .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #f1f5f9 !important;
        font-weight: 600 !important;
      }
      html.dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #0f172a !important;
      }
    </style>

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- Page Specific Styles / CSS -->
    @yield('style')
    @yield('css')
  </head>

  <body>
    <!-- Top Header Navbar (Full Width) -->
    @include('admin.layout.navbar')

    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container" style="min-height: calc(100vh - 48px);">
        @include('admin.layout.sidebar')

        <div class="layout-page">
          <div class="content-wrapper">
            @yield('content')
          </div>

          <!-- Global Site Footer -->
          <footer class="content-footer footer py-3 text-center text-muted" style="font-size: 0.8rem; background: var(--bg-surface); border-top: 1px solid var(--border-color);">
            <div class="text-secondary fw-semibold">
              {{ date('Y') }} &copy; Payzone. Powered By Payzone
            </div>
          </footer>
          <!-- / Global Site Footer -->
        </div>
      </div>

      <div class="layout-overlay layout-menu-toggle" onclick="toggleAdminSidebar()"></div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
      function toggleAdminSidebar() {
        const layout = document.querySelector('.layout-wrapper');
        if (layout) {
          layout.classList.toggle('layout-menu-expanded');
        }
      }

      document.addEventListener('DOMContentLoaded', () => {
        const collapseBtn = document.getElementById('collapseSidebarBtn');
        const layout = document.querySelector('.layout-wrapper');
        if (collapseBtn && layout) {
          collapseBtn.addEventListener('click', () => {
            layout.classList.toggle('layout-menu-collapsed');
            const icon = document.getElementById('collapseSidebarIcon');
            if (icon) {
              if (layout.classList.contains('layout-menu-collapsed')) {
                icon.className = 'bx bx-chevron-right fs-4';
              } else {
                icon.className = 'bx bx-chevron-left fs-4';
              }
            }
          });
        }
      });
    </script>

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

    <!-- Page Specific Scripts / JS -->
    @yield('scripts')
    @yield('js')
  </body>
</html>
