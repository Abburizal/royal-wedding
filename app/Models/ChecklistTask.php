<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id', 'task_name', 'description',
        'category', 'status', 'due_date', 'notes', 'sort_order',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function wedding() { return $this->belongsTo(Wedding::class); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'text-gray-500',
            'in_progress' => 'text-amber-600',
            'done'        => 'text-green-600',
            default       => 'text-gray-500',
        };
    }
}
