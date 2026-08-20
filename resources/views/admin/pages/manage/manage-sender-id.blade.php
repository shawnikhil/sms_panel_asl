@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- Breadcrumb --}}
    <div class="d-flex align-items-center gap-2 mb-4 pt-2">
        <i class="bx bx-home text-secondary fs-5"></i>
        <span class="text-secondary fw-semibold">Manage Item</span>
        <span class="text-muted">|</span>
        <span class="text-primary fw-bold">Manage Sender ID</span>
    </div>

    {{-- 1. Find Sender Id Details (Filter Card) --}}
    <div class="card border shadow-sm mb-4 overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center gap-2 fw-semibold" style="background:#6c757d;">
            <i class="bx bx-grid-alt fs-5"></i>
            <span>Find Sender Id details -</span>
        </div>
        <div class="card-body p-4 bg-white">
            <form id="filterForm" onsubmit="event.preventDefault(); loadSenderData(1);">
                <div class="row g-3 justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">REG NO</label>
                            <div class="col-sm-8"><input type="text" id="f_regno" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">USER NAME</label>
                            <div class="col-sm-8"><input type="text" id="f_user" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">SENDER ID</label>
                            <div class="col-sm-8"><input type="text" id="f_sender" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">ENTITY ID</label>
                            <div class="col-sm-8"><input type="text" id="f_entity" class="form-control form-control-sm rounded-1" placeholder="" /></div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">FROM DATE</label>
                            <div class="col-sm-8"><input type="date" id="f_from" class="form-control form-control-sm rounded-1" /></div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end text-uppercase fw-bold text-secondary" style="font-size:.75rem;">TO DATE</label>
                            <div class="col-sm-8"><input type="date" id="f_to" class="form-control form-control-sm rounded-1" /></div>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3 d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold text-uppercase rounded-1 shadow-sm">SEARCH</button>
                        <button type="button" class="btn btn-light btn-sm border px-4 fw-bold text-uppercase rounded-1" onclick="clearFilters()">CLEAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- 2. Sender Id Details (Table Card) --}}
    <div class="card border shadow-sm overflow-hidden rounded-1">
        <div class="px-3 py-2 text-white d-flex align-items-center gap-2 fw-semibold" style="background:#0f6698;">
            <i class="bx bx-grid-alt fs-5"></i>
            <span>Sender Id details -</span>
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
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 sender-table" id="senderTable">
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size: .75rem;">
                            <th class="text-center" style="width:40px;">#</th>
                            <th class="text-center" style="width:125px;">ACTION</th>
                            <th>SENDER ID</th>
                            <th>ENTITY ID</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">USER REGNO</th>
                            <th>USER NAME</th>
                            <th class="text-center">TRAN DATE/TIME</th>
                        </tr>
                    </thead>
                    <tbody id="senderTbody">
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading Sender ID data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Edit Status Modal --}}
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow:hidden;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bx bx-edit text-primary fs-4"></i> Edit Sender Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" onsubmit="event.preventDefault(); updateSenderStatus();">
                <input type="hidden" id="m_id" />
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-secondary" style="font-size:.75rem;">SENDER ID</label>
                        <input type="text" id="m_sender" class="form-control rounded-2 bg-light" readonly />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-secondary" style="font-size:.75rem;">NEW STATUS <span class="text-danger">*</span></label>
                        <select id="m_status" class="form-select rounded-2" required>
                            <option value="1">✅ Approved</option>
                            <option value="0">⏳ Pending</option>
                            <option value="2">❌ Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-uppercase fw-bold text-secondary" style="font-size:.75rem;">REMARKS</label>
                        <textarea id="m_remarks" class="form-control rounded-2" rows="3" placeholder="Reason for status change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="m_submitBtn" class="btn btn-primary px-4 py-2 rounded-2 d-flex align-items-center gap-1 shadow-sm" style="background:#5b5df8; border:none;">
                        <i class="bx bx-save fs-5"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .sender-table th { font-weight:700; color:#333; padding:.65rem .75rem; border-bottom:2px solid #dee2e6; }
    .sender-table td { padding:.55rem .75rem; border-bottom:1px solid #e9ecef; }
    .page-link { cursor: pointer; user-select: none; }
    html.dark .sender-table th { background:#1e293b; color:#cbd5e1; border-color:#334155; }
    html.dark .sender-table td { border-color:#334155; }
</style>

<script>
    let currentPage = 1;
    let cachedRows = [];

    // AJAX Data Loading (Zero Page Reload)
    async function loadSenderData(page = 1) {
        currentPage = page;
        const tbody = document.getElementById('senderTbody');
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted"><span class="spinner-border spinner-border-sm text-primary me-2"></span> Loading page ${page}...</td></tr>`;

        const regno = (document.getElementById('f_regno')?.value || '').trim();
        const user = (document.getElementById('f_user')?.value || '').trim();
        const sender = (document.getElementById('f_sender')?.value || '').trim();
        const entity = (document.getElementById('f_entity')?.value || '').trim();
        const fromDate = document.getElementById('f_from')?.value || '';
        const toDate = document.getElementById('f_to')?.value || '';

        const params = new URLSearchParams({
            page: page,
            reg_no: regno,
            user_name: user,
            sender_id: sender,
            entity_id: entity,
            from_date: fromDate,
            to_date: toDate
        });

        try {
            const res = await fetch(`{{ route('admin.manage.sender_id') }}?${params.toString()}`, {
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
                tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Failed to load Sender ID records.</td></tr>`;
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-danger"><i class="bx bx-error fs-4 d-block mb-1"></i> Network error: ${err.message}</td></tr>`;
        }
    }

    function renderTableRows(rows, offsetIndex) {
        const tbody = document.getElementById('senderTbody');
        tbody.innerHTML = '';

        if (!rows || rows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted"><i class="bx bx-info-circle fs-4 d-block mb-1"></i> No Sender ID records found.</td></tr>`;
            return;
        }

        rows.forEach((row, i) => {
            const u = row.user || null;
            const regNo = u?.regno || (row.user_id ? 'UID:' + row.user_id : '');
            const userName = u ? ((u.fname || '') + ' ' + (u.lname || '')).trim() : (row.user_id ? 'User #' + row.user_id : '');
            const st = String(row.status !== null && row.status !== undefined ? row.status : '1').toLowerCase();
            const isApp = (st === '1' || st === 'approved');
            const isRej = (st === '2' || st === 'rejected');
            const statusLabel = isApp ? 'APPROVED' : (isRej ? 'REJECTED' : 'PENDING');
            const badgeColor = isApp ? 'bg-success' : (isRej ? 'bg-danger' : 'bg-warning text-dark');

            // Format date & time
            let dateFormatted = row.entry_date || '-';
            if (row.entry_date && row.entry_date.includes('-')) {
                const parts = row.entry_date.split('-');
                if (parts.length === 3) dateFormatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }

            const tr = document.createElement('tr');
            tr.className = 'sender-row';
            tr.dataset.id = row.id;
            tr.innerHTML = `
                <td class="text-center text-muted fw-bold">${offsetIndex + i + 1}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-success btn-sm fw-bold px-2 py-1 text-uppercase"
                            style="font-size:.72rem; letter-spacing:.02em;"
                            onclick="openEditModal(${i})">
                        EDIT STATUS
                    </button>
                </td>
                <td class="fw-bold text-dark">${escapeHtml(row.sender_id || '-')}</td>
                <td><span class="text-secondary font-monospace" style="font-size:.8rem;">${escapeHtml(row.entity_id || '-')}</span></td>
                <td class="text-center">
                    <span class="badge ${badgeColor} rounded-1 px-2 py-1 fw-bold" style="font-size:.7rem;">${statusLabel}</span>
                </td>
                <td class="text-center fw-semibold text-secondary">${escapeHtml(regNo)}</td>
                <td class="text-dark">${escapeHtml(userName)}</td>
                <td class="text-center" style="font-size:.8rem; line-height:1.2;">
                    <div>${dateFormatted}</div>
                    ${row.entry_time ? `<div class="text-muted" style="font-size:.72rem;">(${escapeHtml(row.entry_time)})</div>` : ''}
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
        prevLi.innerHTML = `<a class="page-link" onclick="loadSenderData(${cur - 1})">«</a>`;
        ul.appendChild(prevLi);

        // Calculate sliding window
        let start = Math.max(1, cur - 2);
        let end = Math.min(last, cur + 2);

        if (start > 1) {
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadSenderData(1)">1</a></li>`;
            if (start > 2) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === cur ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" onclick="loadSenderData(${i})">${i}</a>`;
            ul.appendChild(li);
        }

        if (end < last) {
            if (end < last - 1) ul.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            ul.innerHTML += `<li class="page-item"><a class="page-link" onclick="loadSenderData(${last})">${last}</a></li>`;
        }

        // Next Button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${cur === last ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" onclick="loadSenderData(${cur + 1})">»</a>`;
        ul.appendChild(nextLi);
    }

    function clearFilters() {
        ['f_regno', 'f_user', 'f_sender', 'f_entity', 'f_from', 'f_to'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        loadSenderData(1);
    }

    // Modal Handling (Indexed)
    function openEditModal(index) {
        const row = cachedRows[index];
        if (!row) return;
        document.getElementById('m_id').value = row.id;
        document.getElementById('m_sender').value = row.sender_id || '';
        const s = String(row.status !== null && row.status !== undefined ? row.status : '1').toLowerCase();
        document.getElementById('m_status').value = (s === '1' || s.includes('app')) ? '1' : ((s === '2' || s.includes('rej')) ? '2' : '0');
        document.getElementById('m_remarks').value = row.modified_mesg || '';
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    }

    // Async AJAX Status Update (Zero Reload)
    async function updateSenderStatus() {
        const id = document.getElementById('m_id').value;
        const status = document.getElementById('m_status').value;
        const remarks = document.getElementById('m_remarks').value;
        const btn = document.getElementById('m_submitBtn');

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Updating...';

        try {
            const res = await fetch("{{ route('admin.manage.sender_id.update_status') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ id, status, remarks })
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
                // Reload current page smoothly without refresh
                loadSenderData(currentPage);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Updated!', text: data.message, timer: 1200, showConfirmButton: false });
                } else {
                    alert(data.message || 'Status updated successfully!');
                }
            } else {
                alert(data.message || 'Failed to update status.');
            }
        } catch (err) {
            alert('Error updating status: ' + err.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save fs-5"></i> Update Status';
        }
    }

    function escapeHtml(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Debounced search on typing
    let searchDebounceTimer = null;
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#filterForm input[type="text"]').forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    loadSenderData(1);
                }, 350);
            });
        });
        loadSenderData(1);
    });
</script>
@endsection
