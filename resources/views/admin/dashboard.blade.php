@extends('admin.layout.master')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Welcome Header Banner -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card bg-primary text-white shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 50%, #06b6d4 100%); border: none;">
          <div class="card-body p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
              <div>
                <div class="badge bg-white text-primary mb-2 px-3 py-1 fw-bold shadow-sm">
                  <i class="bx bx-shield-quarter me-1"></i> ASL SMS HUB Enterprise Console
                </div>
                <h3 class="text-white fw-bold mb-1">Welcome back, {{ Auth::user()->name ?? 'Administrator' }}! 👋</h3>
                <p class="text-white text-opacity-80 mb-0 fs-6">
                  Carrier routing engine is active with <span class="fw-bold text-white">99.99% uptime</span> across all global routes.
                </p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.master.user_register') }}" class="btn btn-white text-primary fw-semibold shadow-sm">
                  <i class="bx bx-user-plus me-1"></i> Register User
                </a>
                <a href="{{ route('admin.account.fund_transfer') }}" class="btn btn-outline-white fw-semibold">
                  <i class="bx bx-wallet me-1"></i> Fund Transfer
                </a>
                <a href="{{ route('admin.reports.sms_live_panel') }}" class="btn btn-dark fw-semibold shadow-sm">
                  <i class="bx bx-broadcast me-1"></i> Live SMS Stream
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Top 4 Metric KPI Cards -->
    <div class="row g-4 mb-4">
      <!-- Card 1: Total SMS Today -->
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-semibold fs-7">SMS Sent Today</span>
              <div class="avatar avatar-sm">
                <span class="avatar-initial rounded-3 bg-label-primary">
                  <i class="bx bx-paper-plane fs-4"></i>
                </span>
              </div>
            </div>
            <h3 class="fw-bold mb-1">1,428,590</h3>
            <div class="d-flex align-items-center text-success fs-7">
              <i class="bx bx-up-arrow-alt me-1"></i>
              <span class="fw-semibold">+14.2%</span>
              <span class="text-muted ms-1">vs last week</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 2: Delivery Success Rate -->
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-semibold fs-7">Delivery Success Rate</span>
              <div class="avatar avatar-sm">
                <span class="avatar-initial rounded-3 bg-label-success">
                  <i class="bx bx-check-double fs-4"></i>
                </span>
              </div>
            </div>
            <h3 class="fw-bold mb-1 text-success">99.92%</h3>
            <div class="d-flex align-items-center text-muted fs-7">
              <i class="bx bx-time-five me-1 text-primary"></i>
              <span>Avg Latency: <strong class="fw-bold">1.4s</strong></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 3: Total Active Clients -->
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-semibold fs-7">Active Client Accounts</span>
              <div class="avatar avatar-sm">
                <span class="avatar-initial rounded-3 bg-label-info">
                  <i class="bx bx-group fs-4"></i>
                </span>
              </div>
            </div>
            <h3 class="fw-bold mb-1">3,842</h3>
            <div class="d-flex align-items-center text-info fs-7">
              <i class="bx bx-user-plus me-1"></i>
              <span class="fw-semibold">+28 New</span>
              <span class="text-muted ms-1">this week</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card 4: Wallet Circulation -->
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-semibold fs-7">Wallet In Circulation</span>
              <div class="avatar avatar-sm">
                <span class="avatar-initial rounded-3 bg-label-warning">
                  <i class="bx bx-wallet-alt fs-4"></i>
                </span>
              </div>
            </div>
            <h3 class="fw-bold mb-1 text-warning">$48,290.00</h3>
            <div class="d-flex align-items-center text-muted fs-7">
              <i class="bx bx-shield-quarter me-1 text-success"></i>
              <span>100% Balanced</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Traffic & Carrier Performance Section -->
    <div class="row g-4 mb-4">
      
      <!-- Left: Delivery Breakdown & Traffic Analysis -->
      <div class="col-lg-8">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div>
              <h5 class="card-title mb-1">Real-Time SMS Delivery Telemetry</h5>
              <p class="text-muted mb-0 fs-7">24-hour transmission status & carrier queue breakdown</p>
            </div>
            <a href="{{ route('admin.reports.sms_details') }}" class="btn btn-sm btn-outline-primary">
              View Full Report <i class="bx bx-chevron-right"></i>
            </a>
          </div>
          <div class="card-body pt-4">
            
            <!-- Progress Bars -->
            <div class="mb-4">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-semibold fs-7"><i class="bx bxs-circle text-success me-1 fs-8"></i> Delivered (94.8%)</span>
                <span class="fw-bold fs-7">1,354,203 SMS</span>
              </div>
              <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 94.8%" aria-valuenow="94.8" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-semibold fs-7"><i class="bx bxs-circle text-info me-1 fs-8"></i> In-Flight / Queued (4.2%)</span>
                <span class="fw-bold fs-7">60,000 SMS</span>
              </div>
              <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: 4.2%" aria-valuenow="4.2" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-semibold fs-7"><i class="bx bxs-circle text-warning me-1 fs-8"></i> DND Filtered (0.8%)</span>
                <span class="fw-bold fs-7">11,428 SMS</span>
              </div>
              <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 0.8%" aria-valuenow="0.8" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="mb-0">
              <div class="d-flex justify-content-between mb-1">
                <span class="fw-semibold fs-7"><i class="bx bxs-circle text-danger me-1 fs-8"></i> Undelivered / Expired (0.2%)</span>
                <span class="fw-bold fs-7">2,959 SMS</span>
              </div>
              <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 0.2%" aria-valuenow="0.2" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <!-- Route Summary Badges -->
            <div class="row mt-4 pt-3 border-top g-3">
              <div class="col-4 text-center border-end">
                <span class="text-muted fs-7 d-block">Transactional OTP</span>
                <span class="fs-5 fw-bold text-primary">68%</span>
              </div>
              <div class="col-4 text-center border-end">
                <span class="text-muted fs-7 d-block">Promotional Bulk</span>
                <span class="fs-5 fw-bold text-info">26%</span>
              </div>
              <div class="col-4 text-center">
                <span class="text-muted fs-7 d-block">Two-Way / Inbound</span>
                <span class="fs-5 fw-bold text-warning">6%</span>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Right: Carrier Route Health Monitor -->
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0">
            <h5 class="card-title mb-1">Carrier Direct Pipes</h5>
            <p class="text-muted mb-0 fs-7">Active telecom connections</p>
          </div>
          <div class="card-body pt-3">
            
            <div class="d-flex flex-column gap-3">
              
              <!-- Route Item 1 -->
              <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" style="background-color: var(--bg-table-head);">
                <div>
                  <div class="d-flex align-items-center gap-1.5 mb-1">
                    <span class="badge badge-dot bg-success"></span>
                    <strong class="fs-7">TIER1-DIRECT-01</strong>
                  </div>
                  <span class="text-muted fs-8">OTP & Transactional • Latency: 1.1s</span>
                </div>
                <span class="badge bg-label-success">99.98%</span>
              </div>

              <!-- Route Item 2 -->
              <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" style="background-color: var(--bg-table-head);">
                <div>
                  <div class="d-flex align-items-center gap-1.5 mb-1">
                    <span class="badge badge-dot bg-success"></span>
                    <strong class="fs-7">TIER1-DIRECT-02</strong>
                  </div>
                  <span class="text-muted fs-8">Promotional Fast Pipe • Latency: 1.3s</span>
                </div>
                <span class="badge bg-label-success">99.95%</span>
              </div>

              <!-- Route Item 3 -->
              <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" style="background-color: var(--bg-table-head);">
                <div>
                  <div class="d-flex align-items-center gap-1.5 mb-1">
                    <span class="badge badge-dot bg-success"></span>
                    <strong class="fs-7">INTL-GATEWAY-GLOBAL</strong>
                  </div>
                  <span class="text-muted fs-8">180+ Countries • Latency: 1.8s</span>
                </div>
                <span class="badge bg-label-success">99.89%</span>
              </div>

              <!-- Route Item 4 -->
              <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" style="background-color: var(--bg-table-head);">
                <div>
                  <div class="d-flex align-items-center gap-1.5 mb-1">
                    <span class="badge badge-dot bg-info"></span>
                    <strong class="fs-7">2WAY-INTERACTIVE-PIPE</strong>
                  </div>
                  <span class="text-muted fs-8">Inbound SMS & Webhooks • Latency: 1.2s</span>
                </div>
                <span class="badge bg-label-info">Active</span>
              </div>

            </div>

          </div>
        </div>
      </div>

    </div>

    <!-- Live SMS Transactions & Quick Audits -->
    <div class="row g-4">
      
      <!-- Recent Real-Time SMS Stream -->
      <div class="col-12 col-xl-8">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div>
              <h5 class="card-title mb-1">Live SMS Traffic Monitor</h5>
              <p class="text-muted mb-0 fs-7">Real-time log of recently processed carrier transmissions</p>
            </div>
            <a href="{{ route('admin.reports.sms_live_panel') }}" class="btn btn-sm btn-primary">
              <i class="bx bx-broadcast me-1"></i> Open Live Panel
            </a>
          </div>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>Message ID</th>
                  <th>Sender ID</th>
                  <th>Recipient</th>
                  <th>Route</th>
                  <th>Status</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td><span class="fw-bold font-monospace text-primary">#ASL-94021</span></td>
                  <td><span class="badge bg-label-primary">ASL-NOTIFY</span></td>
                  <td>+1 (555) 019-2834</td>
                  <td><span class="badge bg-label-success">Transactional</span></td>
                  <td><span class="badge bg-success"><i class="bx bx-check-double me-1"></i> DELIVRD</span></td>
                  <td class="text-muted fs-7">Just now</td>
                </tr>
                <tr>
                  <td><span class="fw-bold font-monospace text-primary">#ASL-94020</span></td>
                  <td><span class="badge bg-label-primary">TX-ALERT</span></td>
                  <td>+1 (555) 849-1102</td>
                  <td><span class="badge bg-label-success">Transactional</span></td>
                  <td><span class="badge bg-success"><i class="bx bx-check-double me-1"></i> DELIVRD</span></td>
                  <td class="text-muted fs-7">1m ago</td>
                </tr>
                <tr>
                  <td><span class="fw-bold font-monospace text-primary">#ASL-94019</span></td>
                  <td><span class="badge bg-label-warning">PR-OFFERS</span></td>
                  <td>+1 (555) 302-8849</td>
                  <td><span class="badge bg-label-warning">Promotional</span></td>
                  <td><span class="badge bg-success"><i class="bx bx-check-double me-1"></i> DELIVRD</span></td>
                  <td class="text-muted fs-7">2m ago</td>
                </tr>
                <tr>
                  <td><span class="fw-bold font-monospace text-primary">#ASL-94018</span></td>
                  <td><span class="badge bg-label-primary">ASL-OTP</span></td>
                  <td>+1 (555) 774-2910</td>
                  <td><span class="badge bg-label-success">OTP Route</span></td>
                  <td><span class="badge bg-success"><i class="bx bx-check-double me-1"></i> DELIVRD</span></td>
                  <td class="text-muted fs-7">3m ago</td>
                </tr>
                <tr>
                  <td><span class="fw-bold font-monospace text-primary">#ASL-94017</span></td>
                  <td><span class="badge bg-label-info">2WAY-SMS</span></td>
                  <td>+1 (555) 489-0193</td>
                  <td><span class="badge bg-label-info">Two-Way</span></td>
                  <td><span class="badge bg-info"><i class="bx bx-send me-1"></i> SENT</span></td>
                  <td class="text-muted fs-7">4m ago</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Quick Administration Actions & Shortcuts -->
      <div class="col-12 col-xl-4">
        <div class="card mb-4">
          <div class="card-header pb-2">
            <h5 class="card-title mb-1">Administrative Shortcuts</h5>
            <p class="text-muted mb-0 fs-7">Frequently used management tools</p>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              <a href="{{ route('admin.master.user_register') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-0 py-2.5" style="background: transparent;">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar avatar-sm">
                    <span class="avatar-initial rounded-3 bg-label-primary"><i class="bx bx-user-plus"></i></span>
                  </div>
                  <div>
                    <h6 class="mb-0 fs-7">Register New Client Account</h6>
                    <small class="text-muted">Create user profile with custom pricing</small>
                  </div>
                </div>
                <i class="bx bx-chevron-right text-muted"></i>
              </a>

              <a href="{{ route('admin.account.fund_transfer') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-0 py-2.5" style="background: transparent;">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar avatar-sm">
                    <span class="avatar-initial rounded-3 bg-label-success"><i class="bx bx-credit-card"></i></span>
                  </div>
                  <div>
                    <h6 class="mb-0 fs-7">Credit Fund Transfer</h6>
                    <small class="text-muted">Recharge and allocate SMS wallet balance</small>
                  </div>
                </div>
                <i class="bx bx-chevron-right text-muted"></i>
              </a>

              <a href="{{ route('admin.manage.sender_id') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-0 py-2.5" style="background: transparent;">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar avatar-sm">
                    <span class="avatar-initial rounded-3 bg-label-warning"><i class="bx bx-id-card"></i></span>
                  </div>
                  <div>
                    <h6 class="mb-0 fs-7">Manage Sender IDs & DLT</h6>
                    <small class="text-muted">Approve and verify custom headers</small>
                  </div>
                </div>
                <i class="bx bx-chevron-right text-muted"></i>
              </a>

              <a href="{{ route('admin.package.new_package') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-0 py-2.5 border-bottom-0" style="background: transparent;">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar avatar-sm">
                    <span class="avatar-initial rounded-3 bg-label-info"><i class="bx bx-package"></i></span>
                  </div>
                  <div>
                    <h6 class="mb-0 fs-7">Package & Pricing Setup</h6>
                    <small class="text-muted">Configure wholesale SMS tariff slabs</small>
                  </div>
                </div>
                <i class="bx bx-chevron-right text-muted"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- System Health & Status Card -->
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h6 class="card-title mb-0 fs-7">Platform Core Services</h6>
              <span class="badge bg-label-success">All Operational</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom fs-7">
              <span class="text-muted"><i class="bx bx-server me-1"></i> SMS Gateway Daemon</span>
              <span class="badge bg-success">Active</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom fs-7">
              <span class="text-muted"><i class="bx bx-data me-1"></i> MySQL Database Cluster</span>
              <span class="badge bg-success">Connected</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom fs-7">
              <span class="text-muted"><i class="bx bx-time me-1"></i> Cron Task Scheduler</span>
              <span class="badge bg-success">Running</span>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 fs-7">
              <span class="text-muted"><i class="bx bx-lock me-1"></i> DLT Regulatory Scrubbing</span>
              <span class="badge bg-success">Enabled</span>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <!-- / Content -->

  <div class="content-backdrop fade"></div>
@endsection