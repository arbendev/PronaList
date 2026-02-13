<?php

namespace App\Livewire\Agent;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LeadMarketplace extends Component
{
    use WithPagination;

    public function purchaseLead(int $id)
    {
        $user = Auth::user();
        $lead = Lead::findOrFail($id);

        // Double-check availability
        if ($lead->isPurchasedBy($user)) {
            $this->js("alert('You have already purchased this lead.')");
            return;
        }

        if ($lead->purchasers_count >= $lead->max_buyers) {
             $this->js("alert('This lead is no longer available.')");
             return;
        }

        try {
            // Charge credits (throws exception if insufficient)
            $user->chargeCredits($lead->credit_cost, "Purchased Lead #{$lead->id}", $lead->id);

            // Create purchase record
            $lead->purchases()->create([
                'user_id' => $user->id,
                'credits_spent' => $lead->credit_cost,
                'purchased_at' => now(),
            ]);

            // Assign status if it's the first purchase? 
            // Actually, we might want to keep it 'new' or 'assigned' but since multiple people can buy it, 'assigned' might be ambiguous.
            // Let's just relying on the purchase record. 
            // UPDATE: if status is 'new', maybe flip to 'assigned' or 'contacted'? 
            // For now, let's leave status alone or set to 'assigned' if it's the first buyer.
            if ($lead->status === 'new') {
                $lead->update(['status' => 'assigned']);
            }

            $this->dispatch('credits-updated'); // Update UI if needed
            $this->js("alert('Lead purchased successfully! View details in My Leads.')");
            
        } catch (\Exception $e) {
            $this->js("alert('Error: " . $e->getMessage() . "')");
        }
    }

    public function render()
    {
        $user = Auth::user();
        
        // Use the scope we created
        $leads = Lead::availableFor($user)
            ->with(['property', 'property.propertyType'])
            ->latest()
            ->paginate(12);

        return view('livewire.agent.lead-marketplace', compact('leads', 'user'))
            ->extends('layouts.app')
            ->section('content');
    }
}
