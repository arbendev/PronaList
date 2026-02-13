<?php

namespace App\Livewire;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteButton extends Component
{
    public int $propertyId;
    public bool $isFavorited = false;

    public function mount(int $propertyId): void
    {
        $this->propertyId = $propertyId;

        if (Auth::check()) {
            $this->isFavorited = Favorite::where('user_id', Auth::id())
                ->where('property_id', $this->propertyId)
                ->exists();
        }
    }

    public function toggleFavorite(): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'), navigate: false);
            return;
        }

        if ($this->isFavorited) {
            Favorite::where('user_id', Auth::id())
                ->where('property_id', $this->propertyId)
                ->delete();
            $this->isFavorited = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'property_id' => $this->propertyId,
            ]);
            $this->isFavorited = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
