<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'avatar', 'bio', 'role', 'agency_name', 'license_number', 'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    // ── Accessors ──────────────────────────────────────────
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=006AFF&color=fff&size=200';
    }

    public function getIsAgentAttribute(): bool
    {
        return $this->role === 'agent';
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    // ── Relationships ──────────────────────────────────────
    // ── Credits & Leads ────────────────────────────────────
    public function creditTransactions(): HasMany
    {
        return $this->hasMany(CreditTransaction::class)->latest();
    }

    public function purchasedLeads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'lead_purchases')
            ->using(LeadPurchase::class)
            ->withPivot('credits_spent', 'purchased_at')
            ->withTimestamps();
    }

    public function hasCredit(int $amount): bool
    {
        return $this->credits >= $amount;
    }

    public function addCredits(int $amount, string $description = 'Admin adjustment'): void
    {
        $this->increment('credits', $amount);
        
        $this->creditTransactions()->create([
            'amount' => $amount,
            'type' => 'adjustment',
            'description' => $description,
        ]);
    }

    public function chargeCredits(int $amount, string $description, ?int $leadId = null): void
    {
        if (!$this->hasCredit($amount)) {
            throw new \Exception("Insufficient credits.");
        }

        $this->decrement('credits', $amount);

        $this->creditTransactions()->create([
            'amount' => -$amount,
            'type' => $leadId ? 'lead_buy' : 'purchase',
            'description' => $description,
            'lead_id' => $leadId,
        ]);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteProperties()
    {
        return $this->belongsToMany(Property::class, 'favorites');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'agent_id');
    }

    public function savedSearches(): HasMany
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
