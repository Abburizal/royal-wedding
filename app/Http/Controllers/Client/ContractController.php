<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingContract;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function sign(WeddingContract $contract)
    {
        // Security: ensure only the contract's own client can sign
        abort_unless(
            Auth::id() === $contract->wedding->client_id,
            403,
            'Anda tidak memiliki izin untuk menandatangani kontrak ini.'
        );

        if ($contract->status === 'sent') {
            $contract->update([
                'status'      => 'signed',
                'signed_name' => Auth::user()->name,
                'signed_ip'   => request()->ip(),
                'signed_at'   => now(),
            ]);
        }

        return back()->with('success', 'Kontrak berhasil ditandatangani secara digital.');
    }
}
