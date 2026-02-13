<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Lead extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'email',
        'phone',
        'message',
        'source',
        'status',
        'assigned_to',
        'assigned_at',
        'notes',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
        ];
    }

    // ── Relationships ──────────────────

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // ── Scopes ──────────────────

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }

    public function scopeUnassigned(Builder $query): Builder
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeBySource(Builder $query, string $source): Builder
    {
        return $query->where('source', $source);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    // ── Helpers ──────────────────

    public function markAs(string $status): self
    {
        $this->update(['status' => $status]);
        return $this;
    }

    public function assignTo(int $userId): self
    {
        $this->update([
            'assigned_to' => $userId,
            'assigned_at' => now(),
            'status' => 'assigned',
        ]);
        return $this;
    }

    // ── Accessors ──────────────────

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'new' => 'bg-primary',
            'contacted' => 'bg-info',
            'qualified' => 'bg-warning text-dark',
            'assigned' => 'bg-success',
            'closed' => 'bg-secondary',
            default => 'bg-light text-dark',
        };
    }

    public function getSourceLabelAttribute(): string
    {
        return match ($this->source) {
            'property_inquiry' => 'Property Inquiry',
            'contact_page' => 'Contact Page',
            'general' => 'General',
            default => ucfirst($this->source),
        };
    }
    // ── Marketplace ──────────────────

    public function purchases(): HasMany
    {
        return $this->hasMany(LeadPurchase::class);
    }

    public function getPurchasersCountAttribute(): int
    {
        return $this->purchases()->count();
    }

    public function isPurchasedBy(User $user): bool
    {
        return $this->purchases()->where('user_id', $user->id)->exists();
    }

    public function scopeAvailableFor(Builder $query, User $user): Builder
    {
        return $query->where('status', 'new')
            ->whereDoesntHave('purchases', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->withCount('purchases')
            ->havingRaw('purchases_count < max_buyers');
    }
}
