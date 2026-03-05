<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Payment;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function index()
    {
        $payments = Payment::with(['wedding.client'])->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['wedding.client', 'wedding.package']);
        return view('admin.payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($request->only(['notes']));
        return back()->with('success', 'Catatan disimpan.');
    }

    public function verify(Payment $payment)
    {
        $this->paymentService->verify($payment);
        ActivityLog::record('verified', 'Verifikasi pembayaran ' . $payment->invoice_number . ' (' . $payment->formatted_amount . ')', $payment);
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $this->paymentService->reject($payment, $request->reason);
        ActivityLog::record('rejected', 'Menolak pembayaran ' . $payment->invoice_number, $payment);
        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function pdf(Payment $payment)
    {
        $payment->load(['wedding.client', 'wedding.package', 'wedding.payments']);

        $pdf = Pdf::loadView('pdf.invoice', compact('payment'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $payment->invoice_number . '.pdf');
    }
}
