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
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" id="topSaveUserBtn" onclick="saveUserRecord()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editUserModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" id="deleteUserBtn" onclick="deleteUserRecord()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearUserForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="userRegisterForm" onsubmit="event.preventDefault(); saveUserRecord();" novalidate>
                <input type="hidden" id="user_id" value="" />

                {{-- ── 1. USER PERSONAL DETAILS ── --}}
                <div class="sms-form-section-header text-center fw-bold py-1 mb-3">
                    [ USER PERSONAL DETAILS ]
                </div>

                {{-- Row 1: First Name & Last Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        FIRST NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_fname" name="fname" class="form-control sms-input" placeholder="" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        LAST NAME
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_lname" name="lname" class="form-control sms-input" placeholder="" />
                    </div>
                </div>

                {{-- Row 2: User Type & Company Name --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        USER TYPE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_type" name="regtype" class="form-select sms-input">
                            <option value="" disabled selected>-- Select User Type --</option>
                            @if(isset($userTypes) && count($userTypes) > 0)
                                @foreach($userTypes as $ut)
                                    <option value="{{ $ut->user_id ?? $ut->id }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $ut->user_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        COMPANY NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_company" name="company_name" class="form-control sms-input" placeholder="" />
                    </div>
                </div>

                {{-- Row 3: Contact No & Email ID --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        CONTACT NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_contact" name="phone" class="form-control sms-input font-monospace" placeholder="" maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        EMAIL ID
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="email" id="user_email" name="email" class="form-control sms-input" placeholder="" />
                    </div>
                </div>

                {{-- Row 4: Date of Birth & Sex --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        DATE OF BIRTH
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="date" id="user_dob" name="dob" class="form-control sms-input" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        SEX <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_sex" name="sex" class="form-select sms-input">
                            <option value="1" selected>MALE</option>
                            <option value="0">FEMALE</option>
                        </select>
                    </div>
                </div>

                {{-- ── 2. ADDRESS DETAILS ── --}}
                <div class="sms-form-section-header text-center fw-bold py-1 mb-3">
                    [ ADDRESS DETAILS ]
                </div>

                {{-- Row 1: Address (Textarea) --}}
                <div class="row align-items-start mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label pt-2">
                        ADDRESS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <textarea id="user_address" name="addsdt" class="form-control sms-input" rows="2" placeholder=""></textarea>
                    </div>
                </div>

                {{-- Row 2: Landmark & Nationality --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        LANDMARK
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_landmark" name="landmark" class="form-control sms-input" placeholder="" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        NATIONALITY
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_nation" name="nation" class="form-control sms-input" value="INDIAN" placeholder="" />
                    </div>
                </div>

                {{-- Row 3: Pin No & Pan No --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PIN NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_pincode" name="pincode" class="form-control sms-input font-monospace" maxlength="6" placeholder="" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        PAN NO <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_panno" name="panno" class="form-control sms-input font-monospace text-uppercase" maxlength="10" placeholder="" />
                    </div>
                </div>

                {{-- ── 3. OTHER'S DETAILS ── --}}
                <div class="sms-form-section-header text-center fw-bold py-1 mb-3">
                    [ OTHER'S DETAILS ]
                </div>

                {{-- Row 1: GST Number & Aadhaar Number --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        GST NUMBER
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_gstnumber" name="gstnumber" class="form-control sms-input font-monospace text-uppercase" placeholder="" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        AADHAAR NUMBER <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_aadharno" name="aadharno" class="form-control sms-input font-monospace" maxlength="12" placeholder="" />
                    </div>
                </div>

                {{-- Row 2: User IP Address & Callback URL --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        USER IP ADDRESS
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="user_ipaddress" name="ipaddress" class="form-control sms-input font-monospace" placeholder="" />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        CALLBACK URL
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="url" id="user_callbackurl" name="callbackurl" class="form-control sms-input font-monospace" placeholder="" />
                    </div>
                </div>

                {{-- Row 3: Is OTP Verify --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        IS OTP VERIFY <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_isotpverify" name="isotpverify" class="form-select sms-input">
                            <option value="N" selected>N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>
                </div>

                {{-- ── 4. PACKAGE DETAILS ── --}}
                <div class="sms-form-section-header text-center fw-bold py-1 mb-3">
                    [ PACKAGE DETAILS ]
                </div>

                {{-- Row 1: Select Package & Lock Amount --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        SELECT PACKAGE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_package_id" name="package_id" class="form-select sms-input">
                            <option value="" disabled selected>-- Select Package --</option>
                            @if(isset($packages) && count($packages) > 0)
                                @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $pkg->pack_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        LOCK AMOUNT
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="number" step="0.01" id="user_lockamt" name="lockamt" class="form-control sms-input font-monospace" placeholder="0.00" value="0.00" />
                    </div>
                </div>

                {{-- Row 2: Login Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        LOGIN STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="user_status" name="status" class="form-select sms-input">
                            <option value="ACTIVE" selected>ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3" id="bottomSaveUserBtn">
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
                <div class="d-flex flex-wrap align-items-center justify-content-between my-2 px-1 gap-2">
                    <div>
                        <small class="text-muted fw-semibold" id="userModalPaginationInfo">Showing 0 of 0 entries</small>
                    </div>
                    <div class="sms-pagination-container">
                        <nav aria-label="User modal navigation">
                            <ul class="pagination pagination-sm mb-0 justify-content-center" id="userModalPagination">
                                <!-- Rendered dynamically by JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>

                {{-- Table Component inside Modal --}}
                <div class="table-responsive text-nowrap border rounded" style="max-height: 440px; overflow: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="userModalTable" style="font-size: 0.80rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>REG NO 1</th>
                                <th>USER NAME</th>
                                <th>COMPANY NAME</th>
                                <th>USER TYPE</th>
                                <th>PACKAGE NAME</th>
                                <th>LOCK AMOUNT</th>
                                <th>MOBILE</th>
                                <th>WHATSAPP</th>
                                <th>EMAIL ID</th>
                                <th>DOB</th>
                                <th>SEX</th>
                                <th>PINNO</th>
                                <th>PANNO</th>
                                <th>GST NUMBER</th>
                                <th>AADHAAR NUMBER</th>
                                <th>OTP CHECK</th>
                                <th>OTP TYPE</th>
                                <th>ADDRESS</th>
                                <th>USER ID</th>
                                <th class="text-center">STATUS</th>
                                <th>REG DATE</th>
                            </tr>
                        </thead>
                        <tbody id="userModalTbody">
                            @php
                                $userTypeMap = [];
                                if (isset($userTypes)) {
                                    foreach ($userTypes as $ut) {
                                        $userTypeMap[(string)$ut->user_id] = $ut->user_name;
                                        $userTypeMap[(string)$ut->id] = $ut->user_name;
                                    }
                                }
                                $fallbackTypeMap = [
                                    '1' => 'Retailer',
                                    '2' => 'Distributor',
                                    '3' => 'Master Distributor',
                                    '4' => 'API User',
                                    'RETAILER' => 'Retailer',
                                    'DISTRIBUTOR' => 'Distributor',
                                    'MASTER DISTRIBUTOR' => 'Master Distributor',
                                    'API USER' => 'API User',
                                ];

                                $packageMap = [];
                                if (isset($packages)) {
                                    foreach ($packages as $pkg) {
                                        $packageMap[(string)$pkg->id] = $pkg->pack_name;
                                    }
                                }
                            @endphp

                            @if(isset($users) && count($users) > 0)
                                @foreach($users as $u)
                                @php
                                    $userFullName = trim(($u->fname ?? '') . ' ' . ($u->lname ?? ''));
                                    $rawRegType = (string)($u->regtype ?? '');
                                    $userTypeName = $userTypeMap[$rawRegType] ?? $fallbackTypeMap[$rawRegType] ?? ($rawRegType ?: 'API User');
                                    $rawPackageId = (string)($u->package_id ?? '');
                                    $packageName = $packageMap[$rawPackageId] ?? ($u->package_name ?? '-');

                                    $uData = [
                                        'id' => $u->id ?? '',
                                        'regno' => $u->regno ?? $u->id ?? '',
                                        'fname' => $u->fname ?? '',
                                        'lname' => $u->lname ?? '',
                                        'name' => $userFullName,
                                        'company' => $u->company_name ?? '',
                                        'type' => $u->regtype ?? '4',
                                        'type_name' => $userTypeName,
                                        'package_id' => $u->package_id ?? '',
                                        'package_name' => $packageName,
                                        'lockamt' => $u->lockamt ?? '0.00',
                                        'contact' => $u->phone ?? '',
                                        'whatsapp' => $u->whatsapp ?? $u->phone ?? '',
                                        'email' => $u->email ?? '',
                                        'dob' => $u->dob ?? '',
                                        'sex' => $u->sex ?? '1',
                                        'pincode' => $u->pincode ?? '',
                                        'panno' => $u->panno ?? '',
                                        'gst' => $u->gstnumber ?? '',
                                        'aadhaar' => $u->aadharno ?? '',
                                        'isotpverify' => $u->isotpverify ?? '0',
                                        'otpverifytype' => $u->otpverifytype ?? '0',
                                        'address' => $u->addsdt ?? '',
                                        'landmark' => $u->landmark ?? '',
                                        'nation' => $u->nation ?? 'INDIAN',
                                        'ip' => $u->ipaddress ?? '',
                                        'callback' => $u->callbackurl ?? '',
                                        'userid' => $u->userid ?? '',
                                        'status' => $u->status ?? '1',
                                        'regst_date' => $u->regst_date ?? ''
                                    ];
                                @endphp
                                <tr class="user-record-row"
                                    style="cursor: pointer;"
                                    data-id="{{ $uData['id'] }}"
                                    data-regno="{{ $uData['regno'] }}"
                                    data-name="{{ $uData['name'] }}"
                                    data-company="{{ $uData['company'] }}"
                                    data-contact="{{ $uData['contact'] }}"
                                    onclick="selectUserRecord({{ json_encode($uData) }})">
                                    <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-label-secondary font-monospace">{{ $uData['regno'] }}</span></td>
                                    <td><span class="fw-bold text-dark">{{ $uData['name'] }}</span></td>
                                    <td><span class="text-secondary">{{ $uData['company'] }}</span></td>
                                    <td><span class="badge bg-label-info fw-bold">{{ $uData['type_name'] }}</span></td>
                                    <td><span class="text-dark fw-semibold">{{ $uData['package_name'] }}</span></td>
                                    <td><span class="font-monospace text-success fw-bold">{{ $uData['lockamt'] }}</span></td>
                                    <td><span class="font-monospace text-primary fw-bold">{{ $uData['contact'] }}</span></td>
                                    <td><span class="font-monospace text-success">{{ $uData['whatsapp'] }}</span></td>
                                    <td><span class="text-secondary">{{ $uData['email'] }}</span></td>
                                    <td><span class="font-monospace text-muted">{{ $uData['dob'] }}</span></td>
                                    <td><span class="text-secondary">{{ $uData['sex'] == '1' || $uData['sex'] === 'MALE' ? 'MALE' : 'FEMALE' }}</span></td>
                                    <td><span class="font-monospace">{{ $uData['pincode'] }}</span></td>
                                    <td><span class="font-monospace text-uppercase">{{ $uData['panno'] }}</span></td>
                                    <td><span class="font-monospace text-uppercase">{{ $uData['gst'] }}</span></td>
                                    <td><span class="font-monospace">{{ $uData['aadhaar'] }}</span></td>
                                    <td class="text-center"><span class="badge {{ $uData['isotpverify'] === '1' || $uData['isotpverify'] === 'Y' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $uData['isotpverify'] === '1' || $uData['isotpverify'] === 'Y' ? 'Y' : 'N' }}</span></td>
                                    <td><span class="text-secondary">{{ $uData['otpverifytype'] == '1' ? 'SMS' : 'NONE' }}</span></td>
                                    <td><span class="text-secondary text-truncate d-inline-block" style="max-width: 140px;" title="{{ $uData['address'] }}">{{ $uData['address'] }}</span></td>
                                    <td><span class="badge bg-label-primary font-monospace">{{ $uData['userid'] }}</span></td>
                                    <td class="text-center">
                                        <span class="badge {{ $uData['status'] === 'ACTIVE' || $uData['status'] === '1' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $uData['status'] === 'ACTIVE' || $uData['status'] === '1' ? 'ACTIVE' : 'INACTIVE' }}
                                        </span>
                                    </td>
                                    <td><span class="font-monospace text-muted">{{ $uData['regst_date'] }}</span></td>
                                </tr>
                                @endforeach
                            @else
                                <tr id="noUserRecordRow">
                                    <td colspan="22" class="text-center text-muted py-4">No registered users found in database.</td>
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

    /* Section Header Banners matching legacy format */
    .sms-form-section-header {
        font-size: 0.8125rem;
        font-weight: 700;
        color: #1e40af;
        letter-spacing: 0.04em;
        background-color: #f1f5f9;
        border-top: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 2px;
    }
    html.dark .sms-form-section-header {
        background-color: #1e293b;
        color: #60a5fa;
        border-color: #334155;
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
        padding: 0.42rem 0.75rem;
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

    /* Sticky Table Header inside Modal */
    #userModalTable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8fafc !important;
        box-shadow: inset 0 -1px 0 #dee2e6, inset 0 1px 0 #dee2e6;
    }
    html.dark #userModalTable thead th {
        background-color: #1e293b !important;
        box-shadow: inset 0 -1px 0 #334155, inset 0 1px 0 #334155;
    }
</style>
@endsection

{{-- ── Page Scripts ── --}}
@section('scripts')
<script>
    const ACTION_URL = "{{ route('admin.master.user_register.action') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
    let userModalCurrentPage = 1;
    const userModalPageSize = 10;

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

    // Save User (Create or Update)
    async function saveUserRecord() {
        const rules = [
            { id: 'user_fname', name: 'FIRST NAME' },
            { id: 'user_type', name: 'USER TYPE' },
            { id: 'user_company', name: 'COMPANY NAME' },
            { id: 'user_contact', name: 'CONTACT NO', regex: /^\d{10}$/, regexMsg: 'Contact number must be exactly 10 digits!' },
            { id: 'user_sex', name: 'SEX' },
            { id: 'user_address', name: 'ADDRESS' },
            { id: 'user_pincode', name: 'PIN NO', regex: /^\d{6}$/, regexMsg: 'PIN NO must be exactly 6 digits!' },
            { id: 'user_panno', name: 'PAN NO' },
            { id: 'user_aadharno', name: 'AADHAAR NUMBER', regex: /^\d{12}$/, regexMsg: 'AADHAAR NUMBER must be exactly 12 digits!' },
            { id: 'user_isotpverify', name: 'IS OTP VERIFY' },
            { id: 'user_package_id', name: 'PACKAGE' },
            { id: 'user_status', name: 'LOGIN STATUS' }
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

        const userId = document.getElementById('user_id').value.trim();
        const payload = {
            _token: CSRF_TOKEN,
            editid: userId,
            fname: document.getElementById('user_fname').value.trim(),
            lname: document.getElementById('user_lname').value.trim(),
            regtype: document.getElementById('user_type').value,
            company_name: document.getElementById('user_company').value.trim(),
            phone: document.getElementById('user_contact').value.trim(),
            email: document.getElementById('user_email').value.trim(),
            dob: document.getElementById('user_dob').value,
            sex: document.getElementById('user_sex').value,
            addsdt: document.getElementById('user_address').value.trim(),
            landmark: document.getElementById('user_landmark').value.trim(),
            nation: document.getElementById('user_nation').value.trim(),
            pincode: document.getElementById('user_pincode').value.trim(),
            panno: document.getElementById('user_panno').value.trim().toUpperCase(),
            gstnumber: document.getElementById('user_gstnumber').value.trim().toUpperCase(),
            aadharno: document.getElementById('user_aadharno').value.trim(),
            ipaddress: document.getElementById('user_ipaddress').value.trim(),
            callbackurl: document.getElementById('user_callbackurl').value.trim(),
            isotpverify: document.getElementById('user_isotpverify').value,
            package_id: document.getElementById('user_package_id').value,
            lockamt: document.getElementById('user_lockamt').value.trim() || '0',
            status: document.getElementById('user_status').value
        };

        setButtonsLoading(['topSaveUserBtn', 'bottomSaveUserBtn'], true, 'SAVING...', '<i class="bx bx-check"></i> SAVE');

        try {
            const response = await fetch(ACTION_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'User saved successfully!', 'Success');
                if (data.user) upsertUserModalRow(data.user);
                if (!userId) clearUserForm();
            } else {
                toastr.error(data.message || 'Failed to save user.', 'Error');
            }
        } catch (error) {
            console.error('Save error:', error);
            toastr.error('Server error occurred. Please try again.', 'Error');
        } finally {
            setButtonsLoading(['topSaveUserBtn', 'bottomSaveUserBtn'], false, '', '<i class="bx bx-check"></i> SAVE');
        }
    }

    // Delete User
    async function deleteUserRecord() {
        const userId = document.getElementById('user_id').value.trim();
        const fname  = document.getElementById('user_fname').value.trim();

        if (!userId) {
            toastr.error('No user selected to delete. Please select a user from EDIT first.', 'Notice');
            return;
        }

        if (!confirm(`Are you sure you want to delete user "${fname || userId}"?`)) return;

        setButtonsLoading(['deleteUserBtn'], true, 'DELETING...', '<i class="bx bx-trash"></i> DEL');

        try {
            const response = await fetch(ACTION_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ _token: CSRF_TOKEN, delid: userId, action: 'delete' })
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'User deleted successfully!', 'Success');
                clearUserForm();

                const row = document.querySelector(`#userModalTbody tr[data-id="${userId}"]`);
                if (row) {
                    row.remove();
                    const allRows = document.querySelectorAll('#userModalTbody tr.user-record-row');
                    if (allRows.length === 0) {
                        const tbody = document.getElementById('userModalTbody');
                        if (tbody) tbody.innerHTML = `<tr id="noUserRecordRow"><td colspan="22" class="text-center text-muted py-4">No registered users found in database.</td></tr>`;
                    } else {
                        allRows.forEach((r, idx) => {
                            const firstTd = r.querySelector('td:first-child');
                            if (firstTd) firstTd.textContent = idx + 1;
                        });
                    }
                    renderUserModalPagination();
                }
            } else {
                toastr.error(data.message || 'Failed to delete user.', 'Error');
            }
        } catch (error) {
            console.error('Delete error:', error);
            toastr.error('Server error occurred while deleting user.', 'Error');
        } finally {
            setButtonsLoading(['deleteUserBtn'], false, '', '<i class="bx bx-trash"></i> DEL');
        }
    }

    // Live Upsert of Modal Table Row
    function upsertUserModalRow(user) {
        if (!user) return;

        const typeOpt = document.querySelector(`#user_type option[value="${user.regtype || user.usertype}"]`);
        const pkgOpt  = document.querySelector(`#user_package_id option[value="${user.package_id || user.packname}"]`);

        const uData = {
            id: user.id || '',
            regno: user.regno || user.id || '',
            fname: user.fname || '',
            lname: user.lname || '',
            name: `${user.fname || ''} ${user.lname || ''}`.trim(),
            company: user.company_name || user.company || '',
            type: user.regtype || user.usertype || '4',
            type_name: typeOpt ? typeOpt.textContent.trim() : 'API User',
            package_id: user.package_id || '',
            package_name: pkgOpt ? pkgOpt.textContent.trim() : 'PREPAID PLAN API',
            lockamt: user.lockamt !== undefined ? parseFloat(user.lockamt).toFixed(2) : '0.00',
            contact: user.phone || user.contact || '',
            whatsapp: user.whatsapp || user.phone || user.contact || '',
            email: user.email || '',
            dob: user.dob || '',
            sex: (user.sex == '0' || String(user.sex).toUpperCase() === 'FEMALE') ? '0' : '1',
            pincode: user.pincode || '',
            panno: (user.panno || '').toUpperCase(),
            gst: (user.gstnumber || user.gstno || '').toUpperCase(),
            aadhaar: user.aadharno || '',
            isotpverify: (user.isotpverify == '1' || user.isotpverify === 'Y') ? 'Y' : 'N',
            otpverifytype: user.otpverifytype == '1' ? 'SMS' : 'NONE',
            address: user.addsdt || user.address || '',
            landmark: user.landmark || '',
            nation: user.nation || user.nationality || 'INDIAN',
            ip: user.ipaddress || user.uip || '',
            callback: user.callbackurl || user.callurl || '',
            userid: user.userid || '',
            status: (user.status == '1' || user.status === 'ACTIVE') ? 'ACTIVE' : 'INACTIVE',
            regst_date: user.regst_date || (new Date().toISOString().slice(0, 10))
        };

        const tbody = document.getElementById('userModalTbody');
        if (!tbody) return;

        document.getElementById('noUserRecordRow')?.remove();

        let row = tbody.querySelector(`tr[data-id="${uData.id}"]`);
        if (!row) {
            row = document.createElement('tr');
            row.className = 'user-record-row';
            row.style.cursor = 'pointer';
            tbody.prepend(row);
        }

        row.dataset.id = uData.id;
        row.dataset.regno = uData.regno;
        row.dataset.name = uData.name;
        row.dataset.company = uData.company;
        row.dataset.contact = uData.contact;
        row.onclick = () => selectUserRecord(uData);

        row.innerHTML = `
            <td class="text-center text-muted fw-bold">1</td>
            <td><span class="badge bg-label-secondary font-monospace">${uData.regno}</span></td>
            <td><span class="fw-bold text-dark">${uData.name}</span></td>
            <td><span class="text-secondary">${uData.company}</span></td>
            <td><span class="badge bg-label-info fw-bold">${uData.type_name}</span></td>
            <td><span class="text-dark fw-semibold">${uData.package_name}</span></td>
            <td><span class="font-monospace text-success fw-bold">${uData.lockamt}</span></td>
            <td><span class="font-monospace text-primary fw-bold">${uData.contact}</span></td>
            <td><span class="font-monospace text-success">${uData.whatsapp}</span></td>
            <td><span class="text-secondary">${uData.email}</span></td>
            <td><span class="font-monospace text-muted">${uData.dob}</span></td>
            <td><span class="text-secondary">${uData.sex === '0' ? 'FEMALE' : 'MALE'}</span></td>
            <td><span class="font-monospace">${uData.pincode}</span></td>
            <td><span class="font-monospace text-uppercase">${uData.panno}</span></td>
            <td><span class="font-monospace text-uppercase">${uData.gst}</span></td>
            <td><span class="font-monospace">${uData.aadhaar}</span></td>
            <td class="text-center"><span class="badge ${uData.isotpverify === 'Y' ? 'bg-success' : 'bg-warning text-dark'}">${uData.isotpverify}</span></td>
            <td><span class="text-secondary">${uData.otpverifytype}</span></td>
            <td><span class="text-secondary text-truncate d-inline-block" style="max-width: 140px;" title="${uData.address}">${uData.address}</span></td>
            <td><span class="badge bg-label-primary font-monospace">${uData.userid}</span></td>
            <td class="text-center"><span class="badge ${uData.status === 'ACTIVE' ? 'bg-success' : 'bg-danger'}">${uData.status}</span></td>
            <td><span class="font-monospace text-muted">${uData.regst_date}</span></td>
        `;

        tbody.querySelectorAll('tr.user-record-row').forEach((r, idx) => {
            const firstTd = r.querySelector('td:first-child');
            if (firstTd) firstTd.textContent = idx + 1;
        });

        userModalCurrentPage = 1;
        renderUserModalPagination();
    }

    // Clear Form
    function clearUserForm() {
        document.getElementById('userRegisterForm').reset();
        document.getElementById('user_id').value = '';
        document.getElementById('user_sex').value = '1';
        document.getElementById('user_isotpverify').value = 'N';
        document.getElementById('user_status').value = 'ACTIVE';
    }

    // Modal Selection
    function selectUserRecord(user) {
        document.getElementById('user_id').value = user.id || '';
        document.getElementById('user_fname').value = user.fname || '';
        document.getElementById('user_lname').value = user.lname || '';
        document.getElementById('user_company').value = user.company || user.company_name || '';
        document.getElementById('user_type').value = user.type || user.regtype || '4';
        document.getElementById('user_contact').value = user.contact || user.phone || '';
        document.getElementById('user_email').value = user.email || '';
        document.getElementById('user_dob').value = user.dob || '';

        const rawSex = String(user.sex ?? '').toUpperCase();
        document.getElementById('user_sex').value = (rawSex === '0' || rawSex === 'FEMALE') ? '0' : '1';

        document.getElementById('user_address').value = user.address || user.addsdt || '';
        document.getElementById('user_landmark').value = user.landmark || '';
        document.getElementById('user_nation').value = user.nation || user.nationality || 'INDIAN';
        document.getElementById('user_pincode').value = user.pincode || '';
        document.getElementById('user_panno').value = user.panno || '';
        document.getElementById('user_gstnumber').value = user.gst || user.gstnumber || '';
        document.getElementById('user_aadharno').value = user.aadhaar || user.aadharno || '';
        document.getElementById('user_ipaddress').value = user.ip || user.ipaddress || '';
        document.getElementById('user_callbackurl').value = user.callback || user.callbackurl || '';

        const rawOtp = String(user.isotpverify ?? '').toUpperCase();
        document.getElementById('user_isotpverify').value = (rawOtp === '1' || rawOtp === 'Y' || rawOtp === 'YES') ? 'Y' : 'N';

        document.getElementById('user_package_id').value = user.package_id || '';
        document.getElementById('user_lockamt').value = user.lockamt !== undefined ? user.lockamt : '0.00';

        const rawStatus = String(user.status ?? '').toUpperCase();
        document.getElementById('user_status').value = (rawStatus === '1' || rawStatus === 'ACTIVE' || rawStatus === 'Y') ? 'ACTIVE' : 'INACTIVE';

        const modalEl = document.getElementById('editUserModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // ── Pagination & Filter Controller for Edit Modal ──
    function renderUserModalPagination() {
        const filterName    = (document.getElementById('modal_filter_username')?.value || '').trim().toLowerCase();
        const filterContact = (document.getElementById('modal_filter_usercontact')?.value || '').trim().toLowerCase();

        const allRows = Array.from(document.querySelectorAll('#userModalTbody tr.user-record-row'));
        const matchedRows = allRows.filter(row => {
            const name    = (row.dataset.name || '').toLowerCase();
            const contact = (row.dataset.contact || '').toLowerCase();
            return (!filterName || name.includes(filterName)) && (!filterContact || contact.includes(filterContact));
        });

        const totalItems = matchedRows.length;
        const totalPages = Math.ceil(totalItems / userModalPageSize) || 1;

        if (userModalCurrentPage > totalPages) userModalCurrentPage = totalPages;
        if (userModalCurrentPage < 1) userModalCurrentPage = 1;

        const startIndex = (userModalCurrentPage - 1) * userModalPageSize;
        const endIndex   = startIndex + userModalPageSize;

        allRows.forEach(row => row.style.display = 'none');
        matchedRows.slice(startIndex, endIndex).forEach(row => row.style.display = '');

        const infoEl = document.getElementById('userModalPaginationInfo');
        if (infoEl) {
            infoEl.textContent = totalItems === 0 ? 'Showing 0 of 0 entries' : `Showing ${startIndex + 1} to ${Math.min(endIndex, totalItems)} of ${totalItems} entries`;
        }

        const pagContainer = document.getElementById('userModalPagination');
        if (!pagContainer) return;

        let pagHtml = `<li class="page-item ${userModalCurrentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToUserModalPage(${userModalCurrentPage - 1})">«</a>
        </li>`;

        let startPage = Math.max(1, userModalCurrentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

        if (startPage > 1) {
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToUserModalPage(1)">1</a></li>`;
            if (startPage > 2) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let p = startPage; p <= endPage; p++) {
            pagHtml += `<li class="page-item ${p === userModalCurrentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="goToUserModalPage(${p})">${p}</a>
            </li>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToUserModalPage(${totalPages})">${totalPages}</a></li>`;
        }

        pagHtml += `<li class="page-item ${userModalCurrentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToUserModalPage(${userModalCurrentPage + 1})">»</a>
        </li>`;

        pagContainer.innerHTML = pagHtml;
    }

    function goToUserModalPage(page) {
        userModalCurrentPage = page;
        renderUserModalPagination();
    }

    function filterUserModalTable() {
        userModalCurrentPage = 1;
        renderUserModalPagination();
    }

    function resetUserModalFilter() {
        if (document.getElementById('modal_filter_username')) document.getElementById('modal_filter_username').value = '';
        if (document.getElementById('modal_filter_usercontact')) document.getElementById('modal_filter_usercontact').value = '';
        userModalCurrentPage = 1;
        renderUserModalPagination();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderUserModalPagination();
        document.getElementById('editUserModal')?.addEventListener('shown.bs.modal', () => {
            renderUserModalPagination();
        });

        // Auto-load user if edit_id is in URL query
        const urlParams = new URLSearchParams(window.location.search);
        const editId = urlParams.get('edit_id') || urlParams.get('id') || urlParams.get('user_id');
        if (editId) {
            const targetRow = document.querySelector(`#userModalTbody tr[data-id="${editId}"]`);
            if (targetRow) {
                targetRow.click();
                if (typeof toastr !== 'undefined') {
                    toastr.info('User details loaded for editing.', 'Edit Mode');
                }
            }
        }
    });
</script>
@endsection
