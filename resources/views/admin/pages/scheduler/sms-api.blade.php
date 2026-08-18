@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar matching Enterprise Style ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">API Manager</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">SMS API Setup</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Table Banner Header matching Screenshot with New Register Button ── --}}
        <div class="help-top-action-bar px-3 py-2 text-white d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bx bx-grid-alt fs-5"></i>
                <span class="fw-bold" style="font-size: 0.925rem; letter-spacing: 0.02em;">SMS API List -</span>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#registerApiModal">
                    <i class="bx bx-plus-circle"></i> NEW REGISTER
                </button>
            </div>
        </div>

        {{-- Table Content Body ── --}}
        <div class="table-responsive text-nowrap bg-white">
            <table class="table table-hover table-bordered mb-0 align-middle" id="smsApiTable" style="font-size: 0.8125rem;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th>VENDOR NAME</th>
                        <th>API NAME</th>
                        <th class="text-center" style="width: 100px;">API NO</th>
                        <th class="text-center">CHANGE DATE/TIME</th>
                        <th class="text-center" style="width: 120px;">ACTION</th>
                    </tr>
                </thead>
                <tbody id="smsApiTbody">
                    @if(isset($smsApis) && count($smsApis) > 0)
                        @foreach($smsApis as $api)
                            @php
                                $isActive = in_array(strtoupper((string)($api->status ?? '1')), ['1', 'ACTIVE', 'Y', 'YES'], true);
                                $vendorDisplay = $api->vendor_name ?? '';
                                if (!empty($vendorDisplay) && !str_starts_with($vendorDisplay, '(')) {
                                    $vendorDisplay = '(' . $vendorDisplay . ')';
                                }
                                
                                $changeDateTime = trim(($api->lastch_date ?? '') . ' ' . ($api->lastch_time ?? ''));
                                if(empty($changeDateTime) && !empty($api->insert_date)) {
                                    $changeDateTime = \Carbon\Carbon::parse($api->insert_date)->format('d/m/Y h:i:s A');
                                }
                            @endphp
                            <tr id="row-api-{{ $api->id }}">
                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold text-dark font-monospace">{{ $vendorDisplay }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge btn-orange-badge">
                                            {{ $api->apiname ?: trim(str_replace(['(', ')'], '', $api->vendor_name)) }}
                                        </span>
                                        <span class="text-secondary fw-semibold">
                                            {{ $api->apitype ?: 'SMS API' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center font-monospace fw-bold text-dark">
                                    {{ $api->apino ?? $loop->iteration }}
                                </td>
                                <td class="text-center font-monospace text-muted" id="change-date-text-{{ $api->id }}">
                                    {{ $changeDateTime ?: '-' }}
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-sm {{ $isActive ? 'btn-status-active' : 'btn-status-inactive' }} px-3 py-1"
                                            id="btn-toggle-{{ $api->id }}"
                                            title="Click to toggle status"
                                            onclick="toggleGatewayStatus({{ $api->id }})">
                                        {{ $isActive ? 'ACTIVE' : 'INACTIVE' }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="noApiRecordRow">
                            <td colspan="6" class="text-center text-muted py-4">No SMS Gateway APIs found in database.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- ── MODAL: NEW SMS API REGISTER ── --}}
<div class="modal fade" id="registerApiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    NEW SMS API REGISTER !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="registerApiForm" onsubmit="event.preventDefault(); saveApiRecord();">
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center mb-3">
                        <label class="col-sm-4 col-form-label text-sm-end help-field-label">
                            VENDOR NAME <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="add_vendor_name" name="vendor_name" class="form-control sms-input text-uppercase font-monospace" placeholder="e.g. (AIRTEL SMS) / VIDEOCON SMS" required />
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label class="col-sm-4 col-form-label text-sm-end help-field-label">
                            API NAME <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="add_api_name" name="apiname" class="form-control sms-input text-uppercase" placeholder="e.g. AIRTEL SMS" required />
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label class="col-sm-4 col-form-label text-sm-end help-field-label">
                            API TYPE
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="add_api_type" name="apitype" class="form-control sms-input text-uppercase" value="SMS API" />
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <label class="col-sm-4 col-form-label text-sm-end help-field-label">
                            STATUS <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-8">
                            <select id="add_status" name="status" class="form-select sms-input" style="max-width: 180px;">
                                <option value="1" selected>ACTIVE</option>
                                <option value="0">INACTIVE</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer py-2 bg-light d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal" onclick="clearApiForm()">
                        <i class="bx bx-refresh"></i> CLEAR
                    </button>
                    <button type="submit" id="saveApiSubmitBtn" class="btn btn-sm btn-orange-action px-3">
                        <i class="bx bx-check"></i> SAVE
                    </button>
                </div>
            </form>
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

    /* Orange Badge */
    .btn-orange-badge {
        background-color: #ea580c;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.03em;
        border-radius: 2px;
        padding: 0.3rem 0.65rem;
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

    /* Status Buttons matching screenshot */
    .btn-status-active {
        background-color: #198754 !important;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.75rem;
        border-radius: 2px;
        padding: 0.25rem 0.75rem;
        border: none;
        letter-spacing: 0.03em;
        transition: all 0.2s ease;
    }
    .btn-status-active:hover {
        background-color: #157347 !important;
        transform: translateY(-1px);
    }

    .btn-status-inactive {
        background-color: #94a3b8 !important;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.75rem;
        border-radius: 2px;
        padding: 0.25rem 0.75rem;
        border: none;
        letter-spacing: 0.03em;
        transition: all 0.2s ease;
    }
    .btn-status-inactive:hover {
        background-color: #64748b !important;
        transform: translateY(-1px);
    }

    /* Table Hover */
    #smsApiTable tbody tr:hover {
        background-color: #f8fafc !important;
    }
    html.dark #smsApiTable tbody tr:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    const API_ACTION_URL = '{{ route("admin.scheduler.sms_api.action") }}';
    const API_TOGGLE_URL = '{{ route("admin.scheduler.sms_api.toggle_status") }}';
    const CSRF_TOKEN     = '{{ csrf_token() }}';

    // Clear Register Form
    function clearApiForm() {
        document.getElementById('registerApiForm').reset();
        document.getElementById('add_api_type').value = 'SMS API';
        document.getElementById('add_status').value = '1';
    }

    // Save New SMS API Record
    async function saveApiRecord() {
        const vendorName = document.getElementById('add_vendor_name').value.trim();
        const apiName    = document.getElementById('add_api_name').value.trim();
        const apiType    = document.getElementById('add_api_type').value.trim();
        const status     = document.getElementById('add_status').value;
        const submitBtn  = document.getElementById('saveApiSubmitBtn');

        if (!vendorName) {
            toastr.error('Please enter VENDOR NAME!', 'Validation Error');
            document.getElementById('add_vendor_name').focus();
            return;
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> SAVING...';
        }

        const payload = {
            _token: CSRF_TOKEN,
            vendor_name: vendorName,
            apiname: apiName || vendorName,
            apitype: apiType || 'SMS API',
            status: status
        };

        try {
            const response = await fetch(API_ACTION_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message || 'New SMS API registered successfully!', 'Success');
                
                if (data.api) {
                    upsertApiRow(data.api);
                }

                clearApiForm();

                const modalEl = document.getElementById('registerApiModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            } else {
                toastr.error(data.message || 'Failed to save API details.', 'Error');
            }
        } catch (error) {
            console.error('API Save Error:', error);
            toastr.error('Server error occurred while saving.', 'Error');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bx bx-check"></i> SAVE';
            }
        }
    }

    // Live Append / Upsert Row to Table
    function upsertApiRow(api) {
        if (!api) return;

        const tbody = document.getElementById('smsApiTbody');
        if (!tbody) return;

        document.getElementById('noApiRecordRow')?.remove();

        const isActive = (api.status === '1' || String(api.status).toUpperCase() === 'ACTIVE' || String(api.status).toUpperCase() === 'Y');
        const vendorDisplay = String(api.vendor_name).startsWith('(') ? api.vendor_name : `(${api.vendor_name})`;
        const apiName = api.apiname || api.vendor_name.replace(/[()]/g, '');
        const apiType = api.apitype || 'SMS API';
        const changeDateTime = api.change_datetime || `${api.lastch_date || ''} ${api.lastch_time || ''}`.trim() || '-';

        let row = document.getElementById(`row-api-${api.id}`);
        if (!row) {
            row = document.createElement('tr');
            row.id = `row-api-${api.id}`;
            tbody.appendChild(row);
        }

        const rowCount = tbody.querySelectorAll('tr').length;

        row.innerHTML = `
            <td class="text-center text-muted fw-bold">${rowCount}</td>
            <td>
                <span class="fw-bold text-dark font-monospace">${vendorDisplay}</span>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge btn-orange-badge">${apiName}</span>
                    <span class="text-secondary fw-semibold">${apiType}</span>
                </div>
            </td>
            <td class="text-center font-monospace fw-bold text-dark">${api.apino || rowCount}</td>
            <td class="text-center font-monospace text-muted" id="change-date-text-${api.id}">${changeDateTime}</td>
            <td class="text-center">
                <button type="button"
                        class="btn btn-sm ${isActive ? 'btn-status-active' : 'btn-status-inactive'} px-3 py-1"
                        id="btn-toggle-${api.id}"
                        onclick="toggleGatewayStatus(${api.id})">
                    ${isActive ? 'ACTIVE' : 'INACTIVE'}
                </button>
            </td>
        `;

        tbody.querySelectorAll('tr').forEach((r, idx) => {
            const firstTd = r.querySelector('td:first-child');
            if (firstTd) firstTd.textContent = idx + 1;
        });
    }

    // Live Toggle Gateway Status
    async function toggleGatewayStatus(id) {
        const btn = document.getElementById(`btn-toggle-${id}`);
        const dateSpan = document.getElementById(`change-date-text-${id}`);
        if (!btn) return;

        const previousText = btn.textContent.trim();
        const previousClass = btn.className;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        try {
            const response = await fetch(API_TOGGLE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ _token: CSRF_TOKEN, id: id, api_id: id })
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                toastr.success(data.message, 'Status Updated');
                const isNowActive = (data.new_status === 'active' || data.new_status === '1' || data.is_active === true);

                btn.className = `btn btn-sm ${isNowActive ? 'btn-status-active' : 'btn-status-inactive'} px-3 py-1`;
                btn.textContent = isNowActive ? 'ACTIVE' : 'INACTIVE';

                if (dateSpan && data.change_datetime) {
                    dateSpan.textContent = data.change_datetime;
                }
            } else {
                btn.className = previousClass;
                btn.textContent = previousText;
                toastr.error(data.message || 'Failed to toggle status.', 'Error');
            }
        } catch (error) {
            console.error('Toggle error:', error);
            btn.className = previousClass;
            btn.textContent = previousText;
            toastr.error('Failed to communicate with server.', 'Error');
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endsection
