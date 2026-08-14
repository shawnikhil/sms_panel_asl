@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="fund-transfer-shell">
            <div class="fund-transfer-breadcrumb">
                <span class="crumb-home">🏠</span>
                <span>Manage API User</span>
                <span class="crumb-separator">|</span>
                <span class="crumb-current">Fund Transfer</span>
            </div>

            <div class="top-action-bar">
                <button type="button" class="action-btn save-btn">
                    <i class="bx bx-check"></i> Send
                </button>
                <button type="button" class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#viewFundTransferModal">
                    <i class="bx bx-show"></i> View
                </button>
                <button type="button" class="action-btn clear-btn" data-bs-toggle="modal" data-bs-target="#clearFundTransferModal">
                    <i class="bx bx-x"></i> Clear
                </button>
            </div>

            <div class="fund-transfer-card">
                <div class="fund-transfer-form-grid">
                    <div class="fund-transfer-form-row full-row">
                        <label class="fund-transfer-form-label">API User <span class="mandatory">*</span></label>
                        <div class="fund-transfer-form-control-wrap api-user-select-wrap">
                            <select class="fund-transfer-form-control api-user-select">
                                <option value="">-- Select --</option>
                                <option value="GAURAV KUMAR : M - 8348920759 [BAL: 0]">GAURAV KUMAR : M - 8348920759 [BAL: 0]</option>
                                <option value="NIKHIL KUMAR : M - 8709305218 [BAL: 227]">NIKHIL KUMAR : M - 8709305218 [BAL: 227]</option>
                                <option value="SAHISTA PAY : M - 9800546248 [BAL: 478]">SAHISTA PAY : M - 9800546248 [BAL: 478]</option>
                                <option value="TEST KUMAR : M - 9973732671 [BAL: 0]">TEST KUMAR : M - 9973732671 [BAL: 0]</option>
                            </select>
                        </div>
                    </div>

                    <div class="fund-transfer-form-row split-row">
                        <div class="fund-transfer-field-group">
                            <label class="fund-transfer-form-label">Transfer Amount <span class="mandatory">*</span></label>
                            <div class="fund-transfer-form-control-wrap">
                                <input type="text" class="fund-transfer-form-control" value="" />
                            </div>
                        </div>

                        <div class="fund-transfer-field-group">
                            <label class="fund-transfer-form-label">Transaction Date</label>
                            <div class="fund-transfer-form-control-wrap">
                                <input type="text" class="fund-transfer-form-control" value="14/08/2026" />
                            </div>
                        </div>
                    </div>

                    <div class="fund-transfer-form-row split-row">
                        <div class="fund-transfer-field-group">
                            <label class="fund-transfer-form-label">Transfer Type <span class="mandatory">*</span></label>
                            <div class="fund-transfer-form-control-wrap">
                                <select class="fund-transfer-form-control">
                                    <option value="FUND TRANSFER">FUND TRANSFER</option>
                                </select>
                            </div>
                        </div>

                        <div class="fund-transfer-field-group">
                            <label class="fund-transfer-form-label">Wallet Type <span class="mandatory">*</span></label>
                            <div class="fund-transfer-form-control-wrap">
                                <select class="fund-transfer-form-control">
                                    <option value="PREPAID BALANCE">PREPAID BALANCE</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="fund-transfer-form-row full-row">
                        <label class="fund-transfer-form-label">Transaction Desc</label>
                        <div class="fund-transfer-form-control-wrap">
                            <input type="text" class="fund-transfer-form-control" value="" />
                        </div>
                    </div>
                </div>

                <div class="fund-transfer-actions">
                    <button type="button" class="fund-transfer-btn primary-btn">
                        <i class="bx bx-check"></i> Send
                    </button>
                    <button type="button" class="fund-transfer-btn secondary-btn">
                        <i class="bx bx-check"></i> Send OTP
                    </button>
                    <button type="button" class="fund-transfer-btn tertiary-btn" data-bs-toggle="modal" data-bs-target="#clearFundTransferModal">
                        <i class="bx bx-x"></i> Clear
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="viewFundTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog fund-transfer-modal-dialog modal-dialog-centered">
        <div class="modal-content fund-transfer-modal-content">
            <div class="modal-header fund-transfer-modal-header">
                <h5 class="modal-title fund-transfer-modal-title">EDIT FUND TRANSFER DETAILS !</h5>
                <button type="button" class="btn-close fund-transfer-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body fund-transfer-modal-body">
                <div class="fund-transfer-filter-row">
                    <div class="fund-transfer-field-box">
                        <label>Company Name</label>
                        <input type="text" class="form-control" value="" />
                    </div>

                    <div class="fund-transfer-field-box">
                        <label>User Name</label>
                        <input type="text" class="form-control" value="" />
                    </div>

                    <button type="button" class="all-btn">ALL</button>
                </div>

                <div class="fund-transfer-pagination">
                    <button type="button" class="page-btn">«</button>
                    <button type="button" class="page-btn current">1</button>
                    <button type="button" class="page-btn">»</button>
                </div>

                <div class="table-responsive fund-transfer-table-wrap">
                    <table class="table table-bordered mb-0 fund-transfer-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TRAN ID</th>
                                <th>USER REGNO</th>
                                <th>COMPANY NAME</th>
                                <th>USER NAME</th>
                                <th>TRANSFER TYPE</th>
                                <th>TRANSFER AMOUNT</th>
                                <th>WALLET TYPE</th>
                                <th>OPENING BALANCE</th>
                                <th>CLOSING BALANCE</th>
                                <th>TRAN DESC</th>
                                <th>TRANS DATE/TIME</th>
                                <th>INSERT DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>14212</td>
                                <td>3905</td>
                                <td>sahistapay</td>
                                <td>sahista pay</td>
                                <td>FUND TRANSFER</td>
                                <td>500</td>
                                <td>PREPAID BALANCE</td>
                                <td>2500</td>
                                <td>2000</td>
                                <td>Transfer to wallet</td>
                                <td>2026-08-14 12:30:00</td>
                                <td>2026-08-14</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>14211</td>
                                <td>3902</td>
                                <td>ASL WALLETS</td>
                                <td>Nikhil Kumar</td>
                                <td>FUND TRANSFER</td>
                                <td>500</td>
                                <td>PREPAID BALANCE</td>
                                <td>1600</td>
                                <td>1100</td>
                                <td>Transfer to wallet</td>
                                <td>2026-08-14 11:10:00</td>
                                <td>2026-08-14</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer fund-transfer-modal-footer">
                <button type="button" class="btn btn-light fund-transfer-close-action" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="clearFundTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered fund-transfer-clear-modal-dialog">
        <div class="modal-content fund-transfer-clear-modal-content">
            <div class="modal-header fund-transfer-clear-header">
                <h5 class="modal-title fund-transfer-clear-title">Clear Form</h5>
                <button type="button" class="btn-close fund-transfer-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fund-transfer-clear-body">
                Do you want to clear the fund transfer form fields?
            </div>
            <div class="modal-footer fund-transfer-clear-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning">Clear</button>
            </div>
        </div>
    </div>
</div>

<style>
    .fund-transfer-shell {
        background: #f2f2f2;
        border: 1px solid #d4d4d4;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.02);
    }

    .fund-transfer-breadcrumb {
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
    .fund-transfer-btn {
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
    .clear-btn,
    .tertiary-btn {
        background: #dfe7eb;
        color: #1e1e1e;
        border-color: #c7d2d7;
    }

    .fund-transfer-card {
        background: #f7f7f7;
        border: 1px solid #d9d9d9;
        border-top: none;
    }

    .fund-transfer-form-grid {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .fund-transfer-form-row {
        display: grid;
        border-bottom: 1px solid #d9d9d9;
        min-height: 56px;
    }

    .full-row {
        grid-template-columns: 1fr;
    }

    .split-row {
        grid-template-columns: 1fr 1fr;
    }

    .fund-transfer-field-group {
        display: grid;
        grid-template-columns: 1fr;
        border-right: 1px solid #d9d9d9;
    }

    .fund-transfer-field-group:last-child {
        border-right: none;
    }

    .fund-transfer-form-label {
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

    .full-row .fund-transfer-form-label {
        border-bottom: 1px solid #d9d9d9;
    }

    .fund-transfer-form-control-wrap {
        display: flex;
        align-items: center;
        padding: 0 16px 12px;
    }

    .api-user-select-wrap {
        position: relative;
        padding-right: 0;
    }

    .fund-transfer-form-control {
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

    .api-user-select {
        appearance: auto;
        -webkit-appearance: menulist;
    }

    .mandatory {
        color: #e53935;
        margin-left: 6px;
    }

    .fund-transfer-actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        padding: 16px 16px 18px;
        background: #f7f7f7;
    }

    .fund-transfer-footer {
        text-align: center;
        padding: 18px 12px;
        font-size: 13px;
        color: #4a4a4a;
        background: #f3f3f3;
        border-top: 1px solid #d6d6d6;
        font-weight: 600;
    }

    .fund-transfer-modal-dialog {
        max-width: 86vw;
        width: 86vw;
        margin: 2rem auto;
    }

    .fund-transfer-modal-content {
        background: #f2f2f2;
        border: 1px solid #d7d7d7;
        border-radius: 0;
        box-shadow: none;
    }

    .fund-transfer-modal-header {
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        min-height: 54px;
        padding: 14px 18px;
        position: relative;
    }

    .fund-transfer-modal-title {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin: 0;
        color: #fff;
    }

    .fund-transfer-close-btn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        opacity: 1;
        filter: invert(1) grayscale(100%) brightness(2);
    }

    .fund-transfer-modal-body {
        background: #f5f5f5;
        padding: 12px 14px 10px;
    }

    .fund-transfer-filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 16px;
        align-items: end;
        padding: 8px 0 12px;
        border-bottom: 1px solid #d6d6d6;
    }

    .fund-transfer-field-box {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .fund-transfer-field-box label {
        font-size: 12px;
        font-weight: 700;
        color: #1e1e1e;
        text-transform: uppercase;
        margin: 0;
    }

    .fund-transfer-field-box .form-control {
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
        min-width: 80px;
        height: 34px;
        border-radius: 0;
        box-shadow: none;
    }

    .fund-transfer-pagination {
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

    .fund-transfer-table-wrap {
        border: 1px solid #d5d5d5;
        background: #fff;
        overflow-x: auto;
    }

    .fund-transfer-table {
        min-width: 1400px;
        margin: 0;
        border-collapse: collapse;
    }

    .fund-transfer-table thead th {
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

    .fund-transfer-table tbody td {
        font-size: 12px;
        padding: 9px 10px;
        border: 1px solid #d8d8d8;
        color: #2b2b2b;
        white-space: nowrap;
        background: #fff;
    }

    .fund-transfer-table tbody tr:nth-child(odd) td {
        background: #f7f7f7;
    }

    .fund-transfer-modal-footer {
        background: #f4f4f4;
        border-top: 1px solid #d7d7d7;
        padding: 12px 16px;
        justify-content: flex-end;
    }

    .fund-transfer-close-action {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 0;
        min-width: 90px;
        padding: 8px 18px;
    }

    .fund-transfer-clear-modal-dialog {
        max-width: 460px;
        width: 460px;
    }

    .fund-transfer-clear-modal-content {
        border-radius: 0;
        border: 1px solid #d7d7d7;
        box-shadow: none;
    }

    .fund-transfer-clear-header {
        background: #0d7291;
        color: #fff;
        border-bottom: 1px solid #0a5f7e;
        min-height: 52px;
        padding: 12px 16px;
        position: relative;
    }

    .fund-transfer-clear-title {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin: 0;
    }

    .fund-transfer-clear-body {
        background: #f5f5f5;
        font-size: 15px;
        color: #2a2a2a;
        padding: 22px 20px;
    }

    .fund-transfer-clear-footer {
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
        .fund-transfer-btn {
            padding: 7px 10px;
            font-size: 11px;
        }

        .split-row {
            grid-template-columns: 1fr;
        }

        .fund-transfer-field-group {
            border-right: none;
            border-bottom: 1px solid #d9d9d9;
        }

        .fund-transfer-field-group:last-child {
            border-bottom: none;
        }

        .fund-transfer-actions {
            justify-content: flex-end;
            flex-wrap: nowrap;
        }

        .fund-transfer-filter-row {
            grid-template-columns: 1fr;
        }

        .fund-transfer-modal-dialog {
            max-width: 94vw;
            width: 94vw;
            margin: 1rem auto;
        }
    }
</style>

@endsection
