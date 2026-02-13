<div class="dashboard-page">
    <div class="container">
        <div class="dashboard-header">
            <h1>{{ __('general.dash_title') }}</h1>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs dashboard-tabs mb-4">
            @if(Auth::user()->role === 'agent')
                <li class="nav-item">
                    <button wire:click="setTab('new-leads')" class="nav-link {{ $activeTab === 'new-leads' ? 'active' : '' }}">
                        New Leads
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="setTab('my-leads')" class="nav-link {{ $activeTab === 'my-leads' ? 'active' : '' }}">
                        My Leads
                    </button>
                </li>
            @endif
            <li class="nav-item">
                <button wire:click="setTab('listings')" class="nav-link {{ $activeTab === 'listings' ? 'active' : '' }}">
                    {{ __('general.dash_my_listings') }}
                    <span class="badge bg-secondary ms-1">{{ $listings->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button wire:click="setTab('favorites')" class="nav-link {{ $activeTab === 'favorites' ? 'active' : '' }}">
                    {{ __('general.dash_favorites') }}
                    <span class="badge bg-secondary ms-1">{{ $favorites->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button wire:click="setTab('messages')" class="nav-link {{ $activeTab === 'messages' ? 'active' : '' }}">
                    {{ __('general.dash_messages') }}
                    @if($messages->where('is_read', false)->count())
                        <span class="badge bg-danger ms-1">{{ $messages->where('is_read', false)->count() }}</span>
                    @endif
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div>
            @if(Auth::user()->role === 'agent')
                {{-- New Leads --}}
                @if($activeTab === 'new-leads')
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <livewire:agent.lead-marketplace />
                        </div>
                    </div>
                @endif

                {{-- My Leads --}}
                @if($activeTab === 'my-leads')
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <livewire:agent.my-leads />
                        </div>
                    </div>
                @endif
            @endif

            {{-- My Listings --}}
            @if($activeTab === 'listings')
                @if($listings->count())
                    @foreach($listings as $listing)
                        <div class="listing-item">
                            <img src="{{ $listing->primary_image_url }}" alt="" class="listing-thumb">
                            <div class="listing-info">
                                <div class="listing-title">{{ $listing->translated_title }}</div>
                                <div class="listing-meta">{{ $listing->city }} · {{ $listing->bedrooms }} {{ __('general.card_beds') }} · {{ ucfirst($listing->status) }}</div>
                            </div>
                            <div class="listing-price">{{ $listing->formatted_price }}</div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('properties.show', $listing->slug) }}" class="btn btn-sm btn-outline-primary">
                                    {{ __('general.card_view_details') }}
                                </a>
                                <button wire:click="deleteListing({{ $listing->id }})"
                                        wire:confirm="Are you sure?"
                                        class="btn btn-sm btn-outline-danger">
                                    {{ __('general.dash_delete') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5 text-muted">
                        <p>{{ __('general.dash_no_listings') }}</p>
                        <a href="{{ route('list-property') }}" class="btn btn-primary-custom">{{ __('general.nav_list_property') }}</a>
                    </div>
                @endif
            @endif

            {{-- Favorites --}}
            @if($activeTab === 'favorites')
                @if($favorites->count())
                    <div class="row g-3">
                        @foreach($favorites as $property)
                            <div class="col-md-6 col-lg-4">
                                <x-property-card :property="$property" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <p>{{ __('general.dash_no_favorites') }}</p>
                        <a href="{{ route('properties.search') }}" class="btn btn-primary-custom">{{ __('general.hero_btn_search') }}</a>
                    </div>
                @endif
            @endif

            {{-- Messages --}}
            @if($activeTab === 'messages')
                @if($messages->count())
                    @foreach($messages as $msg)
                        <div class="message-item {{ !$msg->is_read ? 'unread' : '' }}" wire:click="markAsRead({{ $msg->id }})">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="message-sender">
                                        {{ $msg->sender->name }}
                                        @if(!$msg->is_read)
                                            <span class="badge bg-primary ms-1" style="font-size:0.7rem">{{ __('general.dash_unread') }}</span>
                                        @endif
                                    </div>
                                    <div class="message-subject">{{ $msg->subject }}</div>
                                    <div class="mt-1" style="font-size:0.85rem;color:#495057">{{ Str::limit($msg->body, 120) }}</div>
                                </div>
                                <div class="message-time">{{ $msg->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5 text-muted">
                        <p>{{ __('general.dash_no_messages') }}</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
