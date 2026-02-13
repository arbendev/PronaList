<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Livewire\Component;

class ContactPage extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public bool $sent = false;

    public function send(): void
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'nullable|min:6',
            'message' => 'required|min:10',
        ]);

        $lead = Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'message' => $this->message,
            'source' => 'contact_page',
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
        return view('livewire.contact-page');
    }
}
