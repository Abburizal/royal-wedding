<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Wedding extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'planner_id', 'package_id',
        'groom_name', 'bride_name', 'wedding_date', 'wedding_time',
        'venue_name', 'venue_address', 'venue_city',
        'estimated_guests', 'status', 'total_price', 'special_notes',
    ];

    protected $casts = [
        'wedding_date'     => 'date',
        'total_price'      => 'decimal:2',
        'estimated_guests' => 'integer',
    ];

    public function client()            { return $this->belongsTo(User::class, 'client_id'); }
    public function planner()           { return $this->belongsTo(User::class, 'planner_id'); }
    public function package()           { return $this->belongsTo(Package::class); }
    public function payments()          { return $this->hasMany(Payment::class); }
    public function checklistTasks()    { return $this->hasMany(ChecklistTask::class); }
    public function vendorAssignments() { return $this->hasMany(VendorAssignment::class); }
    public function vendors()           { return $this->belongsToMany(Vendor::class, 'vendor_assignments')->withPivot('category','agreed_price','status','notes'); }
    public function milestones()        { return $this->hasMany(WeddingMilestone::class)->orderBy('sort_order'); }
    public function moodboards()        { return $this->hasMany(WeddingMoodboard::class)->latest(); }
    public function notes()             { return $this->hasMany(WeddingNote::class)->latest(); }
    public function messages()          { return $this->hasMany(WeddingMessage::class)->latest(); }
    public function contracts()         { return $this->hasMany(WeddingContract::class)->latest(); }
    public function guests()            { return $this->hasMany(Guest::class); }
    public function budgetItems()       { return $this->hasMany(WeddingBudget::class); }

    public function getDaysUntilWeddingAttribute(): int
    {
        return max(0, now()->diffInDays($this->wedding_date, false));
    }

    public function getChecklistProgressAttribute(): int
    {
        $total = $this->checklistTasks()->count();
        if ($total === 0) return 0;
        $done = $this->checklistTasks()->where('status', 'done')->count();
        return (int) round(($done / $total) * 100);
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->where('status', 'verified')->sum('amount');
    }

    public function getRemainingPaymentAttribute(): float
    {
        return max(0, (float) $this->total_price - $this->total_paid);
    }

    public function getCoupleNameAttribute(): string
    {
        return "{$this->groom_name} & {$this->bride_name}";
    }
}
