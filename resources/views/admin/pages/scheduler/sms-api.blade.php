@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <!-- Breadcrumb & Page Header Bar -->
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 text-muted fs-7 mb-1">
                    <span class="fs-6">🏠</span>
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none hover-primary">API Manager</a>
                    <span>|</span>
                    <span class="text-primary fw-bold">SMS API Setup</span>
                </div>
                <h4 class="fw-bold mb-0 text-heading">SMS Gateway API Configuration</h4>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#addApiModal">
                    <i class="bx bx-plus-circle fs-5"></i>
                    <span>Add New Gateway</span>
                </button>
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1" onclick="refreshGatewayPipes()">
                    <i class="bx bx-refresh fs-5" id="refresh-spinner"></i>
                    <span class="d-none d-sm-inline">Refresh Pipes</span>
                </button>
            </div>
        </div>

        <!-- KPI Gateway Status Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fs-7 d-block mb-1">Configured Gateways</span>
                            <h4 class="fw-bold mb-0">3 Providers</h4>
                        </div>
                        <div class="avatar avatar-md">
                            <span class="avatar-initial rounded-3 bg-label-primary">
                                <i class="bx bx-server fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fs-7 d-block mb-1">Primary Active Route</span>
                            <h4 class="fw-bold mb-0 text-success">VIDEOCON SMS</h4>
                        </div>
                        <div class="avatar avatar-md">
                            <span class="avatar-initial rounded-3 bg-label-success">
                                <i class="bx bx-check-shield fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fs-7 d-block mb-1">Standby Fallback Pipes</span>
                            <h4 class="fw-bold mb-0 text-warning">2 Standby</h4>
                        </div>
                        <div class="avatar avatar-md">
                            <span class="avatar-initial rounded-3 bg-label-warning">
                                <i class="bx bx-transfer-alt fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fs-7 d-block mb-1">Live Pipeline Health</span>
                            <h4 class="fw-bold mb-0 text-info">99.98% SLA</h4>
                        </div>
                        <div class="avatar avatar-md">
                            <span class="avatar-initial rounded-3 bg-label-info">
                                <i class="bx bx-pulse fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main SMS API List Card Shell -->
        <div class="card shadow-sm border overflow-hidden">
            
            <!-- Table Header Bar -->
            <div class="card-header py-3 px-4 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3" style="background: var(--bg-action-bar);">
                <div class="d-flex align-items-center gap-2 text-white">
                    <i class="bx bx-grid-alt fs-4"></i>
                    <h5 class="card-title mb-0 text-white fw-bold">SMS API List -</h5>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 w-100 w-md-auto">
                    <!-- Search Input -->
                    <div class="input-group input-group-sm" style="max-width: 260px;">
                        <span class="input-group-text bg-white bg-opacity-10 border-0 text-white"><i class="bx bx-search"></i></span>
                        <input type="text" id="api-search-input" class="form-control form-control-sm bg-white bg-opacity-15 border-0 text-white placeholder-white" placeholder="Search Vendor or API..." onkeyup="filterApiTable()" />
                    </div>

                    <!-- Status Filter -->
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-light active" onclick="filterByStatus('all', this)">All (3)</button>
                        <button type="button" class="btn btn-outline-light" onclick="filterByStatus('active', this)">Active (1)</button>
                        <button type="button" class="btn btn-outline-light" onclick="filterByStatus('inactive', this)">Inactive (2)</button>
                    </div>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0" id="smsApiTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th>VENDOR NAME</th>
                            <th>API NAME</th>
                            <th class="text-center">API NO</th>
                            <th>CHANGE DATE/TIME</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center" style="width: 140px;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        
                        <!-- Row 1: PRIORITY SMS -->
                        <tr data-status="inactive" id="row-api-1">
                            <td class="text-center fw-bold text-muted">1</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-xs">
                                        <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-broadcast fs-6"></i></span>
                                    </div>
                                    <span class="fw-bold font-monospace text-heading">(PRIORITY SMS)</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #ffffff; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.04em;">
                                        PRIORITY SMS
                                    </span>
                                    <span class="fw-semibold text-heading fs-7">SMS API</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-secondary font-monospace px-2.5 py-1 fw-bold">1</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1.5 text-muted fs-7">
                                    <i class="bx bx-calendar-event text-primary"></i>
                                    <span>17/12/2023 05:03:46 PM</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-secondary px-3 py-1.5 fw-bold" id="badge-status-1">
                                    INACTIVE
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" title="Test Gateway Ping" onclick="testPingGateway('PRIORITY SMS', 1)">
                                        <i class="bx bx-wifi"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-info" title="Edit API Details" data-bs-toggle="modal" data-bs-target="#editApiModal" onclick="populateEditModal(1, 'PRIORITY SMS', 'SMS API', 1, '17/12/2023 05:03:46 PM', 'INACTIVE')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success px-2 py-1 fs-8 fw-bold" title="Activate Gateway" onclick="toggleGatewayStatus(1)">
                                        Activate
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2: NIMBUSIT SMS -->
                        <tr data-status="inactive" id="row-api-2">
                            <td class="text-center fw-bold text-muted">2</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-xs">
                                        <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-broadcast fs-6"></i></span>
                                    </div>
                                    <span class="fw-bold font-monospace text-heading">(NIMBUSIT SMS)</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #ffffff; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.04em;">
                                        NIMBUSIT SMS
                                    </span>
                                    <span class="fw-semibold text-heading fs-7">SMS API</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-secondary font-monospace px-2.5 py-1 fw-bold">2</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1.5 text-muted fs-7">
                                    <i class="bx bx-calendar-event text-primary"></i>
                                    <span>04/05/2026 12:04:46 PM</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-secondary px-3 py-1.5 fw-bold" id="badge-status-2">
                                    INACTIVE
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" title="Test Gateway Ping" onclick="testPingGateway('NIMBUSIT SMS', 2)">
                                        <i class="bx bx-wifi"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-info" title="Edit API Details" data-bs-toggle="modal" data-bs-target="#editApiModal" onclick="populateEditModal(2, 'NIMBUSIT SMS', 'SMS API', 2, '04/05/2026 12:04:46 PM', 'INACTIVE')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success px-2 py-1 fs-8 fw-bold" title="Activate Gateway" onclick="toggleGatewayStatus(2)">
                                        Activate
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3: VIDEOCON SMS -->
                        <tr data-status="active" id="row-api-3">
                            <td class="text-center fw-bold text-muted">3</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-xs">
                                        <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-signal-5 fs-6"></i></span>
                                    </div>
                                    <span class="fw-bold font-monospace text-heading">(VIDEOCON SMS)</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #ffffff; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.04em;">
                                        VIDEOCON SMS
                                    </span>
                                    <span class="fw-semibold text-heading fs-7">SMS API</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-primary font-monospace px-2.5 py-1 fw-bold">3</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1.5 text-muted fs-7">
                                    <i class="bx bx-calendar-event text-primary"></i>
                                    <span>04/05/2026 12:10:46 PM</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success px-3 py-1.5 fw-bold shadow-sm" id="badge-status-3">
                                    <i class="bx bx-check-double me-1"></i> ACTIVE
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" title="Test Gateway Ping" onclick="testPingGateway('VIDEOCON SMS', 3)">
                                        <i class="bx bx-wifi"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-info" title="Edit API Details" data-bs-toggle="modal" data-bs-target="#editApiModal" onclick="populateEditModal(3, 'VIDEOCON SMS', 'SMS API', 3, '04/05/2026 12:10:46 PM', 'ACTIVE')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 fs-8 fw-bold" title="Deactivate Gateway" onclick="toggleGatewayStatus(3)">
                                        Deactivate
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Table Footer Status Note -->
            <div class="card-footer py-3 px-4 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2" style="background: var(--bg-table-head);">
                <div class="text-muted fs-7 d-flex align-items-center gap-2">
                    <span class="badge badge-dot bg-success"></span>
                    <span>Direct SMPP/HTTP Carrier Pipe connected. Failover auto-routing enabled.</span>
                </div>
                <div class="text-muted fs-7">
                    Showing <strong>3</strong> of <strong>3</strong> Gateways
                </div>
            </div>

        </div>

        </div>
</div>

<!-- ==============================================================
     MODAL: ADD NEW SMS GATEWAY API
     ============================================================== -->
<div class="modal fade" id="addApiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-plus"></i></span>
                    </div>
                    <h5 class="modal-title mb-0">Add New SMS Gateway API</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="addGatewayForm" onsubmit="handleFormSubmit(event, 'add')">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="e.g. AIRTEL SMS / JIO DLT" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">API Identifier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="e.g. PROMOTIONAL FAST PIPE" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label">HTTP Gateway URL / Host Endpoint <span class="text-danger">*</span></label>
                            <input type="url" class="form-control font-monospace" placeholder="https://api.sms-carrier.com/v2/send" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Request Method</label>
                            <select class="form-select">
                                <option value="GET">HTTP GET</option>
                                <option value="POST" selected>HTTP POST (JSON)</option>
                                <option value="SMPP">SMPP 3.4 Protocol</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Max TPS Throughput</label>
                            <input type="number" class="form-control" value="2500" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Initial Route Status</label>
                            <select class="form-select">
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE" selected>INACTIVE (Standby)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">API Key / Auth Header Token</label>
                            <input type="password" class="form-control font-monospace" placeholder="Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6..." />
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-check me-1"></i> Save Gateway
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================================
     MODAL: EDIT SMS GATEWAY API
     ============================================================== -->
<div class="modal fade" id="editApiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-pencil"></i></span>
                    </div>
                    <h5 class="modal-title mb-0">Edit SMS API Gateway Details</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editGatewayForm" onsubmit="handleFormSubmit(event, 'edit')">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-vendor-name" class="form-control font-monospace" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">API Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit-api-name" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">API No ID</label>
                            <input type="text" id="edit-api-no" class="form-control font-monospace bg-light" readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Route Status</label>
                            <select id="edit-status" class="form-select">
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Modified Date</label>
                            <input type="text" id="edit-change-date" class="form-control bg-light fs-7" readonly />
                        </div>
                        <div class="col-12">
                            <label class="form-label">Carrier Direct Pipe Endpoint</label>
                            <input type="text" class="form-control font-monospace" value="https://gateway.aslsmshub.com/pipes/v1/transmit" />
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">
                        <i class="bx bx-save me-1"></i> Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================================
     MODAL: PING TEST GATEWAY LATENCY
     ============================================================== -->
<div class="modal fade" id="pingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-wifi"></i></span>
                    </div>
                    <h5 class="modal-title mb-0">Telecom Pipe Diagnostic Ping</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div id="ping-spinner" class="mb-3">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                    <p class="text-muted mt-2 fs-7" id="ping-status-text">Connecting to carrier gateway socket...</p>
                </div>

                <div id="ping-results" class="d-none">
                    <div class="avatar avatar-lg mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-success fs-2"><i class="bx bx-check"></i></span>
                    </div>
                    <h5 class="fw-bold text-success mb-1" id="ping-gateway-name">VIDEOCON SMS Pipe</h5>
                    <p class="text-muted fs-7 mb-3">Gateway handshake verified successfully.</p>
                    
                    <div class="p-3 rounded-3 text-start font-monospace fs-7 mb-3" style="background: var(--bg-input); border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">HTTP Response:</span>
                            <span class="text-success fw-bold">200 OK</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Round-trip Latency:</span>
                            <span class="text-primary fw-bold" id="ping-latency">138 ms</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Carrier Route:</span>
                            <span class="text-heading">TIER-1 DIRECT PIPE</span>
                        </div>
                        <div class="d-flex justify-content-between pt-1">
                            <span class="text-muted">DLT Scrubbing Engine:</span>
                            <span class="text-success">SYNCHRONIZED</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close Diagnostic</button>
            </div>
        </div>
    </div>
</div>

<!-- ==============================================================
     JAVASCRIPT INTERACTION ENGINE
     ============================================================== -->
<script>
    // Search Filter
    function filterApiTable() {
        const query = document.getElementById('api-search-input').value.toLowerCase();
        const rows = document.querySelectorAll('#smsApiTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }

    // Status Filter (All, Active, Inactive)
    function filterByStatus(status, btn) {
        document.querySelectorAll('.btn-group button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const rows = document.querySelectorAll('#smsApiTable tbody tr');
        rows.forEach(row => {
            if (status === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.getAttribute('data-status') === status ? '' : 'none';
            }
        });
    }

    // Populate Edit Modal
    function populateEditModal(id, vendor, apiName, apiNo, changeDate, status) {
        document.getElementById('edit-vendor-name').value = vendor;
        document.getElementById('edit-api-name').value = apiName;
        document.getElementById('edit-api-no').value = apiNo;
        document.getElementById('edit-status').value = status;
        document.getElementById('edit-change-date').value = changeDate;
    }

    // Toggle Gateway Status
    function toggleGatewayStatus(id) {
        const row = document.getElementById(`row-api-${id}`);
        const badge = document.getElementById(`badge-status-${id}`);
        const isCurrentlyActive = row.getAttribute('data-status') === 'active';

        if (isCurrentlyActive) {
            row.setAttribute('data-status', 'inactive');
            badge.className = 'badge bg-label-secondary px-3 py-1.5 fw-bold';
            badge.innerHTML = 'INACTIVE';
            row.querySelector('.btn-outline-danger, .btn-outline-success').className = 'btn btn-sm btn-outline-success px-2 py-1 fs-8 fw-bold';
            row.querySelector('.btn-outline-danger, .btn-outline-success').textContent = 'Activate';
        } else {
            row.setAttribute('data-status', 'active');
            badge.className = 'badge bg-success px-3 py-1.5 fw-bold shadow-sm';
            badge.innerHTML = '<i class="bx bx-check-double me-1"></i> ACTIVE';
            row.querySelector('.btn-outline-danger, .btn-outline-success').className = 'btn btn-sm btn-outline-danger px-2 py-1 fs-8 fw-bold';
            row.querySelector('.btn-outline-danger, .btn-outline-success').textContent = 'Deactivate';
        }
    }

    // Refresh Gateway Pipes Simulation
    function refreshGatewayPipes() {
        const icon = document.getElementById('refresh-spinner');
        icon.classList.add('bx-spin');
        setTimeout(() => {
            icon.classList.remove('bx-spin');
        }, 800);
    }

    // Ping Gateway Test
    function testPingGateway(vendorName, id) {
        const pingModal = new bootstrap.Modal(document.getElementById('pingModal'));
        const spinner = document.getElementById('ping-spinner');
        const results = document.getElementById('ping-results');
        const nameDisplay = document.getElementById('ping-gateway-name');
        const latencyDisplay = document.getElementById('ping-latency');

        nameDisplay.textContent = `${vendorName} Telecom Pipe`;
        spinner.classList.remove('d-none');
        results.classList.add('d-none');

        pingModal.show();

        setTimeout(() => {
            const randomLatency = Math.floor(90 + Math.random() * 80);
            latencyDisplay.textContent = `${randomLatency} ms`;
            spinner.classList.add('d-none');
            results.classList.remove('d-none');
        }, 900);
    }

    // Handle Modal Form Submissions
    function handleFormSubmit(e, type) {
        e.preventDefault();
        const modalEl = document.getElementById(type === 'add' ? 'addApiModal' : 'editApiModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }
</script>
@endsection
