@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="admin-form-shell">
            <div class="top-action-bar">
                <button type="button" class="action-btn save-btn">
                    <i class="bx bx-check"></i> Save
                </button>
                <button type="button" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editUserModal">
                    <i class="bx bx-pencil"></i> Edit
                </button>
                <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                    <i class="bx bx-trash"></i> Del
                </button>
                <button type="button" class="action-btn clear-btn" data-bs-toggle="modal" data-bs-target="#clearUserModal">
                    <i class="bx bx-x"></i> Clear
                </button>
            </div>

            <div class="user-register-card">
                <div class="form-section-title">[ USER PERSONAL DETAILS ]</div>

                <div class="user-form-grid">
                    <div class="user-form-row">
                        <label class="user-form-label">First Name <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap highlight-field">
                            <input type="text" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">Last Name</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">User Type <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <select class="user-form-control select-control">
                                <option value="">-- Select --</option>
                                <option>Retail</option>
                                <option>Reseller</option>
                                <option>Enterprise</option>
                            </select>
                        </div>

                        <label class="user-form-label">Company Name <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">Contact No <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">Email Id</label>
                        <div class="user-form-control-wrap">
                            <input type="email" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">Date of Birth</label>
                        <div class="user-form-control-wrap">
                            <input type="date" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">Sex <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <select class="user-form-control select-control">
                                <option value="">-- Select --</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">[ ADDRESS DETAILS ]</div>

                <div class="user-form-grid">
                    <div class="user-form-row">
                        <label class="user-form-label">Address <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap full-width">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">Landmark</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">Nationality</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">Pin Code <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">PAN No</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>
                </div>

                <div class="form-section-title">[ OTHER'S DETAILS ]</div>

                <div class="user-form-grid">
                    <div class="user-form-row">
                        <label class="user-form-label">GST Number</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">Aadhaar Number <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">User IP Address</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>

                        <label class="user-form-label">Callback URL</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">OTP Verified <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <select class="user-form-control select-control">
                                <option value="">-- Select --</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">[ PACKAGE DETAILS ]</div>

                <div class="user-form-grid">
                    <div class="user-form-row">
                        <label class="user-form-label">Select Package <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <select class="user-form-control select-control">
                                <option value="">-- Select --</option>
                                <option>Basic</option>
                                <option>Standard</option>
                                <option>Premium</option>
                            </select>
                        </div>

                        <label class="user-form-label">Lock Amount</label>
                        <div class="user-form-control-wrap">
                            <input type="text" class="user-form-control" value="" />
                        </div>
                    </div>

                    <div class="user-form-row">
                        <label class="user-form-label">Login Status <span class="mandatory">*</span></label>
                        <div class="user-form-control-wrap">
                            <select class="user-form-control select-control">
                                <option value="">-- Select --</option>
                                <option>ACTIVE</option>
                                <option>INACTIVE</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-footer-action">
                    <button type="button" class="footer-btn primary-btn">
                        <i class="bx bx-check"></i> Save
                    </button>
                    <button type="button" class="footer-btn secondary-btn" data-bs-toggle="modal" data-bs-target="#clearUserModal">
                        <i class="bx bx-x"></i> Clear
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 mb-2 text-muted small" style="font-size: 12px; color: #666;">
            © 2026 - Powered By Payzone
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog edit-user-modal-dialog modal-dialog-centered">
        <div class="modal-content edit-user-modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDIT USER DETAILS !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit-user-modal-body">
                <div class="edit-user-filter-row">
                    <div class="edit-user-field-box">
                        <label>USER NAME</label>
                        <input type="text" class="form-control" value="" />
                    </div>

                    <div class="edit-user-field-box">
                        <label>CONTACT NUMBER</label>
                        <input type="text" class="form-control" value="" />
                    </div>

                    <button type="button" class="all-btn">ALL</button>
                </div>

                <div class="edit-user-pagination">
                    <button type="button" class="page-btn">«</button>
                    <button type="button" class="page-btn current">1</button>
                    <button type="button" class="page-btn">»</button>
                </div>

                <div class="table-responsive edit-user-table-wrap">
                    <table class="table table-bordered mb-0 edit-user-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>REG NO</th>
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
                                <th>STATUS</th>
                                <th>REG DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>3905</td>
                                <td>sahista pay</td>
                                <td>sahistapay</td>
                                <td>API USER</td>
                                <td><span class="package-pill">PREPAID PLAN API</span></td>
                                <td>0</td>
                                <td>9800546248</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>3904</td>
                                <td>test Kumar</td>
                                <td>ASL WALLETS</td>
                                <td>API USER</td>
                                <td><span class="package-pill">PREPAID PLAN API</span></td>
                                <td>0</td>
                                <td>9973732671</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>3903</td>
                                <td>Gaurav Kumar</td>
                                <td>ASL WALLETS</td>
                                <td>API USER</td>
                                <td><span class="package-pill">PREPAID PLAN API</span></td>
                                <td>0</td>
                                <td>8348920759</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer edit-user-modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="clearUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Clear Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you want to clear the user form fields?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning">Clear</button>
      </div>
    </div>
  </div>
</div>

<style>
    .admin-form-shell {
        background: #f3f3f3;
        border: 1px solid #d5d5d5;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.03);
        margin-top: 10px;
    }

    .top-action-bar {
        background: #0d7291;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
    }

    .action-btn,
    .footer-btn {
        border: 1px solid rgba(0,0,0,0.15);
        background: #f4f4f4;
        color: #222;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        padding: 8px 14px;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        font-size: 13px;
    }

    .save-btn,
    .primary-btn {
        background: #f28b2d;
        color: #fff;
        border-color: #d9781d;
    }

    .action-btn {
        flex: 0 0 auto;
    }

    .edit-btn,
    .delete-btn,
    .clear-btn,
    .secondary-btn {
        background: #f0f0f0;
        color: #1b1b1b;
    }

    .user-register-card {
        background: #f6f6f6;
        border: 1px solid #d9d9d9;
        border-top: none;
        padding: 0;
    }

    .form-section-title {
        font-size: 13px;
        font-weight: 700;
        color: #2c2c2c;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 12px 16px 10px;
        border-bottom: 1px solid #d9d9d9;
        text-align: left;
    }

    .modal-content {
        border-radius: 0;
        border: 1px solid #d7d7d7;
        box-shadow: none;
    }

    .modal-header {
        position: relative;
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        padding: 14px 18px;
        min-height: 56px;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        margin: 0;
        color: #fff;
    }

    .btn-close {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        border: 0;
        border-radius: 0;
        background: transparent;
        opacity: 1;
        padding: 0;
        margin: 0;
        filter: invert(1) grayscale(100%) brightness(2);
    }

    .btn-close::before,
    .btn-close::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 2px;
        height: 18px;
        background: #fff;
        border-radius: 2px;
        transform-origin: center;
    }

    .btn-close::before {
        transform: translate(-50%, -50%) rotate(45deg);
    }

    .btn-close::after {
        transform: translate(-50%, -50%) rotate(-45deg);
    }

    .btn-close:hover,
    .btn-close:focus {
        opacity: 1;
        box-shadow: none;
    }

    .user-form-grid {
        display: block;
        width: 100%;
    }

    .edit-user-modal-dialog {
        max-width: 72vw;
        width: 72vw;
        margin: 1.5rem auto;
    }

    .edit-user-modal-content {
        background: #f2f2f2;
        border: 1px solid #d7d7d7;
    }

    .edit-user-modal-body {
        background: #f5f5f5;
        padding: 10px 12px 8px;
    }

    .edit-user-filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 10px;
        align-items: end;
        padding: 4px 0 8px;
        border-bottom: 1px solid #d6d6d6;
    }

    .edit-user-field-box {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .edit-user-field-box label {
        font-size: 12px;
        font-weight: 700;
        color: #1e1e1e;
        text-transform: uppercase;
        margin: 0;
    }

    .edit-user-field-box .form-control {
        width: 100%;
        height: 34px;
        border: 1px solid #bdbdbd;
        border-radius: 0;
        background: #fff;
        font-size: 12px;
    }

    .all-btn {
        border: 0;
        background: #1d9adf;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        min-width: 74px;
        height: 34px;
        border-radius: 0;
        box-shadow: none;
    }

    .edit-user-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        padding: 6px 0 8px;
    }

    .page-btn {
        width: 28px;
        height: 28px;
        border: 1px solid #cfcfcf;
        background: #f4f4f4;
        color: #444;
        font-weight: 700;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .page-btn.current {
        background: #1d9adf;
        color: #fff;
        border-color: #1d9adf;
    }

    .edit-user-table-wrap {
        border: 1px solid #d5d5d5;
        background: #fff;
        overflow-x: auto;
    }

    .edit-user-table {
        min-width: 1120px;
        margin: 0;
        border-collapse: collapse;
    }

    .edit-user-table thead th {
        background: #e9e9e9;
        color: #1f1f1f;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        padding: 8px 6px;
        border: 1px solid #d0d0d0;
        white-space: nowrap;
    }

    .edit-user-table tbody td {
        font-size: 11px;
        padding: 7px 8px;
        border: 1px solid #d8d8d8;
        color: #2a2a2a;
        white-space: nowrap;
        background: #fff;
    }

    .edit-user-table tbody tr:nth-child(odd) td {
        background: #f7f7f7;
    }

    .package-pill {
        display: inline-block;
        background: #f28b2d;
        color: #fff;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 2px;
        font-size: 10px;
        line-height: 1.4;
        text-transform: uppercase;
    }

    .edit-user-modal-footer {
        background: #f4f4f4;
        border-top: 1px solid #d7d7d7;
        padding: 10px 14px;
        justify-content: flex-end;
    }

    .edit-user-modal-footer .btn {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-radius: 0;
        min-width: 90px;
    }

    @media (max-width: 1200px) {
        .edit-user-modal-dialog {
            max-width: 78vw;
            width: 78vw;
        }
    }

    @media (max-width: 992px) {
        .edit-user-modal-dialog {
            max-width: 88vw;
            width: 88vw;
        }

        .edit-user-filter-row {
            grid-template-columns: 1fr 1fr;
        }

        .all-btn {
            grid-column: 1 / -1;
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .edit-user-modal-dialog {
            max-width: 94vw;
            width: 94vw;
            margin: 1rem auto;
        }

        .edit-user-filter-row {
            grid-template-columns: 1fr;
        }

        .edit-user-table {
            min-width: 980px;
        }
    }

    .user-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        border-bottom: 1px solid #d9d9d9;
    }

    .user-form-label {
        display: flex;
        align-items: center;
        padding: 12px 14px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #1d1d1d;
        border-right: 1px solid #d9d9d9;
        background: rgba(0,0,0,0.01);
    }

    .user-form-control-wrap {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-right: 1px solid #d9d9d9;
    }

    .user-form-control-wrap:last-child {
        border-right: none;
    }

    .full-width {
        grid-column: 2 / span 3;
    }

    .highlight-field {
        background: #fff7a8;
    }

    .mandatory {
        color: #e53935;
        margin-left: 4px;
    }

    .user-form-control {
        width: 100%;
        height: 30px;
        border: 1px solid #bfc0c1;
        background: #fff;
        padding: 6px 10px;
        font-size: 12px;
        color: #222;
        outline: none;
        border-radius: 2px;
    }

    .select-control {
        appearance: auto;
    }

    .user-form-control:focus {
        border-color: #4ea9d9;
        box-shadow: 0 0 0 1px rgba(78,169,217,0.15);
    }

    .form-footer-action {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 16px 18px;
        flex-wrap: nowrap;
    }

    .footer-btn {
        min-width: 112px;
        justify-content: center;
        flex: 0 0 auto;
    }

    @media (max-width: 992px) {
        .user-form-row {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .top-action-bar {
            padding: 8px 10px;
        }

        .action-btn {
            padding: 7px 10px;
            font-size: 11px;
        }

        .user-form-row {
            grid-template-columns: 1fr;
        }

        .user-form-label,
        .user-form-control-wrap {
            border-right: none;
            border-bottom: 1px solid #d9d9d9;
        }

        .full-width {
            grid-column: auto;
        }

        .form-footer-action {
            gap: 8px;
            justify-content: flex-end;
            flex-wrap: nowrap;
        }

        .footer-btn {
            min-width: 96px;
            padding: 8px 10px;
            font-size: 12px;
        }
    }
</style>
@endsection
