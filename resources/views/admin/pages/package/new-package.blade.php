@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="package-register-shell">
            <div class="package-breadcrumb-bar">
                <span class="crumb-home">🏠</span>
                <span>Package</span>
                <span class="crumb-separator">|</span>
                <span class="crumb-current">New Package Register</span>
            </div>

            <div class="top-action-bar">
                <button type="button" class="action-btn save-btn">
                    <i class="bx bx-check"></i> Save
                </button>
                <button type="button" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editPackageModal">
                    <i class="bx bx-pencil"></i> Edit
                </button>
                <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deletePackageModal">
                    <i class="bx bx-trash"></i> Del
                </button>
                <button type="button" class="action-btn clear-btn" data-bs-toggle="modal" data-bs-target="#clearPackageModal">
                    <i class="bx bx-x"></i> Clear
                </button>
            </div>

            <div class="package-card">
                <div class="package-form-grid">
                    <div class="package-form-row full-row">
                        <label class="package-form-label">Package Name <span class="mandatory">*</span></label>
                        <div class="package-form-control-wrap">
                            <input type="text" class="package-form-control" value="" />
                        </div>
                    </div>

                    <div class="package-form-row full-row">
                        <label class="package-form-label">Per SMS Charges <span class="mandatory">*</span></label>
                        <div class="package-form-control-wrap">
                            <input type="text" class="package-form-control" value="" />
                        </div>
                    </div>

                    <div class="package-form-row full-row">
                        <label class="package-form-label">Wh SMS Charges <span class="mandatory">*</span></label>
                        <div class="package-form-control-wrap">
                            <input type="text" class="package-form-control" value="" />
                        </div>
                    </div>

                    <div class="package-form-row full-row">
                        <label class="package-form-label">Status <span class="mandatory">*</span></label>
                        <div class="package-form-control-wrap">
                            <select class="package-form-control">
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="package-form-actions">
                    <button type="button" class="package-footer-btn primary-btn">
                        <i class="bx bx-check"></i> Save
                    </button>
                    <button type="button" class="package-footer-btn secondary-btn" data-bs-toggle="modal" data-bs-target="#clearPackageModal">
                        <i class="bx bx-x"></i> Clear
                    </button>
                </div>
            </div>

            <div class="package-page-footer">
                2026 © Payzone. Powered By Payzone
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog package-edit-modal-dialog modal-dialog-centered">
        <div class="modal-content package-edit-modal-content">
            <div class="modal-header package-edit-header">
                <h5 class="modal-title package-edit-title">EDIT PACKAGE DETAILS !</h5>
                <button type="button" class="btn-close package-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body package-edit-body">
                <div class="package-edit-filter-row">
                    <div class="package-edit-field-box">
                        <label>Package Name</label>
                        <input type="text" class="form-control" value="" />
                    </div>

                    <button type="button" class="all-btn">ALL</button>
                </div>

                <div class="package-edit-pagination">
                    <button type="button" class="page-btn">«</button>
                    <button type="button" class="page-btn current">1</button>
                    <button type="button" class="page-btn">»</button>
                </div>

                <div class="table-responsive package-edit-table-wrap">
                    <table class="table table-bordered mb-0 package-edit-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>USER NAME</th>
                                <th>PACKAGE NAME</th>
                                <th>PER SMS CHARGES</th>
                                <th>PER WH CHARGES</th>
                                <th>STATUS</th>
                                <th>INSERT DATE</th>
                                <th>UPDATE DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>ADMIN</td>
                                <td>PREPAID PLAN API</td>
                                <td>0.1</td>
                                <td>0.2</td>
                                <td>ACTIVE</td>
                                <td>13-05-2026</td>
                                <td>11-06-2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer package-edit-footer">
                <button type="button" class="btn btn-light package-close-action" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered package-confirm-modal-dialog">
        <div class="modal-content package-confirm-modal-content">
            <div class="modal-header package-confirm-header">
                <h5 class="modal-title package-confirm-title">Delete Package</h5>
                <button type="button" class="btn-close package-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body package-confirm-body">
                Are you sure you want to delete this package record?
            </div>
            <div class="modal-footer package-confirm-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="clearPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered package-confirm-modal-dialog">
        <div class="modal-content package-confirm-modal-content">
            <div class="modal-header package-confirm-header">
                <h5 class="modal-title package-confirm-title">Clear Form</h5>
                <button type="button" class="btn-close package-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body package-confirm-body">
                Do you want to clear the package form fields?
            </div>
            <div class="modal-footer package-confirm-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning">Clear</button>
            </div>
        </div>
    </div>
</div>

<style>
    .package-register-shell {
        background: #f2f2f2;
        border: 1px solid #d4d4d4;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.02);
    }

    .package-breadcrumb-bar {
        background: #f5f5f5;
        border-bottom: 1px solid #d7d7d7;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #1d1d1d;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .crumb-home {
        font-size: 16px;
    }

    .crumb-separator {
        color: #6f6f6f;
    }

    .crumb-current {
        color: #1d1d1d;
        font-weight: 700;
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
    .package-footer-btn {
        border: 1px solid rgba(0,0,0,0.15);
        background: #f4f4f4;
        color: #222;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 9px 16px;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        font-size: 13px;
        line-height: 1;
        flex: 0 0 auto;
    }

    .save-btn,
    .primary-btn {
        background: #f28b2d;
        color: #fff;
        border-color: #d8741f;
    }

    .edit-btn,
    .delete-btn,
    .clear-btn,
    .secondary-btn {
        background: #e3e3e3;
        color: #1e1e1e;
        border-color: #c9c9c9;
    }

    .package-card {
        background: #f7f7f7;
        border: 1px solid #d9d9d9;
        border-top: none;
    }

    .package-form-grid {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .package-form-row {
        display: grid;
        border-bottom: 1px solid #d9d9d9;
        min-height: 56px;
    }

    .full-row {
        grid-template-columns: 1fr;
    }

    .package-form-label {
        display: flex;
        align-items: center;
        padding: 12px 16px 8px;
        font-size: 12px;
        font-weight: 700;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        background: rgba(0,0,0,0.01);
    }

    .full-row .package-form-label {
        border-bottom: 1px solid #d9d9d9;
    }

    .package-form-control-wrap {
        display: flex;
        align-items: center;
        padding: 0 16px 12px;
    }

    .package-form-control {
        width: 100%;
        height: 34px;
        border: 1px solid #bfc0c1;
        background: #fff;
        padding: 7px 10px;
        font-size: 14px;
        color: #222;
        border-radius: 2px;
        outline: none;
    }

    .mandatory {
        color: #e53935;
        margin-left: 6px;
    }

    .package-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        padding: 16px 16px 18px;
        background: #f7f7f7;
    }

    .package-page-footer {
        text-align: center;
        padding: 18px 12px;
        font-size: 13px;
        color: #4a4a4a;
        background: #f3f3f3;
        border-top: 1px solid #d6d6d6;
        font-weight: 600;
    }

    .package-edit-modal-dialog {
        max-width: 85vw;
        width: 85vw;
        margin: 2rem auto;
    }

    .package-edit-modal-content {
        background: #f2f2f2;
        border: 1px solid #d7d7d7;
        border-radius: 0;
        box-shadow: none;
    }

    .package-edit-header {
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        min-height: 54px;
        padding: 14px 18px;
        position: relative;
    }

    .package-edit-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin: 0;
        color: #fff;
    }

    .package-close-btn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        opacity: 1;
        filter: invert(1) grayscale(100%) brightness(2);
    }

    .package-edit-body {
        background: #f5f5f5;
        padding: 12px 14px 10px;
    }

    .package-edit-filter-row {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 16px;
        align-items: end;
        padding: 8px 0 12px;
        border-bottom: 1px solid #d6d6d6;
    }

    .package-edit-field-box {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .package-edit-field-box label {
        font-size: 12px;
        font-weight: 700;
        color: #1e1e1e;
        text-transform: uppercase;
        margin: 0;
    }

    .package-edit-field-box .form-control {
        width: 100%;
        height: 34px;
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
        min-width: 90px;
        height: 34px;
        border-radius: 0;
        box-shadow: none;
    }

    .package-edit-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        padding: 10px 0 12px;
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
    }

    .page-btn.current {
        background: #1d9adf;
        color: #fff;
        border-color: #1d9adf;
    }

    .package-edit-table-wrap {
        border: 1px solid #d5d5d5;
        background: #fff;
        overflow-x: auto;
    }

    .package-edit-table {
        min-width: 1100px;
        margin: 0;
        border-collapse: collapse;
    }

    .package-edit-table thead th {
        background: #e8e8e8;
        color: #1f1f1f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        padding: 10px 8px;
        border: 1px solid #d0d0d0;
        white-space: nowrap;
    }

    .package-edit-table tbody td {
        font-size: 12px;
        padding: 9px 10px;
        border: 1px solid #d8d8d8;
        color: #2b2b2b;
        white-space: nowrap;
        background: #fff;
    }

    .package-edit-table tbody tr:nth-child(odd) td {
        background: #f7f7f7;
    }

    .package-edit-footer {
        background: #f4f4f4;
        border-top: 1px solid #d7d7d7;
        padding: 12px 16px;
        justify-content: flex-end;
    }

    .package-close-action {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 0;
        min-width: 90px;
        padding: 8px 18px;
    }

    .package-confirm-modal-dialog {
        max-width: 460px;
        width: 460px;
    }

    .package-confirm-modal-content {
        border-radius: 0;
        border: 1px solid #d7d7d7;
        box-shadow: none;
    }

    .package-confirm-header {
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        min-height: 52px;
        padding: 12px 16px;
        position: relative;
    }

    .package-confirm-title {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin: 0;
    }

    .package-confirm-body {
        background: #f5f5f5;
        font-size: 15px;
        color: #2a2a2a;
        padding: 22px 20px;
    }

    .package-confirm-footer {
        background: #f4f4f4;
        border-top: 1px solid #d7d7d7;
        padding: 12px 16px;
        justify-content: flex-end;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .top-action-bar {
            padding: 8px 10px;
        }

        .action-btn,
        .package-footer-btn {
            padding: 7px 10px;
            font-size: 11px;
        }

        .package-form-actions {
            justify-content: flex-end;
            flex-wrap: nowrap;
        }

        .package-edit-modal-dialog {
            max-width: 94vw;
            width: 94vw;
            margin: 1rem auto;
        }

        .package-edit-filter-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
