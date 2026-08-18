@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Package</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">New Package Register</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Enterprise Style --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" id="topSavePackageBtn" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="savePackageRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editPackageModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" id="deletePackageBtn" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deletePackageRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearPackageForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="packageRegisterForm" onsubmit="event.preventDefault(); savePackageRecord();">
                <input type="hidden" id="package_id" name="package_id" value="" />

                {{-- Row 1: Package Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PACKAGE NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="package_name" name="pack_name" class="form-control sms-input text-uppercase" placeholder="e.g. PREPAID PLAN API / BULK SMS ROUTE" required />
                    </div>
                </div>

                {{-- Row 2: Per SMS Charges & Per WH Charges --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PER SMS CHARGES <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" inputmode="decimal" id="per_sms_charges" name="pacch" class="form-control sms-input font-monospace no-spinner" placeholder="0.1000" required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PER WH CHARGES <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" inputmode="decimal" id="per_wh_charges" name="whch" class="form-control sms-input font-monospace no-spinner" placeholder="0.0000" required />
                    </div>
                </div>

                {{-- Row 3: Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="package_status" name="status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="1" selected>ACTIVE</option>
                            <option value="0">INACTIVE</option>
                        </select>
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" id="bottomSavePackageBtn" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearPackageForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit Package Details Modal matching UI Screenshot ── --}}
<div class="modal fade" id="editPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT PACKAGE DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-7">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">PACKAGE NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_pkg_name" class="form-control sms-input" placeholder="" oninput="filterPackageModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-4 fw-bold" onclick="resetPackageModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Center Pagination above Table --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Package modal navigation">
                            <ul class="pagination pagination-sm mb-0 justify-content-center" id="pkgModalPagination">
                                <!-- Dynamic Pagination Links -->
                            </ul>
                        </nav>
                    </div>
                </div>

                {{-- Table Component inside Modal with all 8 columns --}}
                <div class="table-responsive text-nowrap border rounded mb-2" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="packageModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">#</th>
                                <th>USER NAME</th>
                                <th>PACKAGE NAME</th>
                                <th class="text-center">PER SMS CHARGES</th>
                                <th class="text-center">PER WH CHARGES</th>
                                <th class="text-center" style="width: 100px;">STATUS</th>
                                <th class="text-center">INSERT DATE</th>
                                <th class="text-center">UPDATE DATE</th>
                            </tr>
                        </thead>
                        <tbody id="packageModalTbody">
                            @if(isset($packages) && count($packages) > 0)
                                @foreach($packages as $pkg)
                                    @php
                                        $isAct = in_array(strtoupper((string)($pkg->status ?? '1')), ['1', 'Y', 'YES', 'ACTIVE']) ? '1' : '0';
                                        $smsCost = (float)($pkg->pacch ?? 0);
                                        $whCost = (float)($pkg->whch ?? 0);
                                        $insertDate = $pkg->insert_date ? \Carbon\Carbon::parse($pkg->insert_date)->format('d-m-Y') : '-';
                                        $updateDate = $pkg->update_date ? \Carbon\Carbon::parse($pkg->update_date)->format('d-m-Y') : '-';
                                        
                                        $pkgData = [
                                            'id' => $pkg->id,
                                            'user' => $pkg->insert_user ?: 'ADMIN',
                                            'name' => $pkg->pack_name ?? '',
                                            'sms_cost' => (string)$smsCost,
                                            'wh_cost' => (string)$whCost,
                                            'status' => $isAct,
                                            'insert_date' => $insertDate,
                                            'update_date' => $updateDate
                                        ];
                                    @endphp
                                    <tr class="pkg-record-row"
                                        style="cursor: pointer;"
                                        data-id="{{ $pkgData['id'] }}"
                                        data-name="{{ $pkgData['name'] }}"
                                        data-sms="{{ $pkgData['sms_cost'] }}"
                                        data-wh="{{ $pkgData['wh_cost'] }}"
                                        data-status="{{ $pkgData['status'] }}"
                                        onclick="selectPackageRecord({{ json_encode($pkgData) }})">
                                        <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                        <td><span class="fw-bold text-dark">{{ $pkgData['user'] }}</span></td>
                                        <td><span class="text-dark">{{ $pkgData['name'] }}</span></td>
                                        <td class="text-center font-monospace">{{ $pkgData['sms_cost'] }}</td>
                                        <td class="text-center font-monospace">{{ $pkgData['wh_cost'] }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $pkgData['status'] === '1' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $pkgData['status'] === '1' ? 'ACTIVE' : 'INACTIVE' }}
                                            </span>
                                        </td>
                                        <td class="text-center font-monospace text-muted">{{ $pkgData['insert_date'] }}</td>
                                        <td class="text-center font-monospace text-muted">{{ $pkgData['update_date'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="noPackageRecordRow">
                                    <td colspan="8" class="text-center text-muted py-4">No package records found in database.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer py-2 bg-light d-flex justify-content-end">
                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal" style="background-color: #e9ecef;">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Page Styles ── --}}
<style>
    /* Breadcrumb Header Spacing & Appearance */
    .sms-breadcrumb-wrapper {
        font-size: 0.9rem;
        font-weight: 500;
        margin-top: 0.75rem;
        margin-bottom: 1.5rem !important;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    .sms-breadcrumb-wrapper .crumb-section {
        color: #64748b;
        font-weight: 600;
    }
    .sms-breadcrumb-wrapper .crumb-sep {
        color: #94a3b8;
        font-weight: 400;
    }
    .sms-breadcrumb-wrapper .crumb-active {
        color: #0f172a;
        font-weight: 700;
    }
    html.dark .sms-breadcrumb-wrapper .crumb-active {
        color: #f8fafc;
    }

    /* Shell & Headers */
    .sms-card-shell {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .help-top-action-bar {
        background: var(--bg-action-bar, #1a4f78);
    }
    html.dark .help-top-action-bar {
        background: #1e293b;
    }

    /* Form Fields */
    .help-field-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    html.dark .help-field-label {
        color: #cbd5e1;
    }

    .sms-input {
        border-radius: 3px;
        border: 1px solid #ced4da;
        padding: 0.45rem 0.75rem;
        font-size: 0.8125rem;
        background-color: #ffffff;
    }
    html.dark .sms-input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* Remove increase / decrease arrows on all number inputs */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button,
    .no-spinner::-webkit-outer-spin-button { 
        -webkit-appearance: none !important; 
        margin: 0 !important; 
    }
    input[type=number],
    .no-spinner {
        -moz-appearance: textfield !important;
        appearance: textfield !important;
    }

    /* Orange Action Button */
    .btn-orange-action {
        background-color: #f97316;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.04em;
        border-radius: 3px;
        padding: 0.35rem 0.85rem;
        border: none;
        box-shadow: 0 2px 4px rgba(249, 115, 22, 0.3);
        transition: all 0.2s ease;
    }
    .btn-orange-action:hover {
        background-color: #ea580c;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Table Hover on Modal */
    .pkg-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .pkg-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    const ACTION_URL = '{{ route("admin.package.new_package.action") }}';
    const CSRF_TOKEN = '{{ csrf_token() }}';

    let pkgModalCurrentPage = 1;
    const pkgModalPageSize = 10;

    function setButtonsLoading(btnIds, isLoading, loadingText = 'SAVING...', defaultHtml = '<i class="bx bx-check"></i> SAVE') {
        btnIds.forEach(id => {
            const btn = document.getElementById(id);
            if (btn) {
                btn.disabled = isLoading;
                btn.innerHTML = isLoading ? `<span class="spinner-border spinner-border-sm me-1"></span> ${loadingText}` : defaultHtml;
            }
        });
    }

    // Save Package Record (Create or Update)
    async function savePackageRecord() {
        const packageId = document.getElementById('package_id').value.trim();
        const name      = document.getElementById('package_name').value.trim();
        const sms       = document.getElementById('per_sms_charges').value.trim();
        const wh        = document.getElementById('per_wh_charges').value.trim();
        const status    = document.getElementById('package_status').value;

        if (!name) {
            toastr.error('Please enter PACKAGE NAME!', 'Validation Error');
            document.getElementById('package_name').focus();
            return;
        }

        if (sms === '' || isNaN(sms) || parseFloat(sms) < 0) {
            toastr.error('Please enter valid PER SMS CHARGES!', 'Validation Error');
            document.getElementById('per_sms_charges').focus();
            return;
        }

        if (wh === '' || isNaN(wh) || parseFloat(wh) < 0) {
            toastr.error('Please enter valid PER WH CHARGES!', 'Validation Error');
            document.getElementById('per_wh_charges').focus();
            return;
        }

        setButtonsLoading(['topSavePackageBtn', 'bottomSavePackageBtn'], true, 'SAVING...', '<i class="bx bx-check"></i> SAVE');

        const payload = {
            _token: CSRF_TOKEN,
            editid: packageId || null,
            package_id: packageId || null,
            pack_name: name,
            pacch: parseFloat(sms).toFixed(4),
            whch: parseFloat(wh).toFixed(4),
            status: status
        };

        try {
            const response = await fetch(ACTION_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'Package details saved successfully!', 'Success');
                if (data.package) {
                    upsertPackageModalRow(data.package);
                }
                if (!packageId) {
                    clearPackageForm();
                }
            } else {
                toastr.error(data.message || 'Failed to save package details.', 'Error');
            }
        } catch (error) {
            console.error('Package save error:', error);
            toastr.error('Server error occurred. Please try again.', 'Error');
        } finally {
            setButtonsLoading(['topSavePackageBtn', 'bottomSavePackageBtn'], false, '', '<i class="bx bx-check"></i> SAVE');
        }
    }

    // Delete Package Record
    async function deletePackageRecord() {
        const packageId   = document.getElementById('package_id').value.trim();
        const packageName = document.getElementById('package_name').value.trim();

        if (!packageId) {
            toastr.error('No package selected to delete. Please select a package from EDIT first.', 'Notice');
            return;
        }

        if (!confirm(`Are you sure you want to delete package "${packageName || packageId}"?`)) {
            return;
        }

        setButtonsLoading(['deletePackageBtn'], true, 'DELETING...', '<i class="bx bx-trash"></i> DEL');

        try {
            const response = await fetch(ACTION_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    _token: CSRF_TOKEN,
                    delid: packageId,
                    action: 'delete'
                })
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'Package deleted successfully!', 'Success');
                clearPackageForm();

                const row = document.querySelector(`#packageModalTbody tr[data-id="${packageId}"]`);
                if (row) {
                    row.remove();
                    const allRows = document.querySelectorAll('#packageModalTbody tr.pkg-record-row');
                    if (allRows.length === 0) {
                        const tbody = document.getElementById('packageModalTbody');
                        if (tbody) {
                            tbody.innerHTML = `<tr id="noPackageRecordRow"><td colspan="8" class="text-center text-muted py-4">No package records found in database.</td></tr>`;
                        }
                    } else {
                        allRows.forEach((r, idx) => {
                            const firstTd = r.querySelector('td:first-child');
                            if (firstTd) firstTd.textContent = idx + 1;
                        });
                    }
                    renderPackageModalPagination();
                }
            } else {
                toastr.error(data.message || 'Failed to delete package.', 'Error');
            }
        } catch (error) {
            console.error('Delete error:', error);
            toastr.error('Server error occurred while deleting package.', 'Error');
        } finally {
            setButtonsLoading(['deletePackageBtn'], false, '', '<i class="bx bx-trash"></i> DEL');
        }
    }

    // Format Date Helper to d-m-Y
    function formatDisplayDate(dateStr) {
        if (!dateStr || dateStr === '-') return '-';
        try {
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;
        } catch (e) {
            return dateStr;
        }
    }

    // Live Upsert of Modal Table Row
    function upsertPackageModalRow(pkg) {
        if (!pkg) return;

        const isAct = (pkg.status === '1' || String(pkg.status).toUpperCase() === 'ACTIVE' || String(pkg.status).toUpperCase() === 'Y') ? '1' : '0';
        const smsCost = parseFloat(pkg.pacch || 0);
        const whCost = parseFloat(pkg.whch || 0);
        const insertDate = pkg.insert_date_formatted || formatDisplayDate(pkg.insert_date);
        const updateDate = pkg.update_date_formatted || formatDisplayDate(pkg.update_date);

        const pkgData = {
            id: pkg.id || '',
            user: pkg.insert_user || 'ADMIN',
            name: pkg.pack_name || '',
            sms_cost: String(smsCost),
            wh_cost: String(whCost),
            status: isAct,
            insert_date: insertDate,
            update_date: updateDate
        };

        const tbody = document.getElementById('packageModalTbody');
        if (!tbody) return;

        document.getElementById('noPackageRecordRow')?.remove();

        let row = tbody.querySelector(`tr[data-id="${pkgData.id}"]`);
        if (!row) {
            row = document.createElement('tr');
            row.className = 'pkg-record-row';
            row.style.cursor = 'pointer';
            tbody.prepend(row);
        }

        row.dataset.id = pkgData.id;
        row.dataset.name = pkgData.name;
        row.dataset.sms = pkgData.sms_cost;
        row.dataset.wh = pkgData.wh_cost;
        row.dataset.status = pkgData.status;
        row.onclick = () => selectPackageRecord(pkgData);

        row.innerHTML = `
            <td class="text-center text-muted fw-bold">1</td>
            <td><span class="fw-bold text-dark">${pkgData.user}</span></td>
            <td><span class="text-dark">${pkgData.name}</span></td>
            <td class="text-center font-monospace">${pkgData.sms_cost}</td>
            <td class="text-center font-monospace">${pkgData.wh_cost}</td>
            <td class="text-center">
                <span class="badge ${pkgData.status === '1' ? 'bg-success' : 'bg-danger'}">
                    ${pkgData.status === '1' ? 'ACTIVE' : 'INACTIVE'}
                </span>
            </td>
            <td class="text-center font-monospace text-muted">${pkgData.insert_date}</td>
            <td class="text-center font-monospace text-muted">${pkgData.update_date}</td>
        `;

        tbody.querySelectorAll('tr.pkg-record-row').forEach((r, idx) => {
            const firstTd = r.querySelector('td:first-child');
            if (firstTd) firstTd.textContent = idx + 1;
        });

        pkgModalCurrentPage = 1;
        renderPackageModalPagination();
    }

    // Clear Form
    function clearPackageForm() {
        document.getElementById('packageRegisterForm').reset();
        document.getElementById('package_id').value = '';
        document.getElementById('package_name').value = '';
        document.getElementById('per_sms_charges').value = '';
        document.getElementById('per_wh_charges').value = '';
        document.getElementById('package_status').value = '1';
    }

    // Modal Selection
    function selectPackageRecord(pkg) {
        document.getElementById('package_id').value = pkg.id || '';
        document.getElementById('package_name').value = pkg.name || '';
        document.getElementById('per_sms_charges').value = pkg.sms_cost || '';
        document.getElementById('per_wh_charges').value = pkg.wh_cost || '';
        document.getElementById('package_status').value = pkg.status === '1' ? '1' : '0';

        const modalEl = document.getElementById('editPackageModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // ── Pagination & Filter Controller for Edit Modal ──
    function renderPackageModalPagination() {
        const filterName = (document.getElementById('modal_filter_pkg_name')?.value || '').trim().toLowerCase();

        const allRows = Array.from(document.querySelectorAll('#packageModalTbody tr.pkg-record-row'));
        const matchedRows = allRows.filter(row => {
            const pName = (row.dataset.name || '').toLowerCase();
            return !filterName || pName.includes(filterName);
        });

        const totalItems = matchedRows.length;
        const totalPages = Math.ceil(totalItems / pkgModalPageSize) || 1;

        if (pkgModalCurrentPage > totalPages) pkgModalCurrentPage = totalPages;
        if (pkgModalCurrentPage < 1) pkgModalCurrentPage = 1;

        const startIndex = (pkgModalCurrentPage - 1) * pkgModalPageSize;
        const endIndex   = startIndex + pkgModalPageSize;

        allRows.forEach(row => row.style.display = 'none');
        matchedRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

        const pagContainer = document.getElementById('pkgModalPagination');
        if (!pagContainer) return;

        let pagHtml = `<li class="page-item ${pkgModalCurrentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToPackageModalPage(${pkgModalCurrentPage - 1})">«</a>
        </li>`;

        let startPage = Math.max(1, pkgModalCurrentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

        if (startPage > 1) {
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPackageModalPage(1)">1</a></li>`;
            if (startPage > 2) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let p = startPage; p <= endPage; p++) {
            pagHtml += `<li class="page-item ${p === pkgModalCurrentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="goToPackageModalPage(${p})">${p}</a>
            </li>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPackageModalPage(${totalPages})">${totalPages}</a></li>`;
        }

        pagHtml += `<li class="page-item ${pkgModalCurrentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToPackageModalPage(${pkgModalCurrentPage + 1})">»</a>
        </li>`;

        pagContainer.innerHTML = pagHtml;
    }

    function goToPackageModalPage(page) {
        pkgModalCurrentPage = page;
        renderPackageModalPagination();
    }

    function filterPackageModalTable() {
        pkgModalCurrentPage = 1;
        renderPackageModalPagination();
    }

    function resetPackageModalFilter() {
        if (document.getElementById('modal_filter_pkg_name')) {
            document.getElementById('modal_filter_pkg_name').value = '';
        }
        pkgModalCurrentPage = 1;
        renderPackageModalPagination();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderPackageModalPagination();
        document.getElementById('editPackageModal')?.addEventListener('shown.bs.modal', () => {
            renderPackageModalPagination();
        });

        // Input uppercase formatter
        document.getElementById('package_name')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Allow only valid numbers and decimals on charges inputs
        ['per_sms_charges', 'per_wh_charges'].forEach(id => {
            document.getElementById(id)?.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });
        });
    });
</script>
@endsection
