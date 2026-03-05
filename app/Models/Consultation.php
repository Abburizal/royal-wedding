<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'package_id', 'event_date',
        'message', 'status', 'admin_notes', 'responded_at', 'handled_by',
    ];

    protected $casts = [
        'event_date'   => 'date',
        'responded_at' => 'datetime',
    ];

    public function package()   { return $this->belongsTo(Package::class); }
    public function handler()   { return $this->belongsTo(User::class, 'handled_by'); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'contacted'  => 'bg-blue-50 text-blue-700',
            'converted'  => 'bg-green-50 text-green-700',
            'declined'   => 'bg-red-50 text-red-600',
            default      => 'bg-amber-50 text-amber-700',
        };
    }
}
