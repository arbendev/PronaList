<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;

class PageController extends Controller
{
    public function home()
    {
        $featured = Property::active()
            ->featured()
            ->with('images', 'propertyType')
            ->limit(6)
            ->get();

        $recent = Property::active()
            ->with('images', 'propertyType')
            ->latest()
            ->limit(8)
            ->get();

        $types = PropertyType::withCount('properties')->get();

        $stats = [
            'properties' => Property::active()->count(),
            'agents' => User::where('role', 'agent')->count(),
            'cities' => Property::active()->distinct('city')->count('city'),
        ];

        return view('welcome', compact('featured', 'recent', 'types', 'stats'));
    }

    public function search()
    {
        return view('pages.search');
    }

    public function show(string $slug)
    {
        $property = Property::where('slug', $slug)
            ->with(['images', 'propertyType', 'user', 'reviews.user'])
            ->firstOrFail();

        return view('pages.property-detail', compact('property'));
    }

    public function listProperty()
    {
        return view('pages.list-property');
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function mortgage()
    {
        return view('pages.mortgage');
    }

    public function about()
    {
        $stats = [
            'properties' => Property::active()->count(),
            'agents' => User::where('role', 'agent')->count(),
            'cities' => Property::active()->distinct('city')->count('city'),
        ];

        return view('pages.about', compact('stats'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function agentProfile(int $id)
    {
        $agent = User::findOrFail($id);
        $properties = $agent->properties()->active()->with('images')->get();

        return view('pages.agent-profile', compact('agent', 'properties'));
    }

    public function adminLeads()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        return view('pages.admin-leads');
    }

    public function switchLocale(string $locale)
    {
        if (in_array($locale, ['en', 'sq'])) {
            session(['locale' => $locale]);
        }

        return back();
    }
}
