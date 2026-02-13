<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadPurchase extends Pivot
{
    public $timestamps = false; // We use purchased_at manually if needed, but standard timestamps are fine too. Migration has timestamps() + purchased_at
    
    protected $table = 'lead_purchases';

    // Actually migration has timestamps() AND purchased_at. Let's use both.
    
    protected $fillable = [
        'lead_id',
        'user_id',
        'credits_spent',
        'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
