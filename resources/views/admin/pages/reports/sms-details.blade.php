@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Proper Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Report</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">SMS details</span>
        </div>
    </div>

        {{-- ── Find SMS Details Filter Card ── --}}
        <div class="sms-card-shell mb-4">
            <div class="sms-card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-grid-alt fs-5"></i>
                    <span class="sms-card-title">Find SMS Details -</span>
                </div>
                <button type="button" class="btn btn-sm text-white p-0" data-bs-toggle="collapse" data-bs-target="#filterPanelBody" aria-expanded="true">
                    <i class="bx bx-chevron-down fs-4"></i>
                </button>
            </div>
            
            <div class="collapse show" id="filterPanelBody">
                <div class="sms-card-body p-4">
                    <form id="smsSearchForm" onsubmit="event.preventDefault(); applySmsFilters();">
                        <div class="row g-3 justify-content-center">
                            {{-- Row 1 --}}
                            <div class="col-lg-5 col-md-6">
                                <div class="row align-items-center">
                                    <label class="col-sm-4 col-form-label text-sm-end sms-field-label">TRAN ID</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="filter_tran_id" class="form-control sms-input" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="row align-items-center">
                                    <label class="col-sm-4 col-form-label text-sm-end sms-field-label">RECHARGE NO</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="filter_recharge_no" class="form-control sms-input" placeholder="" />
                                    </div>
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="col-lg-5 col-md-6">
                                <div class="row align-items-center">
                                    <label class="col-sm-4 col-form-label text-sm-end sms-field-label">OPERATOR NAME</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="filter_operator_name" class="form-control sms-input" placeholder="" />
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
                                    <button type="button" class="btn sms-btn-clear px-4" onclick="clearSmsFilters()">
                                        CLEAR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── SMS Details Table Card ── --}}
        <div class="sms-card-shell">
            <div class="sms-card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bx bx-grid-alt fs-5"></i>
                    <span class="sms-card-title">SMS Details -</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="exportTableToCSV('sms-details-report.csv')">
                        <i class="bx bx-download"></i> Export
                    </button>
                    <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="window.print()">
                        <i class="bx bx-printer"></i> Print
                    </button>
                </div>
            </div>

            <div class="sms-card-body p-0">
                
                {{-- Top Pagination Controls --}}
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between px-3 py-3 border-bottom gap-2">
                    <div class="text-muted small">
                        Showing <span id="currentShowingCount" class="fw-bold">8</span> of <span class="fw-bold">1,380</span> entries
                    </div>
                    
                    <div class="sms-pagination-container">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center">
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(2)">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(3)">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(4)">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(5)">5</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(6)">6</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(7)">7</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(8)">8</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(9)">9</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(10)">10</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(11)">11</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(12)">12</a></li>
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">...</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(138)">138</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToPage(2)">»</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                {{-- Table Component --}}
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover sms-details-table mb-0" id="smsDetailsTable">
                        <thead>
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>TRAN ID</th>
                                <th style="min-width: 260px; max-width: 320px;">SMS TEXT</th>
                                <th>SENDER ID</th>
                                <th>ENTITY ID</th>
                                <th>SEND TO</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">CREDIT USE</th>
                                <th class="text-center">CHARGES</th>
                                <th>TRAN DATE/TIME</th>
                                <th>USER DETAILS</th>
                                <th>USER LOG</th>
                                <th>API LOG</th>
                            </tr>
                        </thead>
                        <tbody id="smsTableBody">
                            @php
                                $smsData = [
                                    [
                                        'id' => 1,
                                        'tran_id' => '3628567153',
                                        'sms_text' => 'Dear User, Your Password : OR mpin is 366931. -From (OPENI)',
                                        'sender_id' => 'OPNMSG',
                                        'entity_id' => '1201161753681791806',
                                        'send_to' => '6396788609',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(11:42:51 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 11:42:51","doneDate":"2026-08-17 11:42:53"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 2,
                                        'tran_id' => '3662972974',
                                        'sms_text' => 'Dear User, Your Password : OR mpin is 879282. -From (OPENI)',
                                        'sender_id' => 'OPNMSG',
                                        'entity_id' => '1201161753681791806',
                                        'send_to' => '6396788609',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(11:42:19 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 11:42:19","doneDate":"2026-08-17 11:42:21"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 3,
                                        'tran_id' => '3662826185',
                                        'sms_text' => 'Dear User, Your Password : OR mpin is 893062. -From (OPENI)',
                                        'sender_id' => 'OPNMSG',
                                        'entity_id' => '1201161753681791806',
                                        'send_to' => '6289862424',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(11:27:10 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 11:27:10","doneDate":"2026-08-17 11:27:12"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 4,
                                        'tran_id' => '3662685053',
                                        'sms_text' => 'Dear User, Your Password : OR mpin is 463878. -From (OPENI)',
                                        'sender_id' => 'OPNMSG',
                                        'entity_id' => '1201161753681791806',
                                        'send_to' => '6289862424',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(11:26:44 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 11:26:44","doneDate":"2026-08-17 11:26:46"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 5,
                                        'tran_id' => '3662035188',
                                        'sms_text' => 'Dear User, Your Password : OR mpin is 285960. -From (OPENI)',
                                        'sender_id' => 'OPNMSG',
                                        'entity_id' => '1201161753681791806',
                                        'send_to' => '8558035789',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(11:03:56 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 11:03:56","doneDate":"2026-08-17 11:03:59"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 6,
                                        'tran_id' => '3661872748',
                                        'sms_text' => 'Dear User, Your Password : 7281. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                        'sender_id' => 'ASLSTC',
                                        'entity_id' => '1701171888357691913',
                                        'send_to' => '7689668203',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(11:01:41 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 11:01:41","doneDate":"2026-08-17 11:01:43"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 7,
                                        'tran_id' => '3661214197',
                                        'sms_text' => 'Dear User, Your Password : 2944. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                        'sender_id' => 'ASLSTC',
                                        'entity_id' => '1701171888357691913',
                                        'send_to' => '8370846222',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(10:32:44 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 10:32:44","doneDate":"2026-08-17 10:32:46"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                    ],
                                    [
                                        'id' => 8,
                                        'tran_id' => '3660901952',
                                        'sms_text' => 'Dear User, Your Password : 5807. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                        'sender_id' => 'ASLSTC',
                                        'entity_id' => '1701171888357691913',
                                        'send_to' => '9540794800',
                                        'status' => 'SUCCESS',
                                        'credit_use' => '1',
                                        'charges' => '0.1',
                                        'date' => '17/08/2026',
                                        'time' => '(10:21:33 AM)',
                                        'user_name' => 'Nikhil Kumar',
                                        'reg_no' => '3902',
                                        'user_log' => '{"status":"DELIVRD","submitDate":"2026-08-17 10:21:33","doneDate":"2026-08-17 10:21:36"}',
                                        'api_log' => '{"apiToken":"fe1c25598680c09b8b0c5e09df1903bf","associatedId":"4491","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                    ],
                                ];
                            @endphp

                            @foreach($smsData as $row)
                            <tr class="sms-row" 
                                data-tran-id="{{ $row['tran_id'] }}"
                                data-sender-id="{{ $row['sender_id'] }}"
                                data-entity-id="{{ $row['entity_id'] }}"
                                data-send-to="{{ $row['send_to'] }}"
                                data-user-name="{{ $row['user_name'] }}"
                                data-date="{{ $row['date'] }}">
                                
                                <td class="text-muted fw-bold">{{ $row['id'] }}</td>
                                
                                <td>
                                    <span class="sms-mono-id">{{ $row['tran_id'] }}</span>
                                </td>
                                
                                <td>
                                    <div class="sms-text-cell" title="{{ $row['sms_text'] }}" onclick="showTextModal('{{ addslashes($row['sms_text']) }}')">
                                        {{ $row['sms_text'] }}
                                    </div>
                                </td>
                                
                                <td>
                                    <span class="sms-sender-tag">{{ $row['sender_id'] }}</span>
                                </td>
                                
                                <td>
                                    <span class="sms-entity-id" title="{{ $row['entity_id'] }}">{{ $row['entity_id'] }}</span>
                                </td>
                                
                                <td>
                                    <span class="sms-phone-num">{{ $row['send_to'] }}</span>
                                </td>
                                
                                <td class="text-center">
                                    @if(strtoupper($row['status']) === 'SUCCESS')
                                        <span class="badge sms-status-success">SUCCESS</span>
                                    @elseif(strtoupper($row['status']) === 'FAILED')
                                        <span class="badge sms-status-failed">FAILED</span>
                                    @else
                                        <span class="badge sms-status-pending">{{ $row['status'] }}</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <span class="text-muted">{{ $row['credit_use'] }}</span>
                                </td>
                                
                                <td class="text-center fw-semibold">
                                    {{ $row['charges'] }}
                                </td>
                                
                                <td>
                                    <div class="sms-datetime">
                                        <span class="sms-date">{{ $row['date'] }}</span>
                                        <span class="sms-time text-muted">{{ $row['time'] }}</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="sms-user-info">
                                        <span class="sms-username">{{ $row['user_name'] }}</span>
                                        <span class="sms-regno text-muted">Regno: {{ $row['reg_no'] }}</span>
                                    </div>
                                </td>

                                <td>
                                    <div class="sms-log-cell" title="Click to view User Log" onclick="showLogModal('User Log', '{{ addslashes($row['user_log']) }}')">
                                        <code>{{ Str::limit($row['user_log'], 40) }}</code>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="sms-log-cell" title="Click to view API Log" onclick="showLogModal('API Log (Tran ID: {{ $row['tran_id'] }})', '{{ addslashes($row['api_log']) }}')">
                                        <code>{{ Str::limit($row['api_log'], 50) }}</code>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-top gap-2 bg-light-subtle">
                    <div class="text-muted small">
                        <i class="bx bx-check-double text-success me-1"></i> SMS Gateway Live Transaction Logs
                    </div>
                    <div class="text-muted small">
                        Page <strong>1</strong> of <strong>138</strong>
                    </div>
                </div>

            </div>
        </div>

    </div>

{{-- ── Log Preview Modal ── --}}
<div class="modal fade" id="logPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header sms-modal-header py-3">
                <h5 class="modal-title fs-6 text-white mb-0" id="logModalTitle">Log Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="copyLogContent()">
                        <i class="bx bx-copy me-1"></i> Copy to Clipboard
                    </button>
                </div>
                <pre id="logModalContent" class="sms-code-block p-3 rounded mb-0"></pre>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ── SMS Text Preview Modal ── --}}
<div class="modal fade" id="textPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header sms-modal-header py-3">
                <h5 class="modal-title fs-6 text-white mb-0">SMS Message Content</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 bg-light rounded border fs-7" id="textModalContent" style="white-space: pre-wrap; line-height: 1.6; color: var(--text-primary);">
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
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
        padding: 0.65rem 1rem;
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
    .sms-details-table thead th {
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
    html.dark .sms-details-table thead th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }

    .sms-details-table tbody td {
        font-size: 0.8125rem !important;
        padding: 0.55rem 0.75rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    html.dark .sms-details-table tbody td {
        border-bottom-color: #1e293b !important;
    }

    .sms-mono-id {
        font-family: var(--font-mono), monospace;
        font-size: 0.8rem;
        font-weight: 600;
        color: #0d6efd;
    }
    html.dark .sms-mono-id {
        color: #60a5fa;
    }

    .sms-text-cell {
        max-width: 280px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.8125rem;
        color: #334155;
        cursor: pointer;
    }
    .sms-text-cell:hover {
        color: #007bff;
        text-decoration: underline;
    }
    html.dark .sms-text-cell {
        color: #cbd5e1;
    }

    .sms-sender-tag {
        font-weight: 600;
        font-size: 0.8rem;
        color: #475569;
    }
    html.dark .sms-sender-tag {
        color: #94a3b8;
    }

    .sms-entity-id {
        font-family: var(--font-mono), monospace;
        font-size: 0.75rem;
        color: #64748b;
    }

    .sms-phone-num {
        font-family: var(--font-mono), monospace;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #1e293b;
    }
    html.dark .sms-phone-num {
        color: #f1f5f9;
    }

    /* Badges */
    .sms-status-success {
        background-color: #28a745 !important;
        color: #ffffff !important;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        border-radius: 2px;
        padding: 0.35rem 0.5rem;
    }

    .sms-status-failed {
        background-color: #dc3545 !important;
        color: #ffffff !important;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        border-radius: 2px;
        padding: 0.35rem 0.5rem;
    }

    .sms-status-pending {
        background-color: #ffc107 !important;
        color: #212529 !important;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        border-radius: 2px;
        padding: 0.35rem 0.5rem;
    }

    .sms-datetime {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .sms-date {
        font-size: 0.78rem;
        color: #334155;
    }
    html.dark .sms-date {
        color: #cbd5e1;
    }
    .sms-time {
        font-size: 0.72rem;
    }

    .sms-user-info {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }
    .sms-username {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #1e293b;
    }
    html.dark .sms-username {
        color: #f1f5f9;
    }
    .sms-regno {
        font-size: 0.72rem;
    }

    .sms-log-cell {
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }
    .sms-log-cell code {
        font-size: 0.72rem;
        color: #64748b;
        background: transparent;
        border: none;
        padding: 0;
    }
    .sms-log-cell:hover code {
        color: #007bff;
        text-decoration: underline;
    }

    .sms-modal-header {
        background: #6c757d;
    }
    html.dark .sms-modal-header {
        background: #334155;
    }

    .sms-code-block {
        background: #0f172a;
        color: #38bdf8;
        font-family: var(--font-mono), monospace;
        font-size: 0.8125rem;
        max-height: 380px;
        overflow: auto;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Show Modal for Logs
    let currentModalRawLog = '';
    function showLogModal(title, jsonString) {
        currentModalRawLog = jsonString;
        document.getElementById('logModalTitle').innerText = title;
        try {
            const parsed = JSON.parse(jsonString);
            document.getElementById('logModalContent').innerText = JSON.stringify(parsed, null, 2);
        } catch (e) {
            document.getElementById('logModalContent').innerText = jsonString;
        }
        new bootstrap.Modal(document.getElementById('logPreviewModal')).show();
    }

    // Show Modal for SMS Text
    function showTextModal(text) {
        document.getElementById('textModalContent').innerText = text;
        new bootstrap.Modal(document.getElementById('textPreviewModal')).show();
    }

    // Copy to clipboard
    function copyLogContent() {
        navigator.clipboard.writeText(currentModalRawLog).then(() => {
            alert('Log content copied to clipboard!');
        });
    }

    // Filter Logic
    function applySmsFilters() {
        const tranId = document.getElementById('filter_tran_id').value.trim().toLowerCase();
        const rechargeNo = document.getElementById('filter_recharge_no').value.trim().toLowerCase();
        const operatorName = document.getElementById('filter_operator_name').value.trim().toLowerCase();
        const userName = document.getElementById('filter_user_name').value.trim().toLowerCase();
        const fromDate = document.getElementById('filter_from_date').value;
        const toDate = document.getElementById('filter_to_date').value;

        const rows = document.querySelectorAll('#smsTableBody tr.sms-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const rTran = (row.dataset.tranId || '').toLowerCase();
            const rSendTo = (row.dataset.sendTo || '').toLowerCase();
            const rSender = (row.dataset.senderId || '').toLowerCase();
            const rUser = (row.dataset.userName || '').toLowerCase();
            const rDate = row.dataset.date || '';

            let match = true;
            if (tranId && !rTran.includes(tranId)) match = false;
            if (rechargeNo && !rSendTo.includes(rechargeNo)) match = false;
            if (operatorName && !rSender.includes(operatorName)) match = false;
            if (userName && !rUser.includes(userName)) match = false;

            if (match) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('currentShowingCount').innerText = visibleCount;
    }

    // Clear Filters
    function clearSmsFilters() {
        document.getElementById('filter_tran_id').value = '';
        document.getElementById('filter_recharge_no').value = '';
        document.getElementById('filter_operator_name').value = '';
        document.getElementById('filter_user_name').value = '';
        document.getElementById('filter_from_date').value = '';
        document.getElementById('filter_to_date').value = '';

        const rows = document.querySelectorAll('#smsTableBody tr.sms-row');
        rows.forEach(row => row.style.display = '');
        document.getElementById('currentShowingCount').innerText = rows.length;
    }

    // Page navigation simulation
    function goToPage(pageNum) {
        document.querySelectorAll('.sms-pagination-container .page-item').forEach(el => el.classList.remove('active'));
        // Find link matching pageNum
        const links = document.querySelectorAll('.sms-pagination-container .page-link');
        links.forEach(l => {
            if (l.innerText.trim() == pageNum) {
                l.parentElement.classList.add('active');
            }
        });
    }

    // Export CSV Helper
    function exportTableToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#smsDetailsTable tr");
        
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
