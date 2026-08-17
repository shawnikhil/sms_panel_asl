@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Manage API User</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">Fund Transfer</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Enterprise Style --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="submitFundTransfer()">
                <i class="bx bx-check"></i> SEND
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#viewFundTransferModal">
                <i class="bx bx-show"></i> VIEW
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearFundTransferForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="fundTransferForm" onsubmit="event.preventDefault(); submitFundTransfer();">
                <input type="hidden" id="transfer_id" value="" />

                {{-- Row 1: API User --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        API USER <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <select id="api_user_select" class="form-select sms-input" required>
                            <option value="">-- Select --</option>
                            <option value="GAURAV KUMAR : M - 8348920759 [BAL: 0.00]">GAURAV KUMAR : M - 8348920759 [BAL: 0.00]</option>
                            <option value="NIKHIL KUMAR : M - 8709305218 [BAL: 227.40]">NIKHIL KUMAR : M - 8709305218 [BAL: 227.40]</option>
                            <option value="SAHISTA PAY : M - 9800546248 [BAL: 478.48]">SAHISTA PAY : M - 9800546248 [BAL: 478.48]</option>
                            <option value="TEST KUMAR : M - 9973732671 [BAL: 0.00]">TEST KUMAR : M - 9973732671 [BAL: 0.00]</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2: Transfer Amount & Transaction Date --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        TRANSFER AMOUNT <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="number" step="0.01" id="transfer_amount" class="form-control sms-input" placeholder="0.00" required />
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        TRANSACTION DATE
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <div class="input-group">
                            <input type="date" id="transaction_date" class="form-control sms-input" value="{{ date('Y-m-d') }}" />
                            <button class="btn btn-light border sms-calendar-btn" type="button" onclick="document.getElementById('transaction_date').showPicker ? document.getElementById('transaction_date').showPicker() : document.getElementById('transaction_date').focus()">
                                <i class="bx bx-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Row 3: Transfer Type & Wallet Type --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        TRANSFER TYPE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="transfer_type" class="form-select sms-input" required>
                            <option value="FUND TRANSFER" selected>FUND TRANSFER</option>
                            <option value="CREDIT ADJUSTMENT">CREDIT ADJUSTMENT</option>
                            <option value="DEBIT ADJUSTMENT">DEBIT ADJUSTMENT</option>
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        WALLET TYPE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="wallet_type" class="form-select sms-input" required>
                            <option value="PREPAID BALANCE" selected>PREPAID BALANCE</option>
                            <option value="UTILITY BALANCE">UTILITY BALANCE</option>
                            <option value="BANK WALLET">BANK WALLET</option>
                        </select>
                    </div>
                </div>

                {{-- Row 4: Transaction Desc --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        TRANSACTION DESC
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="transaction_desc" class="form-control sms-input" placeholder="Optional remark or notes..." />
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SEND
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary d-inline-flex align-items-center gap-1 px-3" onclick="sendTransferOTP()">
                                <i class="bx bx-mobile-alt"></i> SEND OTP
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearFundTransferForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit Fund Transfer Details Modal ── --}}
<div class="modal fade" id="viewFundTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT FUND TRANSFER DETAILS !
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
                                <input type="text" id="modal_filter_user" class="form-control sms-input" placeholder="" oninput="filterFundTransferModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">TRAN ID</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_tran" class="form-control sms-input" placeholder="" oninput="filterFundTransferModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetFundTransferModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Fund transfer modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle" id="fundTransferModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>TRAN ID</th>
                                <th>REG NO</th>
                                <th>COMPANY NAME</th>
                                <th>USER NAME</th>
                                <th>TRANSFER TYPE</th>
                                <th class="text-end">TRANSFER AMOUNT</th>
                                <th>WALLET TYPE</th>
                                <th class="text-end">OPENING BAL</th>
                                <th class="text-end">CLOSING BAL</th>
                            </tr>
                        </thead>
                        <tbody id="fundTransferModalTbody">
                            @php
                                $transferRecords = [
                                    [
                                        'id' => 1,
                                        'tran_id' => '1771146747209',
                                        'reg_no' => '3902',
                                        'company' => 'ASL WALLETS',
                                        'user' => 'Nikhil Kumar',
                                        'type' => 'FUND TRANSFER',
                                        'amount' => '500.00',
                                        'wallet' => 'PREPAID BALANCE',
                                        'open_bal' => '0.00',
                                        'close_bal' => '500.00'
                                    ],
                                    [
                                        'id' => 2,
                                        'tran_id' => '1771146748301',
                                        'reg_no' => '3905',
                                        'company' => 'sahistapay',
                                        'user' => 'sahista pay',
                                        'type' => 'FUND TRANSFER',
                                        'amount' => '500.00',
                                        'wallet' => 'PREPAID BALANCE',
                                        'open_bal' => '0.00',
                                        'close_bal' => '500.00'
                                    ]
                                ];
                            @endphp

                            @foreach($transferRecords as $record)
                            <tr class="transfer-record-row"
                                style="cursor: pointer;"
                                data-user="{{ $record['user'] }}"
                                data-tran="{{ $record['tran_id'] }}"
                                data-amount="{{ $record['amount'] }}"
                                data-wallet="{{ $record['wallet'] }}"
                                data-type="{{ $record['type'] }}"
                                onclick="selectTransferRecord({{ json_encode($record) }})">
                                <td class="text-center text-muted fw-bold">{{ $record['id'] }}</td>
                                <td><span class="badge bg-label-secondary font-monospace">{{ $record['tran_id'] }}</span></td>
                                <td><span class="font-monospace text-primary fw-bold">{{ $record['reg_no'] }}</span></td>
                                <td><span class="fw-semibold text-secondary">{{ $record['company'] }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $record['user'] }}</span></td>
                                <td><span class="badge bg-label-info">{{ $record['type'] }}</span></td>
                                <td class="text-end font-monospace fw-bold text-success">{{ $record['amount'] }}</td>
                                <td><span class="badge bg-label-primary">{{ $record['wallet'] }}</span></td>
                                <td class="text-end font-monospace text-muted">{{ $record['open_bal'] }}</td>
                                <td class="text-end font-monospace fw-bold text-dark">{{ $record['close_bal'] }}</td>
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

    .sms-calendar-btn {
        background-color: #f8f9fa;
        color: #495057;
    }
    html.dark .sms-calendar-btn {
        background-color: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
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
    .transfer-record-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .transfer-record-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Submit Fund Transfer
    function submitFundTransfer() {
        const user = document.getElementById('api_user_select').value;
        const amount = document.getElementById('transfer_amount').value;
        const type = document.getElementById('transfer_type').value;
        const wallet = document.getElementById('wallet_type').value;

        if (!user) {
            alert('Please select API USER!');
            document.getElementById('api_user_select').focus();
            return;
        }

        if (!amount || parseFloat(amount) <= 0) {
            alert('Please enter a valid TRANSFER AMOUNT!');
            document.getElementById('transfer_amount').focus();
            return;
        }

        alert(`Fund Transfer of ₹${parseFloat(amount).toFixed(2)} to [${user}] initiated successfully!`);
    }

    // Send OTP
    function sendTransferOTP() {
        const user = document.getElementById('api_user_select').value;
        if (!user) {
            alert('Please select API USER first!');
            return;
        }
        alert(`OTP has been sent to registered mobile for ${user}.`);
    }

    // Clear Form
    function clearFundTransferForm() {
        document.getElementById('transfer_id').value = '';
        document.getElementById('api_user_select').value = '';
        document.getElementById('transfer_amount').value = '';
        document.getElementById('transfer_type').value = 'FUND TRANSFER';
        document.getElementById('wallet_type').value = 'PREPAID BALANCE';
        document.getElementById('transaction_desc').value = '';
    }

    // Modal Selection
    function selectTransferRecord(rec) {
        document.getElementById('transfer_id').value = rec.id;
        document.getElementById('transfer_amount').value = rec.amount;
        document.getElementById('transfer_type').value = rec.type;
        document.getElementById('wallet_type').value = rec.wallet;

        // Try select matching user
        const select = document.getElementById('api_user_select');
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text.includes(rec.user) || select.options[i].text.includes(rec.reg_no)) {
                select.selectedIndex = i;
                break;
            }
        }

        // Close modal
        const modalEl = document.getElementById('viewFundTransferModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterFundTransferModalTable() {
        const filterUser = (document.getElementById('modal_filter_user').value || '').trim().toLowerCase();
        const filterTran = (document.getElementById('modal_filter_tran').value || '').trim().toLowerCase();

        document.querySelectorAll('#fundTransferModalTbody tr.transfer-record-row').forEach(row => {
            const user = (row.dataset.user || '').toLowerCase();
            const tran = (row.dataset.tran || '').toLowerCase();

            let match = true;
            if (filterUser && !user.includes(filterUser)) match = false;
            if (filterTran && !tran.includes(filterTran)) match = false;

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetFundTransferModalFilter() {
        document.getElementById('modal_filter_user').value = '';
        document.getElementById('modal_filter_tran').value = '';
        document.querySelectorAll('#fundTransferModalTbody tr.transfer-record-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
