@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- Breadcrumb & Live Monitoring Bar --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary fs-5"></i>
            <span class="text-secondary fw-semibold">Report</span>
            <span class="text-muted">|</span>
            <span class="text-primary fw-bold">SMS Live Panel</span>
        </div>

        {{-- Live Stream Controls --}}
        <div class="d-flex align-items-center gap-2">
            <div class="badge bg-label-success d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm" id="liveBadgeContainer">
                <span class="spinner-grow spinner-grow-sm text-success" id="liveStreamDot" role="status" style="width:10px; height:10px;"></span>
                <span class="fw-bold" id="liveStreamText">LIVE MONITORING</span>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 shadow-sm" id="toggleLiveBtn" onclick="toggleLiveFeed()">
                <i class="bx bx-pause" id="liveIcon"></i>
                <span id="liveBtnText">Pause</span>
            </button>
        </div>
    </div>

    {{-- 1. Find SMS Details (Filter Card - Identical to SMS Details) --}}
    <div class="card border shadow-sm mb-4 overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center justify-content-between" style="background:#6c757d;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>Find SMS Details -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#filterPanelBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>

        <div class="collapse show" id="filterPanelBody">
            <div class="card-body p-4 bg-white">
                <form id="smsLiveFilterForm" onsubmit="event.preventDefault(); loadLiveData(1);">
                    <div class="row g-3 justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">TRAN ID</label>
                                <div class="col-sm-8"><input type="text" id="f_tran_id" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">RECHARGE NO</label>
                                <div class="col-sm-8"><input type="text" id="f_recharge_no" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">OPERATOR NAME</label>
                                <div class="col-sm-8"><input type="text" id="f_operator_name" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">USER NAME</label>
                                <div class="col-sm-8"><input type="text" id="f_user_name" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">FROM DATE</label>
                                <div class="col-sm-8"><input type="date" id="f_from_date" class="form-control form-control-sm rounded-1" /></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">TO DATE</label>
                                <div class="col-sm-8"><input type="date" id="f_to_date" class="form-control form-control-sm rounded-1" /></div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-3 d-flex justify-content-center gap-2">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold text-uppercase rounded-1 shadow-sm">SEARCH</button>
                            <button type="button" class="btn btn-light btn-sm border px-4 fw-bold text-uppercase rounded-1" onclick="clearLiveFilters()">CLEAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. SMS Live Panel Table Card --}}
    <div class="card border shadow-sm overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center justify-content-between" style="background:#0f6698;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-broadcast fs-5"></i>
                <span>SMS Live Panel -</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="exportLiveReportCSV()">
                    <i class="bx bx-download"></i> Export
                </button>
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="printLiveReport()">
                    <i class="bx bx-printer"></i> Print
                </button>
            </div>
        </div>

        <div class="card-body p-0 bg-white position-relative">
            {{-- Top Pagination Toolbar (Zero Reload) --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-3 py-2 border-bottom gap-2">
                <div class="text-muted small">
                    Showing <span id="live_page_info" class="fw-bold text-dark">0</span> entries
                </div>
                <div class="d-flex align-items-center gap-1">
                    <ul class="pagination pagination-sm mb-0" id="livePaginationList">
                        {{-- Rendered dynamically by AJAX --}}
                    </ul>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive text-nowrap" style="max-height: 650px; overflow-x: auto;">
                <table class="table table-hover align-middle mb-0 live-sms-table" id="smsLiveDetailsTable">
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size:.74rem;">
                            <th class="text-center" style="width:35px;">#</th>
                            <th>TRAN ID</th>
                            <th style="min-width:240px; max-width:320px;">SMS TEXT</th>
                            <th>SENDER ID</th>
                            <th>ENTITY ID</th>
                            <th>SEND TO</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">CREDIT USE</th>
                            <th class="text-center">CHARGES</th>
                            <th class="text-center">TRAN DATE/TIME</th>
                            <th>USER DETAILS</th>
                            <th class="text-center">USER LOG</th>
                            <th class="text-center">API LOG</th>
                        </tr>
                    </thead>
                    <tbody id="smsLiveTbody">
                        <tr>
                            <td colspan="13" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading live SMS stream...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- ── Log Preview Modal (With Textarea & Copy Button) ── --}}
<div class="modal fade" id="liveLogPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header text-white py-3 px-4" style="background:#475569;">
                <h6 class="modal-title mb-0 fw-bold d-flex align-items-center gap-2 text-white" id="liveLogModalTitle">
                    <i class="bx bx-code-alt fs-5"></i> Log Details
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-secondary small fw-semibold text-uppercase">Formatted Log Content:</span>
                    <button class="btn btn-sm btn-primary px-3 py-1 d-flex align-items-center gap-1 shadow-sm" onclick="copyCurrentModalContent()">
                        <i class="bx bx-copy"></i> Copy to Clipboard
                    </button>
                </div>
                <textarea id="liveLogModalTextarea" class="form-control font-monospace p-3 shadow-inner" rows="12" readonly
                          style="font-size:0.85rem; line-height:1.5; background:#0f172a; color:#38bdf8; border:1px solid #334155; border-radius:8px; resize:vertical;"></textarea>
            </div>
            <div class="modal-footer py-2 px-4 bg-white border-top">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ── SMS Text Preview Modal (With Textarea & Copy Button) ── --}}
<div class="modal fade" id="liveTextPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header text-white py-3 px-4" style="background:#0f6698;">
                <h6 class="modal-title mb-0 fw-bold d-flex align-items-center gap-2 text-white" id="liveTextModalTitle">
                    <i class="bx bx-message-rounded-dots fs-5"></i> SMS Message Content
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-secondary small fw-semibold text-uppercase">Message Text:</span>
                    <button class="btn btn-sm btn-primary px-3 py-1 d-flex align-items-center gap-1 shadow-sm" onclick="copyCurrentModalContent()">
                        <i class="bx bx-copy"></i> Copy Text
                    </button>
                </div>
                <textarea id="liveTextModalTextarea" class="form-control p-3 bg-white" rows="6" readonly
                          style="font-size:0.9rem; line-height:1.6; color:#1e293b; border:1px solid #cbd5e1; border-radius:8px; resize:vertical;"></textarea>
            </div>
            <div class="modal-footer py-2 px-4 bg-white border-top">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .live-sms-table th {
        font-weight: 700;
        color: #333;
        padding: .65rem .75rem;
        border-bottom: 2px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8fafc !important;
        box-shadow: inset 0 -2px 0 #dee2e6;
    }
    .live-sms-table td { padding: .55rem .75rem; border-bottom: 1px solid #e9ecef; }
    .page-link { cursor: pointer; user-select: none; }
    .sms-text-cell { max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; }
    .sms-text-cell:hover { text-decoration: underline !important; }
    html.dark .live-sms-table th {
        background-color: #1e293b !important;
        color: #cbd5e1;
        border-color: #334155;
        box-shadow: inset 0 -2px 0 #334155;
    }
    html.dark .live-sms-table td { border-color: #334155; }
</style>

<script>
    let currentCopyContent = '';
    let liveCurrentPage = 1;
    let liveCachedRows = [];
    let isLiveActive = true;
    let livePollTimer = null;
    let searchDebounceTimer = null;

    const BASE_LIVE_URL = "{{ route('admin.reports.sms_live_panel') }}";

    function getLiveFilterParams(page = 1) {
        const tranId   = (document.getElementById('f_tran_id')?.value || '').trim();
        const recharge = (document.getElementById('f_recharge_no')?.value || '').trim();
        const operator = (document.getElementById('f_operator_name')?.value || '').trim();
        const user     = (document.getElementById('f_user_name')?.value || '').trim();
        const fromDate = (document.getElementById('f_from_date')?.value || '').trim();
        const toDate   = (document.getElementById('f_to_date')?.value || '').trim();

        return new URLSearchParams({
            page: page,
            tran_id: tranId,
            recharge_no: recharge,
            operator_name: operator,
            user_name: user,
            from_date: fromDate,
            to_date: toDate
        });
    }

    // AJAX Data Fetching (Zero Page Reload)
    async function loadLiveData(page = 1, isBackgroundPoll = false) {
        liveCurrentPage = page;
        const tbody = document.getElementById('smsLiveTbody');
        if (!isBackgroundPoll) {
            tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading page ${page}...</td></tr>`;
        }

        const params = getLiveFilterParams(page);

        try {
            const res = await fetch(`${BASE_LIVE_URL}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                liveCachedRows = data.data || [];
                renderLiveTableRows(liveCachedRows, (data.current_page - 1) * 10);
                document.getElementById('live_page_info').textContent = data.total > 0 ? `${data.from}-${data.to} of ${data.total}` : '0 of 0';
                renderLivePagination(data.current_page, data.last_page);
            } else if (!isBackgroundPoll) {
                tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Failed to load live records.</td></tr>`;
            }
        } catch (err) {
            if (!isBackgroundPoll) {
                tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Error: ${err.message}</td></tr>`;
            }
        }
    }

    function renderLiveTableRows(rows, offsetIndex) {
        const tbody = document.getElementById('smsLiveTbody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-muted"><i class="bx bx-info-circle fs-4 d-block mb-1"></i> No live SMS records found.</td></tr>`;
            return;
        }

        rows.forEach((row, i) => {
            const statusInt = parseInt(row.status || 0);
            let statusBadge = '<span class="badge bg-label-warning font-monospace">PENDING</span>';
            if (statusInt === 1) statusBadge = '<span class="badge bg-label-success font-monospace">SUCCESS</span>';
            else if (statusInt === 2) statusBadge = '<span class="badge bg-label-danger font-monospace">FAILED</span>';

            const userFullName = row.user ? `${row.user.fname || ''} ${row.user.lname || ''}`.trim() : '-';
            const company = row.user?.company_name || '-';
            const charges = parseFloat(row.sms_charge || 0).toFixed(2);

            let transDateFormatted = row.trandate || '-';
            if (row.trandate && row.trandate.includes('-')) {
                const parts = row.trandate.split('-');
                if (parts.length === 3) transDateFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
            if (row.trantime) {
                transDateFormatted += ` <span class="text-muted" style="font-size:.7rem;">(${escapeHtml(row.trantime)})</span>`;
            }

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td class="font-monospace text-primary fw-bold">${escapeHtml(row.servid || '-')}</td>
                <td>
                    <div class="sms-text-cell text-primary fw-semibold" title="Click to view full message" onclick="openSmsTextModal(${i})">
                        ${escapeHtml(row.smstext || row.msg || '-')}
                    </div>
                </td>
                <td class="font-monospace"><span class="badge bg-label-secondary font-monospace">${escapeHtml(row.sender_id || '-')}</span></td>
                <td class="font-monospace text-muted" style="font-size:.8rem;">${escapeHtml(row.template_id || row.entityid || '-')}</td>
                <td class="font-monospace fw-semibold">${escapeHtml(row.rechargeno || '-')}</td>
                <td class="text-center">${statusBadge}</td>
                <td class="text-center font-monospace">${row.credit_count || row.credit_use || 1}</td>
                <td class="text-center font-monospace text-muted">${row.amount || charges}</td>
                <td class="text-center text-nowrap" style="font-size:.78rem;">${transDateFormatted}</td>
                <td>
                    <div class="fw-semibold text-secondary">${escapeHtml(company)}</div>
                    <div class="text-muted small">${escapeHtml(userFullName)}</div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-warning btn-xs px-2 py-1 fw-bold shadow-sm" onclick="openUserLogModal(${i})">
                        LOG
                    </button>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-info btn-xs px-2 py-1 fw-bold shadow-sm" onclick="openApiLogModal(${i})">
                        LOG
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderLivePagination(cur, last) {
        const ul = document.getElementById('livePaginationList');
        ul.innerHTML = '';

        if (last <= 1) return;

        // Prev
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${cur === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" onclick="loadLiveData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadLiveData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadLiveData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadLiveData(${last})">${last}</a></li>`;
        }

        // Next
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadLiveData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function clearLiveFilters() {
        ['f_tran_id', 'f_recharge_no', 'f_operator_name', 'f_user_name', 'f_from_date', 'f_to_date'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        loadLiveData(1);
    }

    function exportLiveReportCSV() {
        const params = getLiveFilterParams(1);
        params.append('export', 'csv');
        window.location.href = `${BASE_LIVE_URL}?${params.toString()}`;
    }

    function printLiveReport() {
        const params = getLiveFilterParams(1);
        params.append('print', '1');
        window.open(`${BASE_LIVE_URL}?${params.toString()}`, '_blank', 'width=1200,height=800,scrollbars=yes');
    }

    // Modal Helpers
    function openSmsTextModal(index) {
        const row = liveCachedRows[index];
        if (!row) return;
        currentCopyContent = row.smstext || row.msg || 'No message content';
        document.getElementById('liveTextModalTitle').innerHTML = `<i class="bx bx-message-rounded-dots fs-5 me-1"></i> SMS Message Content (Tran ID: ${row.servid || '-'})`;
        document.getElementById('liveTextModalTextarea').value = currentCopyContent;
        new bootstrap.Modal(document.getElementById('liveTextPreviewModal')).show();
    }

    function openUserLogModal(index) {
        const row = liveCachedRows[index];
        if (!row) return;
        let log = row.custsend_log || row.userpayload || row.userlog || 'No user log available';
        try {
            const parsed = JSON.parse(log);
            log = JSON.stringify(parsed, null, 4);
        } catch (e) {}
        currentCopyContent = log;
        document.getElementById('liveLogModalTitle').innerHTML = `<i class="bx bx-user fs-5 me-1"></i> User Log (Tran ID: ${row.servid || '-'})`;
        document.getElementById('liveLogModalTextarea').value = log;
        new bootstrap.Modal(document.getElementById('liveLogPreviewModal')).show();
    }

    function openApiLogModal(index) {
        const row = liveCachedRows[index];
        if (!row) return;
        let log = row.apirecv_log || row.apirequest || row.apilog || 'No API log available';
        try {
            const parsed = JSON.parse(log);
            log = JSON.stringify(parsed, null, 4);
        } catch (e) {}
        currentCopyContent = log;
        document.getElementById('liveLogModalTitle').innerHTML = `<i class="bx bx-code-alt fs-5 me-1"></i> API Log (Tran ID: ${row.servid || '-'})`;
        document.getElementById('liveLogModalTextarea').value = log;
        new bootstrap.Modal(document.getElementById('liveLogPreviewModal')).show();
    }

    function formatJsonString(str) {
        if (!str || str === '-') return '-';
        try {
            const parsed = JSON.parse(str);
            return JSON.stringify(parsed, null, 2);
        } catch (e) {
            return str;
        }
    }

    function copyCurrentModalContent() {
        if (!currentCopyContent) return;
        navigator.clipboard.writeText(currentCopyContent).then(() => {
            alert('Copied to clipboard successfully!');
        });
    }

    // Live Stream Toggle
    function startLiveStream() {
        clearInterval(livePollTimer);
        livePollTimer = setInterval(() => {
            if (isLiveActive && liveCurrentPage === 1) {
                loadLiveData(1, true);
            }
        }, 4000);
    }

    function toggleLiveFeed() {
        isLiveActive = !isLiveActive;
        const icon = document.getElementById('liveIcon');
        const text = document.getElementById('liveBtnText');
        const dot  = document.getElementById('liveStreamDot');
        const liveText = document.getElementById('liveStreamText');
        const badgeCont = document.getElementById('liveBadgeContainer');

        if (isLiveActive) {
            icon.className = 'bx bx-pause';
            text.textContent = 'Pause';
            dot.className = 'spinner-grow spinner-grow-sm text-success';
            liveText.textContent = 'LIVE MONITORING';
            badgeCont.className = 'badge bg-label-success d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm';
            loadLiveData(1);
        } else {
            icon.className = 'bx bx-play';
            text.textContent = 'Resume';
            dot.className = 'spinner-grow spinner-grow-sm text-secondary';
            liveText.textContent = 'PAUSED';
            badgeCont.className = 'badge bg-label-secondary d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm';
        }
    }

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Debounced search on typing
    document.addEventListener('DOMContentLoaded', () => {
        ['f_tran_id', 'f_recharge_no', 'f_operator_name', 'f_user_name'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', () => {
                    clearTimeout(searchDebounceTimer);
                    searchDebounceTimer = setTimeout(() => {
                        loadLiveData(1);
                    }, 350);
                });
            }
        });
        loadLiveData(1);
        startLiveStream();
    });
</script>
@endsection
