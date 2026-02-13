<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class PropertyDetail extends Component
{
    public Property $property;
    public int $activeImage = 0;

    public function mount(Property $property): void
    {
        $this->property = $property->load(['images', 'propertyType', 'user', 'reviews.user']);
        $property->increment('views');
    }

    public function setImage(int $index): void
    {
        $this->activeImage = $index;
    }

    public function render()
    {
        $similar = Property::active()
            ->where('id', '!=', $this->property->id)
            ->where('property_type_id', $this->property->property_type_id)
            ->where('city', $this->property->city)
            ->limit(3)
            ->with('images')
            ->get();

        return view('livewire.property-detail', [
            'similar' => $similar,
        ]);
    }
}
