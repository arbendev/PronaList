<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\Message;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboard extends Component
{
    public string $activeTab = 'listings';

    public function mount()
    {
        if (Auth::user()->role === 'agent') {
            $this->activeTab = 'new-leads';
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function deleteListing(int $id): void
    {
        Property::where('id', $id)->where('user_id', Auth::id())->delete();
    }

    public function removeFavorite(int $propertyId): void
    {
        Favorite::where('user_id', Auth::id())->where('property_id', $propertyId)->delete();
    }

    public function markAsRead(int $messageId): void
    {
        Message::where('id', $messageId)->where('receiver_id', Auth::id())->update(['is_read' => true]);
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.user-dashboard', [
            'listings' => $user->properties()->with('images')->latest()->get(),
            'favorites' => $user->favoriteProperties()->with('images')->get(),
            'messages' => $user->receivedMessages()->with(['sender', 'property'])->latest()->get(),
        ]);
    }
}
