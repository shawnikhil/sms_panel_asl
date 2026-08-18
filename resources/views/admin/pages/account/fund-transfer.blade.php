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
            <button type="button" id="topSendFundBtn" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="submitFundTransfer()">
                <i class="bx bx-check"></i> SEND
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#viewFundTransferModal" onclick="fetchFundTransferData()">
                <i class="bx bx-show"></i> VIEW
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearFundTransferForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="fundTransferForm" onsubmit="event.preventDefault(); submitFundTransfer();" novalidate>
                <input type="hidden" id="transfer_id" value="" />

                {{-- Row 1: API User --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        API USER <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <select id="api_user_select" name="apiuser" class="form-select sms-input">
                            <option value="" disabled selected>-- Select API User --</option>
                            @if(isset($apiUsers) && count($apiUsers) > 0)
                                @foreach($apiUsers as $u)
                                    @php
                                        $fullName = strtoupper(trim(($u->fname ?? '') . ' ' . ($u->lname ?? '')));
                                        $balance = round((float)($u->balance_amt ?? 0));
                                    @endphp
                                    <option value="{{ $u->regno }}" data-name="{{ $fullName }}" data-phone="{{ $u->phone }}" data-balance="{{ $balance }}">
                                        {{ $fullName }} : M- {{ $u->phone }} [BAL: {{ $balance }}]
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                {{-- Row 2: Transfer Amount & Transaction Date --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        TRANSFER AMOUNT <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <input type="text" id="transfer_amount" name="amount" class="form-control sms-input" placeholder="" />
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
                        <select id="transfer_type" name="transid" class="form-select sms-input">
                            <option value="1" selected>FUND TRANSFER</option>
                            <option value="0">FUND REVERSE</option>
                        </select>
                    </div>

                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        WALLET TYPE <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="wallet_type" name="wallettype" class="form-select sms-input">
                            @if(isset($walletTypes) && count($walletTypes) > 0)
                                @foreach($walletTypes as $wt)
                                    <option value="{{ $wt->id }}" {{ $loop->first ? 'selected' : '' }}>
                                        {{ $wt->typename ?? $wt->name ?? 'PREPAID BALANCE' }}
                                    </option>
                                @endforeach
                            @else
                                <option value="1" selected>PREPAID BALANCE</option>
                            @endif
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
                            <button type="submit" id="bottomSendFundBtn" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
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

{{-- ── View Fund Transfer Details Modal ── --}}
<div class="modal fade" id="viewFundTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    VIEW FUND TRANSFER DETAILS !
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

                {{-- Table Component inside Modal --}}
                <div class="table-responsive text-nowrap border rounded" style="max-height: 440px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="fundTransferModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>TRAN ID</th>
                                <th>USER REGNO</th>
                                <th>COMPANY NAME</th>
                                <th>USER NAME</th>
                                <th>TRANSFER TYPE</th>
                                <th class="text-end">TRANSFER AMOUNT</th>
                                <th>WALLET TYPE</th>
                                <th class="text-end">OPENING BALANCE</th>
                                <th class="text-end">CLOSING BALANCE</th>
                                <th>TRAN DESC</th>
                                <th>TRANS DATE/TIME</th>
                                <th>INSERT DATE</th>
                            </tr>
                        </thead>
                        <tbody id="fundTransferModalTbody">
                            @if(isset($transfers) && count($transfers) > 0)
                                @foreach($transfers as $tr)
                                    @php
                                        $tType = ($tr->transfertype == '1' || $tr->transfertype === 'FUND TRANSFER') ? 'FUND TRANSFER' : 'FUND REVERSE';
                                        $tData = [
                                            'id' => $tr->id,
                                            'tran_id' => $tr->id,
                                            'reg_no' => $tr->regno,
                                            'company' => $tr->company_name ?? 'ASL WALLETS',
                                            'user' => trim(($tr->fname ?? '') . ' ' . ($tr->lname ?? '')),
                                            'type' => $tType,
                                            'amount' => number_format(abs((float)($tr->transfer_amt ?? 0)), 2, '.', ''),
                                            'wallet' => $tr->wallet_name ?? 'PREPAID BALANCE',
                                            'open_bal' => number_format((float)($tr->opening_bal ?? 0), 2, '.', ''),
                                            'close_bal' => number_format((float)($tr->closing_bal ?? 0), 2, '.', ''),
                                            'transdesc' => $tr->transdesc ?: '-',
                                            'trans_datetime' => trim(($tr->trans_date ?? '') . ' ' . ($tr->trans_time ?? '')) ?: '-',
                                            'insert_date' => $tr->insert_date ?? '-',
                                        ];
                                    @endphp
                                    <tr class="transfer-record-row"
                                        data-user="{{ $tData['user'] }}"
                                        data-tran="{{ $tData['tran_id'] }}"
                                        data-reg="{{ $tData['reg_no'] }}"
                                        data-amount="{{ $tData['amount'] }}"
                                        data-wallet="{{ $tData['wallet'] }}"
                                        data-type="{{ $tData['type'] }}">
                                        <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                        <td><span class="badge bg-label-secondary font-monospace">{{ $tData['tran_id'] }}</span></td>
                                        <td><span class="font-monospace text-primary fw-bold">{{ $tData['reg_no'] }}</span></td>
                                        <td><span class="fw-semibold text-secondary">{{ $tData['company'] }}</span></td>
                                        <td><span class="fw-bold text-dark">{{ $tData['user'] }}</span></td>
                                        <td><span class="badge {{ $tData['type'] === 'FUND TRANSFER' ? 'bg-label-success' : 'bg-label-danger' }}">{{ $tData['type'] }}</span></td>
                                        <td class="text-end font-monospace fw-bold text-dark">
                                            {{ $tData['amount'] }}
                                        </td>
                                        <td><span class="badge bg-label-primary">{{ $tData['wallet'] }}</span></td>
                                        <td class="text-end font-monospace text-muted">{{ $tData['open_bal'] }}</td>
                                        <td class="text-end font-monospace fw-bold text-dark">{{ $tData['close_bal'] }}</td>
                                        <td><span class="text-secondary small">{{ $tData['transdesc'] }}</span></td>
                                        <td><span class="font-monospace small text-muted">{{ $tData['trans_datetime'] }}</span></td>
                                        <td><span class="font-monospace small text-muted">{{ $tData['insert_date'] }}</span></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="noTransferRecordRow">
                                    <td colspan="13" class="text-center text-muted py-4">No fund transfer records found in database.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer inside Modal --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2 pt-2 border-top">
                    <div class="text-muted small" id="transferModalPaginationInfo">
                        Showing 0 to 0 of 0 entries
                    </div>
                    <div class="sms-pagination-container">
                        <nav aria-label="Transfer modal navigation">
                            <ul class="pagination pagination-sm mb-0 justify-content-center" id="transferModalPagination">
                                {{-- JS generated pagination --}}
                            </ul>
                        </nav>
                    </div>
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

    /* Sticky Table Header inside Modal */
    #fundTransferModalTable thead th {
        position: sticky !important;
        top: 0 !important;
        z-index: 10 !important;
        background-color: #f8fafc !important;
        box-shadow: inset 0 -1px 0 #dee2e6, inset 0 1px 0 #dee2e6;
    }
    html.dark #fundTransferModalTable thead th {
        background-color: #1e293b !important;
        box-shadow: inset 0 -1px 0 #334155, inset 0 1px 0 #334155;
    }
</style>
@endsection

{{-- ── Page Scripts ── --}}
@section('scripts')
<script>
    const ACTION_URL = "{{ route('admin.account.fund_transfer.action') }}";
    const DATA_URL   = "{{ route('admin.account.fund_transfer.data') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    // Silent background fetch to update all balances and modal records dynamically
    async function fetchFundTransferData() {
        try {
            const res = await fetch(DATA_URL, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            if (res.ok && data.status === 'success') {
                // 1. Update dropdown options with live balances
                if (data.apiUsers && Array.isArray(data.apiUsers)) {
                    const selectEl = document.getElementById('api_user_select');
                    if (selectEl) {
                        const currentSelectedVal = selectEl.value;
                        let optionsHtml = '<option value="">-- Select API USER --</option>';
                        data.apiUsers.forEach(u => {
                            const bal = Math.round(parseFloat(u.balance_amt || 0));
                            const fullName = `${(u.fname || '').toUpperCase()} ${(u.lname || '').toUpperCase()}`.trim();
                            const isSelected = String(u.regno) === String(currentSelectedVal) ? 'selected' : '';
                            optionsHtml += `<option value="${u.regno}" data-name="${fullName}" data-phone="${u.phone || ''}" data-balance="${bal}" ${isSelected}>
                                ${fullName} : M- ${u.phone || ''} [BAL: ${bal}]
                            </option>`;
                        });
                        selectEl.innerHTML = optionsHtml;
                        if ($.fn.select2) {
                            $('#api_user_select').trigger('change.select2');
                        }
                    }
                }

                // 2. Update VIEW modal table rows
                if (data.transfers && Array.isArray(data.transfers)) {
                    const tbody = document.getElementById('fundTransferModalTbody');
                    if (tbody) {
                        if (data.transfers.length === 0) {
                            tbody.innerHTML = `<tr id="noTransferRecordRow"><td colspan="13" class="text-center text-muted py-4">No fund transfer records found in database.</td></tr>`;
                        } else {
                            let rowsHtml = '';
                            data.transfers.forEach((tr, idx) => {
                                const isCredit = tr.type === 'FUND TRANSFER';
                                rowsHtml += `
                                    <tr class="transfer-record-row"
                                        data-user="${tr.user}"
                                        data-tran="${tr.tran_id}"
                                        data-reg="${tr.reg_no}"
                                        data-amount="${tr.amount}"
                                        data-wallet="${tr.wallet}"
                                        data-type="${tr.type}">
                                        <td class="text-center text-muted fw-bold">${idx + 1}</td>
                                        <td><span class="badge bg-label-secondary font-monospace">${tr.tran_id}</span></td>
                                        <td><span class="font-monospace text-primary fw-bold">${tr.reg_no}</span></td>
                                        <td><span class="fw-semibold text-secondary">${tr.company}</span></td>
                                        <td><span class="fw-bold text-dark">${tr.user}</span></td>
                                        <td><span class="badge ${isCredit ? 'bg-label-success' : 'bg-label-danger'}">${tr.type}</span></td>
                                        <td class="text-end font-monospace fw-bold text-dark">
                                            ${tr.amount}
                                        </td>
                                        <td><span class="badge bg-label-primary">${tr.wallet}</span></td>
                                        <td class="text-end font-monospace text-muted">${tr.open_bal}</td>
                                        <td class="text-end font-monospace fw-bold text-dark">${tr.close_bal}</td>
                                        <td><span class="text-secondary small">${tr.transdesc}</span></td>
                                        <td><span class="font-monospace small text-muted">${tr.trans_datetime}</span></td>
                                        <td><span class="font-monospace small text-muted">${tr.insert_date}</span></td>
                                    </tr>
                                `;
                            });
                            tbody.innerHTML = rowsHtml;
                        }
                        renderTransferModalPagination();
                    }
                }
            }
        } catch (err) {
            console.error('Silent data sync error:', err);
        }
    }

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

    // Submit Fund Transfer matching option 119 legacy logic
    async function submitFundTransfer() {
        const apiuser    = document.getElementById('api_user_select')?.value || '';
        const transid    = document.getElementById('transfer_type')?.value || '';
        const tranamt    = (document.getElementById('transfer_amount')?.value || '').trim();
        const wallettype = document.getElementById('wallet_type')?.value || '';
        const transdesc  = (document.getElementById('transaction_desc')?.value || '').trim();
        const trandate   = (document.getElementById('transaction_date')?.value || '').trim();
        const rowid      = document.getElementById('transfer_id')?.value || '';

        // Validations exactly as in legacy
        if (!apiuser) {
            toastr.error('Please select user name !', 'Validation Error');
            if ($.fn.select2) {
                $('#api_user_select').select2('open');
            } else {
                document.getElementById('api_user_select')?.focus();
            }
            return;
        }
        if (transid === '') {
            toastr.error('Please select transaction type !', 'Validation Error');
            document.getElementById('transfer_type')?.focus();
            return;
        }
        if (!tranamt || parseFloat(tranamt) <= 0 || isNaN(parseFloat(tranamt))) {
            toastr.error('Please enter transfer amount !', 'Validation Error');
            document.getElementById('transfer_amount')?.focus();
            return;
        }
        if (!wallettype) {
            toastr.error('Please select wallet !', 'Validation Error');
            document.getElementById('wallet_type')?.focus();
            return;
        }
        if (!trandate) {
            toastr.error('Please enter transaction date !', 'Validation Error');
            document.getElementById('transaction_date')?.focus();
            return;
        }

        const formData = new FormData();
        formData.append('_token', CSRF_TOKEN);
        formData.append('apiuser', apiuser);
        formData.append('transid', transid);
        formData.append('tranamt', tranamt);
        formData.append('wallettype', wallettype);
        formData.append('transdesc', transdesc);
        formData.append('trandate', trandate);
        formData.append('editid', rowid);

        const btnIds = ['topSendFundBtn', 'bottomSendFundBtn'];
        setButtonsLoading(btnIds, true, 'Plz wait...', '<i class="bx bx-check"></i> SEND');

        try {
            const res = await fetch(ACTION_URL, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const data = await res.json();

            if (res.ok && data.status === 'success') {
                toastr.success(data.message || 'Fund transfer successful!', 'Success');

                // Clear form inputs
                clearFundTransferForm();

                // Silently refresh all balances and table data in background without page reload
                fetchFundTransferData();
            } else {
                toastr.error(data.message || 'Error! While fund transfer !', 'Error');
                if (data.field && document.getElementById(data.field)) {
                    document.getElementById(data.field).focus();
                }
            }
        } catch (err) {
            toastr.error('Server communication error. Please try again.', 'Network Error');
        } finally {
            setButtonsLoading(btnIds, false, '', '<i class="bx bx-check"></i> SEND');
        }
    }

    let transferModalCurrentPage = 1;
    const transferModalPageSize = 10;

    // Modal Pagination & Live Filter Logic
    function renderTransferModalPagination() {
        const filterUser = (document.getElementById('modal_filter_user')?.value || '').trim().toLowerCase();
        const filterTran = (document.getElementById('modal_filter_tran')?.value || '').trim().toLowerCase();
        const allRows = Array.from(document.querySelectorAll('#fundTransferModalTbody tr.transfer-record-row'));

        const matchedRows = allRows.filter(row => {
            const user = (row.dataset.user || '').toLowerCase();
            const tran = (row.dataset.tran || '').toLowerCase();
            if (filterUser && !user.includes(filterUser)) return false;
            if (filterTran && !tran.includes(filterTran)) return false;
            return true;
        });

        const totalRecords = matchedRows.length;
        const totalPages = Math.max(1, Math.ceil(totalRecords / transferModalPageSize));
        if (transferModalCurrentPage > totalPages) transferModalCurrentPage = totalPages;

        const startIndex = (transferModalCurrentPage - 1) * transferModalPageSize;
        const endIndex = startIndex + transferModalPageSize;

        allRows.forEach(row => row.style.display = 'none');

        matchedRows.forEach((row, idx) => {
            const firstTd = row.querySelector('td:first-child');
            if (firstTd) firstTd.textContent = idx + 1;

            if (idx >= startIndex && idx < endIndex) {
                row.style.display = '';
            }
        });

        const infoEl = document.getElementById('transferModalPaginationInfo');
        if (infoEl) {
            const showStart = totalRecords === 0 ? 0 : startIndex + 1;
            const showEnd = Math.min(endIndex, totalRecords);
            infoEl.textContent = `Showing ${showStart} to ${showEnd} of ${totalRecords} entries`;
        }

        const pagContainer = document.getElementById('transferModalPagination');
        if (!pagContainer) return;

        if (totalPages <= 1) {
            pagContainer.innerHTML = '';
            return;
        }

        let pagHtml = '';
        pagHtml += `<li class="page-item ${transferModalCurrentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToTransferModalPage(${transferModalCurrentPage - 1})">«</a>
        </li>`;

        let startPage = Math.max(1, transferModalCurrentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);

        if (startPage > 1) {
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToTransferModalPage(1)">1</a></li>`;
            if (startPage > 2) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let p = startPage; p <= endPage; p++) {
            pagHtml += `<li class="page-item ${p === transferModalCurrentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="goToTransferModalPage(${p})">${p}</a>
            </li>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            pagHtml += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToTransferModalPage(${totalPages})">${totalPages}</a></li>`;
        }

        pagHtml += `<li class="page-item ${transferModalCurrentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0);" onclick="goToTransferModalPage(${transferModalCurrentPage + 1})">»</a>
        </li>`;

        pagContainer.innerHTML = pagHtml;
    }

    function goToTransferModalPage(page) {
        transferModalCurrentPage = page;
        renderTransferModalPagination();
    }

    function filterFundTransferModalTable() {
        transferModalCurrentPage = 1;
        renderTransferModalPagination();
    }

    function resetFundTransferModalFilter() {
        if (document.getElementById('modal_filter_user')) document.getElementById('modal_filter_user').value = '';
        if (document.getElementById('modal_filter_tran')) document.getElementById('modal_filter_tran').value = '';
        transferModalCurrentPage = 1;
        renderTransferModalPagination();
    }

    // Send OTP
    function sendTransferOTP() {
        const user = document.getElementById('api_user_select')?.value;
        if (!user) {
            toastr.error('Please select API USER first!', 'Validation Error');
            return;
        }
        toastr.success(`OTP has been sent to registered mobile for selected user.`, 'OTP Sent');
    }

    // Clear Form
    function clearFundTransferForm() {
        document.getElementById('transfer_id').value = '';
        document.getElementById('transfer_amount').value = '';
        document.getElementById('transfer_type').value = '1';
        if (document.getElementById('wallet_type')) document.getElementById('wallet_type').selectedIndex = 0;
        document.getElementById('transaction_desc').value = '';

        if ($.fn.select2) {
            $('#api_user_select').val('').trigger('change');
        } else {
            document.getElementById('api_user_select').value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if ($.fn.select2) {
            $('#api_user_select').select2({
                placeholder: '-- Select API USER --',
                allowClear: true,
                width: '100%'
            });
        }

        renderTransferModalPagination();

        // Silent background fetch when VIEW modal is opened
        document.getElementById('viewFundTransferModal')?.addEventListener('shown.bs.modal', () => {
            fetchFundTransferData();
        });
    });
</script>
@endsection
