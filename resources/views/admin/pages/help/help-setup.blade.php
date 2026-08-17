@extends('admin.layout.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y pt-3 pb-5">

    {{-- ── Breadcrumb Bar with Proper Spacing ── --}}
    <div class="sms-breadcrumb-wrapper d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pt-2 pb-1">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-home text-secondary" style="font-size: 1.15rem;"></i>
            <span class="crumb-section">Help</span>
            <span class="crumb-sep">|</span>
            <span class="crumb-active">API Help Details</span>
        </div>
    </div>

    {{-- ── Main Shell Container ── --}}
    <div class="sms-card-shell mb-4">
        
        {{-- Top Action Bar matching Screenshot --}}
        <div class="help-top-action-bar d-flex flex-wrap align-items-center gap-2 px-3 py-2 border-bottom">
            <button type="button" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1" onclick="saveHelpTopic()">
                <i class="bx bx-check"></i> SAVE
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editHelpModal">
                <i class="bx bx-pencil"></i> EDIT
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="deleteHelpTopic()">
                <i class="bx bx-trash"></i> DEL
            </button>
            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1" onclick="clearHelpForm()">
                <i class="bx bx-refresh"></i> CLEAR
            </button>
        </div>

        {{-- Form Content Body --}}
        <div class="sms-card-body p-4 bg-white">
            <form id="helpTopicForm" onsubmit="event.preventDefault(); saveHelpTopic();">
                <input type="hidden" id="topic_id" value="" />
                
                {{-- Field 1: Topic Name --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        TOPIC NAME <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <input type="text" id="topic_name" class="form-control sms-input" placeholder="Enter topic title..." required />
                    </div>
                </div>

                {{-- Field 2: Topic Description (Rich Text Editor) --}}
                <div class="row mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label pt-2">
                        TOPIC DESC <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-10">
                        <div class="rich-editor-container border rounded">
                            {{-- Editor Toolbar matching Screenshot --}}
                            <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 p-2 border-bottom bg-light">
                                <div class="btn-group btn-group-sm me-1" role="group">
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('bold')" title="Bold (Ctrl+B)"><b>B</b></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('italic')" title="Italic (Ctrl+I)"><i>I</i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('underline')" title="Underline (Ctrl+U)"><u>U</u></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('strikeThrough')" title="Strikethrough"><s>S</s></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('subscript')" title="Subscript">x<sub>2</sub></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('superscript')" title="Superscript">x<sup>2</sup></button>
                                </div>

                                <div class="btn-group btn-group-sm me-1" role="group">
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('justifyLeft')" title="Align Left"><i class="bx bx-align-left"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('justifyCenter')" title="Align Center"><i class="bx bx-align-middle"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('justifyRight')" title="Align Right"><i class="bx bx-align-right"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('justifyFull')" title="Justify"><i class="bx bx-align-justify"></i></button>
                                </div>

                                <select class="form-select form-select-sm editor-select me-1" onchange="formatDoc('formatBlock', this.value); this.selectedIndex=0;" style="width: 100px;">
                                    <option value="" selected>Styles</option>
                                    <option value="p">Paragraph</option>
                                    <option value="h1">Heading 1</option>
                                    <option value="h2">Heading 2</option>
                                    <option value="h3">Heading 3</option>
                                    <option value="pre">Code Block</option>
                                </select>

                                <select class="form-select form-select-sm editor-select me-1" onchange="formatDoc('fontName', this.value); this.selectedIndex=0;" style="width: 110px;">
                                    <option value="" selected>Font</option>
                                    <option value="Plus Jakarta Sans">Sans-serif</option>
                                    <option value="Arial">Arial</option>
                                    <option value="Courier New">Courier</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Tahoma">Tahoma</option>
                                    <option value="Verdana">Verdana</option>
                                </select>

                                <select class="form-select form-select-sm editor-select me-1" onchange="formatDoc('fontSize', this.value); this.selectedIndex=0;" style="width: 80px;">
                                    <option value="" selected>Size</option>
                                    <option value="1">Small</option>
                                    <option value="3">Normal</option>
                                    <option value="5">Large</option>
                                    <option value="7">Extra Large</option>
                                </select>

                                <div class="btn-group btn-group-sm me-1" role="group">
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('insertUnorderedList')" title="Bullet List"><i class="bx bx-list-ul"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('insertOrderedList')" title="Numbered List"><i class="bx bx-list-ol"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="formatDoc('formatBlock', 'blockquote')" title="Quote"><i class="bx bxs-quote-left"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="insertCodeSnippet()" title="Source/Code">&lt;/&gt;</button>
                                </div>

                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-light border editor-btn" onclick="insertTableDialog()" title="Insert Table"><i class="bx bx-table"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="insertLinkDialog()" title="Insert Link"><i class="bx bx-link"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="window.print()" title="Print"><i class="bx bx-printer"></i></button>
                                    <button type="button" class="btn btn-light border editor-btn" onclick="toggleFullscreenEditor()" title="Maximize"><i class="bx bx-fullscreen"></i></button>
                                </div>
                            </div>

                            {{-- Editable Area --}}
                            <div class="editor-content-area p-3" id="topic_desc_editor" contenteditable="true" style="min-height: 250px; outline: none;">
                                <p>Welcome to <strong>ASL SMS HUB API Documentation</strong>.</p>
                                <p>This help center provides comprehensive documentation on HTTP endpoints, parameter specifications, DLT compliance requirements, and delivery callback integrations.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Field 3: Status --}}
                <div class="row align-items-center mb-4">
                    <label class="col-sm-3 col-md-2 col-form-label text-sm-end help-field-label">
                        STATUS <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9 col-md-4">
                        <select id="topic_status" class="form-select sms-input" style="max-width: 260px;">
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                        </select>
                    </div>
                </div>

                {{-- Bottom Buttons matching Screenshot --}}
                <div class="row">
                    <div class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-sm btn-orange-action d-inline-flex align-items-center gap-1 px-3">
                                <i class="bx bx-check"></i> SAVE
                            </button>
                            <button type="button" class="btn btn-sm btn-light border d-inline-flex align-items-center gap-1 px-3" onclick="clearHelpForm()">
                                <i class="bx bx-refresh"></i> CLEAR
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ── Edit API Help Details Modal matching Screenshot 2 ── --}}
<div class="modal fade" id="editHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom py-3 px-4 bg-white d-flex align-items-center justify-content-between">
                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">
                    EDIT API HELP DETAILS !
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 bg-white">
                {{-- Search Filter Form inside Modal --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">TOPIC NAME</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_topic" class="form-control sms-input" placeholder="" oninput="filterHelpModalTable()" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="row align-items-center">
                            <label class="col-sm-4 col-form-label text-sm-end help-field-label">TOPIC DESC</label>
                            <div class="col-sm-8">
                                <input type="text" id="modal_filter_desc" class="form-control sms-input" placeholder="" oninput="filterHelpModalTable()" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 text-start">
                        <button type="button" class="btn btn-primary btn-sm px-3 fw-bold" onclick="resetHelpModalFilter()">
                            ALL
                        </button>
                    </div>
                </div>

                {{-- Pagination Inside Modal --}}
                <div class="d-flex justify-content-center my-3">
                    <div class="sms-pagination-container">
                        <nav aria-label="Help modal navigation">
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
                    <table class="table table-hover table-bordered mb-0 align-middle help-modal-table" id="helpModalTable" style="font-size: 0.8125rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;" class="text-center">#</th>
                                <th>TOPIC NAME</th>
                                <th>TOPIC DESC</th>
                                <th>POST DATE</th>
                                <th>POST TIME</th>
                            </tr>
                        </thead>
                        <tbody id="helpModalTbody">
                            @php
                                $helpTopics = [
                                    [
                                        'id' => 1,
                                        'name' => 'HTTP SMS API v2 Documentation',
                                        'desc' => 'Detailed guide on HTTP GET and POST JSON endpoints for single and bulk messaging.',
                                        'status' => 'Y',
                                        'post_date' => '12/08/2026',
                                        'post_time' => '11:30:15 AM'
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'DLT Entity ID & Header Whitelisting',
                                        'desc' => 'Guidelines on registering Principal Entity (PE) ID and sender headers across TRAI operators.',
                                        'status' => 'Y',
                                        'post_date' => '05/08/2026',
                                        'post_time' => '02:15:40 PM'
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'DLT Template & Variable Formatting',
                                        'desc' => 'Explanation of {#var#} placeholder structure, character length limits, and content rules.',
                                        'status' => 'Y',
                                        'post_date' => '28/07/2026',
                                        'post_time' => '04:45:10 PM'
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Delivery Reports & Webhook Callback Integration',
                                        'desc' => 'Specification of DLR webhook payload, retry intervals, and signature authentication.',
                                        'status' => 'Y',
                                        'post_date' => '15/07/2026',
                                        'post_time' => '10:00:22 AM'
                                    ],
                                    [
                                        'id' => 5,
                                        'name' => 'SMPP Gateway Protocol Configuration',
                                        'desc' => 'Connecting to carrier SMSC using SMPP v3.4 transmitter/receiver bind mode.',
                                        'status' => 'N',
                                        'post_date' => '01/07/2026',
                                        'post_time' => '09:12:00 AM'
                                    ]
                                ];
                            @endphp

                            @foreach($helpTopics as $topic)
                            <tr class="help-topic-row" 
                                style="cursor: pointer;"
                                data-id="{{ $topic['id'] }}"
                                data-name="{{ $topic['name'] }}"
                                data-desc="{{ $topic['desc'] }}"
                                data-status="{{ $topic['status'] }}"
                                onclick="selectHelpTopic({{ json_encode($topic) }})">
                                <td class="text-center text-muted fw-bold">{{ $topic['id'] }}</td>
                                <td><span class="fw-bold text-dark">{{ $topic['name'] }}</span></td>
                                <td><span class="text-secondary">{{ $topic['desc'] }}</span></td>
                                <td><span class="font-monospace text-muted">{{ $topic['post_date'] }}</span></td>
                                <td><span class="font-monospace text-muted">{{ $topic['post_time'] }}</span></td>
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

    /* Rich Editor Styling */
    .rich-editor-container {
        border-color: #ced4da !important;
        background: #ffffff;
    }
    html.dark .rich-editor-container {
        background: #0f172a;
        border-color: #334155 !important;
    }
    .editor-toolbar {
        background-color: #f8f9fa !important;
    }
    html.dark .editor-toolbar {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    .editor-btn {
        padding: 0.2rem 0.45rem;
        font-size: 0.8rem;
    }
    html.dark .editor-btn {
        background-color: #0f172a;
        border-color: #334155;
        color: #cbd5e1;
    }
    .editor-select {
        font-size: 0.78rem;
        padding: 0.2rem 0.5rem;
    }
    html.dark .editor-select {
        background-color: #0f172a;
        border-color: #334155;
        color: #cbd5e1;
    }
    .editor-content-area {
        color: #1e293b;
        font-size: 0.875rem;
        line-height: 1.6;
    }
    html.dark .editor-content-area {
        color: #f8fafc;
    }

    /* Table Highlight Hover on Modal */
    .help-topic-row:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .help-topic-row:hover {
        background-color: #1e293b !important;
    }
</style>

{{-- ── Page Scripts ── --}}
<script>
    // Rich Text Formatting Engine
    function formatDoc(cmd, value = null) {
        document.execCommand(cmd, false, value);
        document.getElementById('topic_desc_editor').focus();
    }

    function insertLinkDialog() {
        const url = prompt("Enter link URL:", "https://");
        if (url) formatDoc("createLink", url);
    }

    function insertTableDialog() {
        const rows = prompt("Number of rows:", "3");
        const cols = prompt("Number of columns:", "3");
        if (rows && cols) {
            let html = '<table class="table table-bordered my-2"><tbody>';
            for (let r = 0; r < parseInt(rows); r++) {
                html += '<tr>';
                for (let c = 0; c < parseInt(cols); c++) {
                    html += '<td>Sample Data</td>';
                }
                html += '</tr>';
            }
            html += '</tbody></table><p></p>';
            formatDoc("insertHTML", html);
        }
    }

    function insertCodeSnippet() {
        const code = prompt("Enter code or endpoint snippet:", "POST /api/v2/send-sms HTTP/1.1");
        if (code) {
            formatDoc("insertHTML", `<pre class="bg-light p-2 border rounded font-monospace"><code>${code}</code></pre><p></p>`);
        }
    }

    function toggleFullscreenEditor() {
        const container = document.querySelector('.rich-editor-container');
        container.classList.toggle('position-fixed');
        container.classList.toggle('top-0');
        container.classList.toggle('start-0');
        container.classList.toggle('w-100');
        container.classList.toggle('h-100');
        container.classList.toggle('z-3');
    }

    // Save Topic
    function saveHelpTopic() {
        const name = document.getElementById('topic_name').value.trim();
        const desc = document.getElementById('topic_desc_editor').innerHTML.trim();
        const status = document.getElementById('topic_status').value;

        if (!name) {
            alert('Please enter TOPIC NAME!');
            document.getElementById('topic_name').focus();
            return;
        }

        if (!desc || desc === '<p><br></p>') {
            alert('Please enter TOPIC DESCRIPTION!');
            return;
        }

        alert(`Help Topic "${name}" saved successfully!`);
    }

    // Delete Topic
    function deleteHelpTopic() {
        const name = document.getElementById('topic_name').value.trim();
        if (!name) {
            alert('No topic selected to delete.');
            return;
        }
        if (confirm(`Are you sure you want to delete topic "${name}"?`)) {
            clearHelpForm();
            alert('Topic deleted successfully!');
        }
    }

    // Clear Form
    function clearHelpForm() {
        document.getElementById('topic_id').value = '';
        document.getElementById('topic_name').value = '';
        document.getElementById('topic_desc_editor').innerHTML = '<p></p>';
        document.getElementById('topic_status').value = 'Y';
    }

    // Modal Selection
    function selectHelpTopic(topic) {
        document.getElementById('topic_id').value = topic.id;
        document.getElementById('topic_name').value = topic.name;
        document.getElementById('topic_desc_editor').innerHTML = `<p>${topic.desc}</p>`;
        document.getElementById('topic_status').value = topic.status || 'Y';

        // Close modal
        const modalEl = document.getElementById('editHelpModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    }

    // Modal Filter Logic
    function filterHelpModalTable() {
        const filterName = (document.getElementById('modal_filter_topic').value || '').trim().toLowerCase();
        const filterDesc = (document.getElementById('modal_filter_desc').value || '').trim().toLowerCase();

        document.querySelectorAll('#helpModalTbody tr.help-topic-row').forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();
            const desc = (row.dataset.desc || '').toLowerCase();

            let match = true;
            if (filterName && !name.includes(filterName)) match = false;
            if (filterDesc && !desc.includes(filterDesc)) match = false;

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function resetHelpModalFilter() {
        document.getElementById('modal_filter_topic').value = '';
        document.getElementById('modal_filter_desc').value = '';
        document.querySelectorAll('#helpModalTbody tr.help-topic-row').forEach(row => {
            row.style.display = '';
        });
    }
</script>
@endsection
