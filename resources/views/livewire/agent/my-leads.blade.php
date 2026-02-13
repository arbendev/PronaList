<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Leads</h1>
            <p class="text-muted mb-0">Leads you have purchased and unlocked.</p>
        </div>
        <a href="{{ route('agent.leads') }}" class="btn btn-primary">Browse Marketplace</a>
    </div>

    @if($leads->isEmpty())
        <div class="text-center py-5 bg-light rounded">
            <p class="mb-3 text-muted">You haven't purchased any leads yet.</p>
            <a href="{{ route('agent.leads') }}" class="btn btn-outline-primary">Browse Marketplace</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($leads as $lead)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                {{-- Contact Info (Unlocked) --}}
                                <div class="col-md-4 mb-3 mb-md-0 border-end">
                                    <h5 class="fw-bold text-primary mb-3">{{ $lead->name }}</h5>
                                    
                                    <div class="mb-2">
                                        <label class="small text-muted text-uppercase fw-bold">Email</label>
                                        <div><a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->email }}</a></div>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <label class="small text-muted text-uppercase fw-bold">Phone</label>
                                        <div><a href="tel:{{ $lead->phone }}" class="text-decoration-none">{{ $lead->phone }}</a></div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            Purchased {{ $lead->pivot->purchased_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Lead Details --}}
                                <div class="col-md-8 ps-md-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="badge bg-light text-dark border">{{ $lead->source_label }}</span>
                                        <span class="text-muted small">ID: #{{ $lead->id }}</span>
                                    </div>

                                    <div class="mb-3 bg-light p-3 rounded">
                                        <label class="small text-muted text-uppercase fw-bold mb-1">Message</label>
                                        <p class="mb-0 fst-italic">"{{ $lead->message }}"</p>
                                    </div>

                                    @if($lead->property)
                                        <div class="d-flex align-items-center gap-3 mt-3 pt-3 border-top">
                                            <img src="{{ $lead->property->thumbnail_url }}" style="width:60px;height:40px;object-fit:cover;border-radius:4px" alt="">
                                            <div>
                                                <a href="{{ route('properties.show', $lead->property->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                                                    {{ $lead->property->translated_title }}
                                                </a>
                                                <div class="small text-muted">{{ $lead->property->city }} • {{ $lead->property->formatted_price }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $leads->links() }}
        </div>
    @endif
</div>
