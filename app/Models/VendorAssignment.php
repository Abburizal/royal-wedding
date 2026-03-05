<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id', 'vendor_id', 'category',
        'agreed_price', 'status', 'notes',
    ];

    protected $casts = [
        'agreed_price' => 'decimal:2',
    ];

    public function wedding() { return $this->belongsTo(Wedding::class); }
    public function vendor()  { return $this->belongsTo(Vendor::class); }
}
