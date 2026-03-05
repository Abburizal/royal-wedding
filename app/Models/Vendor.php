<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'phone', 'email',
        'address', 'portfolio_url', 'description',
        'base_price', 'is_active', 'logo',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function vendorAssignments() { return $this->hasMany(VendorAssignment::class); }
    public function weddings()          { return $this->belongsToMany(Wedding::class, 'vendor_assignments')->withPivot('category','agreed_price','status','notes'); }
    public function reviews()           { return $this->hasMany(VendorReview::class)->where('is_published', true); }
    public function allReviews()        { return $this->hasMany(VendorReview::class); }

    public function getAvgRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'catering'      => '🍽️ Catering',
            'decoration'    => '🌸 Dekorasi',
            'mua'           => '💄 MUA',
            'documentation' => '📷 Dokumentasi',
            'entertainment' => '🎵 Entertainment',
            'venue'         => '🏛️ Venue',
            default         => '📦 Lainnya',
        };
    }
}
