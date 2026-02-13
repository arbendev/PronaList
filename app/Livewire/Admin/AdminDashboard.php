<?php

namespace App\Livewire\Admin;

use App\Models\Lead;
use App\Models\Property;
use App\Models\User;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_properties' => Property::count(),
            'active_properties' => Property::where('status', 'active')->count(),
            'pending_properties' => Property::where('status', 'pending')->count(),
            'featured_properties' => Property::where('is_featured', true)->count(),
            'total_users' => User::count(),
            'agents' => User::where('role', 'agent')->count(),
            'total_credits' => User::where('role', 'agent')->sum('credits'),
            'total_leads' => Lead::count(),
            'lead_purchases' => \App\Models\LeadPurchase::count(),
            'new_leads' => Lead::where('status', 'new')->count(),
            'total_views' => Property::sum('views'),
        ];

        $recentLeads = Lead::latest()->limit(5)->get();
        $recentProperties = Property::with('user', 'propertyType')->latest()->limit(5)->get();

        return view('livewire.admin.admin-dashboard', compact('stats', 'recentLeads', 'recentProperties'))
            ->layout('layouts.admin');
    }
}
