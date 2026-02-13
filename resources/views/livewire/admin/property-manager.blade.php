<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="admin-page-title">Properties</h1>
        <span class="text-muted">{{ $properties->total() }} total</span>
    </div>

    {{-- Filters --}}
    <div class="admin-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search title, city, address...">
            </div>
            <div class="col-md-2">
                <select wire:model.live="statusFilter" class="form-select">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="sold">Sold</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <select wire:model.live="typeFilter" class="form-select">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->translated_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select wire:model.live="cityFilter" class="form-select">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
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
                        <th>Property</th>
                        <th wire:click="sortBy('city')" style="cursor:pointer">City ↕</th>
                        <th>Type</th>
                        <th wire:click="sortBy('price')" style="cursor:pointer">Price ↕</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th wire:click="sortBy('views')" style="cursor:pointer">Views ↕</th>
                        <th>Owner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $prop)
                        <tr>
                            <td>{{ $prop->id }}</td>
                            <td>
                                <a href="{{ route('properties.show', $prop->slug) }}" target="_blank" class="text-decoration-none">
                                    <strong>{{ Str::limit($prop->translated_title, 35) }}</strong>
                                </a>
                            </td>
                            <td>{{ $prop->city }}</td>
                            <td><span class="badge bg-light text-dark">{{ $prop->propertyType?->translated_name ?? '—' }}</span></td>
                            <td style="font-weight:600">{{ $prop->formatted_price }}</td>
                            <td>
                                <button wire:click="toggleFeatured({{ $prop->id }})" class="btn btn-sm {{ $prop->is_featured ? 'btn-warning' : 'btn-outline-secondary' }}" title="Toggle Featured">
                                    ★
                                </button>
                            </td>
                            <td>
                                <select wire:change="updateStatus({{ $prop->id }}, $event.target.value)" class="form-select form-select-sm" style="width:auto">
                                    @foreach(['active','pending','sold','inactive'] as $s)
                                        <option value="{{ $s }}" {{ $prop->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>{{ number_format($prop->views ?? 0) }}</td>
                            <td>{{ $prop->user?->name ?? '—' }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button wire:click="editProperty({{ $prop->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                    <button wire:click="deleteProperty({{ $prop->id }})" wire:confirm="Delete this property?" class="btn btn-sm btn-outline-danger">✕</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center text-muted py-4">No properties found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">{{ $properties->links() }}</div>
    </div>

    {{-- Full Edit Modal --}}
    @if($showModal)
        <div class="admin-modal-overlay" wire:click.self="$set('showModal', false)">
            <div class="admin-modal" style="max-width:800px">
                <div class="admin-modal-header">
                    <h5 class="mb-0">Edit Property #{{ $editingId }}</h5>
                    <button wire:click="$set('showModal', false)" class="btn-close"></button>
                </div>
                <div class="admin-modal-body" style="max-height:70vh;overflow-y:auto">

                    {{-- Validation errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger py-2 mb-3">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Title (EN / SQ) --}}
                    <h6 class="fw-bold text-muted text-uppercase small mb-2">Title</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Title (English) <span class="text-danger">*</span></label>
                            <input wire:model="editTitleEn" type="text" class="form-control @error('editTitleEn') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title (Albanian)</label>
                            <input wire:model="editTitleSq" type="text" class="form-control">
                        </div>
                    </div>

                    {{-- Description (EN / SQ) --}}
                    <h6 class="fw-bold text-muted text-uppercase small mb-2">Description</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Description (English)</label>
                            <textarea wire:model="editDescriptionEn" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Description (Albanian)</label>
                            <textarea wire:model="editDescriptionSq" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <hr>

                    {{-- Pricing & Type --}}
                    <h6 class="fw-bold text-muted text-uppercase small mb-2">Pricing & Type</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <input wire:model="editPrice" type="number" step="0.01" class="form-control @error('editPrice') is-invalid @enderror">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Currency</label>
                            <select wire:model="editCurrency" class="form-select">
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Listing Type</label>
                            <select wire:model="editListingType" class="form-select">
                                <option value="sale">For Sale</option>
                                <option value="rent">For Rent</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select wire:model="editStatus" class="form-select">
                                @foreach(['active','pending','sold','inactive'] as $s)
                                    <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Property Type</label>
                            <select wire:model="editPropertyTypeId" class="form-select">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->translated_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>

                    {{-- Location --}}
                    <h6 class="fw-bold text-muted text-uppercase small mb-2">Location</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Address</label>
                            <input wire:model="editAddress" type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input wire:model="editCity" type="text" class="form-control @error('editCity') is-invalid @enderror">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">State</label>
                            <input wire:model="editState" type="text" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Zip Code</label>
                            <input wire:model="editZipCode" type="text" class="form-control">
                        </div>
                    </div>

                    <hr>

                    {{-- Property Details --}}
                    <h6 class="fw-bold text-muted text-uppercase small mb-2">Details</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3 col-6">
                            <label class="form-label">Bedrooms</label>
                            <input wire:model="editBedrooms" type="number" min="0" class="form-control">
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label">Bathrooms</label>
                            <input wire:model="editBathrooms" type="number" min="0" class="form-control">
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label">Area (m²)</label>
                            <input wire:model="editAreaSqm" type="number" step="0.01" min="0" class="form-control">
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label">Lot Size (m²)</label>
                            <input wire:model="editLotSizeSqm" type="number" step="0.01" min="0" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3 col-6">
                            <label class="form-label">Year Built</label>
                            <input wire:model="editYearBuilt" type="number" min="1900" max="{{ date('Y') }}" class="form-control">
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label">Floors</label>
                            <input wire:model="editFloors" type="number" min="0" class="form-control">
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label">Garage Spaces</label>
                            <input wire:model="editGarageSpaces" type="number" min="0" class="form-control">
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label">Featured</label>
                            <div class="form-check form-switch mt-1">
                                <input wire:model="editFeatured" class="form-check-input" type="checkbox" id="editFeaturedSwitch">
                                <label class="form-check-label" for="editFeaturedSwitch">Show as featured</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="admin-modal-footer">
                    <button wire:click="$set('showModal', false)" class="btn btn-light">Cancel</button>
                    <button wire:click="saveProperty" class="btn btn-primary">
                        <span wire:loading wire:target="saveProperty" class="spinner-border spinner-border-sm me-1"></span>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
