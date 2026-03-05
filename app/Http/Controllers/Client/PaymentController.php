<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function index()
    {
        $wedding  = Auth::user()->weddings()->with('payments')->latest()->firstOrFail();
        $payments = $wedding->payments()->latest()->get();
        $summary  = $this->paymentService->getWeddingPaymentSummary($wedding);
        return view('client.payments', compact('payments', 'summary', 'wedding'));
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        abort_unless($payment->wedding->client_id === Auth::id(), 403);

        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $this->paymentService->uploadProof($payment, $request->file('proof'));

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi.');
    }

    public function downloadPdf(Payment $payment)
    {
        abort_unless($payment->wedding->client_id === Auth::id(), 403);
        $payment->load(['wedding.client', 'wedding.package', 'wedding.payments']);

        $pdf = Pdf::loadView('pdf.invoice', compact('payment'))->setPaper('a4', 'portrait');
        return $pdf->download('invoice-' . $payment->invoice_number . '.pdf');
    }
}
