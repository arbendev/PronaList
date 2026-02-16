<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'lead_id' => $this->lead->id,
            'name' => $this->lead->name,
            'email' => $this->lead->email,
            'source' => $this->lead->source,
            'property_id' => $this->lead->property_id,
            'property_title' => $this->lead->property?->translated_title,
            'message' => 'New lead for ' . ($this->lead->property?->translated_title ?? 'Property') . ' from ' . $this->lead->name,
            'link' => route('agent.leads'),
        ];
    }
}
