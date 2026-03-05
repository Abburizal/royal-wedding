<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Summary stats ──────────────────────────────────────────────
        $stats = [
            'total_weddings'     => Wedding::count(),
            'active_weddings'    => Wedding::whereIn('status', ['confirmed', 'in_progress'])->count(),
            'total_clients'      => User::where('role', 'client')->count(),
            'pending_payments'   => Payment::where('status', 'uploaded')->count(),
            'revenue_this_month' => Payment::where('status', 'verified')
                                           ->whereMonth('paid_at', now()->month)
                                           ->whereYear('paid_at', now()->year)
                                           ->sum('amount'),
            'revenue_this_year'  => Payment::where('status', 'verified')
                                           ->whereYear('paid_at', now()->year)
                                           ->sum('amount'),
        ];

        // ── Revenue last 6 months ──────────────────────────────────────
        $revenueChart = collect(range(5, 0))->map(function ($i) {
            $month = now()->startOfMonth()->subMonths($i);
            $revenue = Payment::where('status', 'verified')
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('amount');
            return [
                'label'   => $month->isoFormat('MMM YY'),
                'revenue' => (float) $revenue,
            ];
        });

        // ── Weddings per month (last 6 months) ─────────────────────────
        $weddingChart = collect(range(5, 0))->map(function ($i) {
            $month = now()->startOfMonth()->subMonths($i);
            $count = Wedding::whereYear('wedding_date', $month->year)
                ->whereMonth('wedding_date', $month->month)
                ->count();
            return ['label' => $month->isoFormat('MMM YY'), 'count' => $count];
        });

        // ── Package popularity ──────────────────────────────────────────
        $packageStats = Package::withCount('weddings')
            ->orderByDesc('weddings_count')
            ->get()
            ->map(fn($p) => ['label' => $p->name, 'count' => $p->weddings_count]);

        // ── Vendor usage ───────────────────────────────────────────────
        $vendorStats = Vendor::withCount('vendorAssignments')
            ->orderByDesc('vendor_assignments_count')
            ->limit(5)->get()
            ->map(fn($v) => ['label' => $v->name, 'count' => $v->vendor_assignments_count]);

        // ── Recent data ────────────────────────────────────────────────
        $recentWeddings      = Wedding::with(['client', 'package'])->latest()->limit(5)->get();
        $pendingPayments     = Payment::with(['wedding.client'])->where('status', 'uploaded')->latest()->limit(5)->get();
        $recentActivity      = ActivityLog::with('user')->latest()->limit(10)->get();
        $pendingConsultations = \App\Models\Consultation::where('status', 'pending')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'revenueChart', 'weddingChart',
            'packageStats', 'vendorStats',
            'recentWeddings', 'pendingPayments', 'recentActivity', 'pendingConsultations'
        ));
    }
}
