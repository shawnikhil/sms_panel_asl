@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Proper Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Help</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">Notification Setup</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Screenshot --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveNotification()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editNotificationModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deleteNotification()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearNotificationForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="notificationForm" onsubmit="event.preventDefault(); saveNotification();">
                <input type="hidden" id="notification_id" value="" />
                
                {{-- Field 1: API User (Highlighted Yellow as in Screenshot) --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        API USER <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <select id="api_user" class="form-select sms-input highlight-yellow-select" style="max-width: 320px;" required>
                            <option value="">-- Select API User --</option>
                            <option value="ALL USERS" selected>ALL USERS</option>
                            <option value="SAHISTA PAY">SAHISTA PAY (Reg: 3905)</option>
                            <option value="ASL WALLETS">ASL WALLETS (Reg: 3902)</option>
                            <option value="GAURAV KUMAR">GAURAV KUMAR (Reg: 3903)</option>
                            <option value="TEST KUMAR">TEST KUMAR (Reg: 3904)</option>
                            <option value="NIKHIL KUMAR">NIKHIL KUMAR (Reg: 3902)</option>
                        </select>
                    </div>
                </div>

                {{-- Field 2: Notification Head --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        NOTIFICATION HEAD <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="notification_head" class="form-control sms-input" placeholder="Enter notification title/heading..." required />
                    </div>
                </div>

                {{-- Field 3: Notification Description --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label pt-2">
                        NOTIFICATION DESC <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <textarea id="notification_desc" class="form-control sms-input" rows="8" placeholder="Enter notification message description..." required></textarea>
                    </div>
                </div>

                {{-- Field 4: Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="notification_status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="Y" selected>Y</option>
                            <option value="N">N</option>
                        </select>
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearNotificationForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit Notification Details Modal matching Screenshot 2 ── --}}
<div class="modal fade" id="editNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT NOTIFICATION DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">NOTIFICATION NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_head" class="form-control sms-input" placeholder="" oninput="filterNotificationModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">NOTIFICATION DESC</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_desc" class="form-control sms-input" placeholder="" oninput="filterNotificationModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetNotificationModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Notification modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle notification-modal-table" id="notificationModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>USER NAME</th>
                                <th>TOPIC NAME</th>
                                <th>TOPIC DESC</th>
                                <th>POST DATE</th>
                                <th>POST TIME</th>
                            </tr>
                        </thead>
                        <tbody id="notificationModalTbody">
                            @php
                                $notifications = [
                                    [
                                        'id' => 1,
                                        'user' => 'ALL USERS',
                                        'head' => 'Scheduled Gateway Maintenance Notice',
                                        'desc' => 'SMS gateway servers will undergo scheduled infrastructure maintenance on Sunday 02:00 AM to 04:00 AM IST.',
                                        'status' => 'Y',
                                        'post_date' => '16/08/2026',
                                        'post_time' => '06:30:00 PM'
                                    ],
                                    [
                                        'id' => 2,
                                        'user' => 'SAHISTA PAY',
                                        'head' => 'DLT Template Verification Completed',
                                        'desc' => 'Your new transactional template (Template ID: 17071740037412) has been approved by telecom operator.',
                                        'status' => 'Y',
                                        'post_date' => '14/08/2026',
                                        'post_time' => '03:45:12 PM'
                                    ],
                                    [
                                        'id' => 3,
                                        'user' => 'ASL WALLETS',
                                        'head' => 'Low Wallet Balance Alert',
                                        'desc' => 'Your prepaid credit balance is running below ₹500. Please recharge your wallet to avoid route pauses.',
                                        'status' => 'Y',
                                        'post_date' => '12/08/2026',
                                        'post_time' => '11:15:30 AM'
                                    ],
                                    [
                                        'id' => 4,
                                        'user' => 'ALL USERS',
                                        'head' => 'TRAI Commercial Communications Compliance Update',
                                        'desc' => 'Ensure all message headers and templates adhere to revised TRAI DLT scrubbing mandates.',
                                        'status' => 'Y',
                                        'post_date' => '05/08/2026',
                                        'post_time' => '10:00:00 AM'
                                    ],
                                    [
                                        'id' => 5,
                                        'user' => 'NIKHIL KUMAR',
                                        'head' => 'API Token Rotation Advisory',
                                        'desc' => 'Security notice: Please rotate your primary API authorization key every 90 days for enhanced safety.',
                                        'status' => 'N',
                                        'post_date' => '01/08/2026',
                                        'post_time' => '09:20:45 AM'
                                    ]
                                ];
                            @endphp

                            @foreach($notifications as $item)
                            <tr class="notification-row" 
                                style="cursor: pointer;"
                                data-id="{{ $item['id'] }}"
                                data-user="{{ $item['user'] }}"
                                data-head="{{ $item['head'] }}"
                                data-desc="{{ $item['desc'] }}"
                                data-status="{{ $item['status'] }}"
                                onclick="selectNotification({{ json_encode($item) }})">
                                <td class="text-center text-muted fw-bold">{{ $item['id'] }}</td>
                                <td><span class="badge bg-label-primary font-monospace">{{ $item['user'] }}</span></td>
                                <td><span class="fw-bold text-dark">{{ $item['head'] }}</span></td>
                                <td><span class="text-secondary">{{ $item['desc'] }}</span></td>
                                <td><span class="font-monospace text-muted">{{ $item['post_date'] }}</span></td>
                                <td><span class="font-monospace text-muted">{{ $item['post_time'] }}</span></td>
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

    /* Yellow highlighted dropdown matching screenshot */
    .highlight-yellow-select {
        background-color: #ffff00 !important;
        font-weight: 600;
        color: #000000 !important;
        border-color: #d4d400 !important;
    }
    html.dark .highlight-yellow-select {
        background-color: #ca8a04 !important;
        color: #ffffff !important;
        border-color: #a16207 !important;
    }

    /* Orange Action Button matching Screenshot */
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
    .notification-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .notification-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Save Notification
    function saveNotification() {
        const user = document.getElementById('api_user').value;
        const head = document.getElementById('notification_head').value.trim();
        const desc = document.getElementById('notification_desc').value.trim();
        const status = document.getElementById('notification_status').value;

        if (!user) {
            alert('Please select API USER!');
            document.getElementById('api_user').focus();
            return;
        }

        if (!head) {
            alert('Please enter NOTIFICATION HEAD!');
            document.getElementById('notification_head').focus();
            return;
        }

        if (!desc) {
            alert('Please enter NOTIFICATION DESC!');
            document.getElementById('notification_desc').focus();
            return;
        }

        alert(`Notification "${head}" for [${user}] saved successfully!`);
    }

    // Delete Notification
    function deleteNotification() {
        const head = document.getElementById('notification_head').value.trim();
        if (!head) {
            alert('No notification selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete notification "${head}"?`)) {
            clearNotificationForm();
            alert('Notification deleted successfully!');
        }
    }

    // Clear Form
    function clearNotificationForm() {
        document.getElementById('notification_id').value = '';
        document.getElementById('api_user').value = 'ALL USERS';
        document.getElementById('notification_head').value = '';
        document.getElementById('notification_desc').value = '';
        document.getElementById('notification_status').value = 'Y';
    }

    // Modal Selection
    function selectNotification(item) {
        document.getElementById('notification_id').value = item.id;
        document.getElementById('api_user').value = item.user;
        document.getElementById('notification_head').value = item.head;
        document.getElementById('notification_desc').value = item.desc;
        document.getElementById('notification_status').value = item.status || 'Y';

        // Close modal
        const modalEl = document.getElementById('editNotificationModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterNotificationModalTable() {
        const filterHead = (document.getElementById('modal_filter_head').value || '').trim().toLowerCase();
        const filterDesc = (document.getElementById('modal_filter_desc').value || '').trim().toLowerCase();

        document.querySelectorAll('#notificationModalTbody tr.notification-row').forEach(row => {
            const head = (row.dataset.head || '').toLowerCase();
            const desc = (row.dataset.desc || '').toLowerCase();

            let match = true;
            if (filterHead && !head.includes(filterHead)) match = false;
            if (filterDesc && !desc.includes(filterDesc)) match = false;

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetNotificationModalFilter() {
        document.getElementById('modal_filter_head').value = '';
        document.getElementById('modal_filter_desc').value = '';
        document.querySelectorAll('#notificationModalTbody tr.notification-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
