@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- Breadcrumb --}}
    <div class="d-flex align-items-center gap-2 mb-4 pt-2">
        <i class="bx bx-home text-secondary fs-5"></i>
        <span class="text-secondary fw-semibold">Report</span>
        <span class="text-muted">|</span>
        <span class="text-primary fw-bold">SMS details</span>
    </div>

    {{-- 1. Find SMS Details (Filter Card) --}}
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
                <form id="smsFilterForm" onsubmit="event.preventDefault(); loadSmsData(1);">
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
                            <button type="button" class="btn btn-light btn-sm border px-4 fw-bold text-uppercase rounded-1" onclick="clearSmsFilters()">CLEAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. SMS Details Table Card --}}
    <div class="card border shadow-sm overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center justify-content-between" style="background:#0f6698;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>SMS Details -</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="exportTableToCSV('sms-details-report.csv')">
                    <i class="bx bx-download"></i> Export
                </button>
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bx bx-printer"></i> Print
                </button>
            </div>
        </div>

        <div class="card-body p-0 bg-white position-relative">
            {{-- Top Pagination Toolbar (Zero Reload) --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-3 py-2 border-bottom gap-2">
                <div class="text-muted small">
                    Showing <span id="page_info" class="fw-bold text-dark">0</span> entries
                </div>
                <div class="d-flex align-items-center gap-1">
                    <ul class="pagination pagination-sm mb-0" id="paginationList">
                        {{-- Rendered dynamically by AJAX --}}
                    </ul>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0 sms-table" id="smsDetailsTable">
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
                    <tbody id="smsTbody">
                        <tr>
                            <td colspan="13" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading live SMS data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>
</div>

{{-- ── Log Preview Modal (With Textarea & Copy Button) ── --}}
<div class="modal fade" id="logPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header text-white py-3 px-4" style="background:#475569;">
                <h6 class="modal-title mb-0 fw-bold d-flex align-items-center gap-2 text-white" id="logModalTitle">
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
                <textarea id="logModalTextarea" class="form-control font-monospace p-3 shadow-inner" rows="12" readonly
                          style="font-size:0.85rem; line-height:1.5; background:#0f172a; color:#38bdf8; border:1px solid #334155; border-radius:8px; resize:vertical;"></textarea>
            </div>
            <div class="modal-footer py-2 px-4 bg-white border-top">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ── SMS Text Preview Modal (With Textarea & Copy Button) ── --}}
<div class="modal fade" id="textPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header text-white py-3 px-4" style="background:#0f6698;">
                <h6 class="modal-title mb-0 fw-bold d-flex align-items-center gap-2 text-white" id="textModalTitle">
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
                <textarea id="textModalTextarea" class="form-control p-3 bg-white" rows="6" readonly
                          style="font-size:0.9rem; line-height:1.6; color:#1e293b; border:1px solid #cbd5e1; border-radius:8px; resize:vertical;"></textarea>
            </div>
            <div class="modal-footer py-2 px-4 bg-white border-top">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .sms-table th {
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
    .sms-table td { padding: .55rem .75rem; border-bottom: 1px solid #e9ecef; }
    .page-link { cursor: pointer; user-select: none; }
    .sms-text-cell { max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; }
    .sms-text-cell:hover { text-decoration: underline !important; }
    html.dark .sms-table th {
        background-color: #1e293b !important;
        color: #cbd5e1;
        border-color: #334155;
        box-shadow: inset 0 -2px 0 #334155;
    }
    html.dark .sms-table td { border-color: #334155; }
</style>

<script>
    let currentCopyContent = '';
    let currentPage = 1;
    let cachedRows = [];

    // AJAX Data Fetching (Zero Page Reload)
    async function loadSmsData(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('smsTbody');
        tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading page ${page}...</td></tr>`;

        const tran = (document.getElementById('f_tran_id')?.value || '').trim();
        const recharge = (document.getElementById('f_recharge_no')?.value || '').trim();
        const operator = (document.getElementById('f_operator_name')?.value || '').trim();
        const user = (document.getElementById('f_user_name')?.value || '').trim();
        const fromDate = document.getElementById('f_from_date')?.value || '';
        const toDate = document.getElementById('f_to_date')?.value || '';

        const params = new URLSearchParams({
            page: page,
            tran_id: tran,
            recharge_no: recharge,
            operator_name: operator,
            user_name: user,
            from_date: fromDate,
            to_date: toDate
        });

        try {
            const res = await fetch(`{{ route('admin.reports.sms_details') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                cachedRows = data.data || [];
                renderTableRows(data.data, (data.current_page - 1) * 10);
                document.getElementById('page_info').textContent = data.total > 0 ? `${data.from}-${data.to} of ${data.total}` : '0 of 0';
                renderPagination(data.current_page, data.last_page);
            } else {
                tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Failed to load SMS data.</td></tr>`;
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Network error: ${err.message}</td></tr>`;
        }
    }

    function renderTableRows(rows, offsetIndex) {
        const tbody = document.getElementById('smsTbody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="13" class="text-center py-4 text-muted"><i class="bx bx-info-circle fs-4 d-block mb-1"></i> No SMS transaction records found.</td></tr>`;
            return;
        }

        rows.forEach((row, i) => {
            const u = row.user || null;
            const regNo = u?.regno || (row.userid ? 'UID:' + row.userid : '');
            const userName = u ? ((u.fname || '') + ' ' + (u.lname || '')).trim() : (row.userid ? 'User #' + row.userid : '-');
            const statusStr = (row.tran_status || 'SUCCESS').toUpperCase().trim();
            const isSuccess = (statusStr === 'SUCCESS' || statusStr === 'DELIVRD' || statusStr === '1');
            const isFailed = (statusStr === 'FAILED' || statusStr === 'UNDELIV' || statusStr === 'REJECTED' || statusStr === '0');
            const badgeColor = isSuccess ? 'bg-success' : (isFailed ? 'bg-danger' : 'bg-warning text-dark');

            // Format date & time
            let dateFormatted = row.trandate || '-';
            if (row.trandate && row.trandate.includes('-')) {
                const parts = row.trandate.split('-');
                if (parts.length === 3) dateFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }

            const tr = document.createElement('tr');
            tr.className = 'sms-row';
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td><span class="text-primary font-monospace fw-semibold" style="font-size:.8rem;">${escapeHtml(row.servid || '-')}</span></td>
                <td>
                    <div class="sms-text-cell text-primary fw-semibold" title="Click to view full message" onclick="openSmsTextModal(${i})">
                        ${escapeHtml(row.smstext || '-')}
                    </div>
                </td>
                <td><span class="fw-bold text-dark" style="font-size:.8rem;">${escapeHtml(row.sender_id || '-')}</span></td>
                <td><span class="text-secondary font-monospace" style="font-size:.75rem;">${escapeHtml(row.template_id || '-')}</span></td>
                <td><span class="font-monospace fw-semibold text-dark" style="font-size:.8rem;">${escapeHtml(row.rechargeno || '-')}</span></td>
                <td class="text-center">
                    <span class="badge ${badgeColor} rounded-1 px-2 py-1 fw-bold" style="font-size:.68rem;">${statusStr}</span>
                </td>
                <td class="text-center text-secondary fw-semibold">${row.credit_count || 1}</td>
                <td class="text-center fw-semibold text-dark">${row.amount || '0.00'}</td>
                <td class="text-center" style="font-size:.78rem; line-height:1.2;">
                    <div>${dateFormatted}</div>
                    ${row.trantime ? `<div class="text-muted" style="font-size:.7rem;">(${escapeHtml(row.trantime)})</div>` : ''}
                </td>
                <td>
                    <div style="line-height:1.25;">
                        <div class="fw-semibold text-dark" style="font-size:.8rem;">${escapeHtml(userName)}</div>
                        ${regNo ? `<div class="text-muted" style="font-size:.7rem;">Regno: ${escapeHtml(regNo)}</div>` : ''}
                    </div>
                </td>
                <td class="text-center">
                    ${row.custsend_log ? `
                        <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2 rounded-1 fw-semibold text-nowrap" style="font-size:.72rem;" onclick="openUserLogModal(${i})">
                            <i class="bx bx-file me-1"></i> View Log
                        </button>
                    ` : '<span class="text-muted small">-</span>'}
                </td>
                <td class="text-center">
                    ${row.apirecv_log ? `
                        <button type="button" class="btn btn-outline-info btn-sm py-0 px-2 rounded-1 fw-semibold text-nowrap" style="font-size:.72rem;" onclick="openApiLogModal(${i})">
                            <i class="bx bx-code-alt me-1"></i> View Log
                        </button>
                    ` : '<span class="text-muted small">-</span>'}
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Dynamic Zero-Reload Pagination Bar
    function renderPagination(cur, last) {
        const ul = document.getElementById('paginationList');
        ul.innerHTML = '';

        if (last <= 1) return;

        // Prev Button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${cur === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" onclick="loadSmsData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        // Calculate sliding window
        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadSmsData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadSmsData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadSmsData(${last})">${last}</a></li>`;
        }

        // Next Button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadSmsData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function clearSmsFilters() {
        ['f_tran_id', 'f_recharge_no', 'f_operator_name', 'f_user_name', 'f_from_date', 'f_to_date'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        loadSmsData(1);
    }

    // Modal Helpers (Indexed for clean execution)
    function openSmsTextModal(index) {
        const row = cachedRows[index];
        if (!row) return;
        const msg = row.smstext || 'No message content';
        currentCopyContent = msg;
        document.getElementById('textModalTitle').innerHTML = `<i class="bx bx-message-rounded-dots fs-5 me-1"></i> SMS Message Content (Tran ID: ${row.servid || '-'})`;
        document.getElementById('textModalTextarea').value = msg;
        new bootstrap.Modal(document.getElementById('textPreviewModal')).show();
    }

    function openUserLogModal(index) {
        const row = cachedRows[index];
        if (!row) return;
        let log = row.custsend_log || 'No user log available';
        try {
            const parsed = JSON.parse(log);
            log = JSON.stringify(parsed, null, 4);
        } catch (e) {}
        currentCopyContent = log;
        document.getElementById('logModalTitle').innerHTML = `<i class="bx bx-user fs-5 me-1"></i> User Log (Tran ID: ${row.servid || '-'})`;
        document.getElementById('logModalTextarea').value = log;
        new bootstrap.Modal(document.getElementById('logPreviewModal')).show();
    }

    function openApiLogModal(index) {
        const row = cachedRows[index];
        if (!row) return;
        let log = row.apirecv_log || 'No API log available';
        try {
            const parsed = JSON.parse(log);
            log = JSON.stringify(parsed, null, 4);
        } catch (e) {}
        currentCopyContent = log;
        document.getElementById('logModalTitle').innerHTML = `<i class="bx bx-code-alt fs-5 me-1"></i> API Log (Tran ID: ${row.servid || '-'})`;
        document.getElementById('logModalTextarea').value = log;
        new bootstrap.Modal(document.getElementById('logPreviewModal')).show();
    }

    function copyCurrentModalContent() {
        if (!currentCopyContent) return;
        navigator.clipboard.writeText(currentCopyContent).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Copied!', text: 'Content copied to clipboard', timer: 1200, showConfirmButton: false });
            } else {
                alert('Copied to clipboard successfully!');
            }
        }).catch(() => {
            alert('Failed to copy to clipboard');
        });
    }

    function exportTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#smsDetailsTable tr");
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].style.display === 'none') continue;
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/(\s\s+)/gm, " ");
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }
        const blob = new Blob([csv.join("\n")], { type: "text/csv" });
        const link = document.createElement("a");
        link.download = filename;
        link.href = window.URL.createObjectURL(blob);
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Debounced search on typing
    let searchDebounceTimer = null;
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#smsFilterForm input[type="text"]').forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    loadSmsData(1);
                }, 350);
            });
        });
        loadSmsData(1);
    });
</script>
@endsection
