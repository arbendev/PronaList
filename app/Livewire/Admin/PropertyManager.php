<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $typeFilter = '';
    public string $cityFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Edit modal
    public bool $showModal = false;
    public ?int $editingId = null;

    // ── Editable fields ──
    public string $editTitleEn = '';
    public string $editTitleSq = '';
    public string $editDescriptionEn = '';
    public string $editDescriptionSq = '';
    public string $editPrice = '';
    public string $editCurrency = 'EUR';
    public string $editListingType = 'sale';
    public string $editStatus = '';
    public ?int $editPropertyTypeId = null;
    public string $editAddress = '';
    public string $editCity = '';
    public string $editState = '';
    public string $editZipCode = '';
    public ?int $editBedrooms = null;
    public ?int $editBathrooms = null;
    public string $editAreaSqm = '';
    public string $editLotSizeSqm = '';
    public ?int $editYearBuilt = null;
    public ?int $editFloors = null;
    public ?int $editGarageSpaces = null;
    public bool $editFeatured = false;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }
    public function updatingTypeFilter(): void { $this->resetPage(); }
    public function updatingCityFilter(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleFeatured(int $id): void
    {
        $property = Property::findOrFail($id);
        $property->update(['is_featured' => !$property->is_featured]);
    }

    public function updateStatus(int $id, string $status): void
    {
        Property::findOrFail($id)->update(['status' => $status]);
    }

    public function editProperty(int $id): void
    {
        $property = Property::findOrFail($id);
        $this->editingId = $id;

        // Translatable fields
        $this->editTitleEn = $property->title['en'] ?? '';
        $this->editTitleSq = $property->title['sq'] ?? '';
        $this->editDescriptionEn = $property->description['en'] ?? '';
        $this->editDescriptionSq = $property->description['sq'] ?? '';

        // Core fields
        $this->editPrice = (string) $property->price;
        $this->editCurrency = $property->currency ?? 'EUR';
        $this->editListingType = $property->listing_type ?? 'sale';
        $this->editStatus = $property->status;
        $this->editPropertyTypeId = $property->property_type_id;

        // Location
        $this->editAddress = $property->address ?? '';
        $this->editCity = $property->city ?? '';
        $this->editState = $property->state ?? '';
        $this->editZipCode = $property->zip_code ?? '';

        // Details
        $this->editBedrooms = $property->bedrooms;
        $this->editBathrooms = $property->bathrooms;
        $this->editAreaSqm = (string) ($property->area_sqm ?? '');
        $this->editLotSizeSqm = (string) ($property->lot_size_sqm ?? '');
        $this->editYearBuilt = $property->year_built;
        $this->editFloors = $property->floors;
        $this->editGarageSpaces = $property->garage_spaces;
        $this->editFeatured = $property->is_featured;

        $this->showModal = true;
    }

    public function saveProperty(): void
    {
        $this->validate([
            'editTitleEn' => 'required|min:3',
            'editPrice' => 'required|numeric|min:0',
            'editCity' => 'required',
            'editStatus' => 'required|in:active,pending,sold,inactive',
            'editListingType' => 'required|in:sale,rent',
        ]);

        $property = Property::findOrFail($this->editingId);

        $title = array_filter([
            'en' => $this->editTitleEn,
            'sq' => $this->editTitleSq,
        ]);

        $description = array_filter([
            'en' => $this->editDescriptionEn,
            'sq' => $this->editDescriptionSq,
        ]);

        $property->update([
            'title' => $title,
            'slug' => Str::slug($this->editTitleEn),
            'description' => $description,
            'price' => $this->editPrice,
            'currency' => $this->editCurrency,
            'listing_type' => $this->editListingType,
            'status' => $this->editStatus,
            'property_type_id' => $this->editPropertyTypeId,
            'address' => $this->editAddress ?: null,
            'city' => $this->editCity,
            'state' => $this->editState ?: null,
            'zip_code' => $this->editZipCode ?: null,
            'bedrooms' => $this->editBedrooms,
            'bathrooms' => $this->editBathrooms,
            'area_sqm' => $this->editAreaSqm ?: null,
            'lot_size_sqm' => $this->editLotSizeSqm ?: null,
            'year_built' => $this->editYearBuilt,
            'floors' => $this->editFloors,
            'garage_spaces' => $this->editGarageSpaces,
            'is_featured' => $this->editFeatured,
        ]);

        $this->showModal = false;
        $this->editingId = null;
    }

    public function deleteProperty(int $id): void
    {
        Property::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = Property::with('user', 'propertyType', 'images');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->typeFilter) {
            $query->where('property_type_id', $this->typeFilter);
        }
        if ($this->cityFilter) {
            $query->where('city', $this->cityFilter);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $properties = $query->paginate(15);
        $types = PropertyType::orderBy('name')->get();
        $cities = Property::distinct()->orderBy('city')->pluck('city');

        return view('livewire.admin.property-manager', compact('properties', 'types', 'cities'))
            ->layout('layouts.admin');
    }
}
