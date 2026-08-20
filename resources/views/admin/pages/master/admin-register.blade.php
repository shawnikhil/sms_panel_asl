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
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveAdminRecord()" id="topSaveBtn">
                <i class="bx bx-check" id="topSaveIcon"></i> <span id="saveBtnText">SAVE</span>
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

        {{-- Dynamic Alert Notice Container --}}
        <div id="actionAlertBox" class="px-4 pt-3 d-none"></div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            @php
                $adminFullName = '';
                if (isset($admin)) {
                    $adminFullName = trim(($admin->admin_fname ?? '') . ' ' . ($admin->admin_lname ?? ''));
                    if (empty($adminFullName)) {
                        $adminFullName = $admin->admin_username ?? '';
                    }
                }
                $adminStatus = isset($admin) && in_array(strtoupper((string)($admin->status ?? 'ACTIVE')), ['0', 'INACTIVE', 'IN-ACTIVE'], true) ? 'INACTIVE' : 'ACTIVE';
            @endphp

            <form id="adminRegisterForm" onsubmit="event.preventDefault(); saveAdminRecord();">
                @csrf
                <input type="hidden" id="admin_id" name="admin_id" value="{{ $admin->admin_id ?? '' }}" />

                {{-- Row 1: Admin Name & Mobile --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        ADMIN NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="admin_name" name="admin_name" class="form-control sms-input" value="{{ $adminFullName }}" placeholder="Full name..." required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        MOBILE NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="admin_mobile" name="admin_mobile" class="form-control sms-input font-monospace" value="{{ $admin->mob_one ?? '' }}" placeholder="10-digit mobile number..." maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required />
                    </div>
                </div>

                {{-- Row 2: Login ID & Email --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        LOGIN ID <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="admin_login_id" name="admin_login_id" class="form-control sms-input font-monospace bg-light" value="{{ $admin->admin_username ?? '' }}" placeholder="Username / Login ID..." readonly style="cursor: not-allowed;" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        EMAIL ID
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="email" id="admin_email" name="admin_email" class="form-control sms-input" value="{{ $admin->email_id ?? '' }}" placeholder="admin@domain.com" />
                    </div>
                </div>

                {{-- Row 3: Status & Password --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="admin_status" name="admin_status" class="form-select sms-input" required>
                            <option value="1" {{ $adminStatus === 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                            <option value="0" {{ $adminStatus === 'INACTIVE' ? 'selected' : '' }}>INACTIVE</option>
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PASSWORD <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="password" id="admin_password" name="admin_password" class="form-control sms-input" placeholder="Leave blank to keep existing password..."/>
                        <small class="text-muted" id="pwdHelp" style="font-size: 0.70rem;">Leave blank to keep existing password, or enter new password to update.</small>
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3" id="bottomSubmitBtn">
                                <i class="bx bx-check"></i> <span id="bottomBtnText">SAVE</span>
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
                    ADMIN DETAILS
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 bg-white">
                {{-- Table Component inside Modal --}}
                <div class="table-responsive text-nowrap border rounded" style="max-height: 420px; overflow: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="adminModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>ADMIN NAME</th>
                                <th>MOBILE NO</th>
                                <th>LOGIN ID</th>
                                <th>EMAIL</th>
                                <th class="text-center">STATUS</th>
                                <th>CREATED DATE</th>
                            </tr>
                        </thead>
                        <tbody id="adminModalTbody">
                            @if(isset($admin) && $admin)
                                @php
                                    $formattedRecord = [
                                        'id' => $admin->admin_id,
                                        'name' => $adminFullName,
                                        'fname' => $admin->admin_fname,
                                        'lname' => $admin->admin_lname,
                                        'mobile' => $admin->mob_one ?? '',
                                        'login_id' => $admin->admin_username ?? '',
                                        'email' => $admin->email_id ?? '',
                                        'status' => $adminStatus,
                                        'date' => !empty($admin->insert_date) ? substr($admin->insert_date, 0, 10) : date('Y-m-d'),
                                    ];
                                @endphp
                                <tr class="admin-record-row"
                                    style="cursor: pointer;"
                                    data-id="{{ $formattedRecord['id'] }}"
                                    data-name="{{ $formattedRecord['name'] }}"
                                    data-mobile="{{ $formattedRecord['mobile'] }}"
                                    data-login="{{ $formattedRecord['login_id'] }}"
                                    data-email="{{ $formattedRecord['email'] }}"
                                    data-status="{{ $formattedRecord['status'] }}"
                                    onclick='selectAdminRecord(@json($formattedRecord))'>
                                    <td class="text-center text-muted fw-bold">{{ $loop->iteration ?? 1 }}</td>
                                    <td><span class="fw-bold text-dark">{{ $formattedRecord['name'] }}</span></td>
                                    <td><span class="font-monospace text-primary fw-bold">{{ $formattedRecord['mobile'] }}</span></td>
                                    <td><span class="badge bg-label-secondary font-monospace">{{ $formattedRecord['login_id'] }}</span></td>
                                    <td><span class="text-secondary">{{ $formattedRecord['email'] ?: '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge {{ $formattedRecord['status'] === 'ACTIVE' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $formattedRecord['status'] }}
                                        </span>
                                    </td>
                                    <td><span class="font-monospace text-muted">{{ $formattedRecord['date'] }}</span></td>
                                </tr>
                            @else
                                <tr id="noAdminRow">
                                    <td colspan="7" class="text-center text-muted py-4">No admin record found.</td>
                                </tr>
                            @endif
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
@endsection

{{-- ── Page Styles ── --}}
@section('style')
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

    /* Sticky Table Header inside Modal */
    #adminModalTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8fafc !important;
        box-shadow: inset 0 -1px 0 #dee2e6, inset 0 1px 0 #dee2e6;
    }
    html.dark #adminModalTable thead th {
        background-color: #1e293b !important;
        box-shadow: inset 0 -1px 0 #334155, inset 0 1px 0 #334155;
    }

    /* Toastr Custom High-Contrast & Solid Styling */
    #toast-container {
        z-index: 999999 !important;
    }
    #toast-container > div {
        opacity: 1 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25) !important;
        border-radius: 8px !important;
        padding: 14px 14px 14px 50px !important;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
        font-size: 0.85rem !important;
    }
    #toast-container > .toast-success {
        background-color: #16a34a !important;
        color: #ffffff !important;
        border-left: 5px solid #14532d !important;
    }
    #toast-container > .toast-error {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        border-left: 5px solid #7f1d1d !important;
    }
    #toast-container > .toast-warning {
        background-color: #d97706 !important;
        color: #ffffff !important;
        border-left: 5px solid #78350f !important;
    }
    #toast-container > .toast-info {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-left: 5px solid #1e3a8a !important;
    }
    #toast-container .toast-title {
        font-weight: 700 !important;
        font-size: 0.875rem !important;
        margin-bottom: 3px !important;
        color: #ffffff !important;
    }
    #toast-container .toast-message {
        font-weight: 500 !important;
        color: #ffffff !important;
        line-height: 1.4 !important;
    }
    #toast-container .toast-close-button {
        color: #ffffff !important;
        text-shadow: none !important;
        opacity: 0.9 !important;
        font-size: 1.2rem !important;
    }
    #toast-container .toast-progress {
        background-color: rgba(255, 255, 255, 0.5) !important;
        opacity: 0.9 !important;
    }
</style>
@endsection

{{-- ── Page Scripts ── --}}
@section('scripts')
<script>
    const ACTION_URL = "{{ route('admin.master.admin_register.action') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    // Initial default admin data
    const initialAdminData = {
        id: "{{ $admin->admin_id ?? '' }}",
        name: "{{ addslashes($adminFullName) }}",
        mobile: "{{ $admin->mob_one ?? '' }}",
        login_id: "{{ $admin->admin_username ?? '' }}",
        email: "{{ $admin->email_id ?? '' }}",
        status: "{{ $adminStatus === 'ACTIVE' ? '1' : '0' }}",
    };

    // Configure Toastr Notification Defaults
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "4000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
    }

    // Show Notification via Toastr
    function showAlertNotice(type, message, title = '', focusFieldId = '') {
        if (typeof toastr !== 'undefined') {
            if (type === 'success') {
                toastr.success(message, title || 'Success');
            } else if (type === 'warning') {
                toastr.warning(message, title || 'Notice');
            } else if (type === 'info') {
                toastr.info(message, title || 'Info');
            } else {
                toastr.error(message, title || 'Error');
            }
        } else {
            alert(message);
        }

        if (focusFieldId) {
            const targetField = document.getElementById(focusFieldId);
            if (targetField) {
                targetField.focus();
            }
        }
    }

    // Save Admin
    async function saveAdminRecord() {
        const adminId = document.getElementById('admin_id').value.trim();
        const name    = document.getElementById('admin_name').value.trim();
        const mobile  = document.getElementById('admin_mobile').value.trim();
        const login   = document.getElementById('admin_login_id').value.trim();
        const email   = document.getElementById('admin_email').value.trim();
        const status  = document.getElementById('admin_status').value;
        const pass    = document.getElementById('admin_password').value;

        if (!name) {
            showAlertNotice('danger', 'Please enter ADMIN NAME!', 'Validation Error', 'admin_name');
            return;
        }

        if (!mobile) {
            showAlertNotice('danger', 'Please enter MOBILE NO!', 'Validation Error', 'admin_mobile');
            return;
        }

        if (!/^\d{10}$/.test(mobile)) {
            showAlertNotice('danger', 'Mobile number must be exactly 10 digits!', 'Validation Error', 'admin_mobile');
            return;
        }

        if (!login) {
            showAlertNotice('danger', 'Please enter LOGIN ID!', 'Validation Error', 'admin_login_id');
            return;
        }

        if (!adminId && (!pass || !pass.trim())) {
            showAlertNotice('danger', 'Please enter PASSWORD!', 'Validation Error', 'admin_password');
            return;
        }

        const topSaveBtn = document.getElementById('topSaveBtn');
        const bottomSubmitBtn = document.getElementById('bottomSubmitBtn');
        const saveBtnText = document.getElementById('saveBtnText');
        const bottomBtnText = document.getElementById('bottomBtnText');

        // Disable buttons and show loading state
        if (topSaveBtn) topSaveBtn.disabled = true;
        if (bottomSubmitBtn) bottomSubmitBtn.disabled = true;
        if (saveBtnText) saveBtnText.innerText = 'SAVING...';
        if (bottomBtnText) bottomBtnText.innerText = 'SAVING...';

        const payload = {
            _token: CSRF_TOKEN,
            admin_id: adminId,
            admin_name: name,
            admin_mobile: mobile,
            admin_login_id: login,
            admin_email: email,
            admin_status: status,
            admin_password: pass,
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
                showAlertNotice('success', data.message || 'Admin updated successfully!');
                document.getElementById('admin_password').value = '';
                
                if (data.admin) {
                    const rawSt = (data.admin.status || '1').toString();
                    const normalizedSt = (rawSt === '0' || rawSt === 'INACTIVE') ? '0' : '1';

                    initialAdminData.id = data.admin.admin_id;
                    initialAdminData.name = (data.admin.admin_fname + ' ' + (data.admin.admin_lname || '')).trim() || data.admin.admin_username;
                    initialAdminData.mobile = data.admin.mob_one || '';
                    initialAdminData.login_id = data.admin.admin_username || '';
                    initialAdminData.email = data.admin.email_id || '';
                    initialAdminData.status = normalizedSt;
                    
                    renderSingleAdminModal(data.admin);
                }
            } else {
                showAlertNotice('danger', data.message || 'Failed to save admin.');
            }
        } catch (error) {
            console.error('Save error:', error);
            showAlertNotice('danger', 'A server error occurred. Please try again.');
        } finally {
            // Re-enable buttons after response is received
            if (topSaveBtn) topSaveBtn.disabled = false;
            if (bottomSubmitBtn) bottomSubmitBtn.disabled = false;
            if (saveBtnText) saveBtnText.innerText = 'SAVE';
            if (bottomBtnText) bottomBtnText.innerText = 'SAVE';
        }
    }

    // Delete Admin
    async function deleteAdminRecord() {
        const adminId = document.getElementById('admin_id').value.trim();
        const name    = document.getElementById('admin_name').value.trim();

        if (!adminId) {
            showAlertNotice('danger', 'No admin record found to delete.');
            return;
        }

        if (!confirm(`Are you sure you want to delete admin "${name || adminId}"?`)) {
            return;
        }

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
                    admin_id: adminId,
                    delid: adminId,
                    action: 'delete'
                })
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                showAlertNotice('success', data.message || 'Admin deleted successfully!');
                
                // Clear initial data
                initialAdminData.id = '';
                initialAdminData.name = '';
                initialAdminData.mobile = '';
                initialAdminData.login_id = '';
                initialAdminData.email = '';
                initialAdminData.status = '1';

                // Clear Form
                document.getElementById('admin_id').value = '';
                document.getElementById('admin_name').value = '';
                document.getElementById('admin_mobile').value = '';
                document.getElementById('admin_login_id').value = '';
                document.getElementById('admin_email').value = '';
                document.getElementById('admin_status').value = '1';
                document.getElementById('admin_password').value = '';

                // Clear Modal Table
                const tbody = document.getElementById('adminModalTbody');
                if (tbody) {
                    tbody.innerHTML = `<tr id="noAdminRow"><td colspan="7" class="text-center text-muted py-4">No admin record found.</td></tr>`;
                }
            } else {
                showAlertNotice('danger', data.message || 'Failed to delete admin record.');
            }
        } catch (error) {
            console.error('Delete error:', error);
            showAlertNotice('danger', 'A server error occurred while deleting.');
        }
    }

    // Fully Clear and Reset Form
    function clearAdminForm() {
        // Reset stored selection
        initialAdminData.id = '';
        initialAdminData.name = '';
        initialAdminData.mobile = '';
        initialAdminData.login_id = '';
        initialAdminData.email = '';
        initialAdminData.status = '1';

        // Clear all form inputs
        document.getElementById('admin_id').value = '';
        document.getElementById('admin_name').value = '';
        document.getElementById('admin_mobile').value = '';
        document.getElementById('admin_login_id').value = '';
        document.getElementById('admin_email').value = '';
        document.getElementById('admin_status').value = '1';
        
        const pwdInput = document.getElementById('admin_password');
        if (pwdInput) {
            pwdInput.value = '';
            pwdInput.placeholder = 'Leave blank to keep existing password...';
        }

        // Hide alert message if present
        const alertBox = document.getElementById('actionAlertBox');
        if (alertBox) {
            alertBox.classList.add('d-none');
            alertBox.innerHTML = '';
        }

        // Focus first field
        const nameField = document.getElementById('admin_name');
        if (nameField) {
            nameField.focus();
        }
    }

    // Modal Selection
    function selectAdminRecord(rec) {
        const stVal = (rec.status === '0' || rec.status === 0 || rec.status === 'INACTIVE') ? '0' : '1';

        initialAdminData.id = rec.id || '';
        initialAdminData.name = rec.name || '';
        initialAdminData.mobile = rec.mobile || '';
        initialAdminData.login_id = rec.login_id || '';
        initialAdminData.email = rec.email || '';
        initialAdminData.status = stVal;

        document.getElementById('admin_id').value = rec.id || '';
        document.getElementById('admin_name').value = rec.name || '';
        document.getElementById('admin_mobile').value = rec.mobile || '';
        document.getElementById('admin_login_id').value = rec.login_id || '';
        document.getElementById('admin_email').value = rec.email || '';
        document.getElementById('admin_status').value = stVal;
        
        const pwdInput = document.getElementById('admin_password');
        pwdInput.value = '';
        pwdInput.placeholder = 'Leave blank to keep existing password...';

        const modalEl = document.getElementById('editAdminModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Re-render Modal Table for Single Admin
    function renderSingleAdminModal(item) {
        const tbody = document.getElementById('adminModalTbody');
        if (!tbody || !item) return;

        const fullName = `${item.admin_fname || ''} ${item.admin_lname || ''}`.trim() || (item.admin_username || 'Admin');
        const rawStatus = (item.status || 'ACTIVE').toString().toUpperCase();
        const statusLabel = (rawStatus === '0' || rawStatus === 'INACTIVE' || rawStatus === 'IN-ACTIVE') ? 'INACTIVE' : 'ACTIVE';
        const dateLabel = item.insert_date ? item.insert_date.substring(0, 10) : '';

        const recObj = {
            id: item.admin_id,
            name: fullName,
            fname: item.admin_fname || '',
            lname: item.admin_lname || '',
            mobile: item.mob_one || '',
            login_id: item.admin_username || '',
            email: item.email_id || '',
            status: statusLabel,
            date: dateLabel
        };

        const recJson = JSON.stringify(recObj).replace(/'/g, "&apos;");

        tbody.innerHTML = `
            <tr class="admin-record-row"
                style="cursor: pointer;"
                data-id="${recObj.id}"
                data-name="${recObj.name}"
                data-mobile="${recObj.mobile}"
                data-login="${recObj.login_id}"
                data-email="${recObj.email}"
                data-status="${recObj.status}"
                onclick='selectAdminRecord(${recJson})'>
                <td class="text-center text-muted fw-bold">${recObj.id}</td>
                <td><span class="fw-bold text-dark">${recObj.name}</span></td>
                <td><span class="font-monospace text-primary fw-bold">${recObj.mobile}</span></td>
                <td><span class="badge bg-label-secondary font-monospace">${recObj.login_id}</span></td>
                <td><span class="text-secondary">${recObj.email || '-'}</span></td>
                <td class="text-center">
                    <span class="badge ${recObj.status === 'ACTIVE' ? 'bg-success' : 'bg-danger'}">
                        ${recObj.status}
                    </span>
                </td>
                <td><span class="font-monospace text-muted">${recObj.date}</span></td>
            </tr>
        `;
    }
</script>
@endsection
