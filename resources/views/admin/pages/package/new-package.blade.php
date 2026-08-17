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
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="savePackageRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editPackageModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deletePackageRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearPackageForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="packageRegisterForm" onsubmit="event.preventDefault(); savePackageRecord();">
                <input type="hidden" id="package_id" value="" />

                {{-- Row 1: Package Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PACKAGE NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="package_name" class="form-control sms-input" placeholder="e.g. PREPAID PLAN API / BULK SMS ROUTE" required />
                    </div>
                </div>

                {{-- Row 2: Per SMS Charges & Per WH Charges --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PER SMS CHARGES <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="number" step="0.0001" id="per_sms_charges" class="form-control sms-input font-monospace" placeholder="0.1000" required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PER WH CHARGES <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="number" step="0.0001" id="per_wh_charges" class="form-control sms-input font-monospace" placeholder="0.0000" required />
                    </div>
                </div>

                {{-- Row 3: Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="package_status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="ACTIVE" selected>ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
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

{{-- ── Edit Package Details Modal ── --}}
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
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">PACKAGE NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_pkg_name" class="form-control sms-input" placeholder="" oninput="filterPackageModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetPackageModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Package modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle" id="packageModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>USER NAME</th>
                                <th>PACKAGE NAME</th>
                                <th class="text-end">PER SMS CHARGES</th>
                                <th class="text-end">PER WH CHARGES</th>
                                <th class="text-center">STATUS</th>
                                <th>INSERT DATE</th>
                            </tr>
                        </thead>
                        <tbody id="packageModalTbody">
                            @php
                                $packageList = [
                                    [
                                        'id' => 1,
                                        'user' => 'ASL WALLETS',
                                        'name' => 'PREPAID PLAN API',
                                        'sms_cost' => '0.1000',
                                        'wh_cost' => '0.0000',
                                        'status' => 'ACTIVE',
                                        'date' => '04/05/2026 12:10:46 PM'
                                    ],
                                    [
                                        'id' => 2,
                                        'user' => 'sahistapay',
                                        'name' => 'STANDARD API',
                                        'sms_cost' => '0.1200',
                                        'wh_cost' => '0.0000',
                                        'status' => 'ACTIVE',
                                        'date' => '10/05/2026 03:20:10 PM'
                                    ]
                                ];
                            @endphp

                            @foreach($packageList as $pkg)
                            <tr class="pkg-record-row"
                                style="cursor: pointer;"
                                data-id="{{ $pkg['id'] }}"
                                data-name="{{ $pkg['name'] }}"
                                data-sms="{{ $pkg['sms_cost'] }}"
                                data-wh="{{ $pkg['wh_cost'] }}"
                                data-status="{{ $pkg['status'] }}"
                                onclick="selectPackageRecord({{ json_encode($pkg) }})">
                                <td class="text-center text-muted fw-bold">{{ $pkg['id'] }}</td>
                                <td><span class="fw-semibold text-secondary">{{ $pkg['user'] }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $pkg['name'] }}</span></td>
                                <td class="text-end font-monospace fw-bold text-primary">₹ {{ $pkg['sms_cost'] }}</td>
                                <td class="text-end font-monospace text-muted">₹ {{ $pkg['wh_cost'] }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $pkg['status'] === 'ACTIVE' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $pkg['status'] }}
                                    </span>
                                </td>
                                <td><span class="font-monospace text-muted">{{ $pkg['date'] }}</span></td>
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
    .pkg-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .pkg-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Save Package
    function savePackageRecord() {
        const name = document.getElementById('package_name').value.trim();
        const sms = document.getElementById('per_sms_charges').value;
        const wh = document.getElementById('per_wh_charges').value;

        if (!name) {
            alert('Please enter PACKAGE NAME!');
            document.getElementById('package_name').focus();
            return;
        }

        if (sms === '' || parseFloat(sms) < 0) {
            alert('Please enter valid PER SMS CHARGES!');
            document.getElementById('per_sms_charges').focus();
            return;
        }

        alert(`Package plan "${name}" saved successfully!`);
    }

    // Delete Package
    function deletePackageRecord() {
        const name = document.getElementById('package_name').value.trim();
        if (!name) {
            alert('No package selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete package "${name}"?`)) {
            clearPackageForm();
            alert('Package deleted successfully!');
        }
    }

    // Clear Form
    function clearPackageForm() {
        document.getElementById('package_id').value = '';
        document.getElementById('package_name').value = '';
        document.getElementById('per_sms_charges').value = '';
        document.getElementById('per_wh_charges').value = '';
        document.getElementById('package_status').value = 'ACTIVE';
    }

    // Modal Selection
    function selectPackageRecord(pkg) {
        document.getElementById('package_id').value = pkg.id;
        document.getElementById('package_name').value = pkg.name;
        document.getElementById('per_sms_charges').value = pkg.sms_cost;
        document.getElementById('per_wh_charges').value = pkg.wh_cost;
        document.getElementById('package_status').value = pkg.status || 'ACTIVE';

        // Close modal
        const modalEl = document.getElementById('editPackageModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterPackageModalTable() {
        const filterName = (document.getElementById('modal_filter_pkg_name').value || '').trim().toLowerCase();

        document.querySelectorAll('#packageModalTbody tr.pkg-record-row').forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();

            if (!filterName || name.includes(filterName)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetPackageModalFilter() {
        document.getElementById('modal_filter_pkg_name').value = '';
        document.querySelectorAll('#packageModalTbody tr.pkg-record-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
