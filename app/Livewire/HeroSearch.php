<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\PropertyType;
use Livewire\Component;

class HeroSearch extends Component
{
    public string $city = '';
    public string $listingType = 'sale';
    public string $propertyTypeId = '';

    public function search(): void
    {
        $params = ['listing_type' => $this->listingType];

        if ($this->city) {
            $params['city'] = $this->city;
        }

        if ($this->propertyTypeId) {
            $params['property_type_id'] = $this->propertyTypeId;
        }

        $this->redirect(route('properties.search', $params), navigate: false);
    }

    public function render()
    {
        $cities = Property::active()
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->toArray();

        $propertyTypes = PropertyType::orderBy('name')->get();

        return view('livewire.hero-search', [
            'cities' => $cities,
            'propertyTypes' => $propertyTypes,
        ]);
    }
}
