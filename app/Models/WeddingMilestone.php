<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id', 'title', 'milestone_type',
        'milestone_date', 'status', 'notes', 'sort_order',
    ];

    protected $casts = [
        'milestone_date' => 'date',
    ];

    public function wedding() { return $this->belongsTo(Wedding::class); }

    public function getIconAttribute(): string
    {
        return match($this->milestone_type) {
            'dp_payment'        => '💳',
            'fitting'           => '👗',
            'technical_meeting' => '📋',
            'final_briefing'    => '🤝',
            'rehearsal'         => '🎭',
            'wedding_day'       => '💍',
            default             => '📌',
        };
    }

    public function getLabelAttribute(): string
    {
        return match($this->milestone_type) {
            'dp_payment'        => 'Pembayaran DP',
            'fitting'           => 'Fitting Baju Pengantin',
            'technical_meeting' => 'Technical Meeting',
            'final_briefing'    => 'Final Briefing Vendor',
            'rehearsal'         => 'Gladi Resik',
            'wedding_day'       => 'Hari Pernikahan 💍',
            default             => $this->title,
        ];
    }
}
