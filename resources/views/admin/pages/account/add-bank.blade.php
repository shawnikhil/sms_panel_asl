@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="bank-register-shell">
            <div class="bank-breadcrumb-bar">
                <span class="crumb-home">🏠</span>
                <span>Master Account</span>
                <span class="crumb-separator">|</span>
                <span class="crumb-current">Bank Register</span>
            </div>

            <div class="top-action-bar">
                <button type="button" class="action-btn save-btn">
                    <i class="bx bx-check"></i> Save
                </button>
                <button type="button" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editBankModal">
                    <i class="bx bx-pencil"></i> Edit
                </button>
                <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteBankModal">
                    <i class="bx bx-trash"></i> Del
                </button>
                <button type="button" class="action-btn clear-btn" data-bs-toggle="modal" data-bs-target="#clearBankModal">
                    <i class="bx bx-x"></i> Clear
                </button>
            </div>

            <div class="bank-card">
                <div class="bank-form-grid">
                    <div class="bank-form-row full-row">
                        <label class="bank-form-label">Bank Name <span class="mandatory">*</span></label>
                        <div class="bank-form-control-wrap">
                            <input type="text" class="bank-form-control" value="" />
                        </div>
                    </div>

                    <div class="bank-form-row split-row">
                        <div class="bank-field-group">
                            <label class="bank-form-label">Branch Name <span class="mandatory">*</span></label>
                            <div class="bank-form-control-wrap">
                                <input type="text" class="bank-form-control" value="" />
                            </div>
                        </div>

                        <div class="bank-field-group">
                            <label class="bank-form-label">A/C No <span class="mandatory">*</span></label>
                            <div class="bank-form-control-wrap">
                                <input type="text" class="bank-form-control" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="bank-form-row split-row">
                        <div class="bank-field-group">
                            <label class="bank-form-label">IFSC Code</label>
                            <div class="bank-form-control-wrap">
                                <input type="text" class="bank-form-control" value="" />
                            </div>
                        </div>

                        <div class="bank-field-group">
                            <label class="bank-form-label">Status <span class="mandatory">*</span></label>
                            <div class="bank-form-control-wrap select-wrap">
                                <select class="bank-form-control">
                                    <option value="Y">Y</option>
                                    <option value="N">N</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bank-form-actions">
                    <button type="button" class="bank-footer-btn primary-btn">
                        <i class="bx bx-check"></i> Save
                    </button>
                    <button type="button" class="bank-footer-btn secondary-btn" data-bs-toggle="modal" data-bs-target="#clearBankModal">
                        <i class="bx bx-x"></i> Clear
                    </button>
                </div>
            </div>

            <div class="bank-page-footer">
                2026 © Payzone. Powered By Payzone
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog bank-edit-modal-dialog modal-dialog-centered">
        <div class="modal-content bank-edit-modal-content">
            <div class="modal-header bank-edit-header">
                <h5 class="modal-title bank-edit-title">EDIT BANK DETAILS !</h5>
                <button type="button" class="btn-close bank-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bank-edit-body">
                <div class="table-responsive bank-edit-table-wrap">
                    <table class="table table-bordered mb-0 bank-edit-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>BANK NAME</th>
                                <th>BRANCH</th>
                                <th>ACCOUNT NO</th>
                                <th>IFSC CODE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>UCO BANK</td>
                                <td>test1</td>
                                <td>444444444444444</td>
                                <td>DBDRL@!#</td>
                                <td>Y</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer bank-edit-footer">
                <button type="button" class="btn btn-light bank-close-action" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered bank-confirm-modal-dialog">
        <div class="modal-content bank-confirm-modal-content">
            <div class="modal-header bank-confirm-header">
                <h5 class="modal-title bank-confirm-title">Delete Bank</h5>
                <button type="button" class="btn-close bank-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bank-confirm-body">
                Are you sure you want to delete this bank record?
            </div>
            <div class="modal-footer bank-confirm-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="clearBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered bank-confirm-modal-dialog">
        <div class="modal-content bank-confirm-modal-content">
            <div class="modal-header bank-confirm-header">
                <h5 class="modal-title bank-confirm-title">Clear Form</h5>
                <button type="button" class="btn-close bank-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bank-confirm-body">
                Do you want to clear the bank form fields?
            </div>
            <div class="modal-footer bank-confirm-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning">Clear</button>
            </div>
        </div>
    </div>
</div>

<style>
    .bank-register-shell {
        background: #f2f2f2;
        border: 1px solid #d4d4d4;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.02);
    }

    .bank-breadcrumb-bar {
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
    .bank-footer-btn {
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

    .bank-card {
        background: #f7f7f7;
        border: 1px solid #d9d9d9;
        border-top: none;
    }

    .bank-form-grid {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .bank-form-row {
        display: grid;
        border-bottom: 1px solid #d9d9d9;
        min-height: 60px;
    }

    .full-row {
        grid-template-columns: 1fr;
    }

    .split-row {
        grid-template-columns: 1fr 1fr;
    }

    .bank-field-group {
        display: grid;
        grid-template-columns: 1fr;
        border-right: 1px solid #d9d9d9;
    }

    .bank-field-group:last-child {
        border-right: none;
    }

    .bank-form-label {
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

    .full-row .bank-form-label {
        border-bottom: 1px solid #d9d9d9;
    }

    .bank-form-control-wrap {
        display: flex;
        align-items: center;
        padding: 0 16px 12px;
    }

    .bank-form-control {
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

    .bank-form-control:focus {
        border-color: #4ea9d9;
        box-shadow: 0 0 0 1px rgba(78,169,217,0.15);
    }

    .mandatory {
        color: #e53935;
        margin-left: 6px;
    }

    .select-wrap select {
        appearance: auto;
        -webkit-appearance: menulist;
    }

    .bank-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        padding: 16px 16px 18px;
        background: #f7f7f7;
    }

    .bank-page-footer {
        text-align: center;
        padding: 18px 12px;
        font-size: 13px;
        color: #4a4a4a;
        background: #f3f3f3;
        border-top: 1px solid #d6d6d6;
        font-weight: 600;
    }

    .bank-edit-modal-dialog {
        max-width: 78vw;
        width: 78vw;
        margin: 2rem auto;
    }

    .bank-edit-modal-content {
        background: #f2f2f2;
        border: 1px solid #d7d7d7;
        border-radius: 0;
        box-shadow: none;
    }

    .bank-edit-header {
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        min-height: 54px;
        padding: 14px 18px;
        position: relative;
    }

    .bank-edit-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin: 0;
        color: #fff;
    }

    .bank-close-btn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        opacity: 1;
        filter: invert(1) grayscale(100%) brightness(2);
    }

    .bank-edit-body {
        background: #f5f5f5;
        padding: 16px 18px 10px;
    }

    .bank-edit-table-wrap {
        border: 1px solid #d5d5d5;
        background: #fff;
        overflow-x: auto;
    }

    .bank-edit-table {
        min-width: 860px;
        margin: 0;
        border-collapse: collapse;
    }

    .bank-edit-table thead th {
        background: #e8e8e8;
        color: #1f1f1f;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 10px 8px;
        border: 1px solid #d0d0d0;
        white-space: nowrap;
    }

    .bank-edit-table tbody td {
        font-size: 12px;
        padding: 9px 10px;
        border: 1px solid #d8d8d8;
        color: #2b2b2b;
        white-space: nowrap;
        background: #fff;
    }

    .bank-edit-table tbody tr:nth-child(odd) td {
        background: #f7f7f7;
    }

    .bank-edit-footer {
        background: #f4f4f4;
        border-top: 1px solid #d7d7d7;
        padding: 12px 16px;
        justify-content: flex-end;
    }

    .bank-close-action {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 0;
        min-width: 90px;
        padding: 8px 18px;
    }

    .bank-confirm-modal-dialog {
        max-width: 460px;
        width: 460px;
    }

    .bank-confirm-modal-content {
        border-radius: 0;
        border: 1px solid #d7d7d7;
        box-shadow: none;
    }

    .bank-confirm-header {
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        min-height: 52px;
        padding: 12px 16px;
        position: relative;
    }

    .bank-confirm-title {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin: 0;
    }

    .bank-confirm-body {
        background: #f5f5f5;
        font-size: 15px;
        color: #2a2a2a;
        padding: 22px 20px;
    }

    .bank-confirm-footer {
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
        .bank-footer-btn {
            padding: 7px 10px;
            font-size: 11px;
        }

        .split-row {
            grid-template-columns: 1fr;
        }

        .bank-field-group {
            border-right: none;
            border-bottom: 1px solid #d9d9d9;
        }

        .bank-field-group:last-child {
            border-bottom: none;
        }

        .bank-form-actions {
            justify-content: flex-end;
            flex-wrap: nowrap;
        }

        .bank-edit-modal-dialog {
            max-width: 94vw;
            width: 94vw;
            margin: 1rem auto;
        }
    }
</style>
@endsection
