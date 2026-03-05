<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingMessage extends Model
{
    protected $fillable = ['wedding_id', 'sender_id', 'message', 'is_internal', 'read_at'];

    protected $casts = ['read_at' => 'datetime', 'is_internal' => 'boolean'];

    public function wedding() { return $this->belongsTo(Wedding::class); }
    public function sender()  { return $this->belongsTo(User::class, 'sender_id'); }

    public function isUnreadFor(User $user): bool
    {
        return is_null($this->read_at) && $this->sender_id !== $user->id;
    }
}
