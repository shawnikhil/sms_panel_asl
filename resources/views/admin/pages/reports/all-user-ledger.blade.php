@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- Breadcrumb Bar --}}
    <div class="d-flex align-items-center gap-2 mb-4 pt-2">
        <i class="bx bx-home text-secondary fs-5"></i>
        <span class="text-secondary fw-semibold">Report</span>
        <span class="text-muted">|</span>
        <span class="text-primary fw-bold">User ledger details</span>
    </div>

    {{-- 1. Find User Wise Ledger Filter Card --}}
    <div class="card border shadow-sm mb-4 overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center justify-content-between" style="background:#6c757d;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>Find User wise ledger -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#ledgerFilterBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>
        
        <div class="collapse show" id="ledgerFilterBody">
            <div class="card-body p-4 bg-white">
                <form id="ledgerSearchForm" onsubmit="event.preventDefault(); loadLedgerData(1);">
                    <div class="row g-3 justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">COMPANY NAME</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_company_name" class="form-control form-control-sm rounded-1" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">USER NAME</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_user_name" class="form-control form-control-sm rounded-1" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">REG NO</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_reg_no" class="form-control form-control-sm rounded-1" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">CONTACT NO</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_contact_no" class="form-control form-control-sm rounded-1" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-3 d-flex justify-content-center gap-2">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold text-uppercase rounded-1 shadow-sm">SEARCH</button>
                            <button type="button" class="btn btn-light btn-sm border px-4 fw-bold text-uppercase rounded-1" onclick="clearLedgerFilters()">CLEAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. User Wise Ledger Table Card --}}
    <div class="card border shadow-sm overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background:#0f6698;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>User wise ledger -</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" onclick="exportLedgerReportCSV()">
                    <i class="bx bx-download"></i> EXPORT CSV
                </button>
                <button class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" onclick="printLedgerReport()">
                    <i class="bx bx-printer"></i> PRINT
                </button>
            </div>
        </div>

        <div class="card-body p-0 bg-white position-relative">
            {{-- Top Pagination Toolbar (Zero Reload) --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-3 py-2 border-bottom gap-2">
                <div class="text-muted small">
                    Showing <span id="ledger_page_info" class="fw-bold text-dark">0</span> records
                </div>
                <div class="d-flex align-items-center gap-1">
                    <ul class="pagination pagination-sm mb-0" id="ledgerPaginationList">
                        {{-- Rendered dynamically by AJAX --}}
                    </ul>
                </div>
            </div>

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap" style="max-height: 600px; overflow-x: auto;">
                <table class="table table-hover align-middle mb-0 ledger-table" id="allUserLedgerTable">
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size:.74rem;">
                            <th class="text-center" style="width: 35px;">#</th>
                            <th class="text-center">REGNO</th>
                            <th>USER NAME</th>
                            <th>COMPANY NAME</th>
                            <th class="text-center">USER CATEGORY</th>
                            <th class="text-center">CONTACT NO</th>
                            <th>PACKAGE NAME</th>
                            <th class="text-end">CREDIT AMT</th>
                            <th class="text-end">DEBIT AMT</th>
                            <th class="text-end">COMM AMT</th>
                            <th class="text-end">BALANCE</th>
                            <th class="text-center" style="width: 80px;">LEDGER</th>
                        </tr>
                    </thead>
                    <tbody id="ledgerTableBody">
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading user ledger records...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ── 3. Interactive Ledger Statement Modal (view-ladger-details.php) ── --}}
<div class="modal fade" id="ledgerStatementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0 rounded-2 overflow-hidden">
            <div class="modal-header text-white py-3 px-4" style="background:#0f6698;">
                <h6 class="modal-title fs-6 fw-bold mb-0 text-white" id="ledgerModalTitle">
                    LEDGER :: [<span class="text-white-50 fw-normal">Regno : </span><span id="modal_ledger_regno" class="fw-bold">-</span>], [<span class="text-white-50 fw-normal">User Name : </span><span id="modal_ledger_user" class="fw-bold">-</span>], [<span class="text-white-50 fw-normal">Company : </span><span id="modal_ledger_company" class="fw-bold">-</span>]
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                {{-- Search Bar inside Modal --}}
                <div class="row align-items-center mb-3 bg-white p-3 border rounded">
                    <label class="col-sm-3 col-form-label text-sm-end fw-bold text-secondary" style="font-size:.78rem;">TRANSACTION DESC</label>
                    <div class="col-sm-7 col-md-6">
                        <input type="text" id="modal_trans_desc" class="form-control form-control-sm rounded-1" placeholder="Search narration or description..." oninput="debounceModalSearch()" />
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold rounded-1" onclick="clearModalSearch()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-between align-items-center my-2">
                    <div class="text-muted small" id="modal_page_info">Showing 0 records</div>
                    <ul class="pagination pagination-sm mb-0" id="modalPaginationList"></ul>
                </div>

                {{-- Modal Table --}}
                <div class="table-responsive text-nowrap border rounded bg-white" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="modalLedgerTable" style="font-size: 0.8125rem;">
                        <thead class="table-light sticky-top">
                            <tr class="text-uppercase" style="font-size:.74rem;">
                                <th style="width: 40px;" class="text-center">#</th>
                                <th class="text-center">TRAN DATE</th>
                                <th>NARRATION/REMARKS</th>
                                <th class="text-center">CREDIT AMT</th>
                                <th class="text-center">DEBIT AMT</th>
                                <th class="text-end">OPENING BALANCE</th>
                                <th class="text-end">CLOSING BALANCE</th>
                            </tr>
                        </thead>
                        <tbody id="modal_ledger_tbody">
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Select a user to view ledger statements.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2 px-4 bg-white border-top">
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .ledger-table th {
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
    .ledger-table td { padding: .55rem .75rem; border-bottom: 1px solid #e9ecef; }
    .page-link { cursor: pointer; user-select: none; }
    html.dark .ledger-table th {
        background-color: #1e293b !important;
        color: #cbd5e1;
        border-color: #334155;
        box-shadow: inset 0 -2px 0 #334155;
    }
    html.dark .ledger-table td { border-color: #334155; }
</style>

<script>
    let ledgerCurrentPage = 1;
    let currentModalRegno = null;
    let modalCurrentPage = 1;
    let modalDebounceTimer = null;

    const BASE_LEDGER_URL = "{{ route('admin.reports.all_user_ledger') }}";
    const MODAL_LEDGER_URL = "{{ route('admin.reports.all_user_ledger.details') }}";

    function getLedgerFilterParams(page = 1) {
        const company   = (document.getElementById('filter_company_name')?.value || '').trim();
        const user      = (document.getElementById('filter_user_name')?.value || '').trim();
        const regno     = (document.getElementById('filter_reg_no')?.value || '').trim();
        const contactNo = (document.getElementById('filter_contact_no')?.value || '').trim();

        return new URLSearchParams({
            page: page,
            company_name: company,
            user_name: user,
            reg_no: regno,
            contact_no: contactNo
        });
    }

    // AJAX Data Fetching for All User Ledger (Zero Page Reload)
    async function loadLedgerData(page = 1) {
        ledgerCurrentPage = page;
        const tbody = document.getElementById('ledgerTableBody');
        tbody.innerHTML = `<tr><td colspan="12" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading page ${page}...</td></tr>`;

        const params = getLedgerFilterParams(page);

        try {
            const res = await fetch(`${BASE_LEDGER_URL}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                renderLedgerTableRows(data.data, (data.current_page - 1) * 20);
                document.getElementById('ledger_page_info').textContent = data.total > 0 ? `${data.from}-${data.to} of ${data.total}` : '0 of 0';
                renderLedgerPagination(data.current_page, data.last_page);
            } else {
                tbody.innerHTML = `<tr><td colspan="12" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Failed to load ledger records.</td></tr>`;
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="12" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Network error: ${err.message}</td></tr>`;
        }
    }

    function renderLedgerTableRows(rows, offsetIndex) {
        const tbody = document.getElementById('ledgerTableBody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="12" class="text-center py-4 text-muted"><i class="bx bx-info-circle fs-4 d-block mb-1"></i> No user ledger records found.</td></tr>`;
            return;
        }

        let pageCredit = 0, pageDebit = 0, pageComm = 0, pageBalance = 0;

        rows.forEach((row, i) => {
            const creditAmt = parseFloat(row.credit_amt || 0);
            const debitAmt  = parseFloat(row.debit_amt || 0);
            const commAmt   = parseFloat(row.comm_amt || 0);
            const balAmt    = parseFloat(row.balance_amt || 0);

            pageCredit += creditAmt;
            pageDebit  += debitAmt;
            pageComm   += commAmt;
            pageBalance+= balAmt;

            const fullName = `${row.fname || ''} ${row.lname || ''}`.trim();
            const compName = row.company_name || '-';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td class="text-center font-monospace fw-bold"><span class="badge bg-label-secondary font-monospace">${escapeHtml(row.regno || '-')}</span></td>
                <td><span class="fw-semibold text-dark">${escapeHtml(fullName || '-')}</span></td>
                <td><span class="text-secondary">${escapeHtml(compName)}</span></td>
                <td class="text-center"><span class="badge bg-label-info font-monospace">${escapeHtml(row.catid || '-')}</span></td>
                <td class="text-center font-monospace">${escapeHtml(row.phone || '-')}</td>
                <td><span class="text-muted small">${escapeHtml(row.pack_name || '-')}</span></td>
                <td class="text-end font-monospace text-muted">${creditAmt.toFixed(2)}</td>
                <td class="text-end font-monospace text-muted">${debitAmt.toFixed(2)}</td>
                <td class="text-end font-monospace text-muted">${commAmt.toFixed(2)}</td>
                <td class="text-end fw-bold text-success font-monospace">${balAmt.toFixed(2)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-success btn-xs px-2 py-1 fw-bold shadow-sm" onclick="viewLedgerDetails(${row.regno}, '${escapeQuotes(fullName)}', '${escapeQuotes(compName)}')">
                        VIEW
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Dynamic TOTAL row appended at bottom of the page
        const totalTr = document.createElement('tr');
        totalTr.className = 'bg-light border-top fw-bold';
        totalTr.innerHTML = `
            <td colspan="7" class="text-end fw-bold text-dark pe-3">TOTAL:</td>
            <td class="text-end font-monospace text-dark">${pageCredit.toFixed(2)}</td>
            <td class="text-end font-monospace text-dark">${pageDebit.toFixed(2)}</td>
            <td class="text-end font-monospace text-dark">${pageComm.toFixed(2)}</td>
            <td class="text-end font-monospace text-primary">${pageBalance.toFixed(2)}</td>
            <td></td>
        `;
        tbody.appendChild(totalTr);
    }

    // Dynamic Pagination Bar for Main Table
    function renderLedgerPagination(cur, last) {
        const ul = document.getElementById('ledgerPaginationList');
        ul.innerHTML = '';

        if (last <= 1) return;

        // Prev
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${cur === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" onclick="loadLedgerData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadLedgerData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadLedgerData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadLedgerData(${last})">${last}</a></li>`;
        }

        // Next
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadLedgerData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function clearLedgerFilters() {
        ['filter_company_name', 'filter_user_name', 'filter_reg_no', 'filter_contact_no'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        loadLedgerData(1);
    }

    // Dynamic Backend CSV Export
    function exportLedgerReportCSV() {
        const params = getLedgerFilterParams(1);
        params.append('export', 'csv');
        window.location.href = `${BASE_LEDGER_URL}?${params.toString()}`;
    }

    // Dynamic Printable Window
    function printLedgerReport() {
        const params = getLedgerFilterParams(1);
        params.append('print', '1');
        window.open(`${BASE_LEDGER_URL}?${params.toString()}`, '_blank', 'width=1200,height=800,scrollbars=yes');
    }

    // ── Modal Ledger Statement Logic (view-ladger-details.php) ──
    function viewLedgerDetails(regno, userName, companyName) {
        currentModalRegno = regno;
        modalCurrentPage = 1;

        document.getElementById('modal_ledger_regno').textContent = regno;
        document.getElementById('modal_ledger_user').textContent = userName || '-';
        document.getElementById('modal_ledger_company').textContent = companyName || '-';
        document.getElementById('modal_trans_desc').value = '';

        const modal = new bootstrap.Modal(document.getElementById('ledgerStatementModal'));
        modal.show();

        loadModalLedgerData(1);
    }

    async function loadModalLedgerData(page = 1) {
        if (!currentModalRegno) return;
        modalCurrentPage = page;

        const tbody = document.getElementById('modal_ledger_tbody');
        tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading transactions...</td></tr>`;

        const desc = (document.getElementById('modal_trans_desc')?.value || '').trim();
        const params = new URLSearchParams({
            regno: currentModalRegno,
            brandtext: desc,
            page: page
        });

        try {
            const res = await fetch(`${MODAL_LEDGER_URL}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                renderModalLedgerRows(data.data, (data.current_page - 1) * 20);
                document.getElementById('modal_page_info').textContent = data.total > 0 ? `Showing ${data.from}-${data.to} of ${data.total} records` : 'Showing 0 records';
                renderModalPagination(data.current_page, data.last_page);
            } else {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">Failed to load ledger transactions.</td></tr>`;
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">Error: ${err.message}</td></tr>`;
        }
    }

    function renderModalLedgerRows(rows, offsetIndex) {
        const tbody = document.getElementById('modal_ledger_tbody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">No ledger transactions found.</td></tr>`;
            return;
        }

        rows.forEach((row, i) => {
            const creditAmt = parseFloat(row.credit_amt || 0);
            const debitAmt  = parseFloat(row.debit_amt || 0);
            const openingBal = parseFloat(row.opening_bal || 0);
            const closingBal = parseFloat(row.closing_bal || 0);

            let transDateFormatted = row.trans_date || '-';
            if (row.trans_date && row.trans_date.includes('-')) {
                const parts = row.trans_date.split('-');
                if (parts.length === 3) transDateFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
            if (row.trans_time) {
                transDateFormatted += ` ${escapeHtml(row.trans_time)}`;
            }

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td class="text-center text-nowrap font-monospace" style="font-size:.78rem;">${transDateFormatted}</td>
                <td><span class="text-secondary">${escapeHtml(row.transdesc || '-')}</span></td>
                <td class="text-center">
                    ${creditAmt > 0 ? `<span class="badge bg-success text-white font-monospace">${creditAmt.toFixed(2)}</span>` : '<span class="text-muted">-</span>'}
                </td>
                <td class="text-center">
                    ${debitAmt > 0 ? `<span class="badge bg-warning text-white font-monospace" style="background-color:#f97316 !important;">${debitAmt.toFixed(2)}</span>` : '<span class="text-muted">-</span>'}
                </td>
                <td class="text-end font-monospace text-muted">${openingBal.toFixed(2)}</td>
                <td class="text-end fw-bold font-monospace text-dark">${closingBal.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderModalPagination(cur, last) {
        const ul = document.getElementById('modalPaginationList');
        ul.innerHTML = '';

        if (last <= 1) return;

        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${cur === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" onclick="loadModalLedgerData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadModalLedgerData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadModalLedgerData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadModalLedgerData(${last})">${last}</a></li>`;
        }

        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadModalLedgerData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function debounceModalSearch() {
        clearTimeout(modalDebounceTimer);
        modalDebounceTimer = setTimeout(() => {
            loadModalLedgerData(1);
        }, 350);
    }

    function clearModalSearch() {
        const input = document.getElementById('modal_trans_desc');
        if (input) input.value = '';
        loadModalLedgerData(1);
    }

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function escapeQuotes(str) {
        return String(str).replace(/'/g, "\\'").replace(/"/g, '&quot;');
    }

    // Debounced search on main filter inputs
    let ledgerDebounceTimer = null;
    document.addEventListener('DOMContentLoaded', () => {
        ['filter_company_name', 'filter_user_name', 'filter_reg_no', 'filter_contact_no'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', () => {
                    clearTimeout(ledgerDebounceTimer);
                    ledgerDebounceTimer = setTimeout(() => {
                        loadLedgerData(1);
                    }, 350);
                });
            }
        });
        loadLedgerData(1);
    });
</script>
@endsection
