<?php

namespace App\Livewire\Agent;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyLeads extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();

        // Get leads purchased by this user
        // We can use the relationship we added: purchasedLeads
        // But we want to pivot data too (credits_spent).
        
        $leads = $user->purchasedLeads()
            ->with(['property'])
            ->orderByPivot('purchased_at', 'desc')
            ->paginate(10);

        return view('livewire.agent.my-leads', compact('leads'))
            ->extends('layouts.app')
            ->section('content');
    }
}
