<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'wedding_id', 'name', 'phone', 'email', 'category', 'side',
        'pax', 'table_no', 'rsvp_status', 'invitation_token',
        'rsvp_responded_at', 'notes',
    ];

    protected $casts = [
        'rsvp_responded_at' => 'datetime',
        'pax' => 'integer',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /** Generate unique RSVP token */
    public static function generateToken(): string
    {
        do {
            $token = Str::random(32);
        } while (static::where('invitation_token', $token)->exists());
        return $token;
    }

    public function getRsvpLabelAttribute(): string
    {
        return match ($this->rsvp_status) {
            'confirmed' => 'Hadir',
            'declined'  => 'Tidak Hadir',
            'attended'  => 'Sudah Hadir',
            default     => 'Menunggu',
        };
    }

    public function getRsvpColorAttribute(): string
    {
        return match ($this->rsvp_status) {
            'confirmed' => 'green',
            'declined'  => 'red',
            'attended'  => 'blue',
            default     => 'yellow',
        };
    }
}
