<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id', 'invoice_number', 'amount', 'type',
        'status', 'payment_method', 'proof_image',
        'due_date', 'paid_at', 'notes',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'due_date' => 'date',
        'paid_at'  => 'date',
    ];

    public function wedding() { return $this->belongsTo(Wedding::class); }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'text-gray-600 bg-gray-100',
            'uploaded' => 'text-blue-600 bg-blue-100',
            'verified' => 'text-green-700 bg-green-100',
            'rejected' => 'text-red-600 bg-red-100',
            default    => 'text-gray-600 bg-gray-100',
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
