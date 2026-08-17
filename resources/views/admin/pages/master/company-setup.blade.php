@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Master</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">Company Setup</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Enterprise Style --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveCompanyRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editCompanyModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deleteCompanyRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearCompanyForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="companySetupForm" onsubmit="event.preventDefault(); saveCompanyRecord();">
                <input type="hidden" id="company_id" value="" />

                {{-- Row 1: Company Name & Contact Person --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        COMPANY NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="company_name" class="form-control sms-input" placeholder="e.g. ASL WALLETS / PAYZONE TECHNOLOGIES" required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        CONTACT PERSON <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="contact_person" class="form-control sms-input" placeholder="Authorized representative..." required />
                    </div>
                </div>

                {{-- Row 2: Contact Number & Support Email --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        CONTACT NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="company_contact" class="form-control sms-input font-monospace" placeholder="10-digit number..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        SUPPORT EMAIL <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="email" id="company_email" class="form-control sms-input" placeholder="support@aslhub.com" required />
                    </div>
                </div>

                {{-- Row 3: Website URL & Status --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        WEBSITE URL
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="url" id="company_website" class="form-control sms-input font-monospace" placeholder="https://www.aslhub.com" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="company_status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="ACTIVE" selected>ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>
                </div>

                {{-- Row 4: PAN & GST --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PAN NUMBER
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="company_pan" class="form-control sms-input font-monospace text-uppercase" placeholder="ABCDE1234F" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        GST NUMBER
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="company_gst" class="form-control sms-input font-monospace text-uppercase" placeholder="22AAAAA0000A1Z5" />
                    </div>
                </div>

                {{-- Row 5: Address --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        ADDRESS
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="company_address" class="form-control sms-input" placeholder="Registered office address..." />
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearCompanyForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit Company Details Modal ── --}}
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT COMPANY DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">COMPANY NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_company_name" class="form-control sms-input" placeholder="" oninput="filterCompanyModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetCompanyModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Company modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle" id="companyModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>COMPANY NAME</th>
                                <th>CONTACT PERSON</th>
                                <th>CONTACT NO</th>
                                <th>SUPPORT EMAIL</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="companyModalTbody">
                            @php
                                $companyList = [
                                    [
                                        'id' => 1,
                                        'name' => 'ASL WALLETS PRIVATE LIMITED',
                                        'person' => 'Nikhil Kumar',
                                        'contact' => '8709305218',
                                        'email' => 'support@aslhub.com',
                                        'website' => 'https://www.aslhub.com',
                                        'status' => 'ACTIVE',
                                        'pan' => 'AABCA1234F',
                                        'gst' => '07AABCA1234F1Z5',
                                        'address' => 'Noida Sector 62, Uttar Pradesh'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'SAHISTA PAY FINTECH',
                                        'person' => 'Sahista Pay',
                                        'contact' => '9800546248',
                                        'email' => 'contact@sahistapay.com',
                                        'website' => 'https://www.sahistapay.com',
                                        'status' => 'ACTIVE',
                                        'pan' => 'BBBCB5678G',
                                        'gst' => '19BBBCB5678G1Z2',
                                        'address' => 'Salt Lake Sector 5, Kolkata'
                                    ]
                                ];
                            @endphp

                            @foreach($companyList as $comp)
                            <tr class="comp-record-row"
                                style="cursor: pointer;"
                                data-id="{{ $comp['id'] }}"
                                data-name="{{ $comp['name'] }}"
                                data-person="{{ $comp['person'] }}"
                                data-contact="{{ $comp['contact'] }}"
                                data-email="{{ $comp['email'] }}"
                                data-website="{{ $comp['website'] }}"
                                data-status="{{ $comp['status'] }}"
                                data-pan="{{ $comp['pan'] }}"
                                data-gst="{{ $comp['gst'] }}"
                                data-address="{{ $comp['address'] }}"
                                onclick="selectCompanyRecord({{ json_encode($comp) }})">
                                <td class="text-center text-muted fw-bold">{{ $comp['id'] }}</td>
                                <td><span class="fw-bold text-dark">{{ $comp['name'] }}</span></td>
                                <td><span class="fw-semibold text-secondary">{{ $comp['person'] }}</span></td>
                                <td><span class="font-monospace text-primary fw-bold">{{ $comp['contact'] }}</span></td>
                                <td><span class="text-secondary">{{ $comp['email'] }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $comp['status'] === 'ACTIVE' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $comp['status'] }}
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
    .comp-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .comp-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Save Company
    function saveCompanyRecord() {
        const name = document.getElementById('company_name').value.trim();
        const person = document.getElementById('contact_person').value.trim();
        const contact = document.getElementById('company_contact').value.trim();
        const email = document.getElementById('company_email').value.trim();

        if (!name) {
            alert('Please enter COMPANY NAME!');
            document.getElementById('company_name').focus();
            return;
        }

        if (!person) {
            alert('Please enter CONTACT PERSON!');
            document.getElementById('contact_person').focus();
            return;
        }

        if (!contact) {
            alert('Please enter CONTACT NO!');
            document.getElementById('company_contact').focus();
            return;
        }

        if (!email) {
            alert('Please enter SUPPORT EMAIL!');
            document.getElementById('company_email').focus();
            return;
        }

        alert(`Company profile "${name}" saved successfully!`);
    }

    // Delete Company
    function deleteCompanyRecord() {
        const name = document.getElementById('company_name').value.trim();
        if (!name) {
            alert('No company selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete company profile "${name}"?`)) {
            clearCompanyForm();
            alert('Company profile deleted successfully!');
        }
    }

    // Clear Form
    function clearCompanyForm() {
        document.getElementById('company_id').value = '';
        document.getElementById('company_name').value = '';
        document.getElementById('contact_person').value = '';
        document.getElementById('company_contact').value = '';
        document.getElementById('company_email').value = '';
        document.getElementById('company_website').value = '';
        document.getElementById('company_status').value = 'ACTIVE';
        document.getElementById('company_pan').value = '';
        document.getElementById('company_gst').value = '';
        document.getElementById('company_address').value = '';
    }

    // Modal Selection
    function selectCompanyRecord(comp) {
        document.getElementById('company_id').value = comp.id;
        document.getElementById('company_name').value = comp.name;
        document.getElementById('contact_person').value = comp.person;
        document.getElementById('company_contact').value = comp.contact;
        document.getElementById('company_email').value = comp.email;
        document.getElementById('company_website').value = comp.website;
        document.getElementById('company_status').value = comp.status || 'ACTIVE';
        document.getElementById('company_pan').value = comp.pan || '';
        document.getElementById('company_gst').value = comp.gst || '';
        document.getElementById('company_address').value = comp.address || '';

        // Close modal
        const modalEl = document.getElementById('editCompanyModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterCompanyModalTable() {
        const filterName = (document.getElementById('modal_filter_company_name').value || '').trim().toLowerCase();

        document.querySelectorAll('#companyModalTbody tr.comp-record-row').forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();

            if (!filterName || name.includes(filterName)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetCompanyModalFilter() {
        document.getElementById('modal_filter_company_name').value = '';
        document.querySelectorAll('#companyModalTbody tr.comp-record-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
