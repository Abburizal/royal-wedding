<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    protected $fillable = [
        'vendor_id', 'user_id', 'wedding_id', 'rating', 'title', 'review', 'is_published',
    ];

    protected $casts = ['is_published' => 'boolean', 'rating' => 'integer'];

    public function vendor()  { return $this->belongsTo(Vendor::class); }
    public function user()    { return $this->belongsTo(User::class); }
    public function wedding() { return $this->belongsTo(Wedding::class); }

    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
