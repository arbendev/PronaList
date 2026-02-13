<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Properties
Route::get('/properties', [PageController::class, 'search'])->name('properties.search');
Route::get('/properties/{slug}', [PageController::class, 'show'])->name('properties.show');

// Static Pages
// Route::get('/mortgage', [PageController::class, 'mortgage'])->name('mortgage');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Agent Profile
Route::get('/agents/{id}', [PageController::class, 'agentProfile'])->name('agents.show');

// Locale Switcher
Route::get('/locale/{locale}', [PageController::class, 'switchLocale'])->name('locale.switch');

// Auth Routes
Auth::routes();

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/list-property', [PageController::class, 'listProperty'])->name('list-property');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', \App\Livewire\Admin\AdminDashboard::class)->name('admin.dashboard');
    Route::get('/properties', \App\Livewire\Admin\PropertyManager::class)->name('admin.properties');
    Route::get('/users', \App\Livewire\Admin\UserManager::class)->name('admin.users');
    Route::get('/leads', \App\Livewire\Admin\LeadManager::class)->name('admin.leads');
});

// Agent Routes
Route::middleware(['auth', 'agent'])->prefix('agent')->group(function () {
    Route::get('/leads', \App\Livewire\Agent\LeadMarketplace::class)->name('agent.leads');
    Route::get('/my-leads', \App\Livewire\Agent\MyLeads::class)->name('agent.my-leads');
});
