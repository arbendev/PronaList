<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Lead Marketplace</h1>
            <p class="text-muted mb-0">Browse and acquire new leads for your portfolio.</p>
        </div>
        <div class="bg-white p-3 rounded shadow-sm border d-flex align-items-center gap-3">
            <div>
                <small class="text-uppercase text-muted fw-bold" style="font-size:0.7rem">Your Balance</small>
                <div class="h4 fw-bold text-primary mb-0">{{ $user->credits }} Credits</div>
            </div>
            <a href="{{ route('agent.my-leads') }}" class="btn btn-outline-primary">My Leads</a>
        </div>
    </div>

    @if($leads->isEmpty())
        <div class="text-center py-5">
            <div class="mb-3 text-muted">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                </svg>
            </div>
            <h4>No New Leads Available</h4>
            <p class="text-muted">Check back later for new inquiries.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($leads as $lead)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm lead-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-light text-dark border">{{ $lead->source_label }}</span>
                                <span class="text-muted small">{{ $lead->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h5 class="card-title text-truncate">
                                @if($lead->property)
                                    {{ $lead->property->propertyType->translated_name ?? 'Property' }} inquiry
                                @else
                                    General Inquiry
                                @endif
                            </h5>

                            <p class="card-text text-muted small mb-3">
                                @if($lead->property)
                                    Interested in: <strong>{{ Str::limit($lead->property->translated_title, 40) }}</strong><br>
                                    Location: {{ $lead->property->city }}
                                @else
                                    General contact request via website.
                                @endif
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                <div class="small">
                                    <span class="d-block text-muted" style="font-size:0.75rem">Market Demand</span>
                                    <strong>{{ $lead->purchases_count }} / {{ $lead->max_buyers }} Sold</strong>
                                </div>
                                <button wire:click="purchaseLead({{ $lead->id }})" 
                                        wire:confirm="Purchase this lead for {{ $lead->credit_cost }} credits?"
                                        class="btn btn-primary d-flex align-items-center gap-2"
                                        {{ $user->credits < $lead->credit_cost ? 'disabled' : '' }}>
                                    <span>Buy Now</span>
                                    <span class="badge bg-white text-primary rounded-pill px-2">{{ $lead->credit_cost }} Credits</span>
                                </button>
                            </div>
                        </div>
                        @if($user->credits < $lead->credit_cost)
                            <div class="card-footer bg-light text-center py-2">
                                <small class="text-danger">Insufficient credits</small>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $leads->links() }}
        </div>
    @endif
</div>
