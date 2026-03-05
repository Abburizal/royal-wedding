<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'tier', 'price', 'description',
        'highlight_image', 'guest_capacity', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_active'    => 'boolean',
        'guest_capacity' => 'integer',
    ];

    public function items()    { return $this->hasMany(PackageItem::class); }
    public function weddings() { return $this->hasMany(Wedding::class); }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getTierBadgeColorAttribute(): string
    {
        return match($this->tier) {
            'silver' => 'text-slate-500 bg-slate-100',
            'gold'   => 'text-amber-700 bg-amber-100',
            'royal'  => 'text-purple-700 bg-purple-100',
            default  => 'text-gray-500 bg-gray-100',
        };
    }
}
