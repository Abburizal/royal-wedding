<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $year  = request('year',  now()->year);
        $month = request('month', now()->month);

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $weddings = Wedding::with(['client', 'planner', 'package'])
            ->whereBetween('wedding_date', [$start, $end])
            ->orderBy('wedding_date')
            ->get()
            ->groupBy(fn($w) => $w->wedding_date->format('Y-m-d'));

        // Also get milestones in current month
        $milestones = \App\Models\WeddingMilestone::with('wedding.client')
            ->whereBetween('milestone_date', [$start, $end])
            ->orderBy('milestone_date')
            ->get()
            ->groupBy(fn($m) => $m->milestone_date->format('Y-m-d'));

        $prevMonth = $start->copy()->subMonth();
        $nextMonth = $start->copy()->addMonth();

        // Build calendar grid
        $calendarStart = $start->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd   = $end->copy()->endOfWeek(Carbon::SUNDAY);
        $weeks = [];
        $day = $calendarStart->copy();
        while ($day <= $calendarEnd) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = $day->copy();
                $day->addDay();
            }
            $weeks[] = $week;
        }

        return view('admin.calendar', compact(
            'year', 'month', 'start', 'weddings', 'milestones',
            'prevMonth', 'nextMonth', 'weeks'
        ));
    }
}
