{{-- Property Card Component --}}
@props(['property'])

<div class="property-card">
    <div class="card-image-wrapper">
        <a href="{{ route('properties.show', $property->slug) }}">
            <img src="{{ $property->primary_image_url }}" alt="{{ $property->translated_title }}" class="card-img-top">
        </a>

        <div class="card-badges">
            <span class="badge-type {{ $property->listing_type === 'rent' ? '' : '' }}">
                {{ $property->listing_type === 'sale' ? __('general.card_for_sale') : __('general.card_for_rent') }}
            </span>
            @if($property->is_featured)
                <span class="badge-type badge-featured">{{ __('general.card_featured') }}</span>
            @endif
        </div>

        @auth
            <div class="card-favorite">
                <livewire:favorite-button :property-id="$property->id" :key="'fav-'.$property->id" />
            </div>
        @endauth

        @if($property->images_count ?? $property->images->count() > 1)
            <span class="card-image-count">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                </svg>
                {{ $property->images->count() }}
            </span>
        @endif
    </div>

    <div class="card-body">
        <div class="card-price">
            {{ $property->formatted_price }}
            @if($property->listing_type === 'rent')
                <span class="price-period">{{ __('general.card_per_month') }}</span>
            @endif
        </div>

        <h5 class="card-title">
            <a href="{{ route('properties.show', $property->slug) }}">
                {{ $property->translated_title }}
            </a>
        </h5>

        <div class="card-location">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
            </svg>
            {{ $property->city }}, {{ $property->country }}
        </div>

        <div class="card-features">
            <div class="feature">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 640 512">
                    <path d="M32 32c17.7 0 32 14.3 32 32V320H288V160c0-17.7 14.3-32 32-32H544c53 0 96 43 96 96V448c0 17.7-14.3 32-32 32s-32-14.3-32-32V416H352 320 64v32c0 17.7-14.3 32-32 32s-32-14.3-32-32V64C0 46.3 14.3 32 32 32z"/>
                </svg>
                <strong>{{ $property->bedrooms }}</strong> {{ __('general.card_beds') }}
            </div>
            <div class="feature">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 512 512">
                    <path d="M96 77.3c0-7.3 5.9-13.3 13.3-13.3c3.5 0 6.9 1.4 9.4 3.9l14.9 14.9C130 91.8 128 101.7 128 112c0 19.9 7.2 38 19.2 52c-5.3 9.2-4 21.1 3.8 29c9.4 9.4 24.6 9.4 33.9 0L289 89c9.4-9.4 9.4-24.6 0-33.9c-7.9-7.9-19.8-9.1-29-3.8C246 39.2 227.9 32 208 32c-10.3 0-20.2 2-29.2 5.5L163.9 22.6C149.4 8.1 129.7 0 109.3 0C65.8 0 32 34.8 32 77.3V256c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H96V77.3z"/>
                </svg>
                <strong>{{ $property->bathrooms }}</strong> {{ __('general.card_baths') }}
            </div>
            @if($property->area_sqm)
                <div class="feature">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M5.5 4a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5zM2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z"/>
                    </svg>
                    <strong>{{ number_format($property->area_sqm, 0) }}</strong> {{ __('general.card_sqm') }}
                </div>
            @endif
        </div>
    </div>
</div>
