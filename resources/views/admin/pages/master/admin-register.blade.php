@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Master</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">Admin Register</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Enterprise Style --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveAdminRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deleteAdminRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearAdminForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="adminRegisterForm" onsubmit="event.preventDefault(); saveAdminRecord();">
                <input type="hidden" id="admin_id" value="" />

                {{-- Row 1: Admin Name & Mobile --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        ADMIN NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="admin_name" class="form-control sms-input" placeholder="Full name..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        MOBILE NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="admin_mobile" class="form-control sms-input font-monospace" placeholder="10-digit mobile number..." required />
                    </div>
                </div>

                {{-- Row 2: Login ID & Email --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        LOGIN ID <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="admin_login_id" class="form-control sms-input font-monospace" placeholder="Username / Login ID..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        EMAIL ID
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="email" id="admin_email" class="form-control sms-input" placeholder="admin@domain.com" />
                    </div>
                </div>

                {{-- Row 3: Status & Role --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="admin_status" class="form-select sms-input" required>
                            <option value="ACTIVE" selected>ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        ROLE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="admin_role" class="form-select sms-input" required>
                            <option value="ADMIN" selected>ADMIN</option>
                            <option value="SUPERADMIN">SUPERADMIN</option>
                            <option value="MANAGER">MANAGER</option>
                        </select>
                    </div>
                </div>

                {{-- Row 4: Password --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PASSWORD <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="password" id="admin_password" class="form-control sms-input" placeholder="Enter secure password..." required />
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearAdminForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit Admin Details Modal ── --}}
<div class="modal fade" id="editAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT ADMIN DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">ADMIN NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_admin_name" class="form-control sms-input" placeholder="" oninput="filterAdminModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">MOBILE NO</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_admin_mob" class="form-control sms-input" placeholder="" oninput="filterAdminModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetAdminModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Admin modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle" id="adminModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>ADMIN NAME</th>
                                <th>MOBILE NO</th>
                                <th>LOGIN ID</th>
                                <th>EMAIL</th>
                                <th class="text-center">STATUS</th>
                                <th>ROLE</th>
                                <th>CREATED DATE</th>
                            </tr>
                        </thead>
                        <tbody id="adminModalTbody">
                            @php
                                $adminRecords = [
                                    [
                                        'id' => 1,
                                        'name' => 'PAY ZONE',
                                        'mobile' => '6295654606',
                                        'login_id' => 'admin',
                                        'email' => 'admin@payzones.net',
                                        'status' => 'ACTIVE',
                                        'role' => 'ADMIN',
                                        'date' => '2026-08-14'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'ASL SYSTEM ADMIN',
                                        'mobile' => '8709305218',
                                        'login_id' => 'asladmin',
                                        'email' => 'tech@aslhub.com',
                                        'status' => 'ACTIVE',
                                        'role' => 'SUPERADMIN',
                                        'date' => '2026-08-01'
                                    ]
                                ];
                            @endphp

                            @foreach($adminRecords as $record)
                            <tr class="admin-record-row"
                                style="cursor: pointer;"
                                data-id="{{ $record['id'] }}"
                                data-name="{{ $record['name'] }}"
                                data-mobile="{{ $record['mobile'] }}"
                                data-login="{{ $record['login_id'] }}"
                                data-email="{{ $record['email'] }}"
                                data-status="{{ $record['status'] }}"
                                data-role="{{ $record['role'] }}"
                                onclick="selectAdminRecord({{ json_encode($record) }})">
                                <td class="text-center text-muted fw-bold">{{ $record['id'] }}</td>
                                <td><span class="fw-bold text-dark">{{ $record['name'] }}</span></td>
                                <td><span class="font-monospace text-primary fw-bold">{{ $record['mobile'] }}</span></td>
                                <td><span class="badge bg-label-secondary font-monospace">{{ $record['login_id'] }}</span></td>
                                <td><span class="text-secondary">{{ $record['email'] }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $record['status'] === 'ACTIVE' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $record['status'] }}
                                    </span>
                                </td>
                                <td><span class="badge bg-label-info">{{ $record['role'] }}</span></td>
                                <td><span class="font-monospace text-muted">{{ $record['date'] }}</span></td>
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
    .admin-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .admin-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Save Admin
    function saveAdminRecord() {
        const name = document.getElementById('admin_name').value.trim();
        const mobile = document.getElementById('admin_mobile').value.trim();
        const login = document.getElementById('admin_login_id').value.trim();

        if (!name) {
            alert('Please enter ADMIN NAME!');
            document.getElementById('admin_name').focus();
            return;
        }

        if (!mobile) {
            alert('Please enter MOBILE NO!');
            document.getElementById('admin_mobile').focus();
            return;
        }

        if (!login) {
            alert('Please enter LOGIN ID!');
            document.getElementById('admin_login_id').focus();
            return;
        }

        alert(`Admin user "${name}" saved successfully!`);
    }

    // Delete Admin
    function deleteAdminRecord() {
        const name = document.getElementById('admin_name').value.trim();
        if (!name) {
            alert('No admin selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete admin "${name}"?`)) {
            clearAdminForm();
            alert('Admin user deleted successfully!');
        }
    }

    // Clear Form
    function clearAdminForm() {
        document.getElementById('admin_id').value = '';
        document.getElementById('admin_name').value = '';
        document.getElementById('admin_mobile').value = '';
        document.getElementById('admin_login_id').value = '';
        document.getElementById('admin_email').value = '';
        document.getElementById('admin_status').value = 'ACTIVE';
        document.getElementById('admin_role').value = 'ADMIN';
        document.getElementById('admin_password').value = '';
    }

    // Modal Selection
    function selectAdminRecord(rec) {
        document.getElementById('admin_id').value = rec.id;
        document.getElementById('admin_name').value = rec.name;
        document.getElementById('admin_mobile').value = rec.mobile;
        document.getElementById('admin_login_id').value = rec.login_id;
        document.getElementById('admin_email').value = rec.email;
        document.getElementById('admin_status').value = rec.status || 'ACTIVE';
        document.getElementById('admin_role').value = rec.role || 'ADMIN';
        document.getElementById('admin_password').value = '********';

        // Close modal
        const modalEl = document.getElementById('editAdminModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterAdminModalTable() {
        const filterName = (document.getElementById('modal_filter_admin_name').value || '').trim().toLowerCase();
        const filterMob = (document.getElementById('modal_filter_admin_mob').value || '').trim().toLowerCase();

        document.querySelectorAll('#adminModalTbody tr.admin-record-row').forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();
            const mob = (row.dataset.mobile || '').toLowerCase();

            let match = true;
            if (filterName && !name.includes(filterName)) match = false;
            if (filterMob && !mob.includes(filterMob)) match = false;

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetAdminModalFilter() {
        document.getElementById('modal_filter_admin_name').value = '';
        document.getElementById('modal_filter_admin_mob').value = '';
        document.querySelectorAll('#adminModalTbody tr.admin-record-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
