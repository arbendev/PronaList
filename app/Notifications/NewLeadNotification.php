<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
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

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Lead: ' . ($this->lead->property?->translated_title ?? 'General Inquiry'))
            ->view('emails.new-lead', [
                'lead' => $this->lead,
                'notifiable' => $notifiable
            ]);
    }
}
