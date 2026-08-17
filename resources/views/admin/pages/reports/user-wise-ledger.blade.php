@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Report</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">User wise ledger</span>
        </div>
    </div>

    {{-- ── User Ledger Statement Card ── --}}
    <div class="sms-card-shell">
        <div class="sms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">
                    LEDGER :: [<span class="text-white-50 fw-normal">Regno : </span><strong>3902</strong>], [<span class="text-white-50 fw-normal">User Name : </span><strong>Nikhil Kumar</strong>], [<span class="text-white-50 fw-normal">Company : </span><strong>ASL WALLETS</strong>]
                </span>
            </div>

            {{-- Action Tools --}}
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bx bx-check"></i> PRINT
                </button>
                <button class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="exportUserWiseLedgerCSV('user-wise-ledger.csv')">
                    <i class="bx bx-check"></i> EXPORT
                </button>
            </div>
        </div>

        <div class="sms-card-body p-4 bg-white">
            
            {{-- Search Bar --}}
            <div class="row align-items-center mb-4">
                <label class="col-sm-3 col-form-label text-sm-end sms-field-label">TRANSACTION DESC</label>
                <div class="col-sm-7 col-md-6">
                    <input type="text" id="userwise_trans_desc" class="form-control sms-input" placeholder="Search narration or description..." oninput="filterUserWiseLedger()" />
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-sm px-4 fw-bold" onclick="resetUserWiseFilter()">
                        ALL
                    </button>
                </div>
            </div>

            {{-- Top Pagination --}}
            <div class="d-flex justify-content-center my-3">
                <div class="sms-pagination-container">
                    <nav aria-label="User wise ledger navigation">
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

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap border rounded" style="max-height: 600px; overflow-x: auto;">
                <table class="table table-hover table-bordered mb-0 align-middle user-wise-table" id="userWiseLedgerTable" style="font-size: 0.8125rem;">
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
                    <tbody id="userWiseTbody">
                        @php
                            $userEntries = [
                                ['id' => 1, 'date' => '17/08/2026 12:09:12 PM', 'desc' => 'SMS SEND TO : 9804421758', 'credit' => '-', 'debit' => '0.10', 'open' => '210.50', 'close' => '210.40'],
                                ['id' => 2, 'date' => '17/08/2026 11:42:51 AM', 'desc' => 'SMS SEND TO : 6396788609', 'credit' => '-', 'debit' => '0.10', 'open' => '210.60', 'close' => '210.50'],
                                ['id' => 3, 'date' => '17/08/2026 11:42:18 AM', 'desc' => 'SMS SEND TO : 6396788609', 'credit' => '-', 'debit' => '0.10', 'open' => '210.70', 'close' => '210.60'],
                                ['id' => 4, 'date' => '17/08/2026 11:27:10 AM', 'desc' => 'SMS SEND TO : 6289862424', 'credit' => '-', 'debit' => '0.10', 'open' => '210.80', 'close' => '210.70'],
                                ['id' => 5, 'date' => '17/08/2026 11:26:44 AM', 'desc' => 'SMS SEND TO : 6289862424', 'credit' => '-', 'debit' => '0.10', 'open' => '210.90', 'close' => '210.80'],
                                ['id' => 6, 'date' => '17/08/2026 11:03:56 AM', 'desc' => 'SMS SEND TO : 8558035789', 'credit' => '-', 'debit' => '0.10', 'open' => '211.00', 'close' => '210.90'],
                                ['id' => 7, 'date' => '17/08/2026 11:01:38 AM', 'desc' => 'SMS SEND TO : 7699668203', 'credit' => '-', 'debit' => '0.10', 'open' => '211.10', 'close' => '211.00'],
                                ['id' => 8, 'date' => '17/08/2026 10:32:43 AM', 'desc' => 'SMS SEND TO : 8370846222', 'credit' => '-', 'debit' => '0.10', 'open' => '211.20', 'close' => '211.10'],
                            ];
                        @endphp

                        @foreach($userEntries as $entry)
                        <tr class="uw-row" data-desc="{{ $entry['desc'] }}">
                            <td class="text-center text-muted fw-bold">{{ $entry['id'] }}</td>
                            <td><span class="text-nowrap">{{ $entry['date'] }}</span></td>
                            <td><span class="fw-semibold text-secondary">{{ $entry['desc'] }}</span></td>
                            <td class="text-center text-muted">{{ $entry['credit'] }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning text-white fw-bold px-2 py-1" style="background-color: #f97316 !important;">
                                    {{ $entry['debit'] }}
                                </span>
                            </td>
                            <td class="text-end font-monospace">{{ $entry['open'] }}</td>
                            <td class="text-end font-monospace fw-bold text-dark">{{ $entry['close'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Bottom Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                <div class="sms-pagination-container">
                    <nav aria-label="User wise ledger bottom navigation">
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
    .user-wise-table thead th {
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
    html.dark .user-wise-table thead th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }

    .user-wise-table tbody td {
        font-size: 0.8125rem !important;
        padding: 0.55rem 0.75rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    html.dark .user-wise-table tbody td {
        border-bottom-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    function filterUserWiseLedger() {
        const q = (document.getElementById('userwise_trans_desc').value || '').trim().toLowerCase();
        document.querySelectorAll('#userWiseTbody tr.uw-row').forEach(row => {
            const desc = (row.dataset.desc || '').toLowerCase();
            const text = row.innerText.toLowerCase();
            if (!q || desc.includes(q) || text.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetUserWiseFilter() {
        document.getElementById('userwise_trans_desc').value = '';
        document.querySelectorAll('#userWiseTbody tr.uw-row').forEach(row => {
            row.style.display = '';
        });
    }

    function exportUserWiseLedgerCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#userWiseLedgerTable tr");
        
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
