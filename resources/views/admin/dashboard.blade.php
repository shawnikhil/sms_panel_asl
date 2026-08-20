@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">
    
    {{-- ── 1. Hero Welcome Banner with Action Buttons ── --}}
    <div class="row mb-4">
      <div class="col-12">
        <div class="card text-white shadow-sm overflow-hidden border-0" 
             style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e3a8a 100%); border-radius: 14px;">
          <div class="card-body p-4 p-md-4">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
              <div>
                <div class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 mb-2 px-3 py-1 fw-bold rounded-pill" style="font-size: 0.72rem;">
                  <i class="bx bx-shield-quarter me-1"></i> ASL SMS HUB
                </div>
                <h3 class="text-white fw-bold mb-1" style="letter-spacing: -0.02em;">
                  Welcome back, {{ Auth::user()->admin_fname }} {{ Auth::user()->admin_lname }}
                </h3>
                
              </div>

              {{-- Top Quick Action Buttons --}}
              <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.master.user_register') }}" class="btn btn-primary fw-semibold shadow-sm d-inline-flex align-items-center gap-1 px-3 py-2" style="border-radius: 8px;">
                  <i class="bx bx-user-plus fs-5"></i> Register User
                </a>
                <a href="{{ route('admin.account.fund_transfer') }}" class="btn btn-info text-white fw-semibold shadow-sm d-inline-flex align-items-center gap-1 px-3 py-2" style="border-radius: 8px;">
                  <i class="bx bx-wallet fs-5"></i> Fund Transfer
                </a>
                <a href="{{ route('admin.reports.sms_live_panel') }}" class="btn btn-outline-light fw-semibold shadow-sm d-inline-flex align-items-center gap-1 px-3 py-2" style="border-radius: 8px;">
                  <i class="bx bx-broadcast fs-5 text-success"></i> Live Panel
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- ── 2. Top 4 Dynamic KPI Metric Cards ── --}}
    <div class="row g-3 mb-4">
      
      {{-- Card 1: SMS Sent Today --}}
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
          <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-bold" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em;">SMS Sent Today</span>
              <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6; width: 36px; height: 36px;">
                <i class="bx bx-paper-plane fs-5"></i>
              </div>
            </div>
            <h3 class="fw-bold mb-1 text-dark" style="font-size: 1.65rem;">{{ number_format($todaySms) }}</h3>
            <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
              <span class="text-primary fw-semibold me-1">Total:</span>
              <span class="font-monospace fw-bold">{{ number_format($totalSms) }} All Time</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Card 2: Delivery Success Rate --}}
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
          <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-bold" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em;">Success Rate</span>
              <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: rgba(34, 197, 94, 0.12); color: #16a34a; width: 36px; height: 36px;">
                <i class="bx bx-check-double fs-5"></i>
              </div>
            </div>
            <h3 class="fw-bold mb-1 text-success" style="font-size: 1.65rem;">{{ $successRate }}%</h3>
            <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
              <i class="bx bx-timer text-success me-1"></i>
              <span>High Quality Routing</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Card 3: Active Client Accounts --}}
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
          <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-bold" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em;">Client Accounts</span>
              <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: rgba(14, 165, 233, 0.12); color: #0284c7; width: 36px; height: 36px;">
                <i class="bx bx-group fs-5"></i>
              </div>
            </div>
            <h3 class="fw-bold mb-1 text-dark" style="font-size: 1.65rem;">{{ number_format($activeUsers) }}</h3>
            <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
              <span class="text-info fw-semibold me-1">Active:</span>
              <span class="font-monospace fw-bold">{{ $activeUsers }} of {{ $totalUsers }} Total</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Card 4: Total Wallet Balance --}}
      <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px;">
          <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-muted fw-bold" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em;">Wallet Circulation</span>
              <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: rgba(245, 158, 11, 0.12); color: #d97706; width: 36px; height: 36px;">
                <i class="bx bx-wallet fs-5"></i>
              </div>
            </div>
            <h3 class="fw-bold mb-1 text-warning" style="font-size: 1.65rem;">₹{{ number_format($totalWalletBalance, 2) }}</h3>
            <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
              <i class="bx bx-shield-check text-warning me-1"></i>
              <span>Live User Balances</span>
            </div>
          </div>
        </div>
      </div>

    </div>

    {{-- ── 3. Main Dynamic Content: Recent Transactions & System Shortcuts ── --}}
    <div class="row g-4">
      
      {{-- LEFT COLUMN: Recent Live SMS Transactions --}}
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
          <div class="card-header bg-transparent py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
            <div class="d-flex align-items-center gap-2">
              <div class="rounded p-1 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                <i class="bx bx-transfer-alt fs-6"></i>
              </div>
              <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.92rem;">Recent Live SMS Activity</h6>
            </div>
            <a href="{{ route('admin.reports.sms_live_panel') }}" class="btn btn-xs btn-outline-primary fw-semibold px-2 py-1" style="font-size: 0.75rem; border-radius: 6px;">
              View Live Panel <i class="bx bx-right-arrow-alt"></i>
            </a>
          </div>

          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                <thead class="table-light">
                  <tr>
                    <th class="ps-4">TRAN ID</th>
                    <th>USER / CLIENT</th>
                    <th>MOBILE</th>
                    <th>SENDER</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-end pe-4">DATE / TIME</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentTransactions as $row)
                    @php
                      $st = (string)($row->status ?? '0');
                      $isSuccess = ($st === '1' || $st === 'SUCCESS' || $st === 'success');
                      $isFailed  = ($st === '2' || $st === 'FAILED' || $st === 'failed');
                    @endphp
                    <tr>
                      <td class="ps-4 font-monospace fw-bold text-primary">#{{ $row->servid ?? $row->id }}</td>
                      <td>
                        <span class="fw-semibold text-dark">{{ $row->user->name ?? $row->user->admin_username ?? 'User #' . ($row->user_id ?? '-') }}</span>
                      </td>
                      <td class="font-monospace text-dark">{{ $row->rechargeno ?? '-' }}</td>
                      <td><span class="badge bg-label-secondary font-monospace">{{ $row->sender_id ?? 'SMS' }}</span></td>
                      <td class="text-center">
                        @if($isSuccess)
                          <span class="badge bg-label-success px-2 py-1">SUCCESS</span>
                        @elseif($isFailed)
                          <span class="badge bg-label-danger px-2 py-1">FAILED</span>
                        @else
                          <span class="badge bg-label-warning px-2 py-1">PENDING</span>
                        @endif
                      </td>
                      <td class="text-end pe-4 text-muted font-monospace" style="font-size: 0.75rem;">
                        {{ $row->trandate ?? '' }} {{ $row->trantime ?? '' }}
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bx bx-inbox fs-3 d-block mb-1"></i>
                        No recent transactions found.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {{-- RIGHT COLUMN: Gateway Overview & Management Shortcuts --}}
      <div class="col-lg-4">
        
        {{-- SMS Gateway Status Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
          <div class="card-header bg-transparent py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.92rem;">
              <i class="bx bx-chip text-info me-1"></i> SMS Gateway Nodes
            </h6>
            <a href="{{ route('admin.scheduler.sms_api') }}" class="text-primary small fw-semibold text-decoration-none">
              Manage <i class="bx bx-chevron-right"></i>
            </a>
          </div>
          <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div>
                <span class="text-muted small d-block">Active Gateways</span>
                <h4 class="fw-bold text-dark mb-0">{{ $activeGateways }} <span class="text-muted fs-6">/ {{ $totalGateways }} Online</span></h4>
              </div>
              <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                <i class="bx bx-check-circle me-1"></i> OPERATIONAL
              </div>
            </div>
            
            <div class="progress" style="height: 6px;">
              @php
                $gwPercent = $totalGateways > 0 ? round(($activeGateways / $totalGateways) * 100) : 100;
              @endphp
              <div class="progress-bar bg-success" role="progressbar" style="width: {{ $gwPercent }}%;" aria-valuenow="{{ $gwPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>

        {{-- Quick Management Shortcuts --}}
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
          <div class="card-header bg-transparent py-3 px-4 border-bottom">
            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.92rem;">
              <i class="bx bx-grid-alt text-primary me-1"></i> Quick Action Center
            </h6>
          </div>
          <div class="card-body p-3">
            <div class="row g-2">
              <div class="col-6">
                <a href="{{ route('admin.account.fund_transfer') }}" class="d-flex flex-column align-items-center justify-content-center p-3 rounded text-decoration-none quick-action-tile border">
                  <i class="bx bx-transfer fs-3 text-primary mb-1"></i>
                  <span class="text-dark fw-semibold small">Fund Transfer</span>
                </a>
              </div>
              <div class="col-6">
                <a href="{{ route('admin.master.user_register') }}" class="d-flex flex-column align-items-center justify-content-center p-3 rounded text-decoration-none quick-action-tile border">
                  <i class="bx bx-user-plus fs-3 text-info mb-1"></i>
                  <span class="text-dark fw-semibold small">User Register</span>
                </a>
              </div>
              <div class="col-6">
                <a href="{{ route('admin.reports.sms_details') }}" class="d-flex flex-column align-items-center justify-content-center p-3 rounded text-decoration-none quick-action-tile border">
                  <i class="bx bx-file fs-3 text-warning mb-1"></i>
                  <span class="text-dark fw-semibold small">SMS Reports</span>
                </a>
              </div>
              <div class="col-6">
                <a href="{{ route('admin.master.admin_register') }}" class="d-flex flex-column align-items-center justify-content-center p-3 rounded text-decoration-none quick-action-tile border">
                  <i class="bx bx-user-circle fs-3 text-success mb-1"></i>
                  <span class="text-dark fw-semibold small">Admin Profile</span>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

</div>

<style>
  .quick-action-tile {
    background: var(--bg-surface);
    transition: all 0.2s ease;
  }
  .quick-action-tile:hover {
    background: rgba(59, 130, 246, 0.08);
    transform: translateY(-2px);
    border-color: #3b82f6 !important;
  }
  html.dark .table-light {
    background-color: #1e293b !important;
    color: #e2e8f0 !important;
  }
</style>
@endsection