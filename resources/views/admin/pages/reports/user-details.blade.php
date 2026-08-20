@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- Breadcrumb --}}
    <div class="d-flex align-items-center gap-2 mb-4 pt-2">
        <i class="bx bx-home text-secondary fs-5"></i>
        <span class="text-secondary fw-semibold">Report</span>
        <span class="text-muted">|</span>
        <span class="text-primary fw-bold">User Details</span>
    </div>

    {{-- 1. Find User Details (Filter Card) --}}
    <div class="card border shadow-sm mb-4 overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center justify-content-between" style="background:#6c757d;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>Find User Details -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#userFilterBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>

        <div class="collapse show" id="userFilterBody">
            <div class="card-body p-4 bg-white">
                <form id="userSearchForm" onsubmit="event.preventDefault(); loadUserData(1);">
                    <div class="row g-3 justify-content-center align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">USER NAME</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_user_name" class="form-control form-control-sm rounded-1" placeholder="Enter user name / regno / company..." />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">CONTACT NUMBER</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_contact_no" class="form-control form-control-sm rounded-1" placeholder="Enter phone / email..." />
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
                            <button type="button" class="btn btn-light btn-sm border px-4 fw-bold text-uppercase rounded-1" onclick="clearUserFilters()">CLEAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. User Details Table Card --}}
    <div class="card border shadow-sm overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex flex-wrap align-items-center justify-content-between gap-2" style="background:#0f6698;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bx bx-grid-alt fs-5"></i>
                <span>User Details -</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="position-relative d-none d-md-block" style="width: 220px;">
                    <i class="bx bx-search position-absolute top-50 translate-middle-y text-muted ms-2"></i>
                    <input type="text" id="userQuickSearch" class="form-control form-control-sm ps-4 bg-white text-dark rounded-1" 
                           placeholder="Quick search user..." />
                </div>
                <button class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" onclick="exportUserReportCSV()">
                    <i class="bx bx-download"></i> Export CSV
                </button>
                <button class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" onclick="printUserReport()">
                    <i class="bx bx-printer"></i> Print
                </button>
            </div>
        </div>

        <div class="card-body p-0 bg-white position-relative">
            {{-- Top Pagination Toolbar (Zero Reload) --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between px-3 py-2 border-bottom gap-2">
                <div class="text-muted small">
                    Showing <span id="user_page_info" class="fw-bold text-dark">0</span> users
                </div>
                <div class="d-flex align-items-center gap-1">
                    <ul class="pagination pagination-sm mb-0" id="userPaginationList">
                        {{-- Rendered dynamically by AJAX --}}
                    </ul>
                </div>
            </div>

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap" style="max-height: 650px; overflow-x: auto;">
                <table class="table table-hover align-middle mb-0 user-details-table" id="userDetailsTable">
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size:.74rem;">
                            <th class="text-center" style="width: 35px;">#</th>
                            <th class="text-center" style="width: 70px;">ACTION</th>
                            <th class="text-center">REG NO</th>
                            <th>USER NAME</th>
                            <th>USER TYPE</th>
                            <th>COMPANY NAME</th>
                            <th>CONTACT NUMBER</th>
                            <th>EMAIL ID</th>
                            <th>PACKAGE NAME</th>
                            <th class="text-end">TOTAL BALANCE</th>
                            <th>ADDRESS</th>
                            <th>PIN CODE</th>
                            <th>PAN NO</th>
                            <th>GST NUMBER</th>
                            <th>AADHAAR NUMBER</th>
                            <th class="text-center">IS OTP VERIFY</th>
                            <th class="text-center">OTP VERIFY TYPE</th>
                            <th>USER ID</th>
                            <th class="text-center">API TOKEN</th>
                            <th>IP ADDRESS</th>
                            <th>CALLBACK URL</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">REG DATE</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <tr>
                            <td colspan="23" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading live user accounts data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ── API Token View Modal ── --}}
<div class="modal fade" id="tokenViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
            <div class="modal-header text-white py-3 px-4" style="background:#0f6698;">
                <h6 class="modal-title mb-0 fw-bold d-flex align-items-center gap-2 text-white">
                    <i class="bx bx-key fs-5"></i> API Token & Authentication
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="mb-3">
                    <label class="form-label text-uppercase fw-bold text-secondary small">User Account:</label>
                    <div class="fw-bold text-dark fs-6" id="tokenModalUserName"></div>
                </div>
                <div class="mb-2">
                    <label class="form-label text-uppercase fw-bold text-secondary small">Full API Token:</label>
                    <div class="input-group">
                        <textarea id="tokenModalValue" class="form-control font-monospace p-2 bg-white" rows="3" readonly style="font-size:0.85rem; line-height:1.5; color:#0f172a;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2 px-4 bg-white border-top d-flex justify-content-between">
                <button type="button" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1 shadow-sm" onclick="copyTokenToClipboard()">
                    <i class="bx bx-copy"></i> Copy Token
                </button>
                <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .user-details-table th {
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
    .user-details-table td { padding: .55rem .75rem; border-bottom: 1px solid #e9ecef; }
    .page-link { cursor: pointer; user-select: none; }
    .user-token-cell { cursor: pointer; }
    .user-token-cell:hover code { color: #0d6efd; text-decoration: underline; }
    html.dark .user-details-table th {
        background-color: #1e293b !important;
        color: #cbd5e1;
        border-color: #334155;
        box-shadow: inset 0 -2px 0 #334155;
    }
    html.dark .user-details-table td { border-color: #334155; }
</style>

<script>
    let userCurrentPage = 1;
    let cachedUserRows = [];
    let currentTokenValue = '';
    const BASE_USER_REPORT_URL = "{{ route('admin.reports.user_details') }}";

    function getFilterParams(page = 1) {
        const userName   = (document.getElementById('filter_user_name')?.value || '').trim();
        const contactNo  = (document.getElementById('filter_contact_no')?.value || '').trim();
        const fromDate   = (document.getElementById('filter_from_date')?.value || '').trim();
        const toDate     = (document.getElementById('filter_to_date')?.value || '').trim();
        const quickSearch= (document.getElementById('userQuickSearch')?.value || '').trim();

        return new URLSearchParams({
            page: page,
            user_name: userName,
            contact_no: contactNo,
            from_date: fromDate,
            to_date: toDate,
            quick_search: quickSearch
        });
    }

    // AJAX Data Fetching (Zero Page Reload)
    async function loadUserData(page = 1) {
        userCurrentPage = page;
        const tbody = document.getElementById('userTableBody');
        tbody.innerHTML = `<tr><td colspan="23" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading page ${page}...</td></tr>`;

        const params = getFilterParams(page);

        try {
            const res = await fetch(`${BASE_USER_REPORT_URL}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                cachedUserRows = data.data || [];
                renderUserTableRows(data.data, (data.current_page - 1) * 10);
                document.getElementById('user_page_info').textContent = data.total > 0 ? `${data.from}-${data.to} of ${data.total}` : '0 of 0';
                renderUserPagination(data.current_page, data.last_page);
            } else {
                tbody.innerHTML = `<tr><td colspan="23" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Failed to load user records.</td></tr>`;
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="23" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Network error: ${err.message}</td></tr>`;
        }
    }

    function renderUserTableRows(rows, offsetIndex) {
        const tbody = document.getElementById('userTableBody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="23" class="text-center py-4 text-muted"><i class="bx bx-info-circle fs-4 d-block mb-1"></i> No user records found.</td></tr>`;
            return;
        }

        const editBaseUrl = "{{ route('admin.master.user_register') }}";

        rows.forEach((user, i) => {
            const fullName = ((user.fname || '') + ' ' + (user.lname || '')).trim() || 'User #' + user.id;
            const userType = user.user_type?.user_name || (user.catid ? 'TYPE ' + user.catid : 'API USER');
            const packageName = user.package?.pack_name || (user.package_id ? 'PLAN #' + user.package_id : '-');
            const totalBalance = user.balance_sheet?.balance_amt ?? user.balance_sheet?.total_amt_for_prepaid ?? user.regamt ?? '0.00';
            const statusStr = String(user.status === 1 || user.status === '1' || user.status === 'ACTIVE' ? 'ACTIVE' : 'INACTIVE');
            const isOtp = String(user.isotpverify === 1 || user.isotpverify === '1' || user.isotpverify === 'YES' ? 'YES' : 'NO');
            const otpType = user.otpverifytype || 'SMS';

            // Format registration date
            let regDateStr = user.regst_date || user.insert_date || '-';
            if (regDateStr && regDateStr.includes('-') && regDateStr.length === 10) {
                const parts = regDateStr.split('-');
                if (parts.length === 3) regDateStr = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
            if (user.regst_time) {
                regDateStr += ` <span class="text-muted" style="font-size:.7rem;">(${escapeHtml(user.regst_time)})</span>`;
            }

            const tr = document.createElement('tr');
            tr.className = 'user-row';
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td class="text-center">
                    <a href="${editBaseUrl}?edit_id=${user.id}" class="btn btn-sm btn-success py-0 px-2 rounded-1 fw-bold text-uppercase d-inline-flex align-items-center gap-1 shadow-sm" style="font-size:.72rem;">
                        <i class="bx bx-edit-alt"></i> EDIT
                    </a>
                </td>
                <td class="text-center"><span class="badge bg-label-secondary font-monospace fw-bold">${escapeHtml(user.regno || '-')}</span></td>
                <td><span class="fw-bold text-dark">${escapeHtml(fullName)}</span></td>
                <td><span class="badge bg-label-info fw-semibold">${escapeHtml(userType)}</span></td>
                <td><span class="text-secondary fw-semibold">${escapeHtml(user.company_name || '-')}</span></td>
                <td><span class="font-monospace text-dark">${escapeHtml(user.phone || '-')}</span></td>
                <td><span class="text-muted" style="font-size:.78rem;">${escapeHtml(user.email || '-')}</span></td>
                <td><span class="badge bg-label-primary">${escapeHtml(packageName)}</span></td>
                <td class="text-end fw-bold text-success font-monospace">${parseFloat(totalBalance).toFixed(2)}</td>
                <td><span class="text-truncate d-inline-block" style="max-width:180px;" title="${escapeHtml(user.addsdt || '-')}">${escapeHtml(user.addsdt || '-')}</span></td>
                <td><span class="font-monospace">${escapeHtml(user.pincode || '-')}</span></td>
                <td><span class="font-monospace">${escapeHtml(user.panno || '-')}</span></td>
                <td><span class="font-monospace">${escapeHtml(user.gstnumber || '-')}</span></td>
                <td><span class="font-monospace">${escapeHtml(user.aadharno || '-')}</span></td>
                <td class="text-center">
                    <span class="badge ${isOtp === 'YES' ? 'bg-success' : 'bg-secondary'}">${isOtp}</span>
                </td>
                <td class="text-center"><span class="badge bg-label-dark">${escapeHtml(otpType)}</span></td>
                <td><span class="font-monospace">${escapeHtml(user.userid || ('USR' + user.regno))}</span></td>
                <td class="text-center">
                    ${user.apitoken ? `
                        <div class="user-token-cell d-inline-flex align-items-center gap-1" title="Click to view & copy Token" onclick="openTokenModal(${i})">
                            <code class="text-primary" style="font-size:.72rem;">${escapeHtml((user.apitoken).substring(0, 12))}...</code>
                            <i class="bx bx-copy text-primary" style="font-size:.85rem;"></i>
                        </div>
                    ` : '<span class="text-muted small">-</span>'}
                </td>
                <td><span class="font-monospace">${escapeHtml(user.ipaddress || '-')}</span></td>
                <td><span class="text-truncate d-inline-block" style="max-width:150px;" title="${escapeHtml(user.callbackurl || '-')}">${escapeHtml(user.callbackurl || '-')}</span></td>
                <td class="text-center">
                    <span class="badge ${statusStr === 'ACTIVE' ? 'bg-success' : 'bg-danger'}">${statusStr}</span>
                </td>
                <td class="text-center text-nowrap" style="font-size:.78rem;">${regDateStr}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Dynamic Zero-Reload Pagination Bar
    function renderUserPagination(cur, last) {
        const ul = document.getElementById('userPaginationList');
        ul.innerHTML = '';

        if (last <= 1) return;

        // Prev Button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${cur === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" onclick="loadUserData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        // Sliding window
        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadUserData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadUserData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadUserData(${last})">${last}</a></li>`;
        }

        // Next Button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadUserData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function clearUserFilters() {
        ['filter_user_name', 'filter_contact_no', 'filter_from_date', 'filter_to_date', 'userQuickSearch'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        loadUserData(1);
    }

    // Dynamic Backend CSV Export (Filtered by Date Range & Search)
    function exportUserReportCSV() {
        const params = getFilterParams(1);
        params.append('export', 'csv');
        window.location.href = `${BASE_USER_REPORT_URL}?${params.toString()}`;
    }

    // Dynamic Printable Window (Filtered by Date Range & Search)
    function printUserReport() {
        const params = getFilterParams(1);
        params.append('print', '1');
        window.open(`${BASE_USER_REPORT_URL}?${params.toString()}`, '_blank', 'width=1200,height=800,scrollbars=yes');
    }

    // Token Modal Helper
    function openTokenModal(index) {
        const user = cachedUserRows[index];
        if (!user) return;
        const name = ((user.fname || '') + ' ' + (user.lname || '')).trim() || 'User #' + user.id;
        currentTokenValue = user.apitoken || '';
        document.getElementById('tokenModalUserName').textContent = `${name} (Reg No: ${user.regno || '-'})`;
        document.getElementById('tokenModalValue').value = currentTokenValue;
        new bootstrap.Modal(document.getElementById('tokenViewModal')).show();
    }

    function copyTokenToClipboard() {
        if (!currentTokenValue) return;
        navigator.clipboard.writeText(currentTokenValue).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Copied!', text: 'API Token copied to clipboard', timer: 1200, showConfirmButton: false });
            } else {
                alert('API Token copied to clipboard successfully!');
            }
        });
    }

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Debounced search on typing
    let userDebounceTimer = null;
    document.addEventListener('DOMContentLoaded', () => {
        ['filter_user_name', 'filter_contact_no', 'userQuickSearch'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', () => {
                    clearTimeout(userDebounceTimer);
                    userDebounceTimer = setTimeout(() => {
                        loadUserData(1);
                    }, 350);
                });
            }
        });
        loadUserData(1);
    });
</script>
@endsection
