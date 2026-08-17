@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Generous Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Report</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">SMS Live Panel</span>
        </div>

        {{-- Live Status Indicator & Stream Controls --}}
        <div class="d-flex align-items-center gap-2">
            <div class="sms-live-badge d-flex align-items-center gap-2 px-3 py-1 rounded-pill">
                <span class="sms-live-dot" id="liveStreamDot"></span>
                <span class="sms-live-text fw-bold" id="liveStreamText">LIVE MONITORING</span>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" id="toggleLiveBtn" onclick="toggleLiveFeed()">
                <i class="bx bx-pause" id="liveIcon"></i>
                <span id="liveBtnText">Pause</span>
            </button>
        </div>
    </div>

    {{-- ── SMS Live Panel Table Card ── --}}
    <div class="sms-card-shell mb-4">
        {{-- Header --}}
        <div class="sms-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="sms-card-title">SMS Live Panel -</span>
            </div>

            {{-- Action Tools --}}
            <div class="d-flex align-items-center gap-2">
                <div class="position-relative d-none d-md-block" style="width: 220px;">
                    <i class="bx bx-search position-absolute top-50 translate-middle-y text-muted ms-2"></i>
                    <input type="text" id="liveQuickSearch" class="form-control form-control-sm ps-4 bg-white text-dark" 
                           placeholder="Search Live Feed..." oninput="filterLiveTable()" />
                </div>
                <button class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-1" onclick="exportLiveToCSV('sms-live-panel.csv')">
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
                    Showing <span id="liveShowingCount" class="fw-bold">15</span> of <span class="fw-bold">690</span> live transactions
                </div>
                
                <div class="sms-pagination-container">
                    <nav aria-label="Live panel navigation">
                        <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">«</a></li>
                            <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(2)">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(3)">3</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(4)">4</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(5)">5</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(6)">6</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(7)">7</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(8)">8</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(9)">9</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(10)">10</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(11)">11</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(12)">12</a></li>
                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">...</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(46)">46</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="goToLivePage(2)">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            {{-- Table Component --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover sms-live-table mb-0" id="smsLiveTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>TRAN ID</th>
                            <th>SENDER ID</th>
                            <th style="min-width: 280px; max-width: 380px;">SMS TEXT</th>
                            <th>SEND TO</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">CREDIT USE</th>
                            <th class="text-center">CHARGES</th>
                            <th>TRAN DATE/TIME</th>
                            <th>USER DETAILS</th>
                            <th>API LOG</th>
                        </tr>
                    </thead>
                    <tbody id="smsLiveTbody">
                        @php
                            $liveRecords = [
                                [
                                    'id' => 1,
                                    'tran_id' => '3628567153',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 366931. -From (OPENI)',
                                    'send_to' => '6396788609',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(11:42:51 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3628567153","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 2,
                                    'tran_id' => '3662972974',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 879282. -From (OPENI)',
                                    'send_to' => '6396788609',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(11:42:19 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3662972974","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 3,
                                    'tran_id' => '3662826185',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 893062. -From (OPENI)',
                                    'send_to' => '6289862424',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(11:27:10 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3662826185","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 4,
                                    'tran_id' => '3662685053',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 463878. -From (OPENI)',
                                    'send_to' => '6289862424',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(11:26:44 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3662685053","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 5,
                                    'tran_id' => '3662035188',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 285960. -From (OPENI)',
                                    'send_to' => '8558035789',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(11:03:56 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3662035188","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 6,
                                    'tran_id' => '3661872748',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 7281. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '7689668203',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(11:01:41 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3661872748","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 7,
                                    'tran_id' => '3661214197',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 2944. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '8370846222',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(10:32:44 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3661214197","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 8,
                                    'tran_id' => '3660901952',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 5807. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '9540794800',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(10:21:33 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3660901952","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 9,
                                    'tran_id' => '3660117056',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 6688. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '7076390592',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(09:28:27 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3660117056","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 10,
                                    'tran_id' => '3628311558',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 7372. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '6296126909',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(08:59:08 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3628311558","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 11,
                                    'tran_id' => '3628306088',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 1766. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '7699668203',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(08:50:09 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3628306088","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 12,
                                    'tran_id' => '3659418976',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 347489. -From (OPENI)',
                                    'send_to' => '7418650171',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(07:48:18 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3659418976","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 13,
                                    'tran_id' => '3659132546',
                                    'sender_id' => 'ASLSTC',
                                    'sms_text' => 'Dear User, Your Password : 9165. -From ASL Wallets (ASL Solutions Tech Private Limited)',
                                    'send_to' => '8116598440',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(07:39:39 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3659132546","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1701171888357691913","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 14,
                                    'tran_id' => '3658808108',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 111111. -From (OPENI)',
                                    'send_to' => '9999999999',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(05:58:37 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3658808108","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                                [
                                    'id' => 15,
                                    'tran_id' => '3658867620',
                                    'sender_id' => 'OPNMSG',
                                    'sms_text' => 'Dear User, Your Password : OR mpin is 111111. -From (OPENI)',
                                    'send_to' => '9999999999',
                                    'status' => 'SUCCESS',
                                    'credit_use' => '',
                                    'charges' => '0.1',
                                    'date' => '17/08/2026',
                                    'time' => '(05:56:37 AM)',
                                    'user_name' => 'Nikhil Kumar',
                                    'reg_no' => '3902',
                                    'api_log' => '{"transactionId":"3658867620","state":"SUBMIT_ACCEPTED","statusCode":"200","description":"Message Accepted For Delivery","entityId":"1201161753681791806","tempId":"17071740037412"}',
                                ],
                            ];
                        @endphp

                        @foreach($liveRecords as $row)
                        <tr class="sms-live-row" 
                            data-tran-id="{{ $row['tran_id'] }}"
                            data-sender-id="{{ $row['sender_id'] }}"
                            data-send-to="{{ $row['send_to'] }}"
                            data-user-name="{{ $row['user_name'] }}"
                            data-sms-text="{{ $row['sms_text'] }}">
                            
                            <td class="text-muted fw-bold">{{ $row['id'] }}</td>
                            
                            <td>
                                <span class="sms-mono-id">{{ $row['tran_id'] }}</span>
                            </td>
                            
                            <td>
                                <span class="sms-sender-tag">{{ $row['sender_id'] }}</span>
                            </td>

                            <td>
                                <div class="sms-text-cell" title="{{ $row['sms_text'] }}" onclick="showLiveTextModal('{{ addslashes($row['sms_text']) }}')">
                                    {{ $row['sms_text'] }}
                                </div>
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
                                <div class="sms-log-cell" title="Click to view API Log" onclick="showLiveApiModal('API Log (Tran ID: {{ $row['tran_id'] }})', '{{ addslashes($row['api_log']) }}')">
                                    <code>{{ Str::limit($row['api_log'], 60) }}</code>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Table Footer --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-top gap-2 bg-light-subtle">
                <div class="text-muted small d-flex align-items-center gap-2">
                    <span class="badge badge-dot bg-success"></span>
                    <span>Auto-streaming gateway transactions directly from SMS hub</span>
                </div>
                <div class="text-muted small">
                    Page <strong>1</strong> of <strong>46</strong>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- ── API Log Preview Modal ── --}}
<div class="modal fade" id="liveApiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header sms-modal-header py-3">
                <h5 class="modal-title fs-6 text-white mb-0" id="liveApiModalTitle">API Log Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="copyLiveLogContent()">
                        <i class="bx bx-copy me-1"></i> Copy to Clipboard
                    </button>
                </div>
                <pre id="liveApiModalContent" class="sms-code-block p-3 rounded mb-0"></pre>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ── SMS Text Preview Modal ── --}}
<div class="modal fade" id="liveTextModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header sms-modal-header py-3">
                <h5 class="modal-title fs-6 text-white mb-0">SMS Message Content</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 bg-light rounded border fs-7" id="liveTextModalContent" style="white-space: pre-wrap; line-height: 1.6; color: var(--text-primary);">
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

    /* Live Monitoring Badge */
    .sms-live-badge {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-size: 0.75rem;
        color: #059669;
        letter-spacing: 0.05em;
    }
    .sms-live-dot {
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: smsPulse 1.8s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes smsPulse {
        to {
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
    }

    /* Shell & Headers */
    .sms-card-shell {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-top: 0.5rem;
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
    .sms-live-table thead th {
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
    html.dark .sms-live-table thead th {
        background-color: #1e293b !important;
        color: #cbd5e1 !important;
        border-bottom-color: #334155 !important;
    }

    .sms-live-table tbody td {
        font-size: 0.8125rem !important;
        padding: 0.55rem 0.75rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    html.dark .sms-live-table tbody td {
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

    .sms-sender-tag {
        font-weight: 600;
        font-size: 0.8rem;
        color: #475569;
    }
    html.dark .sms-sender-tag {
        color: #94a3b8;
    }

    .sms-text-cell {
        max-width: 320px;
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
        max-width: 220px;
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

    /* Live Row Flash Effect */
    @keyframes liveRowHighlight {
        0% { background-color: rgba(16, 185, 129, 0.25); }
        100% { background-color: transparent; }
    }
    .new-live-entry {
        animation: liveRowHighlight 2.5s ease-out forwards;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    let isLiveActive = true;
    let liveTimer = null;
    let currentLiveRawLog = '';

    // Show Modal for API Logs
    function showLiveApiModal(title, jsonString) {
        currentLiveRawLog = jsonString;
        document.getElementById('liveApiModalTitle').innerText = title;
        try {
            const parsed = JSON.parse(jsonString);
            document.getElementById('liveApiModalContent').innerText = JSON.stringify(parsed, null, 2);
        } catch (e) {
            document.getElementById('liveApiModalContent').innerText = jsonString;
        }
        new bootstrap.Modal(document.getElementById('liveApiModal')).show();
    }

    // Show Modal for SMS Text
    function showLiveTextModal(text) {
        document.getElementById('liveTextModalContent').innerText = text;
        new bootstrap.Modal(document.getElementById('liveTextModal')).show();
    }

    // Copy to clipboard
    function copyLiveLogContent() {
        navigator.clipboard.writeText(currentLiveRawLog).then(() => {
            alert('API Log copied to clipboard!');
        });
    }

    // Quick filter
    function filterLiveTable() {
        const query = document.getElementById('liveQuickSearch').value.trim().toLowerCase();
        const rows = document.querySelectorAll('#smsLiveTbody tr.sms-live-row');
        let count = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (!query || text.includes(query)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        document.getElementById('liveShowingCount').innerText = count;
    }

    // Live Feed Toggle (Pause / Resume)
    function toggleLiveFeed() {
        isLiveActive = !isLiveActive;
        const btnText = document.getElementById('liveBtnText');
        const icon = document.getElementById('liveIcon');
        const dot = document.getElementById('liveStreamDot');
        const statusText = document.getElementById('liveStreamText');

        if (isLiveActive) {
            btnText.innerText = 'Pause';
            icon.className = 'bx bx-pause';
            dot.style.backgroundColor = '#10b981';
            dot.style.animation = 'smsPulse 1.8s infinite cubic-bezier(0.66, 0, 0, 1)';
            statusText.innerText = 'LIVE MONITORING';
            statusText.style.color = '#059669';
            startLiveStream();
        } else {
            btnText.innerText = 'Resume';
            icon.className = 'bx bx-play';
            dot.style.backgroundColor = '#94a3b8';
            dot.style.animation = 'none';
            statusText.innerText = 'PAUSED';
            statusText.style.color = '#64748b';
            clearInterval(liveTimer);
        }
    }

    // Live stream generator simulation
    function startLiveStream() {
        clearInterval(liveTimer);
        liveTimer = setInterval(() => {
            if (!isLiveActive) return;
            simulateIncomingSms();
        }, 12000); // Injects new simulated live transaction periodically
    }

    function simulateIncomingSms() {
        const sampleSenders = ['OPNMSG', 'ASLSTC', 'HDFCBK', 'PAYTMX'];
        const sampleNumbers = ['9876543210', '9123456789', '8877665544', '7766554433'];
        const randomTran = '36' + Math.floor(10000000 + Math.random() * 90000000);
        const randomSender = sampleSenders[Math.floor(Math.random() * sampleSenders.length)];
        const randomPhone = sampleNumbers[Math.floor(Math.random() * sampleNumbers.length)];
        const otp = Math.floor(100000 + Math.random() * 900000);
        const smsText = `Dear User, Your Password : OR mpin is ${otp}. -From (${randomSender})`;
        
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-GB');
        const timeStr = '(' + now.toLocaleTimeString('en-US') + ')';
        
        const apiLog = JSON.stringify({
            transactionId: randomTran,
            state: "SUBMIT_ACCEPTED",
            statusCode: "200",
            description: "Message Accepted For Delivery",
            entityId: "1201161753681791806",
            tempId: "17071740037412"
        });

        const tbody = document.getElementById('smsLiveTbody');
        const row = document.createElement('tr');
        row.className = 'sms-live-row new-live-entry';
        row.setAttribute('data-tran-id', randomTran);
        row.setAttribute('data-sender-id', randomSender);
        row.setAttribute('data-send-to', randomPhone);
        row.setAttribute('data-user-name', 'Nikhil Kumar');
        row.setAttribute('data-sms-text', smsText);

        row.innerHTML = `
            <td class="text-muted fw-bold">★</td>
            <td><span class="sms-mono-id">${randomTran}</span></td>
            <td><span class="sms-sender-tag">${randomSender}</span></td>
            <td>
                <div class="sms-text-cell" title="${smsText}" onclick="showLiveTextModal('${smsText.replace(/'/g, "\\'")}')">
                    ${smsText}
                </div>
            </td>
            <td><span class="sms-phone-num">${randomPhone}</span></td>
            <td class="text-center"><span class="badge sms-status-success">SUCCESS</span></td>
            <td class="text-center"><span class="text-muted"></span></td>
            <td class="text-center fw-semibold">0.1</td>
            <td>
                <div class="sms-datetime">
                    <span class="sms-date">${dateStr}</span>
                    <span class="sms-time text-muted">${timeStr}</span>
                </div>
            </td>
            <td>
                <div class="sms-user-info">
                    <span class="sms-username">Nikhil Kumar</span>
                    <span class="sms-regno text-muted">Regno: 3902</span>
                </div>
            </td>
            <td>
                <div class="sms-log-cell" title="Click to view API Log" onclick="showLiveApiModal('API Log (Tran ID: ${randomTran})', '${apiLog.replace(/'/g, "\\'")}')">
                    <code>${apiLog.substring(0, 60)}...</code>
                </div>
            </td>
        `;

        tbody.insertBefore(row, tbody.firstChild);

        // Keep maximum 20 rows visible
        if (tbody.children.length > 20) {
            tbody.removeChild(tbody.lastChild);
        }
    }

    // Pagination page switcher
    function goToLivePage(pageNum) {
        document.querySelectorAll('.sms-pagination-container .page-item').forEach(el => el.classList.remove('active'));
        const links = document.querySelectorAll('.sms-pagination-container .page-link');
        links.forEach(l => {
            if (l.innerText.trim() == pageNum) {
                l.parentElement.classList.add('active');
            }
        });
    }

    // Export CSV Helper
    function exportLiveToCSV(filename) {
        let csv = [];
        const rows = document.querySelectorAll("#smsLiveTable tr");
        
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

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        startLiveStream();
    });
</script>
@endsection
