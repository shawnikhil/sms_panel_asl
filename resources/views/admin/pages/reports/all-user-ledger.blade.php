@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Report</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">User ledger details</span>
        </div>
    </div>

    {{-- ── Find User Wise Ledger Filter Card ── --}}
    <div class="sms-card-shell mb-4">
        <div class="sms-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">Find User wise ledger -</span>
            </div>
            <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#ledgerFilterBody" aria-expanded="true">
                <i class="bx bx-chevron-down fs-4"></i>
            </button>
        </div>
        
        <div class="collapse show" id="ledgerFilterBody">
            <div class="sms-card-body p-4">
                <form id="ledgerSearchForm" onsubmit="event.preventDefault(); applyLedgerFilters();">
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
                                <label class="col-sm-4 col-form-label text-sm-end sms-field-label">CONTACT NO</label>
                                <div class="col-sm-8">
                                    <input type="text" id="filter_contact_no" class="form-control sms-input" placeholder="" />
                                </div>
                            </div>
                        </div>

                        {{-- Buttons Row --}}
                        <div class="col-12 mt-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="submit" class="btn sms-btn-search px-4">
                                    SEARCH
                                </button>
                                <button type="button" class="btn sms-btn-clear px-4" onclick="clearLedgerFilters()">
                                    CLEAR
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── User Wise Ledger Table Card ── --}}
    <div class="sms-card-shell">
        <div class="sms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">User wise ledger -</span>
            </div>

            {{-- Action Tools (Orange Print & Export Buttons) --}}
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bx bx-check"></i> PRINT
                </button>
                <button class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="exportLedgerTableToCSV('all-user-ledger.csv')">
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
                <table class="table table-hover user-ledger-table mb-0" id="userLedgerTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>REGNO</th>
                            <th>USER NAME</th>
                            <th>COMAPNY NAME</th>
                            <th>USER CATEGORY</th>
                            <th>CONTACT NO</th>
                            <th>PACKAGE NAME</th>
                            <th class="text-end">CREDIT AMT</th>
                            <th class="text-end">DEBIT AMT</th>
                            <th class="text-end">COMM AMT</th>
                            <th class="text-end">BALANCE</th>
                            <th class="text-center" style="width: 70px;">LEDGER</th>
                        </tr>
                    </thead>
                    <tbody id="ledgerTableBody">
                        @php
                            $ledgerList = [
                                [
                                    'id' => 1,
                                    'reg_no' => '3902',
                                    'user_name' => 'Nikhil Kumar',
                                    'company_name' => 'ASL WALLETS',
                                    'user_category' => '-',
                                    'contact_no' => '8709305218',
                                    'package_name' => 'PREPAID PLAN API',
                                    'credit_amt' => 500.00,
                                    'debit_amt' => 289.60,
                                    'comm_amt' => 0.00,
                                    'balance' => 210.40,
                                ],
                                [
                                    'id' => 2,
                                    'reg_no' => '3903',
                                    'user_name' => 'Gaurav Kumar',
                                    'company_name' => 'ASL WALLETS',
                                    'user_category' => '-',
                                    'contact_no' => '8348920759',
                                    'package_name' => 'PREPAID PLAN API',
                                    'credit_amt' => 0.00,
                                    'debit_amt' => 0.00,
                                    'comm_amt' => 0.00,
                                    'balance' => 0.00,
                                ],
                                [
                                    'id' => 3,
                                    'reg_no' => '3904',
                                    'user_name' => 'test Kumar',
                                    'company_name' => 'ASL WALLETS',
                                    'user_category' => '-',
                                    'contact_no' => '9973732671',
                                    'package_name' => 'PREPAID PLAN API',
                                    'credit_amt' => 0.00,
                                    'debit_amt' => 0.00,
                                    'comm_amt' => 0.00,
                                    'balance' => 0.00,
                                ],
                                [
                                    'id' => 4,
                                    'reg_no' => '3905',
                                    'user_name' => 'sahista pay',
                                    'company_name' => 'sahistapay',
                                    'user_category' => '-',
                                    'contact_no' => '9800546248',
                                    'package_name' => 'PREPAID PLAN API',
                                    'credit_amt' => 500.00,
                                    'debit_amt' => 21.52,
                                    'comm_amt' => 0.00,
                                    'balance' => 478.48,
                                ],
                            ];
                        @endphp

                        @foreach($ledgerList as $row)
                        <tr class="ledger-row"
                            data-reg-no="{{ $row['reg_no'] }}"
                            data-user="{{ $row['user_name'] }}"
                            data-company="{{ $row['company_name'] }}"
                            data-contact="{{ $row['contact_no'] }}"
                            data-credit="{{ $row['credit_amt'] }}"
                            data-debit="{{ $row['debit_amt'] }}"
                            data-comm="{{ $row['comm_amt'] }}"
                            data-balance="{{ $row['balance'] }}">
                            
                            <td class="text-muted fw-bold">{{ $row['id'] }}</td>
                            
                            <td>
                                <span class="ledger-regno">{{ $row['reg_no'] }}</span>
                            </td>

                            <td>
                                <span class="fw-bold text-dark">{{ $row['user_name'] }}</span>
                            </td>

                            <td>
                                <span class="text-secondary fw-semibold">{{ $row['company_name'] }}</span>
                            </td>

                            <td class="text-muted">
                                {{ $row['user_category'] }}
                            </td>

                            <td>
                                <span class="font-monospace text-dark">{{ $row['contact_no'] }}</span>
                            </td>

                            <td>
                                <span class="badge bg-label-info font-monospace">{{ $row['package_name'] }}</span>
                            </td>

                            <td class="text-end font-monospace text-dark fw-semibold">
                                {{ number_format((float)$row['credit_amt'], 2) }}
                            </td>

                            <td class="text-end font-monospace text-danger fw-semibold">
                                {{ number_format((float)$row['debit_amt'], 2) }}
                            </td>

                            <td class="text-end font-monospace text-muted">
                                {{ number_format((float)$row['comm_amt'], 2) }}
                            </td>

                            <td class="text-end font-monospace text-success fw-bold">
                                {{ number_format((float)$row['balance'], 2) }}
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-view-ledger" 
                                        onclick="openLedgerStatementModal({{ json_encode($row) }})">
                                    VIEW
                                </button>
                            </td>
                        </tr>
                        @endforeach

                        {{-- Total Summary Row Matching Screenshot --}}
                        <tr class="ledger-total-row bg-light">
                            <td colspan="7" class="text-end fw-bold text-dark pe-3">
                                <strong>TOTAL</strong>
                            </td>
                            <td class="text-end fw-bold text-dark font-monospace" id="totalCreditAmt">
                                1000.00
                            </td>
                            <td class="text-end fw-bold text-dark font-monospace" id="totalDebitAmt">
                                311.12
                            </td>
                            <td class="text-end fw-bold text-dark font-monospace" id="totalCommAmt">
                                0.00
                            </td>
                            <td class="text-end fw-bold text-primary font-monospace" id="totalBalanceAmt">
                                688.88
                            </td>
                            <td></td>
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

{{-- ── Ledger Statement Modal (Pixel-Perfect Matching Screenshot) ── --}}
<div class="modal fade" id="ledgerStatementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0" id="ledgerModalTitle">
                    LEDGER :: [<span class="text-secondary fw-normal">Regno : </span><span id="modal_ledger_regno" class="fw-bold">3902</span>], [<span class="text-secondary fw-normal">User Name : </span><span id="modal_ledger_user" class="fw-bold">Nikhil Kumar</span>], [<span class="text-secondary fw-normal">Company : </span><span id="modal_ledger_company" class="fw-bold">ASL WALLETS</span>]
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                {{-- Search Bar inside Modal --}}
                <div class="row align-items-center mb-3">
                    <label class="col-sm-3 col-form-label text-sm-end sms-field-label">TRANSACTION DESC</label>
                    <div class="col-sm-7 col-md-6">
                        <input type="text" id="modal_trans_desc" class="form-control sms-input" placeholder="" oninput="filterModalLedger()" />
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetModalLedgerFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Modal ledger navigation">
                            <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center">
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">5</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">6</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">7</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">8</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">9</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">10</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">11</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">12</a></li>
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">...</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">62</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">»</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                {{-- Modal Table --}}
                <div class="table-responsive text-nowrap border rounded" style="max-height: 420px; overflow-y: auto;">
                    <table class="table table-hover table-bordered mb-0 align-middle" id="modalLedgerTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>TRAN DATE</th>
                                <th>NARRATION/REMARKS</th>
                                <th class="text-center">CREDIT AMT</th>
                                <th class="text-center">DEBIT AMT</th>
                                <th class="text-end">OPENING BALANCE</th>
                                <th class="text-end">CLOSING BALANCE</th>
                            </tr>
                        </thead>
                        <tbody id="modal_ledger_tbody">
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 9804421758">
                                <td class="text-center text-muted">1</td>
                                <td>17/08/2026 12:09:12 PM</td>
                                <td>SMS SEND TO : 9804421758</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">210.50</td>
                                <td class="text-end font-monospace fw-bold">210.40</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 6396788609">
                                <td class="text-center text-muted">2</td>
                                <td>17/08/2026 11:42:51 AM</td>
                                <td>SMS SEND TO : 6396788609</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">210.60</td>
                                <td class="text-end font-monospace fw-bold">210.50</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 6396788609">
                                <td class="text-center text-muted">3</td>
                                <td>17/08/2026 11:42:18 AM</td>
                                <td>SMS SEND TO : 6396788609</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">210.70</td>
                                <td class="text-end font-monospace fw-bold">210.60</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 6289862424">
                                <td class="text-center text-muted">4</td>
                                <td>17/08/2026 11:27:10 AM</td>
                                <td>SMS SEND TO : 6289862424</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">210.80</td>
                                <td class="text-end font-monospace fw-bold">210.70</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 6289862424">
                                <td class="text-center text-muted">5</td>
                                <td>17/08/2026 11:26:44 AM</td>
                                <td>SMS SEND TO : 6289862424</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">210.90</td>
                                <td class="text-end font-monospace fw-bold">210.80</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 8558035789">
                                <td class="text-center text-muted">6</td>
                                <td>17/08/2026 11:03:56 AM</td>
                                <td>SMS SEND TO : 8558035789</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">211.00</td>
                                <td class="text-end font-monospace fw-bold">210.90</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 7699668203">
                                <td class="text-center text-muted">7</td>
                                <td>17/08/2026 11:01:38 AM</td>
                                <td>SMS SEND TO : 7699668203</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">211.10</td>
                                <td class="text-end font-monospace fw-bold">211.00</td>
                            </tr>
                            <tr class="modal-ledger-row" data-desc="SMS SEND TO : 8370846222">
                                <td class="text-center text-muted">8</td>
                                <td>17/08/2026 10:32:43 AM</td>
                                <td>SMS SEND TO : 8370846222</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center"><span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">0.10</span></td>
                                <td class="text-end font-monospace">211.20</td>
                                <td class="text-end font-monospace fw-bold">211.10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2 bg-light">
                <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal" style="background-color: #e9ecef;">CLOSE</button>
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

    .btn-view-ledger {
        background-color: #28a745;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.7rem;
        border-radius: 3px;
        padding: 0.2rem 0.55rem;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-view-ledger:hover {
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
    .user-ledger-table thead th {
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
    html.dark .user-ledger-table thead th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }

    .user-ledger-table tbody td {
        font-size: 0.8125rem !important;
        padding: 0.55rem 0.75rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    html.dark .user-ledger-table tbody td {
        border-bottom-color: #1e293b !important;
    }

    .ledger-regno {
        font-family: var(--font-mono), monospace;
        font-weight: 600;
        color: #4338ca;
        font-size: 0.8rem;
    }
    html.dark .ledger-regno {
        color: #a5b4fc;
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
    // Filter Logic
    function applyLedgerFilters() {
        const company = document.getElementById('filter_company_name').value.trim().toLowerCase();
        const user = document.getElementById('filter_user_name').value.trim().toLowerCase();
        const regNo = document.getElementById('filter_reg_no').value.trim().toLowerCase();
        const contact = document.getElementById('filter_contact_no').value.trim().toLowerCase();

        const rows = document.querySelectorAll('#ledgerTableBody tr.ledger-row');
        let totalCredit = 0;
        let totalDebit = 0;
        let totalComm = 0;
        let totalBal = 0;

        rows.forEach(row => {
            const rCompany = (row.dataset.company || '').toLowerCase();
            const rUser = (row.dataset.user || '').toLowerCase();
            const rRegNo = (row.dataset.regNo || '').toLowerCase();
            const rContact = (row.dataset.contact || '').toLowerCase();

            const credit = parseFloat(row.dataset.credit || 0);
            const debit = parseFloat(row.dataset.debit || 0);
            const comm = parseFloat(row.dataset.comm || 0);
            const bal = parseFloat(row.dataset.balance || 0);

            let match = true;
            if (company && !rCompany.includes(company)) match = false;
            if (user && !rUser.includes(user)) match = false;
            if (regNo && !rRegNo.includes(regNo)) match = false;
            if (contact && !rContact.includes(contact)) match = false;

            if (match) {
                row.style.display = '';
                totalCredit += credit;
                totalDebit += debit;
                totalComm += comm;
                totalBal += bal;
            } else {
                row.style.display = 'none';
            }
        });

        // Update totals
        document.getElementById('totalCreditAmt').innerText = totalCredit.toFixed(2);
        document.getElementById('totalDebitAmt').innerText = totalDebit.toFixed(2);
        document.getElementById('totalCommAmt').innerText = totalComm.toFixed(2);
        document.getElementById('totalBalanceAmt').innerText = totalBal.toFixed(2);
    }

    // Clear Filters
    function clearLedgerFilters() {
        document.getElementById('filter_company_name').value = '';
        document.getElementById('filter_user_name').value = '';
        document.getElementById('filter_reg_no').value = '';
        document.getElementById('filter_contact_no').value = '';

        const rows = document.querySelectorAll('#ledgerTableBody tr.ledger-row');
        let totalCredit = 0, totalDebit = 0, totalComm = 0, totalBal = 0;

        rows.forEach(row => {
            row.style.display = '';
            totalCredit += parseFloat(row.dataset.credit || 0);
            totalDebit += parseFloat(row.dataset.debit || 0);
            totalComm += parseFloat(row.dataset.comm || 0);
            totalBal += parseFloat(row.dataset.balance || 0);
        });

        document.getElementById('totalCreditAmt').innerText = totalCredit.toFixed(2);
        document.getElementById('totalDebitAmt').innerText = totalDebit.toFixed(2);
        document.getElementById('totalCommAmt').innerText = totalComm.toFixed(2);
        document.getElementById('totalBalanceAmt').innerText = totalBal.toFixed(2);
    }

    // Ledger Statement Modal
    function openLedgerStatementModal(user) {
        document.getElementById('modal_ledger_user').innerText = user.user_name;
        document.getElementById('modal_ledger_regno').innerText = user.reg_no;
        document.getElementById('modal_ledger_company').innerText = user.company_name;
        document.getElementById('modal_trans_desc').value = '';
        resetModalLedgerFilter();
        
        new bootstrap.Modal(document.getElementById('ledgerStatementModal')).show();
    }

    function filterModalLedger() {
        const q = (document.getElementById('modal_trans_desc').value || '').trim().toLowerCase();
        document.querySelectorAll('#modal_ledger_tbody tr.modal-ledger-row').forEach(row => {
            const desc = (row.dataset.desc || '').toLowerCase();
            const text = row.innerText.toLowerCase();
            if (!q || desc.includes(q) || text.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetModalLedgerFilter() {
        document.getElementById('modal_trans_desc').value = '';
        document.querySelectorAll('#modal_ledger_tbody tr.modal-ledger-row').forEach(row => {
            row.style.display = '';
        });
    }

    // Export CSV Helper
    function exportLedgerTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#userLedgerTable tr");
        
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
