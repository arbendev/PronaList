<div class="list-property-page">
    <div class="container">
        <div class="text-center mb-4">
            <h1 style="font-weight:800;font-size:2rem;color:#1a1a2e">{{ __('general.list_title') }}</h1>
            <p class="text-muted">{{ __('general.list_subtitle') }}</p>
        </div>

        @if($success)
            <div class="form-card text-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#00c853" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <h3 class="mt-3" style="font-weight:700">{{ __('general.list_success') }}</h3>
                <a href="{{ route('dashboard') }}" class="btn btn-primary-custom mt-3">{{ __('general.nav_dashboard') }}</a>
            </div>
        @else
            {{-- Step Indicator --}}
            <div class="step-indicator">
                @foreach([1 => __('general.list_step_basic'), 2 => __('general.list_step_details'), 3 => __('general.list_step_images'), 4 => __('general.list_step_review')] as $num => $label)
                    <div class="step {{ $step >= $num ? ($step > $num ? 'completed' : 'active') : '' }}">
                        <div class="step-circle">{{ $num }}</div>
                        <span class="step-label d-none d-md-inline">{{ $label }}</span>
                        @if($num < 4)<div class="step-line"></div>@endif
                    </div>
                @endforeach
            </div>

            <div class="form-card" style="max-width:800px;margin:0 auto">
                {{-- Step 1: Basic Info --}}
                @if($step === 1)
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('general.list_title_label') }} (EN) *</label>
                            <input type="text" wire:model="titleEn" class="form-control" placeholder="Modern apartment in Prishtina...">
                            @error('titleEn') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('general.list_title_label') }} (SQ)</label>
                            <input type="text" wire:model="titleSq" class="form-control" placeholder="Apartament modern në Prishtinë...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('general.list_description_label') }} (EN) *</label>
                            <textarea wire:model="descriptionEn" class="form-control" rows="4"></textarea>
                            @error('descriptionEn') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('general.list_description_label') }} (SQ)</label>
                            <textarea wire:model="descriptionSq" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('general.list_listing_type_label') }}</label>
                            <select wire:model="listingType" class="form-select">
                                <option value="sale">{{ __('general.filter_for_sale') }}</option>
                                <option value="rent">{{ __('general.filter_for_rent') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('general.list_type_label') }} *</label>
                            <select wire:model="propertyTypeId" class="form-select">
                                <option value="">{{ __('general.filter_all_types') }}</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->translated_name }}</option>
                                @endforeach
                            </select>
                            @error('propertyTypeId') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('general.list_price_label') }} *</label>
                            <input type="number" wire:model="price" class="form-control" min="0" step="100">
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                @endif

                {{-- Step 2: Details --}}
                @if($step === 2)
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">{{ __('general.list_address_label') }} *</label>
                            <input type="text" wire:model="address" class="form-control">
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('general.list_city_label') }} *</label>
                            <input type="text" wire:model="city" class="form-control">
                            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ __('general.detail_bedrooms') }}</label>
                            <input type="number" wire:model="bedrooms" class="form-control" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ __('general.detail_bathrooms') }}</label>
                            <input type="number" wire:model="bathrooms" class="form-control" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ __('general.detail_area') }} (m²)</label>
                            <input type="number" wire:model="areaSqm" class="form-control" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">{{ __('general.detail_floors') }}</label>
                            <input type="number" wire:model="floors" class="form-control" min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">{{ __('general.detail_year_built') }}</label>
                            <input type="number" wire:model="yearBuilt" class="form-control" min="1900" max="{{ date('Y') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('general.detail_features') }}</label>
                            <div class="feature-tags">
                                @foreach($availableFeatures as $feature)
                                    <button type="button"
                                            wire:click="toggleFeature('{{ $feature }}')"
                                            class="feature-tag {{ in_array($feature, $selectedFeatures) ? 'border-primary bg-primary text-white' : '' }}"
                                            style="cursor:pointer;border:none">
                                        {{ $feature }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Step 3: Images --}}
                @if($step === 3)
                    <div>
                        <div class="image-upload-zone" onclick="document.getElementById('photoUpload').click()">
                            <div wire:loading wire:target="newPhotos" class="upload-icon">⏳</div>
                            <div wire:loading.remove wire:target="newPhotos" class="upload-icon">📷</div>
                            <div wire:loading wire:target="newPhotos" class="upload-text">Uploading...</div>
                            <div wire:loading.remove wire:target="newPhotos" class="upload-text">{{ __('general.list_drag_drop') }}</div>
                        </div>
                        <input type="file" wire:model="newPhotos" id="photoUpload" multiple accept="image/*" class="d-none">
                        @error('newPhotos.*') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        @error('photos') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror

                        @if(count($photos))
                            <div class="image-preview">
                                @foreach($photos as $index => $photo)
                                    <div class="preview-item">
                                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview">
                                        <button wire:click="removePhoto({{ $index }})" class="remove-btn">×</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Step 4: Review --}}
                @if($step === 4)
                    <div>
                        <h5 class="fw-bold mb-3">Review Your Listing</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><strong>{{ __('general.list_title_label') }}:</strong> {{ $titleEn }}</p>
                                <p><strong>{{ __('general.list_listing_type_label') }}:</strong> {{ ucfirst($listingType) }}</p>
                                <p><strong>{{ __('general.list_price_label') }}:</strong> €{{ number_format((float) $price, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('general.list_address_label') }}:</strong> {{ $address }}, {{ $city }}</p>
                                <p><strong>{{ __('general.detail_bedrooms') }}:</strong> {{ $bedrooms }} | <strong>{{ __('general.detail_bathrooms') }}:</strong> {{ $bathrooms }}</p>
                                <p><strong>{{ __('general.detail_area') }}:</strong> {{ $areaSqm ? $areaSqm . ' m²' : '—' }}</p>
                            </div>
                            @if(count($selectedFeatures))
                                <div class="col-12">
                                    <strong>{{ __('general.detail_features') }}:</strong>
                                    {{ implode(', ', $selectedFeatures) }}
                                </div>
                            @endif
                            <div class="col-12">
                                <strong>{{ __('general.detail_photos') }}:</strong> {{ count($photos) }} images uploaded
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Navigation --}}
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    @if($step > 1)
                        <button wire:click="prevStep" class="btn btn-outline-custom">{{ __('general.list_prev') }}</button>
                    @else
                        <div></div>
                    @endif

                    @if($step < 4)
                        <button wire:click="nextStep" class="btn btn-primary-custom">{{ __('general.list_next') }}</button>
                    @else
                        <button wire:click="submit" class="btn btn-primary-custom">
                            {{ __('general.list_submit') }}
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
