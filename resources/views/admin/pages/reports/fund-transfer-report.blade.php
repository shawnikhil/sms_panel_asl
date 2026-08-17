@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Report</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">Fund transfer details</span>
        </div>
    </div>

    {{-- ── Find Fund Transfer Details Filter Card ── --}}
    <div class="sms-card-shell mb-4">
        <div class="sms-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">Find Fund Transfer Details -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#fundFilterBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>
        
        <div class="collapse show" id="fundFilterBody">
            <div class="sms-card-body p-4">
                <form id="fundSearchForm" onsubmit="event.preventDefault(); applyFundFilters();">
                    <div class="row g-3 justify-content-center">
                        {{-- Row 1 --}}
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">COMPANY NAME</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_company_name" class="form-control sms-input" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">USER NAME</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_user_name" class="form-control sms-input" placeholder="" />
                                </div>
                            </div>
                        </div>

                        {{-- Row 2 --}}
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">REG NO</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_reg_no" class="form-control sms-input" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">TRANSACTION DESC</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_trans_desc" class="form-control sms-input" placeholder="" />
                                </div>
                            </div>
                        </div>

                        {{-- Row 3 --}}
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">FROM DATE</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="date" id="filter_from_date" class="form-control sms-input" />
                                        <button class="btn btn-light border sms-calendar-btn" type="button" onclick="document.getElementById('filter_from_date').showPicker ? document.getElementById('filter_from_date').showPicker() : document.getElementById('filter_from_date').focus()">
                                            <i class="bx bx-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="row align-items-center">
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">TO DATE</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="date" id="filter_to_date" class="form-control sms-input" />
                                        <button class="btn btn-light border sms-calendar-btn" type="button" onclick="document.getElementById('filter_to_date').showPicker ? document.getElementById('filter_to_date').showPicker() : document.getElementById('filter_to_date').focus()">
                                            <i class="bx bx-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons Row --}}
                        <div class="col-12 mt-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="submit" class="btn sms-btn-search px-4">
                                    SEARCH
                                </button>
                                <button type="button" class="btn sms-btn-clear px-4" onclick="clearFundFilters()">
                                    CLEAR
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Fund Transfer Details Table Card ── --}}
    <div class="sms-card-shell">
        <div class="sms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">Fund Transfer Details -</span>
            </div>

            {{-- Action Tools (Orange Print & Export Buttons) --}}
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bx bx-check"></i> PRINT
                </button>
                <button class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="exportFundTableToCSV('fund-transfer-report.csv')">
                    <i class="bx bx-check"></i> EXPORT
                </button>
            </div>
        </div>

        <div class="sms-card-body p-0">
            
            {{-- Top Pagination Controls --}}
            <div class="d-flex flex-wrap align-items-center justify-content-center px-3 py-3 border-bottom">
                <div class="sms-pagination-container">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0 justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap" style="max-height: 600px; overflow-x: auto;">
                <table class="table table-hover fund-transfer-table mb-0" id="fundTransferTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>REG NO</th>
                            <th>COMPANY NAME</th>
                            <th>REQUEST TYPE</th>
                            <th>TRANSFER TYPE</th>
                            <th class="text-end">TRANSFER AMOUNT</th>
                            <th class="text-end">OPENING BALANCE</th>
                            <th class="text-end">CLOSING BALANCE</th>
                            <th>WALLET TYPE</th>
                            <th>TRANSACTION DESC</th>
                            <th>TRANSACTION ID</th>
                            <th>TRANSACTION DATE/TIME</th>
                            <th>REQUEST ID</th>
                            <th>INSERT DATE</th>
                        </tr>
                    </thead>
                    <tbody id="fundTableBody">
                        @php
                            $fundTransfers = [
                                [
                                    'id' => 1,
                                    'reg_no' => '3905',
                                    'company_name' => 'sahistapay',
                                    'user_name' => 'SAHISTA PAY',
                                    'request_type' => 'BY ADMIN',
                                    'transfer_type' => 'FUND TRANSFER',
                                    'amount' => 500,
                                    'opening_bal' => '0.00',
                                    'closing_bal' => '500.00',
                                    'wallet_type' => 'PREPAID BALANCE',
                                    'trans_desc' => '-',
                                    'trans_id' => '-',
                                    'trans_date' => '06/06/2026 01:09:41 PM',
                                    'request_id' => '-',
                                    'insert_date' => '06-06-2026',
                                ],
                                [
                                    'id' => 2,
                                    'reg_no' => '3902',
                                    'company_name' => 'ASL WALLETS',
                                    'user_name' => 'NIKHIL KUMAR',
                                    'request_type' => 'BY ADMIN',
                                    'transfer_type' => 'FUND TRANSFER',
                                    'amount' => 500,
                                    'opening_bal' => '0.00',
                                    'closing_bal' => '500.00',
                                    'wallet_type' => 'PREPAID BALANCE',
                                    'trans_desc' => 'ui',
                                    'trans_id' => '-',
                                    'trans_date' => '13/05/2026 03:51:41 PM',
                                    'request_id' => '-',
                                    'insert_date' => '13-05-2026',
                                ],
                            ];
                        @endphp

                        @foreach($fundTransfers as $row)
                        <tr class="fund-row"
                            data-company="{{ $row['company_name'] }}"
                            data-user="{{ $row['user_name'] }}"
                            data-reg-no="{{ $row['reg_no'] }}"
                            data-desc="{{ $row['trans_desc'] }}"
                            data-amount="{{ $row['amount'] }}"
                            data-wallet="{{ $row['wallet_type'] }}"
                            data-date="{{ $row['insert_date'] }}">
                            
                            <td class="text-muted fw-bold">{{ $row['id'] }}</td>
                            
                            <td>
                                <span class="fund-regno">{{ $row['reg_no'] }}</span>
                            </td>

                            <td>
                                <span class="fw-semibold text-secondary">{{ $row['company_name'] }}</span>
                            </td>

                            <td>
                                <span class="badge bg-label-secondary font-monospace" style="font-size: 0.72rem;">{{ $row['request_type'] }}</span>
                            </td>

                            <td>
                                <span class="fund-trans-type">{{ $row['transfer_type'] }}</span>
                            </td>

                            <td class="text-end fw-bold fund-amount-cell">
                                {{ $row['amount'] }}
                            </td>

                            <td class="text-end text-muted font-monospace">
                                {{ $row['opening_bal'] }}
                            </td>

                            <td class="text-end fw-bold text-success font-monospace">
                                {{ $row['closing_bal'] }}
                            </td>

                            <td>
                                <span class="badge fund-wallet-badge">{{ $row['wallet_type'] }}</span>
                            </td>

                            <td>
                                <span class="text-secondary">{{ $row['trans_desc'] }}</span>
                            </td>

                            <td>
                                <span class="font-monospace text-muted">{{ $row['trans_id'] }}</span>
                            </td>

                            <td>
                                <span class="text-nowrap" style="font-size: 0.78rem;">{{ $row['trans_date'] }}</span>
                            </td>

                            <td>
                                <span class="font-monospace text-muted">{{ $row['request_id'] }}</span>
                            </td>

                            <td>
                                <span class="text-nowrap" style="font-size: 0.78rem;">{{ $row['insert_date'] }}</span>
                            </td>
                        </tr>
                        @endforeach

                        {{-- Total Summary Row Matching Screenshot --}}
                        <tr class="fund-summary-row bg-light">
                            <td colspan="5" class="text-end fw-bold text-dark pe-3">
                                <strong>TOTAL</strong>
                            </td>
                            <td colspan="9" class="p-2">
                                <div class="fund-total-box font-monospace">
                                    <div class="d-flex justify-content-between gap-4 py-1">
                                        <span class="text-secondary fw-semibold">PREPAID</span>
                                        <span>:</span>
                                        <span class="fw-bold text-dark text-end" id="summaryPrepaidTotal">1000</span>
                                    </div>
                                    <div class="d-flex justify-content-between gap-4 py-1">
                                        <span class="text-secondary fw-semibold">UTILITY</span>
                                        <span>:</span>
                                        <span class="fw-bold text-dark text-end" id="summaryUtilityTotal">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between gap-4 py-1">
                                        <span class="text-secondary fw-semibold">BANK</span>
                                        <span>:</span>
                                        <span class="fw-bold text-dark text-end" id="summaryBankTotal">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between gap-4 py-1 border-top border-dark-subtle mt-1">
                                        <span class="fw-bold text-dark">TOTAL</span>
                                        <span>:</span>
                                        <span class="fw-bold text-primary text-end" id="summaryGrandTotal">1000</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Bottom Pagination --}}
            <div class="d-flex flex-wrap align-items-center justify-content-center p-3 border-top bg-light-subtle">
                <div class="sms-pagination-container">
                    <nav aria-label="Bottom page navigation">
                        <ul class="pagination pagination-sm mb-0 justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">»</a></li>
                        </ul>
                    </nav>
                </div>
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

    .sms-calendar-btn {
        border-radius: 0 3px 3px 0;
        padding: 0.35rem 0.65rem;
        background: #f8f9fa;
        color: #64748b;
    }
    html.dark .sms-calendar-btn {
        background: #1e293b;
        border-color: #334155 !important;
        color: #94a3b8;
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

    /* Orange Print & Export Buttons Matching Screenshot */
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
    .fund-transfer-table thead th {
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
    html.dark .fund-transfer-table thead th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }

    .fund-transfer-table tbody td {
        font-size: 0.8125rem !important;
        padding: 0.55rem 0.75rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    html.dark .fund-transfer-table tbody td {
        border-bottom-color: #1e293b !important;
    }

    .fund-regno {
        font-family: var(--font-mono), monospace;
        font-weight: 600;
        color: #4338ca;
        font-size: 0.8rem;
    }
    html.dark .fund-regno {
        color: #a5b4fc;
    }

    .fund-trans-type {
        font-weight: 600;
        font-size: 0.78rem;
        color: #334155;
    }
    html.dark .fund-trans-type {
        color: #cbd5e1;
    }

    .fund-amount-cell {
        color: #0f172a;
        font-family: var(--font-mono), monospace;
        font-size: 0.85rem;
    }
    html.dark .fund-amount-cell {
        color: #f8fafc;
    }

    .fund-wallet-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 700;
        border: 1px solid #e2e8f0;
    }
    html.dark .fund-wallet-badge {
        background: #1e293b;
        color: #94a3b8;
        border-color: #334155;
    }

    /* Summary Breakdown Box */
    .fund-total-box {
        max-width: 180px;
        font-size: 0.78rem;
        background: #ffffff;
        padding: 0.5rem 0.75rem;
        border: 1px dashed #cbd5e1;
        border-radius: 4px;
    }
    html.dark .fund-total-box {
        background: #0f172a;
        border-color: #334155;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Filter Logic
    function applyFundFilters() {
        const company = document.getElementById('filter_company_name').value.trim().toLowerCase();
        const user = document.getElementById('filter_user_name').value.trim().toLowerCase();
        const regNo = document.getElementById('filter_reg_no').value.trim().toLowerCase();
        const desc = document.getElementById('filter_trans_desc').value.trim().toLowerCase();
        const fromDate = document.getElementById('filter_from_date').value;
        const toDate = document.getElementById('filter_to_date').value;

        const rows = document.querySelectorAll('#fundTableBody tr.fund-row');
        let prepaidTotal = 0;
        let utilityTotal = 0;
        let bankTotal = 0;

        rows.forEach(row => {
            const rCompany = (row.dataset.company || '').toLowerCase();
            const rUser = (row.dataset.user || '').toLowerCase();
            const rRegNo = (row.dataset.regNo || '').toLowerCase();
            const rDesc = (row.dataset.desc || '').toLowerCase();
            const rAmount = parseFloat(row.dataset.amount || 0);
            const rWallet = (row.dataset.wallet || '').toUpperCase();

            let match = true;
            if (company && !rCompany.includes(company)) match = false;
            if (user && !rUser.includes(user)) match = false;
            if (regNo && !rRegNo.includes(regNo)) match = false;
            if (desc && !rDesc.includes(desc)) match = false;

            if (match) {
                row.style.display = '';
                if (rWallet.includes('PREPAID')) prepaidTotal += rAmount;
                else if (rWallet.includes('UTILITY')) utilityTotal += rAmount;
                else if (rWallet.includes('BANK')) bankTotal += rAmount;
            } else {
                row.style.display = 'none';
            }
        });

        // Update totals
        document.getElementById('summaryPrepaidTotal').innerText = prepaidTotal;
        document.getElementById('summaryUtilityTotal').innerText = utilityTotal;
        document.getElementById('summaryBankTotal').innerText = bankTotal;
        document.getElementById('summaryGrandTotal').innerText = (prepaidTotal + utilityTotal + bankTotal);
    }

    // Clear Filters
    function clearFundFilters() {
        document.getElementById('filter_company_name').value = '';
        document.getElementById('filter_user_name').value = '';
        document.getElementById('filter_reg_no').value = '';
        document.getElementById('filter_trans_desc').value = '';
        document.getElementById('filter_from_date').value = '';
        document.getElementById('filter_to_date').value = '';

        const rows = document.querySelectorAll('#fundTableBody tr.fund-row');
        let total = 0;
        rows.forEach(row => {
            row.style.display = '';
            total += parseFloat(row.dataset.amount || 0);
        });

        document.getElementById('summaryPrepaidTotal').innerText = total;
        document.getElementById('summaryUtilityTotal').innerText = 0;
        document.getElementById('summaryBankTotal').innerText = 0;
        document.getElementById('summaryGrandTotal').innerText = total;
    }

    // Export CSV Helper
    function exportFundTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#fundTransferTable tr");
        
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
