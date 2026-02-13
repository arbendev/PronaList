<div class="search-page">
    <div class="container">
        <div class="row g-4">
            {{-- Filter Sidebar --}}
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <h5 class="filter-title">{{ __('general.search_title') }}</h5>

                    {{-- Listing Type --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_listing_type') }}</label>
                        <select wire:model.live="listingType" class="form-select">
                            <option value="">{{ __('general.filter_any') }}</option>
                            <option value="sale">{{ __('general.filter_for_sale') }}</option>
                            <option value="rent">{{ __('general.filter_for_rent') }}</option>
                        </select>
                    </div>

                    {{-- Property Type --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_type') }}</label>
                        <select wire:model.live="propertyTypeId" class="form-select">
                            <option value="">{{ __('general.filter_all_types') }}</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->translated_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- City --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_city') }}</label>
                        <select wire:model.live="city" class="form-select">
                            <option value="">{{ __('general.filter_all_cities') }}</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Range --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_price_range') }}</label>
                        <div class="price-inputs">
                            <input type="number" wire:model.live.debounce.500ms="priceMin"
                                   placeholder="{{ __('general.filter_price_min') }}" class="form-control">
                            <span>–</span>
                            <input type="number" wire:model.live.debounce.500ms="priceMax"
                                   placeholder="{{ __('general.filter_price_max') }}" class="form-control">
                        </div>
                    </div>

                    {{-- Bedrooms --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_bedrooms') }}</label>
                        <div class="bedroom-btns">
                            <button wire:click="$set('bedrooms', '')" class="bed-btn {{ $bedrooms === '' ? 'active' : '' }}">{{ __('general.filter_any') }}</button>
                            @for($i = 1; $i <= 5; $i++)
                                <button wire:click="$set('bedrooms', '{{ $i }}')" class="bed-btn {{ $bedrooms == $i ? 'active' : '' }}">{{ $i }}+</button>
                            @endfor
                        </div>
                    </div>

                    {{-- Bathrooms --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_bathrooms') }}</label>
                        <div class="bedroom-btns">
                            <button wire:click="$set('bathrooms', '')" class="bed-btn {{ $bathrooms === '' ? 'active' : '' }}">{{ __('general.filter_any') }}</button>
                            @for($i = 1; $i <= 4; $i++)
                                <button wire:click="$set('bathrooms', '{{ $i }}')" class="bed-btn {{ $bathrooms == $i ? 'active' : '' }}">{{ $i }}+</button>
                            @endfor
                        </div>
                    </div>

                    {{-- Sort --}}
                    <div class="filter-group">
                        <label>{{ __('general.filter_sort') }}</label>
                        <select wire:model.live="sortBy" class="form-select">
                            <option value="newest">{{ __('general.filter_sort_newest') }}</option>
                            <option value="price_asc">{{ __('general.filter_sort_price_asc') }}</option>
                            <option value="price_desc">{{ __('general.filter_sort_price_desc') }}</option>
                            <option value="area">{{ __('general.filter_sort_area') }}</option>
                        </select>
                    </div>

                    <button wire:click="clearFilters" class="btn btn-outline-custom w-100 mt-2">
                        {{ __('general.filter_clear') }}
                    </button>
                </div>
            </div>

            {{-- Results --}}
            <div class="col-lg-9">
                <div class="search-header">
                    <div class="results-count">
                        {!! __('general.search_results', ['count' => '<strong>' . $properties->total() . '</strong>']) !!}
                    </div>
                    <div class="view-toggle">
                        <button wire:click="setView('grid')" class="btn-view {{ $viewMode === 'grid' ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z"/>
                            </svg>
                        </button>
                        <button wire:click="setView('list')" class="btn-view {{ $viewMode === 'list' ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </button>
                    </div>
                </div>

                @if($properties->count())
                    <div class="row g-3">
                        @foreach($properties as $property)
                            <div class="{{ $viewMode === 'grid' ? 'col-md-6 col-xl-4' : 'col-12' }}">
                                <x-property-card :property="$property" />
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#ced4da" viewBox="0 0 16 16">
                            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        <p class="mt-3 text-muted">{{ __('general.search_no_results') }}</p>
                        <button wire:click="clearFilters" class="btn btn-primary-custom mt-2">{{ __('general.filter_clear') }}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
