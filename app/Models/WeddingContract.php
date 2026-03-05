<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingContract extends Model
{
    protected $fillable = [
        'wedding_id', 'status', 'contract_body',
        'signed_name', 'signed_ip', 'signed_at', 'created_by',
    ];

    protected $casts = ['signed_at' => 'datetime'];

    public function wedding()   { return $this->belongsTo(Wedding::class); }
    public function creator()   { return $this->belongsTo(User::class, 'created_by'); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'sent'   => 'bg-blue-50 text-blue-700',
            'signed' => 'bg-green-50 text-green-700',
            default  => 'bg-gray-100 text-gray-600',
        };
    }
}
