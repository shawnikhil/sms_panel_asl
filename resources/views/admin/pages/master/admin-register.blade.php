@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="admin-form-shell">
            <div class="top-action-bar">
                <button type="button" class="action-btn save-btn">
                    <i class="bx bx-check"></i> Save
                </button>
                <button type="button" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                    <i class="bx bx-pencil"></i> Edit
                </button>
                <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteAdminModal">
                    <i class="bx bx-trash"></i> Del
                </button>
                <button type="button" class="action-btn clear-btn" data-bs-toggle="modal" data-bs-target="#clearAdminModal">
                    <i class="bx bx-x"></i> Clear
                </button>
            </div>

            <div class="admin-form-card">
                <div class="form-section-title">
                    <i class="bx bx-user"></i> Admin Details
                </div>

                <div class="form-grid">
                    <div class="form-row">
                        <label class="form-label">First Name <span class="mandatory">*</span></label>
                        <div class="form-control-wrap highlight-field">
                            <input type="text" value="" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label">Last Name <span class="mandatory">*</span></label>
                        <div class="form-control-wrap">
                            <input type="text" value="" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label">Mobile Number <span class="mandatory">*</span></label>
                        <div class="form-control-wrap">
                            <input type="text" value="" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label">Admin ID <span class="mandatory">*</span></label>
                        <div class="form-control-wrap disabled-field">
                            <input type="text" value="admin" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label">Password <span class="mandatory">*</span></label>
                        <div class="form-control-wrap password-wrap">
                            <input type="password" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="form-footer-action">
                    <button type="button" class="footer-btn primary-btn">
                        <i class="bx bx-check"></i> Save
                    </button>
                    <button type="button" class="footer-btn secondary-btn" data-bs-toggle="modal" data-bs-target="#clearAdminModal">
                        <i class="bx bx-x"></i> Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog edit-user-modal-dialog modal-dialog-centered">
        <div class="modal-content edit-user-modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDIT ADMIN DETAILS !</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit-user-modal-body">
                <div class="table-responsive edit-user-table-wrap">
                    <table class="table table-bordered mb-0 edit-user-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ADMIN NAME</th>
                                <th scope="col">MOBILE NO</th>
                                <th scope="col">LOGIN ID</th>
                                <th scope="col">PASSWORD</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">ROLE</th>
                                <th scope="col">CREATED DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>PAY ZONE</td>
                                <td>6295654606</td>
                                <td>admin</td>
                                <td>xxxx</td>
                                <td>-</td>
                                <td>ACTIVE</td>
                                <td>ADMIN</td>
                                <td>2026-08-14</td>
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

<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this admin?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="clearAdminModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Clear Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you want to clear the admin form fields?
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

    .admin-form-card {
        background: #f7f7f7;
        border: 1px solid #d9d9d9;
        border-top: none;
        padding: 0;
    }

    .form-section-title {
        font-size: 17px;
        font-weight: 700;
        color: #222;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 14px 16px 12px;
        border-bottom: 1px solid #d9d9d9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-grid {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .form-row {
        display: grid;
        grid-template-columns: 220px 1fr;
        min-height: 58px;
        border-bottom: 1px solid #d9d9d9;
    }

    .form-label {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 14px 16px;
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        background: rgba(0,0,0,0.01);
        border-right: 1px solid #d9d9d9;
    }

    .mandatory {
        color: #e53935;
        margin-left: 6px;
    }

    .form-control-wrap {
        display: flex;
        align-items: center;
        padding: 10px 14px;
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
        padding: 12px 14px 10px;
    }

    .edit-user-filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 16px;
        align-items: end;
        padding: 8px 0 12px;
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
        max-width: none;
        height: 36px;
        border: 1px solid #bdbdbd;
        border-radius: 0;
        background: #fff;
    }

    .all-btn {
        border: 0;
        background: #1d9adf;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        min-width: 80px;
        height: 36px;
        border-radius: 0;
        box-shadow: none;
    }

    .edit-user-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        padding: 10px 0 14px;
    }

    .page-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #cfcfcf;
        background: #f4f4f4;
        color: #444;
        font-weight: 700;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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
        min-width: 1180px;
        margin: 0;
        border-collapse: collapse;
    }

    .edit-user-table thead th {
        background: #e9e9e9;
        color: #1f1f1f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        padding: 11px 8px;
        border: 1px solid #d0d0d0;
        white-space: nowrap;
    }

    .edit-user-table tbody td {
        font-size: 12px;
        padding: 8px 10px;
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
        padding: 3px 8px;
        border-radius: 2px;
        font-size: 11px;
        line-height: 1.4;
        text-transform: uppercase;
    }

    .edit-user-modal-footer {
        background: #f4f4f4;
        border-top: 1px solid #d7d7d7;
        padding: 12px 16px;
        justify-content: flex-end;
    }

    .edit-user-modal-footer .btn {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-radius: 0;
        min-width: 90px;
    }

    .highlight-field {
        background: #fff7a8;
    }

    .disabled-field .form-control {
        background: #d5d5d5;
        color: #222;
    }

    .form-control {
        width: 100%;
        max-width: 620px;
        height: 36px;
        border: 1px solid #bfc0c1;
        background: #fff;
        padding: 7px 10px;
        font-size: 14px;
        color: #222;
        outline: none;
        border-radius: 2px;
    }

    .form-control:focus {
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

    @media (max-width: 768px) {
        .top-action-bar {
            padding: 8px 10px;
        }

        .action-btn {
            padding: 7px 10px;
            font-size: 11px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-label {
            border-right: 0;
            border-bottom: 1px solid #d9d9d9;
            padding-bottom: 10px;
        }

        .form-control-wrap {
            padding-top: 12px;
            padding-bottom: 12px;
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
</style>
@endsection
