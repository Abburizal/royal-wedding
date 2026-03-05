<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingNote extends Model
{
    protected $fillable = ['wedding_id', 'user_id', 'content', 'is_private'];

    protected $casts = ['is_private' => 'boolean'];

    public function wedding() { return $this->belongsTo(Wedding::class); }
    public function author()  { return $this->belongsTo(User::class, 'user_id'); }
}
