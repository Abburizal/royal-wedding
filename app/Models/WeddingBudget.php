<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingBudget extends Model
{
    protected $fillable = [
        'wedding_id', 'category', 'item_name',
        'estimated_amount', 'actual_amount', 'paid_amount',
        'vendor_name', 'notes', 'sort_order',
    ];

    protected $casts = [
        'estimated_amount' => 'decimal:2',
        'actual_amount'    => 'decimal:2',
        'paid_amount'      => 'decimal:2',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function getRemainingAttribute(): float
    {
        return max(0, $this->actual_amount - $this->paid_amount);
    }

    public function getVarianceAttribute(): float
    {
        return $this->actual_amount - $this->estimated_amount;
    }
}
