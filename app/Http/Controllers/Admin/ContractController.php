<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use App\Models\WeddingContract;
use App\Models\ActivityLog;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function create(Wedding $wedding)
    {
        $existing = $wedding->contracts()->first();
        return view('admin.contracts.create', compact('wedding', 'existing'));
    }

    public function store(Request $request, Wedding $wedding)
    {
        $request->validate(['contract_body' => 'required|string']);

        $contract = WeddingContract::updateOrCreate(
            ['wedding_id' => $wedding->id],
            [
                'contract_body' => $request->contract_body,
                'status'        => 'sent',
                'created_by'    => auth()->id(),
            ]
        );

        ActivityLog::record('contract_sent', "Kontrak dikirim ke klien {$wedding->client->name}", $contract);

        return redirect()->route('admin.weddings.show', $wedding)->with('success', 'Kontrak berhasil dibuat dan dikirim ke klien.');
    }

    public function pdf(WeddingContract $contract)
    {
        $contract->load('wedding.client', 'wedding.package');
        $companyName = Setting::get('company_name', 'The Royal Wedding');
        $pdf = Pdf::loadView('pdf.contract', compact('contract', 'companyName'))
                  ->setPaper('a4');
        return $pdf->download("kontrak-{$contract->wedding->wedding_code}.pdf");
    }
}
