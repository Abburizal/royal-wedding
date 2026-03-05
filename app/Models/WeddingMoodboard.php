<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WeddingMoodboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id', 'title', 'image_path', 'category', 'notes',
    ];

    const CATEGORIES = [
        'color_palette' => '🎨 Palet Warna',
        'decoration'    => '🌸 Dekorasi',
        'dress'         => '👗 Baju Pengantin',
        'venue'         => '🏛️ Venue',
        'flowers'       => '💐 Bunga',
        'photography'   => '📷 Gaya Foto',
        'general'       => '📌 Umum',
    ];

    public function wedding() { return $this->belongsTo(Wedding::class); }

    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->image_path);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? '📌 Umum';
    }
}
