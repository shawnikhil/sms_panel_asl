@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Proper Spacing ── --}}
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
        
        {{-- Top Action Bar matching Enterprise Style --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveBankRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editBankModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deleteBankRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearBankForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="bankRegisterForm" onsubmit="event.preventDefault(); saveBankRecord();">
                <input type="hidden" id="bank_id" value="" />

                {{-- Row 1: Bank Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        BANK NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="bank_name" class="form-control sms-input" placeholder="e.g. HDFC BANK / STATE BANK OF INDIA" required />
                    </div>
                </div>

                {{-- Row 2: Account Number & IFSC Code --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        ACCOUNT NUMBER <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="account_number" class="form-control sms-input font-monospace" placeholder="Enter account number..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        IFSC CODE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="ifsc_code" class="form-control sms-input font-monospace text-uppercase" placeholder="e.g. HDFC0001234" required />
                    </div>
                </div>

                {{-- Row 3: Branch Name & Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        BRANCH NAME
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="branch_name" class="form-control sms-input" placeholder="e.g. Main Branch, Sector 62" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="bank_status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="Y" selected>Y</option>
                            <option value="N">N</option>
                        </select>
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
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
                                <input type="text" id="modal_filter_bank" class="form-control sms-input" placeholder="" oninput="filterBankModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">ACCOUNT NO</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_acc" class="form-control sms-input" placeholder="" oninput="filterBankModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetBankModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Bank modal navigation">
                            <ul class="pagination pagination-sm mb-0 justify-content-center">
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">»</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                {{-- Table Component inside Modal --}}
                <div class="table-responsive text-nowrap border rounded" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="bankModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>BANK NAME</th>
                                <th>ACCOUNT NUMBER</th>
                                <th>IFSC CODE</th>
                                <th>BRANCH NAME</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="bankModalTbody">
                            @php
                                $bankRecords = [
                                    [
                                        'id' => 1,
                                        'name' => 'HDFC BANK LIMITED',
                                        'acc' => '50200048291044',
                                        'ifsc' => 'HDFC0000128',
                                        'branch' => 'Noida Sector 18',
                                        'status' => 'Y'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'ICICI BANK',
                                        'acc' => '002105018392',
                                        'ifsc' => 'ICIC0000021',
                                        'branch' => 'Connaught Place New Delhi',
                                        'status' => 'Y'
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'STATE BANK OF INDIA',
                                        'acc' => '38491029384',
                                        'ifsc' => 'SBIN0004123',
                                        'branch' => 'Salt Lake Sector 5',
                                        'status' => 'N'
                                    ]
                                ];
                            @endphp

                            @foreach($bankRecords as $record)
                            <tr class="bank-record-row"
                                style="cursor: pointer;"
                                data-id="{{ $record['id'] }}"
                                data-name="{{ $record['name'] }}"
                                data-acc="{{ $record['acc'] }}"
                                data-ifsc="{{ $record['ifsc'] }}"
                                data-branch="{{ $record['branch'] }}"
                                data-status="{{ $record['status'] }}"
                                onclick="selectBankRecord({{ json_encode($record) }})">
                                <td class="text-center text-muted fw-bold">{{ $record['id'] }}</td>
                                <td><span class="fw-bold text-dark">{{ $record['name'] }}</span></td>
                                <td><span class="font-monospace text-primary fw-bold">{{ $record['acc'] }}</span></td>
                                <td><span class="badge bg-label-info font-monospace">{{ $record['ifsc'] }}</span></td>
                                <td><span class="text-secondary">{{ $record['branch'] }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $record['status'] === 'Y' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $record['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
    .bank-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .bank-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Save Bank
    function saveBankRecord() {
        const name = document.getElementById('bank_name').value.trim();
        const acc = document.getElementById('account_number').value.trim();
        const ifsc = document.getElementById('ifsc_code').value.trim();

        if (!name) {
            alert('Please enter BANK NAME!');
            document.getElementById('bank_name').focus();
            return;
        }

        if (!acc) {
            alert('Please enter ACCOUNT NUMBER!');
            document.getElementById('account_number').focus();
            return;
        }

        if (!ifsc) {
            alert('Please enter IFSC CODE!');
            document.getElementById('ifsc_code').focus();
            return;
        }

        alert(`Bank record "${name}" saved successfully!`);
    }

    // Delete Bank
    function deleteBankRecord() {
        const name = document.getElementById('bank_name').value.trim();
        if (!name) {
            alert('No bank record selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete bank record "${name}"?`)) {
            clearBankForm();
            alert('Bank record deleted successfully!');
        }
    }

    // Clear Form
    function clearBankForm() {
        document.getElementById('bank_id').value = '';
        document.getElementById('bank_name').value = '';
        document.getElementById('account_number').value = '';
        document.getElementById('ifsc_code').value = '';
        document.getElementById('branch_name').value = '';
        document.getElementById('bank_status').value = 'Y';
    }

    // Modal Selection
    function selectBankRecord(rec) {
        document.getElementById('bank_id').value = rec.id;
        document.getElementById('bank_name').value = rec.name;
        document.getElementById('account_number').value = rec.acc;
        document.getElementById('ifsc_code').value = rec.ifsc;
        document.getElementById('branch_name').value = rec.branch;
        document.getElementById('bank_status').value = rec.status || 'Y';

        // Close modal
        const modalEl = document.getElementById('editBankModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterBankModalTable() {
        const filterName = (document.getElementById('modal_filter_bank').value || '').trim().toLowerCase();
        const filterAcc = (document.getElementById('modal_filter_acc').value || '').trim().toLowerCase();

        document.querySelectorAll('#bankModalTbody tr.bank-record-row').forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();
            const acc = (row.dataset.acc || '').toLowerCase();

            let match = true;
            if (filterName && !name.includes(filterName)) match = false;
            if (filterAcc && !acc.includes(filterAcc)) match = false;

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetBankModalFilter() {
        document.getElementById('modal_filter_bank').value = '';
        document.getElementById('modal_filter_acc').value = '';
        document.querySelectorAll('#bankModalTbody tr.bank-record-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
