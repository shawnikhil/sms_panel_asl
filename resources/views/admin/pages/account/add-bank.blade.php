@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Master Account</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">Bank Register</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom bg-light">
            <button type="button" id="topSaveBankBtn" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveBankRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editBankModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" id="deleteBankBtn" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 text-danger" onclick="deleteBankRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearBankForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="bankRegisterForm" onsubmit="event.preventDefault(); saveBankRecord();" novalidate>
                <input type="hidden" id="bank_id" value="" />

                {{-- Row 1: Bank Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        BANK NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="bank_name" name="bank_name" class="form-control sms-input text-uppercase" placeholder="e.g. HDFC BANK / STATE BANK OF INDIA" />
                    </div>
                </div>

                {{-- Row 2: Account Number & IFSC Code --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        ACCOUNT NUMBER <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="account_number" name="accno" class="form-control sms-input font-monospace" placeholder="Enter account number..." />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        IFSC CODE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="ifsc_code" name="ifsc_code" class="form-control sms-input font-monospace text-uppercase" placeholder="e.g. HDFC0001234" />
                    </div>
                </div>

                {{-- Row 3: Branch Name & Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        BRANCH NAME
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="branch_name" name="branc_name" class="form-control sms-input" placeholder="e.g. Main Branch, Sector 62" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="bank_status" name="status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="1" selected>ACTIVE (Y)</option>
                            <option value="0">INACTIVE (N)</option>
                        </select>
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" id="bottomSaveBankBtn" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearBankForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit Bank Details Modal ── --}}
<div class="modal fade" id="editBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT BANK DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">BANK NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_bank" class="form-control sms-input" placeholder="Search by bank name..." oninput="filterBankModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">ACCOUNT NO</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_acc" class="form-control sms-input" placeholder="Search by account no..." oninput="filterBankModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetBankModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Table Component inside Modal --}}
                <div class="table-responsive text-nowrap border rounded mb-3" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="bankModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;" class="text-center">#</th>
                                <th>BANK NAME</th>
                                <th>ACCOUNT NUMBER</th>
                                <th>IFSC CODE</th>
                                <th>BRANCH NAME</th>
                                <th class="text-center" style="width: 100px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="bankModalTbody">
                            @if(isset($banks) && count($banks) > 0)
                                @foreach($banks as $b)
                                    @php
                                        $bStatus = in_array(strtoupper((string)($b->status ?? '1')), ['1', 'Y', 'YES', 'ACTIVE']) ? '1' : '0';
                                        $bData = [
                                            'id' => $b->id,
                                            'bank_name' => $b->bank_name ?? '',
                                            'accno' => $b->accno ?? '',
                                            'ifsc_code' => $b->ifsc_code ?? '',
                                            'branc_name' => $b->branc_name ?? '',
                                            'status' => $bStatus,
                                        ];
                                    @endphp
                                    <tr class="bank-record-row"
                                        style="cursor: pointer;"
                                        data-id="{{ $bData['id'] }}"
                                        data-bank="{{ $bData['bank_name'] }}"
                                        data-acc="{{ $bData['accno'] }}"
                                        onclick="selectBankRecord({{ json_encode($bData) }})">
                                        <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                        <td><span class="fw-bold text-dark">{{ $bData['bank_name'] }}</span></td>
                                        <td><span class="font-monospace text-primary fw-bold">{{ $bData['accno'] }}</span></td>
                                        <td><span class="badge bg-label-info font-monospace">{{ $bData['ifsc_code'] }}</span></td>
                                        <td><span class="text-secondary">{{ $bData['branc_name'] ?: '-' }}</span></td>
                                        <td class="text-center">
                                            <span class="badge {{ $bData['status'] === '1' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $bData['status'] === '1' ? 'ACTIVE' : 'INACTIVE' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="noBankRecordRow">
                                    <td colspan="6" class="text-center text-muted py-4">No bank records found in database.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer inside Modal --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2 pt-2 border-top">
                    <div class="text-muted small" id="bankModalPaginationInfo">
                        Showing 0 to 0 of 0 entries
                    </div>
                    <div class="sms-pagination-container">
                        <nav aria-label="Bank modal navigation">
                            <ul class="pagination pagination-sm mb-0 justify-content-center" id="bankModalPagination">
                                {{-- JS generated pagination --}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="modal-footer py-2 bg-light">
                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal" style="background-color: #e9ecef;">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Page Styles ── --}}
<style>
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
        color: #cbd5e1;
        margin: 0 0.25rem;
    }
    .sms-breadcrumb-wrapper .crumb-active {
        color: #1e293b;
        font-weight: 700;
    }
    html.dark .sms-breadcrumb-wrapper .crumb-active {
        color: #f8fafc;
    }

    .sms-card-shell {
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background-color: #ffffff;
    }
    html.dark .sms-card-shell {
        background-color: #1e293b;
        border-color: #334155;
    }

    .help-top-action-bar {
        background-color: #f8fafc;
    }
    html.dark .help-top-action-bar {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    .help-field-label {
        font-size: 0.75rem;
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
        padding: 0.42rem 0.75rem;
        font-size: 0.8125rem;
        background-color: #ffffff;
    }
    html.dark .sms-input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

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

    .bank-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .bank-record-row:hover {
        background-color: #1e293b !important;
    }

    /* Sticky Table Header inside Modal */
    #bankModalTable thead th {
        position: sticky !important;
        top: 0 !important;
        z-index: 10 !important;
        background-color: #f8fafc !important;
        box-shadow: inset 0 -1px 0 #dee2e6, inset 0 1px 0 #dee2e6;
    }
    html.dark #bankModalTable thead th {
        background-color: #1e293b !important;
        box-shadow: inset 0 -1px 0 #334155, inset 0 1px 0 #334155;
    }
</style>
@endsection

{{-- ── Page Scripts ── --}}
@section('scripts')
<script>
    const ACTION_URL = "{{ route('admin.account.add_bank.action') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
    let bankModalCurrentPage = 1;
    const bankModalPageSize = 10;

    // Generic Button Loader Toggler
    function setButtonsLoading(btnIds, isLoading, text, defaultHtml) {
        btnIds.forEach(id => {
            const btn = document.getElementById(id);
            if (!btn) return;
            if (isLoading) {
                btn.disabled = true;
                btn.dataset.prevHtml = btn.innerHTML;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" style="width: 0.85rem; height: 0.85rem;"></span> ${text}`;
                btn.style.cursor = 'not-allowed';
                btn.style.opacity = '0.75';
            } else {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.prevHtml || defaultHtml;
                btn.style.cursor = '';
                btn.style.opacity = '';
            }
        });
    }

    // Save Bank Record (Create or Update)
    async function saveBankRecord() {
        const rules = [
            { id: 'bank_name', name: 'BANK NAME' },
            { id: 'account_number', name: 'ACCOUNT NUMBER', regex: /^\d{9,18}$/, regexMsg: 'Bank Account Number must be between 9 and 18 numeric digits!' },
            { id: 'ifsc_code', name: 'IFSC CODE', regex: /^[A-Z]{4}0[A-Z0-9]{6}$/i, regexMsg: 'Invalid Indian IFSC Code format! (e.g. SBIN0001234, HDFC0000128)' },
            { id: 'bank_status', name: 'STATUS' }
        ];

        for (const r of rules) {
            const el = document.getElementById(r.id);
            const val = el ? el.value.trim() : '';
            if (!val) {
                toastr.error(`Please enter / select ${r.name}!`, 'Validation Error');
                el?.focus();
                return;
            }
            if (r.regex && !r.regex.test(val)) {
                toastr.error(r.regexMsg, 'Validation Error');
                el?.focus();
                return;
            }
        }

        const bankId = document.getElementById('bank_id').value.trim();
        const payload = {
            _token: CSRF_TOKEN,
            editid: bankId,
            bank_id: bankId,
            bank_name: document.getElementById('bank_name').value.trim().toUpperCase(),
            accno: document.getElementById('account_number').value.trim(),
            ifsc_code: document.getElementById('ifsc_code').value.trim().toUpperCase(),
            branc_name: document.getElementById('branch_name').value.trim(),
            status: document.getElementById('bank_status').value
        };

        setButtonsLoading(['topSaveBankBtn', 'bottomSaveBankBtn'], true, 'SAVING...', '<i class="bx bx-check"></i> SAVE');

        try {
            const response = await fetch(ACTION_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'Bank details saved successfully!', 'Success');
                if (data.bank) upsertBankModalRow(data.bank);
                if (!bankId) clearBankForm();
            } else {
                toastr.error(data.message || 'Failed to save bank details.', 'Error');
            }
        } catch (error) {
            console.error('Bank save error:', error);
            toastr.error('Server error occurred. Please try again.', 'Error');
        } finally {
            setButtonsLoading(['topSaveBankBtn', 'bottomSaveBankBtn'], false, '', '<i class="bx bx-check"></i> SAVE');
        }
    }

    // Delete Bank Record
    async function deleteBankRecord() {
        const bankId   = document.getElementById('bank_id').value.trim();
        const bankName = document.getElementById('bank_name').value.trim();

        if (!bankId) {
            toastr.error('No bank selected to delete. Please select a bank from EDIT first.', 'Notice');
            return;
        }

        if (!confirm(`Are you sure you want to delete bank "${bankName || bankId}"?`)) return;

        setButtonsLoading(['deleteBankBtn'], true, 'DELETING...', '<i class="bx bx-trash"></i> DEL');

        try {
            const response = await fetch(ACTION_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ _token: CSRF_TOKEN, delid: bankId, action: 'delete' })
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'Bank deleted successfully!', 'Success');
                clearBankForm();

                const row = document.querySelector(`#bankModalTbody tr[data-id="${bankId}"]`);
                if (row) {
                    row.remove();
                    const allRows = document.querySelectorAll('#bankModalTbody tr.bank-record-row');
                    if (allRows.length === 0) {
                        const tbody = document.getElementById('bankModalTbody');
                        if (tbody) tbody.innerHTML = `<tr id="noBankRecordRow"><td colspan="6" class="text-center text-muted py-4">No bank records found in database.</td></tr>`;
                    } else {
                        allRows.forEach((r, idx) => {
                            const firstTd = r.querySelector('td:first-child');
                            if (firstTd) firstTd.textContent = idx + 1;
                        });
                    }
                    renderBankModalPagination();
                }
            } else {
                toastr.error(data.message || 'Failed to delete bank.', 'Error');
            }
        } catch (error) {
            console.error('Delete error:', error);
            toastr.error('Server error occurred while deleting bank.', 'Error');
        } finally {
            setButtonsLoading(['deleteBankBtn'], false, '', '<i class="bx bx-trash"></i> DEL');
        }
    }

    // Live Upsert of Modal Table Row
    function upsertBankModalRow(bank) {
        if (!bank) return;

        const isAct = inArray(String(bank.status).toUpperCase(), ['1', 'Y', 'YES', 'ACTIVE']) ? '1' : '0';
        const bData = {
            id: bank.id || '',
            bank_name: bank.bank_name || '',
            accno: bank.accno || '',
            ifsc_code: bank.ifsc_code || '',
            branc_name: bank.branc_name || '',
            status: isAct
        };

        const tbody = document.getElementById('bankModalTbody');
        if (!tbody) return;

        document.getElementById('noBankRecordRow')?.remove();

        let row = tbody.querySelector(`tr[data-id="${bData.id}"]`);
        if (!row) {
            row = document.createElement('tr');
            row.className = 'bank-record-row';
            row.style.cursor = 'pointer';
            tbody.prepend(row);
        }

        row.dataset.id = bData.id;
        row.dataset.bank = bData.bank_name;
        row.dataset.acc = bData.accno;
        row.onclick = () => selectBankRecord(bData);

        row.innerHTML = `
            <td class="text-center text-muted fw-bold">1</td>
            <td><span class="fw-bold text-dark">${bData.bank_name}</span></td>
            <td><span class="font-monospace text-primary fw-bold">${bData.accno}</span></td>
            <td><span class="badge bg-label-info font-monospace">${bData.ifsc_code}</span></td>
            <td><span class="text-secondary">${bData.branc_name || '-'}</span></td>
            <td class="text-center">
                <span class="badge ${bData.status === '1' ? 'bg-success' : 'bg-danger'}">
                    ${bData.status === '1' ? 'ACTIVE' : 'INACTIVE'}
                </span>
            </td>
        `;

        tbody.querySelectorAll('tr.bank-record-row').forEach((r, idx) => {
            const firstTd = r.querySelector('td:first-child');
            if (firstTd) firstTd.textContent = idx + 1;
        });

        bankModalCurrentPage = 1;
        renderBankModalPagination();
    }

    function inArray(needle, haystack) {
        return haystack.indexOf(needle) !== -1;
    }

    // Clear Form
    function clearBankForm() {
        document.getElementById('bankRegisterForm').reset();
        document.getElementById('bank_id').value = '';
        document.getElementById('bank_status').value = '1';
    }

    // Modal Selection
    function selectBankRecord(bank) {
        document.getElementById('bank_id').value = bank.id || '';
        document.getElementById('bank_name').value = bank.bank_name || '';
        document.getElementById('account_number').value = bank.accno || '';
        document.getElementById('ifsc_code').value = bank.ifsc_code || '';
        document.getElementById('branch_name').value = bank.branc_name || '';

        const isAct = inArray(String(bank.status).toUpperCase(), ['1', 'Y', 'YES', 'ACTIVE']) ? '1' : '0';
        document.getElementById('bank_status').value = isAct;

        const modalEl = document.getElementById('editBankModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // ── Pagination & Filter Controller for Edit Modal ──
    function renderBankModalPagination() {
        const filterBank = (document.getElementById('modal_filter_bank')?.value || '').trim().toLowerCase();
        const filterAcc  = (document.getElementById('modal_filter_acc')?.value || '').trim().toLowerCase();

        const allRows = Array.from(document.querySelectorAll('#bankModalTbody tr.bank-record-row'));
        const matchedRows = allRows.filter(row => {
            const bName = (row.dataset.bank || '').toLowerCase();
            const bAcc  = (row.dataset.acc || '').toLowerCase();
            return (!filterBank || bName.includes(filterBank)) && (!filterAcc || bAcc.includes(filterAcc));
        });

        const totalItems = matchedRows.length;
        const totalPages = Math.ceil(totalItems / bankModalPageSize) || 1;

        if (bankModalCurrentPage > totalPages) bankModalCurrentPage = totalPages;
        if (bankModalCurrentPage < 1) bankModalCurrentPage = 1;

        const startIndex = (bankModalCurrentPage - 1) * bankModalPageSize;
        const endIndex   = startIndex + bankModalPageSize;

        allRows.forEach(row => row.style.display = 'none');
        matchedRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

        const infoEl = document.getElementById('bankModalPaginationInfo');
        if (infoEl) {
            infoEl.textContent = totalItems === 0 ? 'Showing 0 of 0 entries' : `Showing ${startIndex + 1} to ${Math.min(endIndex, totalItems)} of ${totalItems} entries`;
        }

        const pagContainer = document.getElementById('bankModalPagination');
        if (!pagContainer) return;

        let pagHtml = `<li class="page-item ${bankModalCurrentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToBankModalPage(${bankModalCurrentPage - 1})">«</a>
        </li>`;

        let startPage = Math.max(1, bankModalCurrentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

        if (startPage > 1) {
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToBankModalPage(1)">1</a></li>`;
            if (startPage > 2) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let p = startPage; p <= endPage; p++) {
            pagHtml += `<li class="page-item ${p === bankModalCurrentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="goToBankModalPage(${p})">${p}</a>
            </li>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToBankModalPage(${totalPages})">${totalPages}</a></li>`;
        }

        pagHtml += `<li class="page-item ${bankModalCurrentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToBankModalPage(${bankModalCurrentPage + 1})">»</a>
        </li>`;

        pagContainer.innerHTML = pagHtml;
    }

    function goToBankModalPage(page) {
        bankModalCurrentPage = page;
        renderBankModalPagination();
    }

    function filterBankModalTable() {
        bankModalCurrentPage = 1;
        renderBankModalPagination();
    }

    function resetBankModalFilter() {
        if (document.getElementById('modal_filter_bank')) document.getElementById('modal_filter_bank').value = '';
        if (document.getElementById('modal_filter_acc')) document.getElementById('modal_filter_acc').value = '';
        bankModalCurrentPage = 1;
        renderBankModalPagination();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderBankModalPagination();
        document.getElementById('editBankModal')?.addEventListener('shown.bs.modal', () => {
            renderBankModalPagination();
        });

        // Indian Banking Input Formatters
        document.getElementById('account_number')?.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
        document.getElementById('ifsc_code')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });
        document.getElementById('bank_name')?.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection
