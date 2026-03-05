<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    private function wedding()
    {
        return Auth::user()->weddings()->latest()->firstOrFail();
    }

    public function index()
    {
        $wedding = $this->wedding();
        $items   = $wedding->budgetItems()->orderBy('category')->orderBy('sort_order')->get();

        $summary = [
            'total_estimated' => $items->sum('estimated_amount'),
            'total_actual'    => $items->sum('actual_amount'),
            'total_paid'      => $items->sum('paid_amount'),
            'total_remaining' => $items->sum(fn($i) => max(0, $i->actual_amount - $i->paid_amount)),
            'variance'        => $items->sum(fn($i) => $i->actual_amount - $i->estimated_amount),
            'by_category'     => $items->groupBy('category')->map(fn($g) => [
                'estimated' => $g->sum('estimated_amount'),
                'actual'    => $g->sum('actual_amount'),
                'paid'      => $g->sum('paid_amount'),
            ]),
        ];

        $categories = ['Venue', 'Catering', 'Dekorasi', 'Pakaian', 'Foto & Video',
                       'Hiburan', 'Undangan', 'Transportasi', 'Akomodasi', 'Lainnya'];

        return view('client.budget', compact('wedding', 'items', 'summary', 'categories'));
    }

    public function store(Request $request)
    {
        $wedding = $this->wedding();

        $validated = $request->validate([
            'category'         => 'required|string|max:50',
            'item_name'        => 'required|string|max:150',
            'estimated_amount' => 'required|numeric|min:0',
            'actual_amount'    => 'nullable|numeric|min:0',
            'paid_amount'      => 'nullable|numeric|min:0',
            'vendor_name'      => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:500',
        ]);

        $validated['wedding_id']     = $wedding->id;
        $validated['actual_amount']  = $validated['actual_amount']  ?? 0;
        $validated['paid_amount']    = $validated['paid_amount']    ?? 0;

        WeddingBudget::create($validated);

        return back()->with('success', 'Item budget berhasil ditambahkan.');
    }

    public function update(Request $request, WeddingBudget $budget)
    {
        abort_unless($budget->wedding->client_id === Auth::id(), 403);

        $validated = $request->validate([
            'category'         => 'required|string|max:50',
            'item_name'        => 'required|string|max:150',
            'estimated_amount' => 'required|numeric|min:0',
            'actual_amount'    => 'required|numeric|min:0',
            'paid_amount'      => 'required|numeric|min:0',
            'vendor_name'      => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:500',
        ]);

        $budget->update($validated);

        return back()->with('success', 'Budget diperbarui.');
    }

    public function destroy(WeddingBudget $budget)
    {
        abort_unless($budget->wedding->client_id === Auth::id(), 403);
        $budget->delete();
        return back()->with('success', 'Item budget dihapus.');
    }
}
