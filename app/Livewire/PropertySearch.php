<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\PropertyType;
use Livewire\Component;
use Livewire\WithPagination;

class PropertySearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filters
    public string $listingType = '';
    public string $propertyTypeId = '';
    public string $city = '';
    public string $priceMin = '';
    public string $priceMax = '';
    public string $bedrooms = '';
    public string $bathrooms = '';
    public string $areaMin = '';
    public string $areaMax = '';
    public string $sortBy = 'newest';
    public string $viewMode = 'grid';

    protected $queryString = [
        'listingType' => ['as' => 'listing_type', 'except' => ''],
        'city' => ['except' => ''],
        'propertyTypeId' => ['as' => 'type', 'except' => ''],
        'priceMin' => ['as' => 'price_min', 'except' => ''],
        'priceMax' => ['as' => 'price_max', 'except' => ''],
        'bedrooms' => ['except' => ''],
        'bathrooms' => ['except' => ''],
        'sortBy' => ['as' => 'sort', 'except' => 'newest'],
    ];

    public function updatedListingType(): void { $this->resetPage(); }
    public function updatedPropertyTypeId(): void { $this->resetPage(); }
    public function updatedCity(): void { $this->resetPage(); }
    public function updatedPriceMin(): void { $this->resetPage(); }
    public function updatedPriceMax(): void { $this->resetPage(); }
    public function updatedBedrooms(): void { $this->resetPage(); }
    public function updatedBathrooms(): void { $this->resetPage(); }

    public function clearFilters(): void
    {
        $this->reset(['listingType', 'propertyTypeId', 'city', 'priceMin', 'priceMax', 'bedrooms', 'bathrooms', 'areaMin', 'areaMax', 'sortBy']);
        $this->resetPage();
    }

    public function setView(string $mode): void
    {
        $this->viewMode = $mode;
    }

    public function render()
    {
        $query = Property::active()->with(['images', 'propertyType', 'user']);

        if ($this->listingType) {
            $query->where('listing_type', $this->listingType);
        }
        if ($this->propertyTypeId) {
            $query->where('property_type_id', $this->propertyTypeId);
        }
        if ($this->city) {
            $query->where('city', 'LIKE', '%' . $this->city . '%');
        }
        if ($this->priceMin) {
            $query->where('price', '>=', (float) $this->priceMin);
        }
        if ($this->priceMax) {
            $query->where('price', '<=', (float) $this->priceMax);
        }
        if ($this->bedrooms) {
            $query->where('bedrooms', '>=', (int) $this->bedrooms);
        }
        if ($this->bathrooms) {
            $query->where('bathrooms', '>=', (int) $this->bathrooms);
        }
        if ($this->areaMin) {
            $query->where('area_sqm', '>=', (float) $this->areaMin);
        }
        if ($this->areaMax) {
            $query->where('area_sqm', '<=', (float) $this->areaMax);
        }

        $query = match ($this->sortBy) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'area' => $query->orderBy('area_sqm', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return view('livewire.property-search', [
            'properties' => $query->paginate(12),
            'propertyTypes' => PropertyType::all(),
            'cities' => Property::active()->select('city')->distinct()->pluck('city'),
            'totalCount' => $query->count(),
        ]);
    }
}
