<div class="lead-manager">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 style="font-weight:800;color:#1a1a2e;font-size:1.8rem">Lead Manager</h1>
                <p class="text-muted mb-0">Manage and assign property inquiry leads</p>
            </div>
            <button wire:click="exportCsv" class="btn btn-outline-custom">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                </svg>
                Export CSV
            </button>
        </div>

        {{-- Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#667eea,#764ba2)">
                    <div class="stat-number">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Leads</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#00c853,#00e676)">
                    <div class="stat-number">{{ $stats['new'] }}</div>
                    <div class="stat-label">New Leads</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#ff6b35,#f7c948)">
                    <div class="stat-number">{{ $stats['unassigned'] }}</div>
                    <div class="stat-label">Unassigned</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card" style="background:linear-gradient(135deg,#0091ea,#00b0ff)">
                    <div class="stat-number">{{ $stats['assigned'] }}</div>
                    <div class="stat-label">Assigned</div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="filter-bar mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                           placeholder="Search by name, email, phone...">
                </div>
                <div class="col-md-3">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="new">🟢 New</option>
                        <option value="contacted">🔵 Contacted</option>
                        <option value="qualified">🟡 Qualified</option>
                        <option value="assigned">✅ Assigned</option>
                        <option value="closed">⚫ Closed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select wire:model.live="filterSource" class="form-select">
                        <option value="">All Sources</option>
                        <option value="property_inquiry">Property Inquiry</option>
                        <option value="contact_page">Contact Page</option>
                        <option value="general">General</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <span class="text-muted" style="font-size:0.85rem">{{ $leads->total() }} results</span>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table lead-table">
                <thead>
                    <tr>
                        <th wire:click="sortBy('created_at')" style="cursor:pointer">
                            Date
                            @if($sortField === 'created_at')
                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                            @endif
                        </th>
                        <th wire:click="sortBy('name')" style="cursor:pointer">
                            Contact
                            @if($sortField === 'name')
                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                            @endif
                        </th>
                        <th>Source</th>
                        <th>Property</th>
                        <th wire:click="sortBy('status')" style="cursor:pointer">
                            Status
                            @if($sortField === 'status')
                                <small>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</small>
                            @endif
                        </th>
                        <th>Assigned</th>
                        <th style="width:120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr class="{{ $lead->status === 'new' ? 'lead-new' : '' }}">
                            <td>
                                <div style="font-size:0.85rem">{{ $lead->created_at->format('M d, Y') }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $lead->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $lead->name }}</div>
                                <div style="font-size:0.8rem;color:#6c757d">{{ $lead->email }}</div>
                                @if($lead->phone)
                                    <div style="font-size:0.8rem;color:#6c757d">{{ $lead->phone }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark" style="font-size:0.75rem">
                                    {{ $lead->source_label }}
                                </span>
                            </td>
                            <td>
                                @if($lead->property)
                                    <a href="{{ route('properties.show', $lead->property->slug) }}"
                                       class="text-decoration-none" style="font-size:0.85rem" target="_blank">
                                        {{ Str::limit($lead->property->translated_title, 30) }}
                                    </a>
                                    <div class="text-muted" style="font-size:0.75rem">{{ $lead->property->city }}</div>
                                @else
                                    <span class="text-muted" style="font-size:0.85rem">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $lead->status_badge_class }}" style="font-size:0.75rem">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>
                            <td>
                                @if($lead->assignedAgent)
                                    <div style="font-size:0.85rem">{{ $lead->assignedAgent->name }}</div>
                                    <div class="text-muted" style="font-size:0.7rem">{{ $lead->assigned_at?->format('M d') }}</div>
                                @else
                                    <span class="text-muted" style="font-size:0.85rem">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button wire:click="openLead({{ $lead->id }})"
                                            class="btn btn-outline-primary btn-sm" title="View/Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteLead({{ $lead->id }})"
                                            wire:confirm="Are you sure you want to delete this lead?"
                                            class="btn btn-outline-danger btn-sm" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No leads found matching your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $leads->links() }}
    </div>

    {{-- Edit Lead Modal --}}
    @if($editingLeadId)
        @php $editingLead = \App\Models\Lead::with(['property', 'assignedAgent'])->find($editingLeadId); @endphp
        <div class="lead-modal-overlay" wire:click.self="closeLead">
            <div class="lead-modal">
                <div class="lead-modal-header">
                    <h5 class="mb-0 fw-bold">Lead #{{ $editingLead->id }}</h5>
                    <button wire:click="closeLead" class="btn-close"></button>
                </div>
                <div class="lead-modal-body">
                    {{-- Lead Info --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size:0.8rem">NAME</label>
                            <div class="fw-semibold">{{ $editingLead->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size:0.8rem">EMAIL</label>
                            <div><a href="mailto:{{ $editingLead->email }}">{{ $editingLead->email }}</a></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size:0.8rem">PHONE</label>
                            <div>{{ $editingLead->phone ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted" style="font-size:0.8rem">SOURCE</label>
                            <div>{{ $editingLead->source_label }}</div>
                        </div>
                        @if($editingLead->property)
                            <div class="col-12">
                                <label class="form-label text-muted" style="font-size:0.8rem">PROPERTY</label>
                                <div>
                                    <a href="{{ route('properties.show', $editingLead->property->slug) }}" target="_blank">
                                        {{ $editingLead->property->translated_title }}
                                    </a>
                                    <span class="text-muted">({{ $editingLead->property->city }})</span>
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            <label class="form-label text-muted" style="font-size:0.8rem">MESSAGE</label>
                            <div class="p-3 rounded" style="background:#f8f9fa;white-space:pre-wrap;font-size:0.9rem">{{ $editingLead->message }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted" style="font-size:0.8rem">SUBMITTED</label>
                            <div>{{ $editingLead->created_at->format('M d, Y \\a\\t H:i') }} · IP: {{ $editingLead->ip_address ?? '—' }}</div>
                        </div>
                    </div>

                    <hr>

                    {{-- Editable Fields --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.85rem">Status</label>
                            <select wire:model="editStatus" class="form-select">
                                <option value="new">🟢 New</option>
                                <option value="contacted">🔵 Contacted</option>
                                <option value="qualified">🟡 Qualified</option>
                                <option value="assigned">✅ Assigned</option>
                                <option value="closed">⚫ Closed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.85rem">Assign to Agent</label>
                            <select wire:model="assignAgentId" class="form-select">
                                <option value="">— Unassigned —</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}
                                        @if($agent->agency_name) ({{ $agent->agency_name }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:0.85rem">Internal Notes</label>
                            <textarea wire:model="editNotes" class="form-control" rows="3"
                                      placeholder="Add private notes about this lead..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="lead-modal-footer">
                    <button wire:click="closeLead" class="btn btn-outline-custom">Cancel</button>
                    <button wire:click="updateLead" class="btn btn-primary-custom">Save Changes</button>
                </div>
            </div>
        </div>
    @endif
</div>
