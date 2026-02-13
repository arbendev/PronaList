<div class="detail-page">
    <div class="container py-4">
        {{-- Header --}}
        <div class="detail-header">
            <div class="detail-location-bar">
                <div>
                    <h1 class="detail-title">{{ $property->translated_title }}</h1>
                    <div class="location-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                        </svg>
                        {{ $property->address }}, {{ $property->city }}, {{ $property->country }}
                    </div>
                </div>
                <div class="detail-price">
                    {{ $property->formatted_price }}
                    @if($property->listing_type === 'rent')
                        <span style="font-size:1rem;color:#6c757d;font-weight:400">{{ __('general.card_per_month') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Gallery --}}
                <div class="property-gallery">
                    @if($property->images->count())
                        <img src="{{ $property->images[$activeImage]->url ?? $property->primary_image_url }}"
                             alt="{{ $property->translated_title }}"
                             class="gallery-main">
                        @if($property->images->count() > 1)
                            <div class="gallery-thumbs">
                                @foreach($property->images as $index => $image)
                                    <img wire:click="setImage({{ $index }})"
                                         src="{{ $image->url }}"
                                         alt=""
                                         class="thumb {{ $activeImage === $index ? 'active' : '' }}">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <img src="{{ $property->primary_image_url }}" alt="" class="gallery-main">
                    @endif
                </div>

                {{-- Content --}}
                <div class="detail-content">
                    {{-- Overview / Key Facts --}}
                    <div class="content-section">
                        <h3 class="content-title">{{ __('general.detail_overview') }}</h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 640 512"><path d="M32 32c17.7 0 32 14.3 32 32V320H288V160c0-17.7 14.3-32 32-32H544c53 0 96 43 96 96V448c0 17.7-14.3 32-32 32s-32-14.3-32-32V416H352 320 64v32c0 17.7-14.3 32-32 32s-32-14.3-32-32V64C0 46.3 14.3 32 32 32z"/></svg>
                                </div>
                                <div class="detail-info">
                                    <div class="detail-label">{{ __('general.detail_bedrooms') }}</div>
                                    <div class="detail-value">{{ $property->bedrooms }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 512 512"><path d="M96 77.3c0-7.3 5.9-13.3 13.3-13.3c3.5 0 6.9 1.4 9.4 3.9l14.9 14.9C130 91.8 128 101.7 128 112c0 19.9 7.2 38 19.2 52c-5.3 9.2-4 21.1 3.8 29c9.4 9.4 24.6 9.4 33.9 0L289 89c9.4-9.4 9.4-24.6 0-33.9c-7.9-7.9-19.8-9.1-29-3.8C246 39.2 227.9 32 208 32c-10.3 0-20.2 2-29.2 5.5L163.9 22.6C149.4 8.1 129.7 0 109.3 0C65.8 0 32 34.8 32 77.3V256c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H96V77.3z"/></svg>
                                </div>
                                <div class="detail-info">
                                    <div class="detail-label">{{ __('general.detail_bathrooms') }}</div>
                                    <div class="detail-value">{{ $property->bathrooms }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 4a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5zM2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z"/></svg>
                                </div>
                                <div class="detail-info">
                                    <div class="detail-label">{{ __('general.detail_area') }}</div>
                                    <div class="detail-value">{{ $property->area_sqm ? number_format($property->area_sqm, 0) . ' m²' : '—' }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354z"/></svg>
                                </div>
                                <div class="detail-info">
                                    <div class="detail-label">{{ __('general.detail_type') }}</div>
                                    <div class="detail-value">{{ $property->propertyType->translated_name }}</div>
                                </div>
                            </div>
                            @if($property->year_built)
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                                </div>
                                <div class="detail-info">
                                    <div class="detail-label">{{ __('general.detail_year_built') }}</div>
                                    <div class="detail-value">{{ $property->year_built }}</div>
                                </div>
                            </div>
                            @endif
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1z"/></svg>
                                </div>
                                <div class="detail-info">
                                    <div class="detail-label">{{ __('general.detail_floors') }}</div>
                                    <div class="detail-value">{{ $property->floors }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="content-section">
                        <h3 class="content-title">{{ __('general.detail_description') }}</h3>
                        <p style="line-height:1.8;color:#495057">{{ $property->translated_description }}</p>
                    </div>

                    {{-- Features --}}
                    @if($property->features && count($property->features))
                    <div class="content-section">
                        <h3 class="content-title">{{ __('general.detail_features') }}</h3>
                        <div class="feature-tags">
                            @foreach($property->features as $feature)
                                <span class="feature-tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                    </svg>
                                    {{ $feature }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Mortgage Calculator (hidden for now)
                    <div class="content-section">
                        <livewire:mortgage-calculator :price="$property->price" />
                    </div>
                    --}}
                </div>
            </div>

            {{-- Lead Capture Sidebar --}}
            <div class="col-lg-4">
                <div class="agent-sidebar">
                    <livewire:contact-agent :property-id="$property->id" :agent-id="$property->user_id" />
                </div>
            </div>
        </div>

        {{-- Similar Properties --}}
        @if($similar->count())
        <div class="section-padding">
            <div class="section-header">
                <h2 class="section-title">{{ __('general.detail_similar') }}</h2>
            </div>
            <div class="row g-3">
                @foreach($similar as $prop)
                    <div class="col-md-4">
                        <x-property-card :property="$prop" />
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
