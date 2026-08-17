@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Master</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">User Register</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Enterprise Style --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveUserRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editUserModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deleteUserRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearUserForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="userRegisterForm" onsubmit="event.preventDefault(); saveUserRecord();">
                <input type="hidden" id="user_id" value="" />

                {{-- Row 1: User Type & Package --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        USER TYPE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_type" class="form-select sms-input" required>
                            <option value="RETAILER" selected>RETAILER</option>
                            <option value="DISTRIBUTOR">DISTRIBUTOR</option>
                            <option value="MASTER DISTRIBUTOR">MASTER DISTRIBUTOR</option>
                            <option value="API USER">API USER</option>
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PACKAGE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_package" class="form-select sms-input" required>
                            <option value="PREPAID PLAN API" selected>PREPAID PLAN API</option>
                            <option value="ENTERPRISE ROUTE">ENTERPRISE ROUTE</option>
                            <option value="STANDARD API">STANDARD API</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2: Company Name & User Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        COMPANY NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_company" class="form-control sms-input" placeholder="Business name..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        USER NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_name" class="form-control sms-input" placeholder="Full legal name..." required />
                    </div>
                </div>

                {{-- Row 3: Contact Number & Email ID --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        CONTACT NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_contact" class="form-control sms-input font-monospace" placeholder="10-digit number..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        EMAIL ID <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="email" id="user_email" class="form-control sms-input" placeholder="user@domain.com" required />
                    </div>
                </div>

                {{-- Row 4: Password & Status --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PASSWORD <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="password" id="user_password" class="form-control sms-input" placeholder="Enter secure password..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_status" class="form-select sms-input" required>
                            <option value="ACTIVE" selected>ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>
                </div>

                {{-- Row 5: PAN No & GST No --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PAN NUMBER
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_pan" class="form-control sms-input font-monospace text-uppercase" placeholder="ABCDE1234F" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        GST NUMBER
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_gst" class="form-control sms-input font-monospace text-uppercase" placeholder="22AAAAA0000A1Z5" />
                    </div>
                </div>

                {{-- Row 6: Callback URL & IP Address --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        CALLBACK URL
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="url" id="user_callback" class="form-control sms-input font-monospace" placeholder="https://api.yourdomain.com/webhook" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        IP ADDRESS
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_ip" class="form-control sms-input font-monospace" placeholder="e.g. 103.21.244.0" />
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearUserForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit User Details Modal ── --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT USER DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">USER NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_username" class="form-control sms-input" placeholder="" oninput="filterUserModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">CONTACT NO</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_usercontact" class="form-control sms-input" placeholder="" oninput="filterUserModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetUserModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="User modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle" id="userModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>REG NO</th>
                                <th>USER NAME</th>
                                <th>COMPANY NAME</th>
                                <th>USER TYPE</th>
                                <th>CONTACT NO</th>
                                <th>PACKAGE</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="userModalTbody">
                            @php
                                $usersList = [
                                    [
                                        'id' => 1,
                                        'reg_no' => '3902',
                                        'name' => 'Nikhil Kumar',
                                        'company' => 'ASL WALLETS',
                                        'type' => 'API USER',
                                        'contact' => '8709305218',
                                        'email' => 'tech@aslhub.com',
                                        'package' => 'PREPAID PLAN API',
                                        'status' => 'ACTIVE'
                                    ],
                                    [
                                        'id' => 2,
                                        'reg_no' => '3905',
                                        'name' => 'sahista pay',
                                        'company' => 'sahistapay',
                                        'type' => 'RETAILER',
                                        'contact' => '9800546248',
                                        'email' => 'sahista@payzone.net',
                                        'package' => 'PREPAID PLAN API',
                                        'status' => 'ACTIVE'
                                    ],
                                    [
                                        'id' => 3,
                                        'reg_no' => '3903',
                                        'name' => 'GAURAV KUMAR',
                                        'company' => 'GAURAV ENTERPRISES',
                                        'type' => 'DISTRIBUTOR',
                                        'contact' => '8348920759',
                                        'email' => 'gaurav@domain.com',
                                        'package' => 'STANDARD API',
                                        'status' => 'ACTIVE'
                                    ]
                                ];
                            @endphp

                            @foreach($usersList as $user)
                            <tr class="user-record-row"
                                style="cursor: pointer;"
                                data-id="{{ $user['id'] }}"
                                data-name="{{ $user['name'] }}"
                                data-company="{{ $user['company'] }}"
                                data-contact="{{ $user['contact'] }}"
                                data-email="{{ $user['email'] }}"
                                data-type="{{ $user['type'] }}"
                                data-package="{{ $user['package'] }}"
                                data-status="{{ $user['status'] }}"
                                onclick="selectUserRecord({{ json_encode($user) }})">
                                <td class="text-center text-muted fw-bold">{{ $user['id'] }}</td>
                                <td><span class="font-monospace text-primary fw-bold">{{ $user['reg_no'] }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $user['name'] }}</span></td>
                                <td><span class="fw-semibold text-secondary">{{ $user['company'] }}</span></td>
                                <td><span class="badge bg-label-info">{{ $user['type'] }}</span></td>
                                <td><span class="font-monospace">{{ $user['contact'] }}</span></td>
                                <td><span class="badge bg-label-primary">{{ $user['package'] }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $user['status'] === 'ACTIVE' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user['status'] }}
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
    .user-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .user-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Save User
    function saveUserRecord() {
        const name = document.getElementById('user_name').value.trim();
        const company = document.getElementById('user_company').value.trim();
        const contact = document.getElementById('user_contact').value.trim();

        if (!company) {
            alert('Please enter COMPANY NAME!');
            document.getElementById('user_company').focus();
            return;
        }

        if (!name) {
            alert('Please enter USER NAME!');
            document.getElementById('user_name').focus();
            return;
        }

        if (!contact) {
            alert('Please enter CONTACT NO!');
            document.getElementById('user_contact').focus();
            return;
        }

        alert(`User account for "${name}" (${company}) saved successfully!`);
    }

    // Delete User
    function deleteUserRecord() {
        const name = document.getElementById('user_name').value.trim();
        if (!name) {
            alert('No user selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete user "${name}"?`)) {
            clearUserForm();
            alert('User deleted successfully!');
        }
    }

    // Clear Form
    function clearUserForm() {
        document.getElementById('user_id').value = '';
        document.getElementById('user_name').value = '';
        document.getElementById('user_company').value = '';
        document.getElementById('user_contact').value = '';
        document.getElementById('user_email').value = '';
        document.getElementById('user_type').value = 'RETAILER';
        document.getElementById('user_package').value = 'PREPAID PLAN API';
        document.getElementById('user_status').value = 'ACTIVE';
        document.getElementById('user_password').value = '';
        document.getElementById('user_pan').value = '';
        document.getElementById('user_gst').value = '';
        document.getElementById('user_callback').value = '';
        document.getElementById('user_ip').value = '';
    }

    // Modal Selection
    function selectUserRecord(user) {
        document.getElementById('user_id').value = user.id;
        document.getElementById('user_name').value = user.name;
        document.getElementById('user_company').value = user.company;
        document.getElementById('user_contact').value = user.contact;
        document.getElementById('user_email').value = user.email;
        document.getElementById('user_type').value = user.type || 'RETAILER';
        document.getElementById('user_package').value = user.package || 'PREPAID PLAN API';
        document.getElementById('user_status').value = user.status || 'ACTIVE';
        document.getElementById('user_password').value = '********';

        // Close modal
        const modalEl = document.getElementById('editUserModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterUserModalTable() {
        const filterName = (document.getElementById('modal_filter_username').value || '').trim().toLowerCase();
        const filterContact = (document.getElementById('modal_filter_usercontact').value || '').trim().toLowerCase();

        document.querySelectorAll('#userModalTbody tr.user-record-row').forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();
            const contact = (row.dataset.contact || '').toLowerCase();

            let match = true;
            if (filterName && !name.includes(filterName)) match = false;
            if (filterContact && !contact.includes(filterContact)) match = false;

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetUserModalFilter() {
        document.getElementById('modal_filter_username').value = '';
        document.getElementById('modal_filter_usercontact').value = '';
        document.querySelectorAll('#userModalTbody tr.user-record-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
