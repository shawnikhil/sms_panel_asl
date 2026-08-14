@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    {{-- ── Page Header ── --}}
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <div class="d-flex align-items-center gap-2 text-muted fs-7 mb-1">
          <span class="fs-6">🏠</span>
          <a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none">Manage Item</a>
          <span>|</span>
          <span class="text-primary fw-bold">Manage Sender ID</span>
        </div>
        <h4 class="fw-bold mb-0">Sender ID Management</h4>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center gap-1"
                data-bs-toggle="modal" data-bs-target="#addSenderModal">
          <i class="bx bx-plus-circle fs-5"></i>
          <span>Add Sender ID</span>
        </button>
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                onclick="refreshSenderList()">
          <i class="bx bx-refresh fs-5" id="sid-refresh-icon"></i>
          <span class="d-none d-sm-inline">Refresh</span>
        </button>
      </div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="row g-3 mb-4">
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="card-body p-3 d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 d-block mb-1">Total Sender IDs</span>
              <h4 class="fw-bold mb-0" id="stat-total">—</h4>
            </div>
            <div class="avatar avatar-md">
              <span class="avatar-initial rounded-3 bg-label-primary">
                <i class="bx bx-id-card fs-4"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="card-body p-3 d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 d-block mb-1">Approved</span>
              <h4 class="fw-bold mb-0 text-success" id="stat-approved">—</h4>
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
              <span class="text-muted fs-7 d-block mb-1">Pending</span>
              <h4 class="fw-bold mb-0 text-warning" id="stat-pending">—</h4>
            </div>
            <div class="avatar avatar-md">
              <span class="avatar-initial rounded-3 bg-label-warning">
                <i class="bx bx-time fs-4"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card h-100">
          <div class="card-body p-3 d-flex align-items-center justify-content-between">
            <div>
              <span class="text-muted fs-7 d-block mb-1">Rejected</span>
              <h4 class="fw-bold mb-0 text-danger" id="stat-rejected">—</h4>
            </div>
            <div class="avatar avatar-md">
              <span class="avatar-initial rounded-3 bg-label-danger">
                <i class="bx bx-x-circle fs-4"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- ── Search / Filter Bar ── --}}
    <div class="card mb-4">
      <div class="card-body p-3">
        <div class="row g-3 align-items-end">
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Reg No</label>
            <input type="text" id="filter-regno" class="form-control form-control-sm" placeholder="Enter Reg No" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">User Name</label>
            <input type="text" id="filter-username" class="form-control form-control-sm" placeholder="Enter User Name" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Sender ID</label>
            <input type="text" id="filter-senderid" class="form-control form-control-sm" placeholder="e.g. SAETPL" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Entity ID</label>
            <input type="text" id="filter-entityid" class="form-control form-control-sm" placeholder="Enter Entity ID" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">From Date</label>
            <input type="date" id="filter-from" class="form-control form-control-sm" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">To Date</label>
            <input type="date" id="filter-to" class="form-control form-control-sm" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Status</label>
            <select id="filter-status" class="form-select form-select-sm">
              <option value="">All Status</option>
              <option value="approved">Approved</option>
              <option value="pending">Pending</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-sm-6 col-lg-3 d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm flex-fill" onclick="applyFilters()">
              <i class="bx bx-search me-1"></i> Search
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm flex-fill" onclick="clearFilters()">
              <i class="bx bx-x me-1"></i> Clear
            </button>
          </div>
        </div>
      </div>
    </div>

    {{-- ── Sender ID Table Card ── --}}
    <div class="card shadow-sm border overflow-hidden">

      {{-- Action Bar --}}
      <div class="d-flex align-items-center justify-content-between gap-3 px-4 py-3"
           style="background:var(--bg-action-bar);border-bottom:1px solid var(--border-color);">
        <div class="d-flex align-items-center gap-2">
          <div style="width:32px;height:32px;border-radius:.5rem;background:rgba(255,255,255,.15);
                      display:flex;align-items:center;justify-content:center;">
            <i class="bx bx-id-card" style="color:#fff;font-size:1.1rem;"></i>
          </div>
          <div>
            <span style="color:#fff;font-weight:700;font-size:.9rem;">Sender ID List</span>
            <span id="sid-count-badge" style="margin-left:.5rem;font-size:.72rem;color:rgba(255,255,255,.75);">Loading…</span>
          </div>
        </div>

        {{-- Tab Filters --}}
        <div class="d-flex align-items-center gap-1">
          <button class="sid-tab-btn active" data-filter="all"     onclick="setTabFilter(this,'all')">All</button>
          <button class="sid-tab-btn"        data-filter="approved" onclick="setTabFilter(this,'approved')">Approved</button>
          <button class="sid-tab-btn"        data-filter="pending"  onclick="setTabFilter(this,'pending')">Pending</button>
          <button class="sid-tab-btn"        data-filter="rejected" onclick="setTabFilter(this,'rejected')">Rejected</button>
        </div>

        {{-- Search box in action bar --}}
        <div class="position-relative d-none d-md-block">
          <i class="bx bx-search" style="position:absolute;left:.65rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.6);font-size:1rem;"></i>
          <input type="text" id="sid-quick-search" placeholder="Quick search…"
                 oninput="quickSearch(this.value)"
                 style="height:34px;padding:0 .75rem 0 2.1rem;border-radius:.5rem;border:1px solid rgba(255,255,255,.2);
                        background:rgba(255,255,255,.12);color:#fff;font-size:.8125rem;width:180px;outline:none;"
                 onblur="this.style.borderColor='rgba(255,255,255,.2)'"
                 onfocus="this.style.borderColor='rgba(255,255,255,.5)'" />
        </div>
      </div>

      {{-- Table --}}
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="sender-id-table">
          <thead class="table-light">
            <tr>
              <th style="width:50px;">#</th>
              <th>Sender ID</th>
              <th>Entity ID</th>
              <th>User Reg No</th>
              <th>User Name</th>
              <th>Status</th>
              <th>Tran Date / Time</th>
              <th style="width:120px;">Action</th>
            </tr>
          </thead>
          <tbody id="sid-tbody">
            {{-- Demo rows — replace with @foreach($senderIds as $row) --}}
            <tr data-status="approved">
              <td><span class="text-muted fw-600">1</span></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:32px;height:32px;border-radius:.5rem;background:linear-gradient(135deg,#4f46e5,#3b82f6);
                              display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bx bx-id-card" style="color:#fff;font-size:.9rem;"></i>
                  </div>
                  <span class="fw-bold" style="color:var(--text-primary);">SAETPL</span>
                </div>
              </td>
              <td><span class="text-muted" style="font-family:var(--font-mono);font-size:.8rem;">1705177379937624489</span></td>
              <td><span class="badge" style="background:rgba(79,70,229,.1);color:#4f46e5;font-weight:700;">3901</span></td>
              <td>sabhita pay</td>
              <td>
                <span class="badge d-inline-flex align-items-center gap-1"
                      style="background:rgba(16,185,129,.12);color:#059669;border:1px solid rgba(16,185,129,.25);border-radius:999px;padding:.3rem .7rem;">
                  <span style="width:6px;height:6px;border-radius:50%;background:#10b981;display:inline-block;"></span>
                  Approved
                </span>
              </td>
              <td><span class="text-muted" style="font-size:.8rem;">13/06/2026 08:45:01 PM</span></td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  <button class="btn btn-sm" title="Edit Status"
                          onclick="editSenderStatus(1)"
                          style="padding:.3rem .6rem;background:rgba(59,130,246,.12);color:#3b82f6;border:1px solid rgba(59,130,246,.2);border-radius:.4rem;">
                    <i class="bx bx-edit-alt"></i>
                  </button>
                  <button class="btn btn-sm" title="View Details"
                          onclick="viewSenderDetails(1)"
                          style="padding:.3rem .6rem;background:rgba(79,70,229,.1);color:#4f46e5;border:1px solid rgba(79,70,229,.2);border-radius:.4rem;">
                    <i class="bx bx-show"></i>
                  </button>
                </div>
              </td>
            </tr>
            <tr data-status="approved">
              <td><span class="text-muted fw-600">2</span></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:32px;height:32px;border-radius:.5rem;background:linear-gradient(135deg,#10b981,#059669);
                              display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bx bx-id-card" style="color:#fff;font-size:.9rem;"></i>
                  </div>
                  <span class="fw-bold" style="color:var(--text-primary);">SAETPL</span>
                </div>
              </td>
              <td><span class="text-muted" style="font-family:var(--font-mono);font-size:.8rem;">1705177379937624489</span></td>
              <td><span class="badge" style="background:rgba(79,70,229,.1);color:#4f46e5;font-weight:700;">3905</span></td>
              <td>sabhita pay</td>
              <td>
                <span class="badge d-inline-flex align-items-center gap-1"
                      style="background:rgba(16,185,129,.12);color:#059669;border:1px solid rgba(16,185,129,.25);border-radius:999px;padding:.3rem .7rem;">
                  <span style="width:6px;height:6px;border-radius:50%;background:#10b981;display:inline-block;"></span>
                  Approved
                </span>
              </td>
              <td><span class="text-muted" style="font-size:.8rem;">30/06/2026 08:42:01 PM</span></td>
              <td>
                <div class="d-flex align-items-center gap-1">
                  <button class="btn btn-sm" title="Edit Status"
                          onclick="editSenderStatus(2)"
                          style="padding:.3rem .6rem;background:rgba(59,130,246,.12);color:#3b82f6;border:1px solid rgba(59,130,246,.2);border-radius:.4rem;">
                    <i class="bx bx-edit-alt"></i>
                  </button>
                  <button class="btn btn-sm" title="View Details"
                          onclick="viewSenderDetails(2)"
                          style="padding:.3rem .6rem;background:rgba(79,70,229,.1);color:#4f46e5;border:1px solid rgba(79,70,229,.2);border-radius:.4rem;">
                    <i class="bx bx-show"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- Table Footer --}}
      <div class="d-flex align-items-center justify-content-between px-4 py-3"
           style="border-top:1px solid var(--border-color);background:var(--bg-table-head);">
        <div class="text-muted d-flex align-items-center gap-2" style="font-size:.8125rem;">
          <span class="badge badge-dot bg-success me-1"></span>
          <span>DLT verified sender identities. TRAI compliant.</span>
        </div>
        <div class="text-muted" style="font-size:.8125rem;">
          Showing <strong id="sid-showing">2</strong> of <strong id="sid-total-count">2</strong> Sender IDs
        </div>
      </div>
    </div>

  </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     MODAL: ADD SENDER ID
     ═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="addSenderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:var(--bg-action-bar);">
        <div class="d-flex align-items-center gap-2">
          <div class="avatar avatar-sm">
            <span class="avatar-initial rounded-circle bg-label-primary">
              <i class="bx bx-plus"></i>
            </span>
          </div>
          <h5 class="modal-title mb-0" style="color:#fff;">Add New Sender ID</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">User Reg No <span class="text-danger">*</span></label>
            <input type="text" id="add-regno" class="form-control" placeholder="Enter Reg No" />
          </div>
          <div class="col-md-6">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">User Name <span class="text-danger">*</span></label>
            <input type="text" id="add-username" class="form-control" placeholder="Enter User Name" />
          </div>
          <div class="col-md-6">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Sender ID <span class="text-danger">*</span></label>
            <input type="text" id="add-senderid" class="form-control" placeholder="e.g. MYBRND" maxlength="11" />
          </div>
          <div class="col-md-6">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Entity ID <span class="text-danger">*</span></label>
            <input type="text" id="add-entityid" class="form-control" placeholder="DLT Entity ID" />
          </div>
          <div class="col-md-6">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Status</label>
            <select id="add-status" class="form-select">
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Remarks</label>
            <input type="text" id="add-remarks" class="form-control" placeholder="Optional remarks" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="bx bx-x me-1"></i> Cancel
        </button>
        <button type="button" class="btn btn-primary" onclick="saveSenderId()">
          <i class="bx bx-check me-1"></i> Save Sender ID
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     MODAL: EDIT STATUS
     ═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-edit me-2 text-primary"></i>Edit Sender Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Sender ID</label>
          <input type="text" id="edit-senderid-display" class="form-control" readonly />
        </div>
        <div class="mb-3">
          <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">New Status <span class="text-danger">*</span></label>
          <select id="edit-new-status" class="form-select">
            <option value="approved">✅ Approved</option>
            <option value="pending">⏳ Pending</option>
            <option value="rejected">❌ Rejected</option>
          </select>
        </div>
        <div>
          <label class="form-label" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text-secondary);">Remarks</label>
          <textarea id="edit-remarks" class="form-control" rows="2" placeholder="Reason for status change…"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="updateStatus()">
          <i class="bx bx-save me-1"></i> Update Status
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ═══ STYLES ═══ --}}
<style>
  .sid-tab-btn {
    padding: .3rem .85rem;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,.25);
    background: rgba(255,255,255,.1);
    color: rgba(255,255,255,.75);
    font-size: .75rem;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s ease;
  }
  .sid-tab-btn:hover { background: rgba(255,255,255,.2); color: #fff; }
  .sid-tab-btn.active { background: #fff; color: #4f46e5; border-color: #fff; }

  #sender-id-table tbody tr { transition: background-color .15s ease; }
  #sender-id-table tbody tr.sid-hidden { display: none; }
</style>

{{-- ═══ SCRIPTS ═══ --}}
<script>
  /* ── Stats counter ── */
  document.addEventListener('DOMContentLoaded', function () {
    const rows     = document.querySelectorAll('#sid-tbody tr');
    const approved = [...rows].filter(r => r.dataset.status === 'approved').length;
    const pending  = [...rows].filter(r => r.dataset.status === 'pending').length;
    const rejected = [...rows].filter(r => r.dataset.status === 'rejected').length;
    document.getElementById('stat-total').textContent    = rows.length;
    document.getElementById('stat-approved').textContent = approved;
    document.getElementById('stat-pending').textContent  = pending;
    document.getElementById('stat-rejected').textContent = rejected;
    document.getElementById('sid-count-badge').textContent = rows.length + ' Records';
    updateShowingCount();
  });

  function updateShowingCount() {
    const visible = document.querySelectorAll('#sid-tbody tr:not(.sid-hidden)').length;
    const total   = document.querySelectorAll('#sid-tbody tr').length;
    document.getElementById('sid-showing').textContent     = visible;
    document.getElementById('sid-total-count').textContent = total;
  }

  /* ── Tab filter ── */
  let activeTab = 'all';
  function setTabFilter(btn, filter) {
    document.querySelectorAll('.sid-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    activeTab = filter;
    applyAllFilters();
  }

  /* ── Quick search ── */
  function quickSearch(val) {
    applyAllFilters();
  }

  /* ── Form filter ── */
  function applyFilters() { applyAllFilters(); }

  function applyAllFilters() {
    const q       = (document.getElementById('sid-quick-search')?.value || '').toLowerCase();
    const regno   = document.getElementById('filter-regno').value.toLowerCase();
    const uname   = document.getElementById('filter-username').value.toLowerCase();
    const sid     = document.getElementById('filter-senderid').value.toLowerCase();
    const eid     = document.getElementById('filter-entityid').value.toLowerCase();
    const status  = document.getElementById('filter-status').value.toLowerCase();

    document.querySelectorAll('#sid-tbody tr').forEach(row => {
      const text   = row.textContent.toLowerCase();
      const rStatus = row.dataset.status;
      const tabOk  = activeTab === 'all' || rStatus === activeTab;
      const statusOk = !status || rStatus === status;
      const qOk    = !q || text.includes(q);
      const regOk  = !regno   || text.includes(regno);
      const unOk   = !uname   || text.includes(uname);
      const sidOk  = !sid     || text.includes(sid);
      const eidOk  = !eid     || text.includes(eid);

      if (tabOk && statusOk && qOk && regOk && unOk && sidOk && eidOk) {
        row.classList.remove('sid-hidden');
      } else {
        row.classList.add('sid-hidden');
      }
    });
    updateShowingCount();
  }

  function clearFilters() {
    ['filter-regno','filter-username','filter-senderid','filter-entityid','filter-from','filter-to'].forEach(id => {
      document.getElementById(id).value = '';
    });
    document.getElementById('filter-status').value = '';
    if (document.getElementById('sid-quick-search')) document.getElementById('sid-quick-search').value = '';
    applyAllFilters();
  }

  /* ── Refresh ── */
  function refreshSenderList() {
    const icon = document.getElementById('sid-refresh-icon');
    icon.style.animation = 'spin 1s linear infinite';
    setTimeout(() => { icon.style.animation = ''; }, 1500);
  }

  /* ── Edit status modal ── */
  function editSenderStatus(id) {
    document.getElementById('edit-senderid-display').value = 'SAETPL';
    const modal = new bootstrap.Modal(document.getElementById('editStatusModal'));
    modal.show();
  }

  function updateStatus() {
    bootstrap.Modal.getInstance(document.getElementById('editStatusModal')).hide();
  }

  /* ── View details ── */
  function viewSenderDetails(id) {
    console.log('View Sender ID:', id);
  }

  /* ── Save new sender ID ── */
  function saveSenderId() {
    bootstrap.Modal.getInstance(document.getElementById('addSenderModal')).hide();
  }
</script>

<style>
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

@endsection
