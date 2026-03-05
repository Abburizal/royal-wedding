<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'title', 'couple_names', 'wedding_date', 'location',
        'cover_image', 'gallery_images', 'description',
        'is_featured', 'sort_order',
    ];

    protected $casts = [
        'wedding_date'   => 'date',
        'gallery_images' => 'array',
        'is_featured'    => 'boolean',
    ];

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image && str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&q=80';
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery_images ?? [])->map(function ($img) {
            return str_starts_with($img, 'http') ? $img : asset('storage/' . $img);
        })->toArray();
    }
}
