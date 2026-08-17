@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Report</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">User Details</span>
        </div>
    </div>

    {{-- ── Find User Details Filter Card ── --}}
    <div class="sms-card-shell mb-4">
        <div class="sms-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">Find User Details -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#userFilterBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>
        
        <div class="collapse show" id="userFilterBody">
            <div class="sms-card-body p-4">
                <form id="userSearchForm" onsubmit="event.preventDefault(); applyUserFilters();">
                    <div class="row g-3 justify-content-center align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">USER NAME</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_user_name" class="form-control sms-input" placeholder="Enter user name..." />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">CONTACT NUMBER</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_contact_no" class="form-control sms-input" placeholder="Enter contact number..." />
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 mt-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="submit" class="btn sms-btn-search px-4">
                                    SEARCH
                                </button>
                                <button type="button" class="btn sms-btn-clear px-4" onclick="clearUserFilters()">
                                    CLEAR
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── User Details Table Card ── --}}
    <div class="sms-card-shell">
        <div class="sms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">User Details -</span>
            </div>

            {{-- Action Tools --}}
            <div class="d-flex align-items-center gap-2">
                <div class="position-relative d-none d-md-block" style="width: 220px;">
                    <i class="bx bx-search position-absolute top-50 translate-middle-y text-muted ms-2"></i>
                    <input type="text" id="userQuickSearch" class="form-control form-control-sm ps-4 bg-white text-dark" 
                           placeholder="Quick search user..." oninput="quickFilterUserTable()" />
                </div>
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="exportUserTableToCSV('user-details-report.csv')">
                    <i class="bx bx-download"></i> Export
                </button>
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bx bx-printer"></i> Print
                </button>
            </div>
        </div>

        <div class="sms-card-body p-0">
            
            {{-- Top Pagination Controls --}}
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between px-3 py-3 border-bottom gap-2">
                <div class="text-muted small">
                    Showing <span id="userShowingCount" class="fw-bold">5</span> users
                </div>
                
                <div class="sms-pagination-container">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToUserPage(2)">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToUserPage(3)">3</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToUserPage(2)">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap" style="max-height: 650px; overflow-x: auto;">
                <table class="table table-hover user-details-table mb-0" id="userDetailsTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th style="width: 70px;">ACTION</th>
                            <th>REG NO</th>
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
                            <th>OTP VERIFY TYPE</th>
                            <th>USER ID</th>
                            <th>API TOKEN</th>
                            <th>IP ADDRESS</th>
                            <th>CALLBACK URL</th>
                            <th class="text-center">STATUS</th>
                            <th>REG DATE</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @php
                            $usersList = [
                                [
                                    'id' => 1,
                                    'reg_no' => '3905',
                                    'user_name' => 'SAHISTA PAY',
                                    'user_type' => 'API USER',
                                    'company_name' => 'sahistapay',
                                    'contact_no' => '9800546248',
                                    'email' => 'sahistapay@gmail.com',
                                    'package_name' => 'PREPAID PLAN API',
                                    'balance' => '478.48',
                                    'address' => 'https://www.sahistapay.com/',
                                    'pincode' => '711101',
                                    'pan_no' => 'ABCDE1234F',
                                    'gst_no' => '27ABCDE1234F4F4',
                                    'aadhaar_no' => '859885011111',
                                    'is_otp_verify' => 'YES',
                                    'otp_verify_type' => 'SMS',
                                    'user_id' => 'USR3905',
                                    'api_token' => 'fe1c25598680c09b8b0c5e09df1903bf782a1b90',
                                    'ip_address' => '103.212.156.42',
                                    'callback_url' => 'https://sahistapay.com/api/callback',
                                    'status' => 'ACTIVE',
                                    'reg_date' => '12/05/2026 10:15 AM'
                                ],
                                [
                                    'id' => 2,
                                    'reg_no' => '3904',
                                    'user_name' => 'TEST KUMAR',
                                    'user_type' => 'API USER',
                                    'company_name' => 'ASL WALLETS',
                                    'contact_no' => '9973732671',
                                    'email' => 'nikhilshaw251@gmail.com',
                                    'package_name' => 'PREPAID PLAN API',
                                    'balance' => '0.00',
                                    'address' => 'Bihar saran Temple, Behind South City Mall',
                                    'pincode' => '841204',
                                    'pan_no' => 'ABCDE1234F',
                                    'gst_no' => '77777777777',
                                    'aadhaar_no' => '9999 9999 4444',
                                    'is_otp_verify' => 'YES',
                                    'otp_verify_type' => 'SMS',
                                    'user_id' => 'USR3904',
                                    'api_token' => '9f4c33218760a08b9c1d6e10ef2814ca893b2c01',
                                    'ip_address' => '182.74.12.98',
                                    'callback_url' => 'https://aslwallets.com/callback',
                                    'status' => 'ACTIVE',
                                    'reg_date' => '10/05/2026 04:30 PM'
                                ],
                                [
                                    'id' => 3,
                                    'reg_no' => '3903',
                                    'user_name' => 'GAURAV KUMAR',
                                    'user_type' => 'API USER',
                                    'company_name' => 'ASL WALLETS',
                                    'contact_no' => '8348920759',
                                    'email' => 'nikhilshaw251@gmail.com',
                                    'package_name' => 'PREPAID PLAN API',
                                    'balance' => '0.00',
                                    'address' => 'Bihar saran Temple, test',
                                    'pincode' => '841204',
                                    'pan_no' => 'AAKCD2492A',
                                    'gst_no' => '27ABCDE1234F1Z5',
                                    'aadhaar_no' => '308027202508',
                                    'is_otp_verify' => 'YES',
                                    'otp_verify_type' => 'SMS',
                                    'user_id' => 'USR3903',
                                    'api_token' => '7b3e22109871f19c8d0e5a09df1903ba782b3d11',
                                    'ip_address' => '49.36.128.90',
                                    'callback_url' => 'https://aslwallets.com/api/sms/dlr',
                                    'status' => 'ACTIVE',
                                    'reg_date' => '08/05/2026 01:22 PM'
                                ],
                                [
                                    'id' => 4,
                                    'reg_no' => '3902',
                                    'user_name' => 'NIKHIL KUMAR',
                                    'user_type' => 'RESELLER',
                                    'company_name' => 'OPENI TECH',
                                    'contact_no' => '6396788609',
                                    'email' => 'nikhil@openitech.com',
                                    'package_name' => 'ENTERPRISE ROUTE',
                                    'balance' => '1250.00',
                                    'address' => 'Plot 44, Tech Zone, Sector 62, Noida',
                                    'pincode' => '201301',
                                    'pan_no' => 'NIKHL8821K',
                                    'gst_no' => '07NIKHL8821K1Z2',
                                    'aadhaar_no' => '4567 8901 2345',
                                    'is_otp_verify' => 'YES',
                                    'otp_verify_type' => 'BOTH',
                                    'user_id' => 'USR3902',
                                    'api_token' => 'a1b2c3d4e5f60718293a4b5c6d7e8f9012345678',
                                    'ip_address' => '*',
                                    'callback_url' => 'https://openitech.com/sms/webhook',
                                    'status' => 'ACTIVE',
                                    'reg_date' => '01/05/2026 11:00 AM'
                                ],
                                [
                                    'id' => 5,
                                    'reg_no' => '3901',
                                    'user_name' => 'AMIT SINGH',
                                    'user_type' => 'RETAIL',
                                    'company_name' => 'SINGH SERVICES',
                                    'contact_no' => '9540794800',
                                    'email' => 'amit.singh@gmail.com',
                                    'package_name' => 'STANDARD SMS PLAN',
                                    'balance' => '75.20',
                                    'address' => 'Civil Lines, Prayagraj, UP',
                                    'pincode' => '211001',
                                    'pan_no' => 'AMITS7744M',
                                    'gst_no' => '09AMITS7744M1Z9',
                                    'aadhaar_no' => '7890 1234 5678',
                                    'is_otp_verify' => 'NO',
                                    'otp_verify_type' => 'SMS',
                                    'user_id' => 'USR3901',
                                    'api_token' => '890123456789abcdef0123456789abcdef012345',
                                    'ip_address' => '103.44.12.5',
                                    'callback_url' => '',
                                    'status' => 'ACTIVE',
                                    'reg_date' => '25/04/2026 09:40 AM'
                                ],
                            ];
                        @endphp

                        @foreach($usersList as $user)
                        <tr class="user-row" 
                            data-user-name="{{ $user['user_name'] }}"
                            data-contact-no="{{ $user['contact_no'] }}"
                            data-reg-no="{{ $user['reg_no'] }}"
                            data-company="{{ $user['company_name'] }}"
                            data-email="{{ $user['email'] }}">
                            
                            <td class="text-muted fw-bold">{{ $user['id'] }}</td>
                            
                            <td>
                                <button type="button" class="btn btn-sm btn-edit-action" 
                                        onclick="openEditUserModal({{ json_encode($user) }})">
                                    <i class="bx bx-edit-alt me-1"></i>EDIT
                                </button>
                            </td>

                            <td>
                                <span class="badge user-regno-badge">{{ $user['reg_no'] }}</span>
                            </td>

                            <td>
                                <span class="fw-bold text-dark user-name-cell">{{ $user['user_name'] }}</span>
                            </td>

                            <td>
                                <span class="badge user-type-badge">{{ $user['user_type'] }}</span>
                            </td>

                            <td>
                                <span class="text-secondary fw-semibold">{{ $user['company_name'] }}</span>
                            </td>

                            <td>
                                <span class="user-mono-text">{{ $user['contact_no'] }}</span>
                            </td>

                            <td>
                                <span class="user-email-text" title="{{ $user['email'] }}">{{ $user['email'] }}</span>
                            </td>

                            <td>
                                <span class="badge bg-label-info fw-semibold">{{ $user['package_name'] }}</span>
                            </td>

                            <td class="text-end fw-bold text-success">
                                {{ number_format((float)$user['balance'], 2) }}
                            </td>

                            <td>
                                <span class="user-address-text" title="{{ $user['address'] }}">{{ $user['address'] }}</span>
                            </td>

                            <td>
                                <span class="user-mono-text">{{ $user['pincode'] }}</span>
                            </td>

                            <td>
                                <span class="user-mono-text">{{ $user['pan_no'] }}</span>
                            </td>

                            <td>
                                <span class="user-mono-text" title="{{ $user['gst_no'] }}">{{ $user['gst_no'] }}</span>
                            </td>

                            <td>
                                <span class="user-mono-text">{{ $user['aadhaar_no'] }}</span>
                            </td>

                            <td class="text-center">
                                @if(strtoupper($user['is_otp_verify']) === 'YES')
                                    <span class="badge bg-success">YES</span>
                                @else
                                    <span class="badge bg-secondary">NO</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-label-primary">{{ $user['otp_verify_type'] }}</span>
                            </td>

                            <td>
                                <span class="user-mono-text">{{ $user['user_id'] }}</span>
                            </td>

                            <td>
                                <div class="user-token-cell" title="Click to view full API Token" onclick="viewApiTokenModal('{{ $user['user_name'] }}', '{{ $user['api_token'] }}')">
                                    <code>{{ Str::limit($user['api_token'], 16) }}</code>
                                    <i class="bx bx-copy ms-1 text-primary"></i>
                                </div>
                            </td>

                            <td>
                                <span class="user-mono-text">{{ $user['ip_address'] }}</span>
                            </td>

                            <td>
                                <span class="user-callback-text" title="{{ $user['callback_url'] }}">{{ $user['callback_url'] ?: '-' }}</span>
                            </td>

                            <td class="text-center">
                                @if(strtoupper($user['status']) === 'ACTIVE')
                                    <span class="badge bg-success">ACTIVE</span>
                                @else
                                    <span class="badge bg-danger">INACTIVE</span>
                                @endif
                            </td>

                            <td>
                                <span class="text-muted small text-nowrap">{{ $user['reg_date'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Table Footer --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-top gap-2 bg-light-subtle">
                <div class="text-muted small d-flex align-items-center gap-2">
                    <span class="badge badge-dot bg-success"></span>
                    <span>Active User Accounts & Gateway Permissions</span>
                </div>
                <div class="text-muted small">
                    Page <strong>1</strong> of <strong>1</strong>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- ── Edit User Modal ── --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header sms-modal-header py-3">
                <h5 class="modal-title fs-6 text-white mb-0">
                    <i class="bx bx-user-check me-2"></i>Edit User Account: <span id="modal_edit_username_header" class="fw-bold"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editUserForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="sms-field-label">REG NO</label>
                            <input type="text" id="modal_reg_no" class="form-control sms-input" readonly />
                        </div>
                        <div class="col-md-4">
                            <label class="sms-field-label">USER NAME</label>
                            <input type="text" id="modal_user_name" class="form-control sms-input" />
                        </div>
                        <div class="col-md-4">
                            <label class="sms-field-label">USER TYPE</label>
                            <select id="modal_user_type" class="form-select sms-input">
                                <option value="API USER">API USER</option>
                                <option value="RESELLER">RESELLER</option>
                                <option value="RETAIL">RETAIL</option>
                                <option value="ENTERPRISE">ENTERPRISE</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="sms-field-label">COMPANY NAME</label>
                            <input type="text" id="modal_company_name" class="form-control sms-input" />
                        </div>
                        <div class="col-md-6">
                            <label class="sms-field-label">CONTACT NUMBER</label>
                            <input type="text" id="modal_contact_no" class="form-control sms-input" />
                        </div>

                        <div class="col-md-6">
                            <label class="sms-field-label">EMAIL ID</label>
                            <input type="email" id="modal_email" class="form-control sms-input" />
                        </div>
                        <div class="col-md-6">
                            <label class="sms-field-label">PACKAGE NAME</label>
                            <input type="text" id="modal_package_name" class="form-control sms-input" />
                        </div>

                        <div class="col-md-4">
                            <label class="sms-field-label">STATUS</label>
                            <select id="modal_status" class="form-select sms-input">
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="sms-field-label">IS OTP VERIFY</label>
                            <select id="modal_is_otp" class="form-select sms-input">
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="sms-field-label">OTP VERIFY TYPE</label>
                            <select id="modal_otp_type" class="form-select sms-input">
                                <option value="SMS">SMS</option>
                                <option value="EMAIL">EMAIL</option>
                                <option value="BOTH">BOTH</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="sms-field-label">IP ADDRESS WHITELIST</label>
                            <input type="text" id="modal_ip_address" class="form-control sms-input" placeholder="e.g. 103.212.156.42 or *" />
                        </div>
                        <div class="col-md-6">
                            <label class="sms-field-label">CALLBACK URL</label>
                            <input type="text" id="modal_callback_url" class="form-control sms-input" placeholder="https://..." />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="saveUserEdit()">
                    <i class="bx bx-save me-1"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── API Token View Modal ── --}}
<div class="modal fade" id="tokenViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header sms-modal-header py-3">
                <h5 class="modal-title fs-6 text-white mb-0">API Token & Authentication</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <label class="sms-field-label">User Account:</label>
                <div class="fw-bold mb-3 text-dark fs-6" id="tokenModalUserName"></div>

                <label class="sms-field-label">Full API Token:</label>
                <div class="input-group mb-3">
                    <input type="text" id="tokenModalValue" class="form-control font-monospace sms-input" readonly />
                    <button class="btn btn-primary" type="button" onclick="copyTokenToClipboard()">
                        <i class="bx bx-copy"></i>
                    </button>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
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

    .sms-card-header {
        background: #6c757d;
        color: #ffffff;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
    }

    html.dark .sms-card-header {
        background: #334155;
    }

    .sms-card-title {
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    /* Form Fields */
    .sms-field-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #475569;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        white-space: nowrap;
    }
    html.dark .sms-field-label {
        color: #cbd5e1;
    }

    .sms-input {
        border-radius: 3px;
        border: 1px solid #ced4da;
        padding: 0.4rem 0.65rem;
        font-size: 0.8125rem;
        background-color: #ffffff;
    }
    html.dark .sms-input {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* Action Buttons */
    .sms-btn-search {
        background: #007bff;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        border: none;
        border-radius: 3px;
        padding: 0.45rem 1.25rem;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.25);
        transition: all 0.2s ease;
    }
    .sms-btn-search:hover {
        background: #0056b3;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .sms-btn-clear {
        background: #e9ecef;
        color: #495057;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        border: 1px solid #ced4da;
        border-radius: 3px;
        padding: 0.45rem 1.25rem;
        transition: all 0.2s ease;
    }
    .sms-btn-clear:hover {
        background: #dde2e5;
        color: #212529;
    }
    html.dark .sms-btn-clear {
        background: #1e293b;
        color: #cbd5e1;
        border-color: #334155;
    }

    .btn-edit-action {
        background-color: #28a745;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.7rem;
        border-radius: 3px;
        padding: 0.2rem 0.5rem;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-edit-action:hover {
        background-color: #218838;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Pagination */
    .sms-pagination-container .pagination .page-item .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        padding: 0.25rem 0.55rem;
        font-size: 0.78rem;
        margin: 0 1px;
        border-radius: 2px;
    }
    .sms-pagination-container .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }
    html.dark .sms-pagination-container .pagination .page-item .page-link {
        background-color: #1e293b;
        border-color: #334155;
        color: #38bdf8;
    }
    html.dark .sms-pagination-container .pagination .page-item.active .page-link {
        background-color: #0284c7;
        border-color: #0284c7;
        color: #ffffff;
    }

    /* Table Styling */
    .user-details-table thead th {
        background-color: #f1f3f5 !important;
        color: #333333 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.03em !important;
        padding: 0.65rem 0.75rem !important;
        border-bottom: 2px solid #dee2e6 !important;
        white-space: nowrap !important;
    }
    html.dark .user-details-table thead th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }

    .user-details-table tbody td {
        font-size: 0.8125rem !important;
        padding: 0.55rem 0.75rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    html.dark .user-details-table tbody td {
        border-bottom-color: #1e293b !important;
    }

    .user-regno-badge {
        background: #e0e7ff;
        color: #4338ca;
        font-family: var(--font-mono), monospace;
        font-weight: 700;
        font-size: 0.75rem;
    }
    html.dark .user-regno-badge {
        background: #1e1b4b;
        color: #a5b4fc;
    }

    .user-type-badge {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 0.72rem;
        border: 1px solid #e2e8f0;
    }
    html.dark .user-type-badge {
        background: #1e293b;
        color: #94a3b8;
        border-color: #334155;
    }

    .user-mono-text {
        font-family: var(--font-mono), monospace;
        font-size: 0.78rem;
        color: #334155;
    }
    html.dark .user-mono-text {
        color: #cbd5e1;
    }

    .user-name-cell {
        font-size: 0.82rem;
        letter-spacing: 0.01em;
    }
    html.dark .user-name-cell {
        color: #f1f5f9 !important;
    }

    .user-address-text, .user-email-text, .user-callback-text {
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        vertical-align: middle;
        font-size: 0.8rem;
    }

    .user-token-cell {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }
    .user-token-cell code {
        font-size: 0.75rem;
        color: #4f46e5;
    }
    .user-token-cell:hover code {
        text-decoration: underline;
    }

    .sms-modal-header {
        background: #6c757d;
    }
    html.dark .sms-modal-header {
        background: #334155;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    let activeToken = '';

    // Filter Logic
    function applyUserFilters() {
        const uName = document.getElementById('filter_user_name').value.trim().toLowerCase();
        const contact = document.getElementById('filter_contact_no').value.trim().toLowerCase();

        const rows = document.querySelectorAll('#userTableBody tr.user-row');
        let count = 0;

        rows.forEach(row => {
            const rUser = (row.dataset.userName || '').toLowerCase();
            const rContact = (row.dataset.contactNo || '').toLowerCase();

            let match = true;
            if (uName && !rUser.includes(uName)) match = false;
            if (contact && !rContact.includes(contact)) match = false;

            if (match) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('userShowingCount').innerText = count;
    }

    // Quick filter
    function quickFilterUserTable() {
        const query = document.getElementById('userQuickSearch').value.trim().toLowerCase();
        const rows = document.querySelectorAll('#userTableBody tr.user-row');
        let count = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        document.getElementById('userShowingCount').innerText = count;
    }

    // Clear Filters
    function clearUserFilters() {
        document.getElementById('filter_user_name').value = '';
        document.getElementById('filter_contact_no').value = '';
        document.getElementById('userQuickSearch').value = '';

        const rows = document.querySelectorAll('#userTableBody tr.user-row');
        rows.forEach(row => row.style.display = '');
        document.getElementById('userShowingCount').innerText = rows.length;
    }

    // Edit User Modal
    function openEditUserModal(user) {
        document.getElementById('modal_edit_username_header').innerText = user.user_name;
        document.getElementById('modal_reg_no').value = user.reg_no;
        document.getElementById('modal_user_name').value = user.user_name;
        document.getElementById('modal_user_type').value = user.user_type;
        document.getElementById('modal_company_name').value = user.company_name;
        document.getElementById('modal_contact_no').value = user.contact_no;
        document.getElementById('modal_email').value = user.email;
        document.getElementById('modal_package_name').value = user.package_name;
        document.getElementById('modal_status').value = user.status;
        document.getElementById('modal_is_otp').value = user.is_otp_verify;
        document.getElementById('modal_otp_type').value = user.otp_verify_type;
        document.getElementById('modal_ip_address').value = user.ip_address;
        document.getElementById('modal_callback_url').value = user.callback_url;

        new bootstrap.Modal(document.getElementById('editUserModal')).show();
    }

    function saveUserEdit() {
        const regNo = document.getElementById('modal_reg_no').value;
        const newName = document.getElementById('modal_user_name').value;
        alert(`User details for Reg No: ${regNo} updated successfully!`);
        bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
    }

    // View Token Modal
    function viewApiTokenModal(userName, token) {
        activeToken = token;
        document.getElementById('tokenModalUserName').innerText = userName;
        document.getElementById('tokenModalValue').value = token;
        new bootstrap.Modal(document.getElementById('tokenViewModal')).show();
    }

    function copyTokenToClipboard() {
        navigator.clipboard.writeText(activeToken).then(() => {
            alert('API Token copied to clipboard!');
        });
    }

    // Pagination Simulation
    function goToUserPage(page) {
        document.querySelectorAll('.sms-pagination-container .page-item').forEach(el => el.classList.remove('active'));
        const links = document.querySelectorAll('.sms-pagination-container .page-link');
        links.forEach(l => {
            if (l.innerText.trim() == page) {
                l.parentElement.classList.add('active');
            }
        });
    }

    // Export CSV Helper
    function exportUserTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#userDetailsTable tr");
        
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].style.display === 'none') continue;
            let row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (let j = 0; j < cols.length; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/(\s\s+)/gm, " ");
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }

        const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endsection
