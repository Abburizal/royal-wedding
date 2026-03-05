<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'subject_type', 'subject_id',
        'action', 'description', 'meta', 'ip_address',
    ];

    protected $casts = ['meta' => 'array'];

    public function user()    { return $this->belongsTo(User::class); }
    public function subject() { return $this->morphTo(); }

    /**
     * Record an activity easily.
     */
    public static function record(
        string $action,
        string $description,
        ?Model $subject = null,
        array $meta = []
    ): static {
        return static::create([
            'user_id'      => Auth::id(),
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->getKey(),
            'action'       => $action,
            'description'  => $description,
            'meta'         => $meta ?: null,
            'ip_address'   => request()->ip(),
        ]);
    }

    public function getSubjectLabelAttribute(): string
    {
        return match(true) {
            $this->subject_type && str_ends_with($this->subject_type, 'Wedding') => 'Wedding',
            $this->subject_type && str_ends_with($this->subject_type, 'Payment') => 'Pembayaran',
            $this->subject_type && str_ends_with($this->subject_type, 'User')    => 'Pengguna',
            default => 'Sistem',
        };
    }

    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created'  => 'text-green-600 bg-green-50',
            'updated'  => 'text-blue-600 bg-blue-50',
            'deleted'  => 'text-red-600 bg-red-50',
            'verified' => 'text-emerald-600 bg-emerald-50',
            'rejected' => 'text-red-600 bg-red-50',
            'login'    => 'text-purple-600 bg-purple-50',
            default    => 'text-gray-600 bg-gray-100',
        };
    }
}
