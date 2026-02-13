<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="admin-page-title">Leads</h1>
        <div class="d-flex gap-2 align-items-center">
            <span class="text-muted">{{ $leads->total() }} total</span>
            <button wire:click="exportCsv" class="btn btn-sm btn-outline-primary">Export CSV</button>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8)">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Total</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626)">
                <div class="stat-number">{{ $stats['new'] }}</div>
                <div class="stat-label">New</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
                <div class="stat-number">{{ $stats['unassigned'] }}</div>
                <div class="stat-label">Unassigned</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #10b981, #059669)">
                <div class="stat-number">{{ $stats['assigned'] }}</div>
                <div class="stat-label">Assigned</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="admin-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search name, email, phone...">
            </div>
            <div class="col-md-2">
                <select wire:model.live="statusFilter" class="form-select">
                    <option value="">All Status</option>
                    <option value="new">New</option>
                    <option value="contacted">Contacted</option>
                    <option value="qualified">Qualified</option>
                    <option value="assigned">Assigned</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="col-md-2">
                <select wire:model.live="sourceFilter" class="form-select">
                    <option value="">All Sources</option>
                    <option value="property_inquiry">Property Inquiry</option>
                    <option value="contact_page">Contact Page</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th wire:click="sortBy('id')" style="cursor:pointer">ID ↕</th>
                        <th wire:click="sortBy('name')" style="cursor:pointer">Contact ↕</th>
                        <th>Source</th>
                        <th wire:click="sortBy('status')" style="cursor:pointer">Status ↕</th>
                        <th>Marketplace</th>
                        <th wire:click="sortBy('created_at')" style="cursor:pointer">Date ↕</th>
                        <th>Assigned?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>{{ $lead->id }}</td>
                            <td>
                                <div class="d-flex flex-column" style="line-height:1.2">
                                    <strong>{{ $lead->name }}</strong>
                                    <span class="text-muted small">{{ $lead->email }}</span>
                                    <span class="text-muted small">{{ $lead->phone }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $lead->source_label }}</span>
                                @if($lead->property)
                                    <div class="small text-muted mt-1">
                                        Re: <a href="{{ route('properties.show', $lead->property->slug) }}" target="_blank" class="text-reset">{{ Str::limit($lead->property->translated_title, 20) }}</a>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <select wire:change="quickStatus({{ $lead->id }}, $event.target.value)" class="form-select form-select-sm {{ $lead->status_badge_class }} border-0" style="width:auto;font-weight:600">
                                    @foreach(['new','contacted','qualified','assigned','closed'] as $s)
                                        <option value="{{ $s }}" {{ $lead->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="d-flex flex-column small">
                                    <span>Cost: <strong>{{ $lead->credit_cost }}</strong> credits</span>
                                    <span>Sold: <strong>{{ $lead->purchases_count }}</strong>/{{ $lead->max_buyers }}</span>
                                </div>
                            </td>
                            <td>{{ $lead->created_at->diffForHumans() }}</td>
                            <td>
                                @if($lead->assignedAgent)
                                    <div class="d-flex align-items-center gap-1">
                                        <img src="{{ $lead->assignedAgent->avatar_url }}" alt="" style="width:20px;height:20px;border-radius:50%">
                                        <span class="small">{{ $lead->assignedAgent->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button wire:click="editLead({{ $lead->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                    <button wire:click="deleteLead({{ $lead->id }})" wire:confirm="Delete this lead?" class="btn btn-sm btn-outline-danger">✕</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No leads found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">{{ $leads->links() }}</div>
    </div>

    {{-- Edit Modal --}}
    @if($showModal)
        <div class="admin-modal-overlay" wire:click.self="$set('showModal', false)">
            <div class="admin-modal">
                <div class="admin-modal-header">
                    <h5 class="mb-0">Edit Lead #{{ $editingId }}</h5>
                    <button wire:click="$set('showModal', false)" class="btn-close"></button>
                </div>
                <div class="admin-modal-body">
                    
                    {{-- Marketplace Settings --}}
                    <h6 class="text-uppercase text-muted small fw-bold mb-3">Marketplace Settings</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label">Credit Cost</label>
                            <input wire:model="editCreditCost" type="number" min="0" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Max Buyers</label>
                            <input wire:model="editMaxBuyers" type="number" min="1" class="form-control">
                        </div>
                    </div>
                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select wire:model="editStatus" class="form-select">
                            @foreach(['new','contacted','qualified','assigned','closed'] as $s)
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign Agent (Optional)</label>
                        <select wire:model="editAssignedTo" class="form-select">
                            <option value="">-- Unassigned --</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Manually assigning an agent does NOT deduct credits.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Internal Notes</label>
                        <textarea wire:model="editNotes" class="form-control" rows="3" placeholder="Add notes here..."></textarea>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button wire:click="$set('showModal', false)" class="btn btn-light">Cancel</button>
                    <button wire:click="saveLead" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    @endif
</div>
