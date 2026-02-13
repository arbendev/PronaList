<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="admin-page-title">Dashboard</h1>
        <span class="text-muted" style="font-size:0.85rem">{{ now()->format('l, F j, Y') }}</span>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8)">
                <div class="stat-number">{{ $stats['total_properties'] }}</div>
                <div class="stat-label">Total Properties</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #10b981, #059669)">
                <div class="stat-number">{{ $stats['active_properties'] }}</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
                <div class="stat-number">{{ $stats['pending_properties'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed)">
                <div class="stat-number">{{ number_format($stats['total_views']) }}</div>
                <div class="stat-label">Total Views</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #06b6d4, #0891b2)">
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Users / {{ $stats['agents'] }} Agents</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #ec4899, #db2777)">
                <div class="stat-number">{{ number_format($stats['total_credits']) }}</div>
                <div class="stat-label">Credits in Circulation</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #14b8a6, #0d9488)">
                <div class="stat-number">{{ number_format($stats['lead_purchases']) }}</div>
                <div class="stat-label">Leads Sold</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="admin-stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626)">
                <div class="stat-number">{{ $stats['new_leads'] }}</div>
                <div class="stat-label">New Leads</div>
            </div>
        </div>
    </div>

    {{-- Recent Tables --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="mb-0">Recent Leads</h5>
                    <a href="{{ route('admin.leads') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLeads as $lead)
                                <tr>
                                    <td>
                                        <strong>{{ $lead->name }}</strong>
                                        <div class="text-muted" style="font-size:0.8rem">{{ $lead->email }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $lead->source_label }}</span></td>
                                    <td><span class="badge {{ $lead->status_badge_class }}">{{ ucfirst($lead->status) }}</span></td>
                                    <td style="font-size:0.85rem">{{ $lead->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No leads yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="mb-0">Recent Properties</h5>
                    <a href="{{ route('admin.properties') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProperties as $prop)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($prop->translated_title, 30) }}</strong>
                                        <div class="text-muted" style="font-size:0.8rem">{{ $prop->city }}</div>
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ $prop->propertyType?->translated_name ?? '—' }}</span></td>
                                    <td>
                                        @if($prop->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($prop->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($prop->status) }}</span>
                                        @endif
                                    </td>
                                    <td style="font-weight:600">{{ $prop->formatted_price }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No properties yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
