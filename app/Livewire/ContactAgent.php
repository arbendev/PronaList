<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactAgent extends Component
{
    public int $propertyId;
    public int $agentId;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public bool $sent = false;

    public function mount(int $propertyId, int $agentId): void
    {
        $this->propertyId = $propertyId;
        $this->agentId = $agentId;

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->phone = Auth::user()->phone ?? '';
        }

        $this->message = __('general.contact_default_msg');
    }

    public function send(): void
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        $lead = Lead::create([
            'property_id' => $this->propertyId,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'message' => $this->message,
            'source' => 'property_inquiry',
            'status' => 'new',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Notify admin(s)
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewLeadNotification($lead));
        }

        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.contact-agent');
    }
}
