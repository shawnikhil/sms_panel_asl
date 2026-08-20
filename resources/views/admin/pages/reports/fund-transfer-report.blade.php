@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- Breadcrumb --}}
    <div class="d-flex align-items-center gap-2 mb-4 pt-2">
        <i class="bx bx-home text-secondary fs-5"></i>
        <span class="text-secondary fw-semibold">Report</span>
        <span class="text-muted">|</span>
        <span class="text-primary fw-bold">Fund transfer details</span>
    </div>

    {{-- 1. Find Fund Transfer Details (Filter Card) --}}
    <div class="card border shadow-sm mb-4 overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center justify-content-between" style="background:#6c757d;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>Find Fund Transfer Details -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#fundFilterBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>
        
        <div class="collapse show" id="fundFilterBody">
            <div class="card-body p-4 bg-white">
                <form id="fundSearchForm" onsubmit="event.preventDefault(); loadFundData(1);">
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
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">TRANSACTION DESC</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_trans_desc" class="form-control form-control-sm rounded-1" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">FROM DATE</label>
                                <div class="col-sm-8">
                                    <input type="date" id="filter_from_date" class="form-control form-control-sm rounded-1" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">TO DATE</label>
                                <div class="col-sm-8">
                                    <input type="date" id="filter_to_date" class="form-control form-control-sm rounded-1" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-3 d-flex justify-content-center gap-2">
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold text-uppercase rounded-1 shadow-sm">SEARCH</button>
                            <button type="button" class="btn btn-light btn-sm border px-4 fw-bold text-uppercase rounded-1" onclick="clearFundFilters()">CLEAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. Fund Transfer Details Table Card --}}
    <div class="card border shadow-sm overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background:#0f6698;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>Fund Transfer Details -</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" onclick="exportFundReportCSV()">
                    <i class="bx bx-download"></i> EXPORT CSV
                </button>
                <button class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" onclick="printFundReport()">
                    <i class="bx bx-printer"></i> PRINT
                </button>
            </div>
        </div>

        <div class="card-body p-0 bg-white position-relative">
            {{-- Top Pagination Toolbar (Zero Reload) --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-3 py-2 border-bottom gap-2">
                <div class="text-muted small">
                    Showing <span id="fund_page_info" class="fw-bold text-dark">0</span> records
                </div>
                <div class="d-flex align-items-center gap-1">
                    <ul class="pagination pagination-sm mb-0" id="fundPaginationList">
                        {{-- Rendered dynamically by AJAX --}}
                    </ul>
                </div>
            </div>

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap" style="max-height: 600px; overflow-x: auto;">
                <table class="table table-hover align-middle mb-0 fund-table" id="fundTransferTable">
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size:.74rem;">
                            <th class="text-center" style="width: 35px;">#</th>
                            <th class="text-center">REG NO</th>
                            <th>COMPANY NAME</th>
                            <th class="text-center">REQUEST TYPE</th>
                            <th class="text-center">TRANSFER TYPE</th>
                            <th class="text-end">TRANSFER AMOUNT</th>
                            <th class="text-end">OPENING BALANCE</th>
                            <th class="text-end">CLOSING BALANCE</th>
                            <th class="text-center">WALLET TYPE</th>
                            <th>TRANSACTION DESC</th>
                            <th class="text-center">TRANSACTION ID</th>
                            <th class="text-center">TRANSACTION DATE/TIME</th>
                            <th class="text-center">REQUEST ID</th>
                            <th class="text-center">INSERT DATE</th>
                        </tr>
                    </thead>
                    <tbody id="fundTableBody">
                        <tr>
                            <td colspan="14" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading fund transfer transactions...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .fund-table th {
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
    .fund-table td { padding: .55rem .75rem; border-bottom: 1px solid #e9ecef; }
    .page-link { cursor: pointer; user-select: none; }
    html.dark .fund-table th {
        background-color: #1e293b !important;
        color: #cbd5e1;
        border-color: #334155;
        box-shadow: inset 0 -2px 0 #334155;
    }
    html.dark .fund-table td { border-color: #334155; }
</style>

<script>
    let fundCurrentPage = 1;
    const BASE_FUND_URL = "{{ route('admin.reports.fund_transfer') }}";

    function getFundFilterParams(page = 1) {
        const company  = (document.getElementById('filter_company_name')?.value || '').trim();
        const user     = (document.getElementById('filter_user_name')?.value || '').trim();
        const regno    = (document.getElementById('filter_reg_no')?.value || '').trim();
        const desc     = (document.getElementById('filter_trans_desc')?.value || '').trim();
        const fromDate = (document.getElementById('filter_from_date')?.value || '').trim();
        const toDate   = (document.getElementById('filter_to_date')?.value || '').trim();

        return new URLSearchParams({
            page: page,
            company_name: company,
            user_name: user,
            reg_no: regno,
            trans_desc: desc,
            from_date: fromDate,
            to_date: toDate
        });
    }

    // AJAX Data Fetching (Zero Page Reload)
    async function loadFundData(page = 1) {
        fundCurrentPage = page;
        const tbody = document.getElementById('fundTableBody');
        tbody.innerHTML = `<tr><td colspan="14" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading page ${page}...</td></tr>`;

        const params = getFundFilterParams(page);

        try {
            const res = await fetch(`${BASE_FUND_URL}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                renderFundTableRows(data.data, (data.current_page - 1) * 20);
                document.getElementById('fund_page_info').textContent = data.total > 0 ? `${data.from}-${data.to} of ${data.total}` : '0 of 0';
                renderFundPagination(data.current_page, data.last_page);
            } else {
                tbody.innerHTML = `<tr><td colspan="14" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Failed to load fund transfer records.</td></tr>`;
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="14" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Network error: ${err.message}</td></tr>`;
        }
    }

    function renderFundTableRows(rows, offsetIndex) {
        const tbody = document.getElementById('fundTableBody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="14" class="text-center py-4 text-muted"><i class="bx bx-info-circle fs-4 d-block mb-1"></i> No fund transfer records found.</td></tr>`;
            return;
        }

        let pagePrepaid = 0, pageUtility = 0, pageBank = 0, pageGrand = 0;

        rows.forEach((row, i) => {
            const amt = parseFloat(row.transfer_amt || 0);
            const wt = parseInt(row.wallet_type_id || 0);
            if (wt === 1) pagePrepaid += amt;
            else if (wt === 2) pageUtility += amt;
            else if (wt === 3) pageBank += amt;
            pageGrand += amt;

            const company = row.user?.company_name || '-';
            const reqType = String(row.reqtype) === '0' ? 'BY ADMIN' : 'BY USER';
            const transType = String(row.transfertype) === '1' ? 'FUND TRANSFER' : 'FUND REVERSE';
            const walletType = row.wallet_type?.typename || (row.wallet_type_id == 1 ? 'PREPAID BALANCE' : '-');

            let transDateFormatted = row.trans_date || '-';
            if (row.trans_date && row.trans_date.includes('-')) {
                const parts = row.trans_date.split('-');
                if (parts.length === 3) transDateFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
            if (row.trans_time) {
                transDateFormatted += ` <span class="text-muted" style="font-size:.7rem;">(${escapeHtml(row.trans_time)})</span>`;
            }

            const tr = document.createElement('tr');
            tr.className = 'fund-row';
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td class="text-center font-monospace fw-bold"><span class="badge bg-label-secondary font-monospace">${escapeHtml(row.regno || '-')}</span></td>
                <td><span class="fw-semibold text-secondary">${escapeHtml(company)}</span></td>
                <td class="text-center"><span class="badge bg-label-secondary font-monospace" style="font-size:.72rem;">${reqType}</span></td>
                <td class="text-center"><span class="fw-bold ${String(row.transfertype) === '1' ? 'text-primary' : 'text-danger'}" style="font-size:.78rem;">${transType}</span></td>
                <td class="text-end fw-bold text-dark font-monospace">${amt.toFixed(2)}</td>
                <td class="text-end text-muted font-monospace">${parseFloat(row.opening_bal || 0).toFixed(2)}</td>
                <td class="text-end fw-bold text-success font-monospace">${parseFloat(row.closing_bal || 0).toFixed(2)}</td>
                <td class="text-center"><span class="badge bg-label-info font-monospace">${escapeHtml(walletType)}</span></td>
                <td><span class="text-secondary">${escapeHtml(row.transdesc || '-')}</span></td>
                <td class="text-center font-monospace text-muted">${escapeHtml(row.online_tranid || '-')}</td>
                <td class="text-center text-nowrap" style="font-size:.78rem;">${transDateFormatted}</td>
                <td class="text-center">
                    ${row.request_id ? `<span class="badge bg-label-warning font-monospace">${escapeHtml(row.request_id)}</span>` : '<span class="text-muted small">-</span>'}
                </td>
                <td class="text-center text-nowrap font-monospace" style="font-size:.78rem;">${escapeHtml(row.insert_date || '-')}</td>
            `;
            tbody.appendChild(tr);
        });

        // Dynamic TOTAL row rendered directly on every pagination page
        const totalTr = document.createElement('tr');
        totalTr.className = 'bg-light border-top';
        totalTr.innerHTML = `
            <td colspan="5" class="text-end fw-bold text-dark pe-3 align-top pt-2">
                <strong>TOTAL</strong>
            </td>
            <td class="p-1 align-top">
                <table style="width:100%; min-width:125px; font-size:11px; font-family:monospace; background:#ffffff; border:1px solid #dee2e6;">
                    <tr>
                        <td style="padding:2px 4px; text-align:left;">PREPAID</td>
                        <td>:</td>
                        <td style="text-align:right; font-weight:bold; padding:2px 4px;">${pagePrepaid.toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td style="padding:2px 4px; text-align:left;">UTILITY</td>
                        <td>:</td>
                        <td style="text-align:right; font-weight:bold; padding:2px 4px;">${pageUtility.toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td style="padding:2px 4px; text-align:left;">BANK</td>
                        <td>:</td>
                        <td style="text-align:right; font-weight:bold; padding:2px 4px;">${pageBank.toFixed(2)}</td>
                    </tr>
                    <tr style="border-top:1px solid #dee2e6;">
                        <td style="padding:2px 4px; font-weight:bold; text-align:left;">TOTAL</td>
                        <td>:</td>
                        <td style="text-align:right; font-weight:bold; color:#0f6698; padding:2px 4px;">${pageGrand.toFixed(2)}</td>
                    </tr>
                </table>
            </td>
            <td colspan="8"></td>
        `;
        tbody.appendChild(totalTr);
    }

    // Dynamic Zero-Reload Pagination Bar
    function renderFundPagination(cur, last) {
        const ul = document.getElementById('fundPaginationList');
        ul.innerHTML = '';

        if (last <= 1) return;

        // Prev Button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${cur === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" onclick="loadFundData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        // Sliding window
        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadFundData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadFundData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadFundData(${last})">${last}</a></li>`;
        }

        // Next Button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadFundData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function clearFundFilters() {
        ['filter_company_name', 'filter_user_name', 'filter_reg_no', 'filter_trans_desc', 'filter_from_date', 'filter_to_date'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        loadFundData(1);
    }

    // Dynamic Backend CSV Export (Filtered by Date Range & Search)
    function exportFundReportCSV() {
        const params = getFundFilterParams(1);
        params.append('export', 'csv');
        window.location.href = `${BASE_FUND_URL}?${params.toString()}`;
    }

    // Dynamic Printable Window (Filtered by Date Range & Search)
    function printFundReport() {
        const params = getFundFilterParams(1);
        params.append('print', '1');
        window.open(`${BASE_FUND_URL}?${params.toString()}`, '_blank', 'width=1200,height=800,scrollbars=yes');
    }

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Debounced search on typing
    let fundDebounceTimer = null;
    document.addEventListener('DOMContentLoaded', () => {
        ['filter_company_name', 'filter_user_name', 'filter_reg_no', 'filter_trans_desc'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', () => {
                    clearTimeout(fundDebounceTimer);
                    fundDebounceTimer = setTimeout(() => {
                        loadFundData(1);
                    }, 350);
                });
            }
        });
        loadFundData(1);
    });
</script>
@endsection
