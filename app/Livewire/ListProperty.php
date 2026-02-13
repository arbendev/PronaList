<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListProperty extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // Step 1: Basic Info
    public string $titleEn = '';
    public string $titleSq = '';
    public string $descriptionEn = '';
    public string $descriptionSq = '';
    public string $listingType = 'sale';
    public string $propertyTypeId = '';
    public string $price = '';

    // Step 2: Details
    public string $address = '';
    public string $city = '';
    public string $bedrooms = '1';
    public string $bathrooms = '1';
    public string $areaSqm = '';
    public string $yearBuilt = '';
    public string $floors = '1';
    public array $selectedFeatures = [];

    // Step 3: Images
    public array $photos = [];
    public $newPhotos = [];

    public bool $success = false;

    public array $availableFeatures = [
        'Parking', 'Garden', 'Pool', 'Balcony', 'Elevator', 'Air Conditioning',
        'Central Heating', 'Furnished', 'Security System', 'Storage Room',
        'Gym', 'Fireplace', 'Sea View', 'Mountain View', 'Terrace',
    ];

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'titleEn' => 'required|min:5',
                'descriptionEn' => 'required|min:20',
                'propertyTypeId' => 'required',
                'price' => 'required|numeric|min:1',
            ]);
        }
        if ($this->step === 2) {
            $this->validate([
                'address' => 'required|min:5',
                'city' => 'required|min:2',
            ]);
        }
        if ($this->step === 3) {
            $this->validate([
                'photos' => 'required|min:1',
                'photos.*' => 'image|max:10240',
            ]);
        }
        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step--;
    }

    public function toggleFeature(string $feature): void
    {
        if (in_array($feature, $this->selectedFeatures)) {
            $this->selectedFeatures = array_values(array_diff($this->selectedFeatures, [$feature]));
        } else {
            $this->selectedFeatures[] = $feature;
        }
    }

    public function removePhoto(int $index): void
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos);
    }

    public function updatedNewPhotos(): void
    {
        $this->validate([
            'newPhotos.*' => 'image|max:10240',
        ]);

        foreach ($this->newPhotos as $photo) {
            $this->photos[] = $photo;
        }
        $this->newPhotos = [];
    }

    public function submit(): void
    {
        $slug = Str::slug($this->titleEn) . '-' . Str::random(6);

        $property = Property::create([
            'user_id' => Auth::id(),
            'property_type_id' => $this->propertyTypeId,
            'title' => ['en' => $this->titleEn, 'sq' => $this->titleSq ?: $this->titleEn],
            'slug' => $slug,
            'description' => ['en' => $this->descriptionEn, 'sq' => $this->descriptionSq ?: $this->descriptionEn],
            'price' => (float) $this->price,
            'listing_type' => $this->listingType,
            'address' => $this->address,
            'city' => $this->city,
            'bedrooms' => (int) $this->bedrooms,
            'bathrooms' => (int) $this->bathrooms,
            'area_sqm' => $this->areaSqm ? (float) $this->areaSqm : null,
            'year_built' => $this->yearBuilt ? (int) $this->yearBuilt : null,
            'floors' => (int) $this->floors,
            'features' => $this->selectedFeatures,
            'status' => 'active',
        ]);

        // Handle images
        foreach ($this->photos as $index => $photo) {
            $path = $photo->store('properties', 'public');
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index,
            ]);
        }

        $this->success = true;
    }

    public function render()
    {
        return view('livewire.list-property', [
            'propertyTypes' => PropertyType::all(),
        ]);
    }
}
