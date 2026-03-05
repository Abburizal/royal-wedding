<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name', 'couple_names', 'wedding_date',
        'content', 'rating', 'photo', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'is_published' => 'boolean',
        'rating'       => 'integer',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && str_starts_with($this->photo, 'http')) {
            return $this->photo;
        }
        return $this->photo
            ? asset('storage/' . $this->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->client_name) . '&background=B8860B&color=fff&size=80';
    }

    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
