@extends('admin.layout.master')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    {{-- ── Page Header ── --}}
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <div class="d-flex align-items-center gap-2 text-muted fs-7 mb-1">
          <span class="fs-6">🏠</span>
          <a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none">Manage Item</a>
          <span>|</span>
          <span class="text-primary fw-bold">Manage Template</span>
        </div>
        <h4 class="fw-bold mb-0">SMS Template Management</h4>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center gap-1"
                data-bs-toggle="modal" data-bs-target="#addTemplateModal">
          <i class="bx bx-plus-circle fs-5"></i>
          <span>Add Template</span>
        </button>
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1"
                onclick="refreshTemplateList()">
          <i class="bx bx-refresh fs-5" id="tpl-refresh-icon"></i>
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
              <span class="text-muted fs-7 d-block mb-1">Total Templates</span>
              <h4 class="fw-bold mb-0" id="tpl-stat-total">7</h4>
            </div>
            <div class="avatar avatar-md">
              <span class="avatar-initial rounded-3 bg-label-primary">
                <i class="bx bx-file fs-4"></i>
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
              <h4 class="fw-bold mb-0 text-success" id="tpl-stat-approved">7</h4>
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
              <h4 class="fw-bold mb-0 text-warning" id="tpl-stat-pending">0</h4>
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
              <h4 class="fw-bold mb-0 text-danger" id="tpl-stat-rejected">0</h4>
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
            <label class="tpl-label">Reg No</label>
            <input type="text" id="tpl-filter-regno" class="form-control form-control-sm" placeholder="Enter Reg No" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="tpl-label">User Name</label>
            <input type="text" id="tpl-filter-username" class="form-control form-control-sm" placeholder="Enter User Name" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="tpl-label">Sender ID</label>
            <input type="text" id="tpl-filter-senderid" class="form-control form-control-sm" placeholder="e.g. SAETPL" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="tpl-label">Entity ID</label>
            <input type="text" id="tpl-filter-entityid" class="form-control form-control-sm" placeholder="Enter Entity ID" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="tpl-label">Template ID</label>
            <input type="text" id="tpl-filter-templateid" class="form-control form-control-sm" placeholder="Enter Template ID" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="tpl-label">From Date</label>
            <input type="date" id="tpl-filter-from" class="form-control form-control-sm" />
          </div>
          <div class="col-sm-6 col-lg-3">
            <label class="tpl-label">Status</label>
            <select id="tpl-filter-status" class="form-select form-select-sm">
              <option value="">All Status</option>
              <option value="approved">Approved</option>
              <option value="pending">Pending</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-sm-6 col-lg-3 d-flex gap-2">
            <button type="button" class="btn btn-primary btn-sm flex-fill" onclick="tplApplyFilters()">
              <i class="bx bx-search me-1"></i> Search
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm flex-fill" onclick="tplClearFilters()">
              <i class="bx bx-x me-1"></i> Clear
            </button>
          </div>
        </div>
      </div>
    </div>

    {{-- ── Template Table Card ── --}}
    <div class="card shadow-sm border overflow-hidden">

      {{-- Action Bar --}}
      <div class="d-flex align-items-center justify-content-between gap-3 px-4 py-3"
           style="background:var(--bg-action-bar);border-bottom:1px solid var(--border-color);">
        <div class="d-flex align-items-center gap-2">
          <div style="width:32px;height:32px;border-radius:.5rem;background:rgba(255,255,255,.15);
                      display:flex;align-items:center;justify-content:center;">
            <i class="bx bx-file" style="color:#fff;font-size:1.1rem;"></i>
          </div>
          <div>
            <span style="color:#fff;font-weight:700;font-size:.9rem;">Template List</span>
            <span id="tpl-count-badge" style="margin-left:.5rem;font-size:.72rem;color:rgba(255,255,255,.75);">7 Records</span>
          </div>
        </div>

        {{-- Tab Filters --}}
        <div class="d-flex align-items-center gap-1">
          <button class="tpl-tab-btn active" data-filter="all"      onclick="tplSetTab(this,'all')">All</button>
          <button class="tpl-tab-btn"        data-filter="approved"  onclick="tplSetTab(this,'approved')">Approved</button>
          <button class="tpl-tab-btn"        data-filter="pending"   onclick="tplSetTab(this,'pending')">Pending</button>
          <button class="tpl-tab-btn"        data-filter="rejected"  onclick="tplSetTab(this,'rejected')">Rejected</button>
        </div>

        {{-- Quick Search --}}
        <div class="position-relative d-none d-md-block">
          <i class="bx bx-search"
             style="position:absolute;left:.65rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.6);font-size:1rem;"></i>
          <input type="text" id="tpl-quick-search" placeholder="Quick search…"
                 oninput="tplApplyAllFilters()"
                 style="height:34px;padding:0 .75rem 0 2.1rem;border-radius:.5rem;
                        border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.12);
                        color:#fff;font-size:.8125rem;width:180px;outline:none;"
                 onfocus="this.style.borderColor='rgba(255,255,255,.5)'"
                 onblur="this.style.borderColor='rgba(255,255,255,.2)'" />
        </div>
      </div>

      {{-- Table --}}
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="template-table">
          <thead class="table-light">
            <tr>
              <th style="width:46px;">#</th>
              <th style="width:80px;">Action</th>
              <th>Sender ID</th>
              <th>Template ID</th>
              <th>Content</th>
              <th>Status</th>
              <th>User Reg No</th>
              <th>User Name</th>
              <th>Tran Date / Time</th>
            </tr>
          </thead>
          <tbody id="tpl-tbody">

            @php
              $templates = [
                ['id'=>1, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598070669735', 'content'=>'Sabhita fund transfer',                   'status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 05:45:16 PM'],
                ['id'=>2, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598245157455', 'content'=>'Sabhita distributor registration message','status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 12:48:59 PM'],
                ['id'=>3, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598374968814', 'content'=>'Sabhita DMT alert message',                'status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 12:44:20 PM'],
                ['id'=>4, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598299493471', 'content'=>'Sabhita registration',                     'status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 12:43:31 PM'],
                ['id'=>5, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598321669745', 'content'=>'Sabhita resend OTP',                       'status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 12:42:50 PM'],
                ['id'=>6, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598163225946', 'content'=>'Sabhita MPIN send',                        'status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 12:39:07 PM'],
                ['id'=>7, 'sender'=>'SAETPL', 'tpl_id'=>'1707177598018919012', 'content'=>'Sabhita Login OTP send',                   'status'=>'approved', 'regno'=>'3905', 'user'=>'sabhita pay', 'date'=>'12/05/2026 11:15:11 AM'],
              ];

              $iconColors = [
                ['#4f46e5','#3b82f6'], ['#10b981','#059669'], ['#f59e0b','#d97706'],
                ['#8b5cf6','#6d28d9'], ['#06b6d4','#0284c7'], ['#ef4444','#dc2626'], ['#14b8a6','#0d9488'],
              ];
            @endphp

            @foreach($templates as $i => $t)
            @php
              $c = $iconColors[$i % count($iconColors)];
              $statusColor  = $t['status'] === 'approved' ? ['#10b981','rgba(16,185,129,.12)','rgba(16,185,129,.25)']
                            : ($t['status'] === 'pending'  ? ['#d97706','rgba(245,158,11,.12)','rgba(245,158,11,.25)']
                                                           : ['#dc2626','rgba(239,68,68,.12)','rgba(239,68,68,.25)']);
            @endphp
            <tr data-status="{{ $t['status'] }}" data-id="{{ $t['id'] }}">
              <td><span class="text-muted" style="font-weight:600;">{{ $t['id'] }}</span></td>
              <td>
                <button class="btn btn-sm tpl-edit-btn"
                        onclick="tplEditStatus({{ $t['id'] }}, '{{ $t['sender'] }}', '{{ $t['tpl_id'] }}', '{{ $t['status'] }}')"
                        title="Edit Status"
                        style="padding:.3rem .65rem;background:rgba(59,130,246,.12);color:#3b82f6;
                               border:1px solid rgba(59,130,246,.2);border-radius:.4rem;font-size:.78rem;font-weight:700;">
                  <i class="bx bx-edit-alt me-1"></i>Edit
                </button>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:30px;height:30px;border-radius:.45rem;flex-shrink:0;
                              background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }});
                              display:flex;align-items:center;justify-content:center;">
                    <i class="bx bx-file" style="color:#fff;font-size:.85rem;"></i>
                  </div>
                  <span class="fw-bold" style="color:var(--text-primary);font-size:.85rem;">{{ $t['sender'] }}</span>
                </div>
              </td>
              <td>
                <span class="tpl-id-chip">{{ $t['tpl_id'] }}</span>
              </td>
              <td>
                <span class="tpl-content-text" title="{{ $t['content'] }}">{{ $t['content'] }}</span>
              </td>
              <td>
                <span class="badge d-inline-flex align-items-center gap-1"
                      style="background:{{ $statusColor[1] }};color:{{ $statusColor[0] }};
                             border:1px solid {{ $statusColor[2] }};border-radius:999px;padding:.28rem .65rem;
                             font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">
                  <span style="width:5px;height:5px;border-radius:50%;background:{{ $statusColor[0] }};display:inline-block;"></span>
                  {{ ucfirst($t['status']) }}
                </span>
              </td>
              <td>
                <span class="badge" style="background:rgba(79,70,229,.1);color:#4f46e5;font-weight:700;font-size:.78rem;">
                  {{ $t['regno'] }}
                </span>
              </td>
              <td style="font-size:.84rem;">{{ $t['user'] }}</td>
              <td><span class="text-muted" style="font-size:.78rem;white-space:nowrap;">{{ $t['date'] }}</span></td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>

      {{-- Table Footer --}}
      <div class="d-flex align-items-center justify-content-between px-4 py-3"
           style="border-top:1px solid var(--border-color);background:var(--bg-table-head);">
        <div class="d-flex align-items-center gap-2 text-muted" style="font-size:.8125rem;">
          <span class="badge badge-dot bg-success me-1"></span>
          DLT registered templates. TRAI compliant content.
        </div>
        <div class="text-muted" style="font-size:.8125rem;">
          Showing <strong id="tpl-showing">7</strong> of <strong id="tpl-total-count">7</strong> Templates
        </div>
      </div>
    </div>

  </div>

{{-- ═══════════════════════════════════════════════════════
     MODAL: ADD TEMPLATE
     ═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="addTemplateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:var(--bg-action-bar);">
        <div class="d-flex align-items-center gap-2">
          <div class="avatar avatar-sm">
            <span class="avatar-initial rounded-circle bg-label-primary">
              <i class="bx bx-plus"></i>
            </span>
          </div>
          <h5 class="modal-title mb-0" style="color:#fff;">Add New SMS Template</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="tpl-label">User Reg No <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter Reg No" />
          </div>
          <div class="col-md-6">
            <label class="tpl-label">User Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter User Name" />
          </div>
          <div class="col-md-6">
            <label class="tpl-label">Sender ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="e.g. SAETPL" />
          </div>
          <div class="col-md-6">
            <label class="tpl-label">Template ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="DLT Template ID" />
          </div>
          <div class="col-md-6">
            <label class="tpl-label">Entity ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="DLT Entity ID" />
          </div>
          <div class="col-md-6">
            <label class="tpl-label">Status</label>
            <select class="form-select">
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-12">
            <label class="tpl-label">Template Content <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="3" placeholder="Enter SMS template content…"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="bx bx-x me-1"></i> Cancel
        </button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          <i class="bx bx-check me-1"></i> Save Template
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     MODAL: EDIT STATUS
     ═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="tplEditStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bx bx-edit me-2 text-primary"></i>Edit Template Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="tpl-label">Sender ID</label>
          <input type="text" id="tpl-edit-sender-display" class="form-control" readonly />
        </div>
        <div class="mb-3">
          <label class="tpl-label">Template ID</label>
          <input type="text" id="tpl-edit-tplid-display" class="form-control" readonly
                 style="font-family:var(--font-mono);font-size:.8rem;" />
        </div>
        <div class="mb-3">
          <label class="tpl-label">New Status <span class="text-danger">*</span></label>
          <select id="tpl-edit-new-status" class="form-select">
            <option value="approved">✅ Approved</option>
            <option value="pending">⏳ Pending</option>
            <option value="rejected">❌ Rejected</option>
          </select>
        </div>
        <div>
          <label class="tpl-label">Remarks</label>
          <textarea class="form-control" rows="2" placeholder="Reason for status change…"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          <i class="bx bx-save me-1"></i> Update Status
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ═══ STYLES ═══ --}}
<style>
  .tpl-label {
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: var(--text-secondary);
    display: block;
    margin-bottom: .35rem;
  }

  .tpl-tab-btn {
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
  .tpl-tab-btn:hover  { background: rgba(255,255,255,.2); color: #fff; }
  .tpl-tab-btn.active { background: #fff; color: #4f46e5; border-color: #fff; }

  .tpl-id-chip {
    font-family: var(--font-mono);
    font-size: .75rem;
    color: var(--text-muted);
    background: var(--bg-table-head);
    border: 1px solid var(--border-color);
    border-radius: .35rem;
    padding: .15rem .45rem;
    display: inline-block;
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: middle;
  }

  .tpl-content-text {
    font-size: .84rem;
    color: var(--text-secondary);
    max-width: 220px;
    display: inline-block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: middle;
  }

  #template-table tbody tr { transition: background-color .15s ease; }
  #template-table tbody tr.tpl-hidden { display: none; }

  @keyframes tpl-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

{{-- ═══ SCRIPTS ═══ --}}
<script>
  /* ── Tab filter ── */
  let tplActiveTab = 'all';
  function tplSetTab(btn, filter) {
    document.querySelectorAll('.tpl-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    tplActiveTab = filter;
    tplApplyAllFilters();
  }

  /* ── Unified filter ── */
  function tplApplyFilters() { tplApplyAllFilters(); }

  function tplApplyAllFilters() {
    const q      = (document.getElementById('tpl-quick-search')?.value || '').toLowerCase();
    const regno  = document.getElementById('tpl-filter-regno').value.toLowerCase();
    const uname  = document.getElementById('tpl-filter-username').value.toLowerCase();
    const sid    = document.getElementById('tpl-filter-senderid').value.toLowerCase();
    const eid    = document.getElementById('tpl-filter-entityid').value.toLowerCase();
    const tplid  = document.getElementById('tpl-filter-templateid').value.toLowerCase();
    const status = document.getElementById('tpl-filter-status').value.toLowerCase();

    document.querySelectorAll('#tpl-tbody tr').forEach(row => {
      const text   = row.textContent.toLowerCase();
      const rStat  = row.dataset.status;
      const tabOk  = tplActiveTab === 'all' || rStat === tplActiveTab;
      const statOk = !status || rStat === status;
      const ok = tabOk && statOk
        && (!q     || text.includes(q))
        && (!regno || text.includes(regno))
        && (!uname || text.includes(uname))
        && (!sid   || text.includes(sid))
        && (!eid   || text.includes(eid))
        && (!tplid || text.includes(tplid));

      row.classList.toggle('tpl-hidden', !ok);
    });
    tplUpdateCount();
  }

  function tplClearFilters() {
    ['tpl-filter-regno','tpl-filter-username','tpl-filter-senderid',
     'tpl-filter-entityid','tpl-filter-templateid','tpl-filter-from'].forEach(id => {
      document.getElementById(id).value = '';
    });
    document.getElementById('tpl-filter-status').value = '';
    const qs = document.getElementById('tpl-quick-search');
    if (qs) qs.value = '';
    tplApplyAllFilters();
  }

  function tplUpdateCount() {
    const visible = document.querySelectorAll('#tpl-tbody tr:not(.tpl-hidden)').length;
    const total   = document.querySelectorAll('#tpl-tbody tr').length;
    document.getElementById('tpl-showing').textContent     = visible;
    document.getElementById('tpl-total-count').textContent = total;
  }

  /* ── Refresh ── */
  function refreshTemplateList() {
    const icon = document.getElementById('tpl-refresh-icon');
    icon.style.animation = 'tpl-spin 1s linear infinite';
    setTimeout(() => { icon.style.animation = ''; }, 1500);
  }

  /* ── Edit Status Modal ── */
  function tplEditStatus(id, sender, tplId, status) {
    document.getElementById('tpl-edit-sender-display').value  = sender;
    document.getElementById('tpl-edit-tplid-display').value   = tplId;
    document.getElementById('tpl-edit-new-status').value      = status;
    new bootstrap.Modal(document.getElementById('tplEditStatusModal')).show();
  }
</script>

@endsection
