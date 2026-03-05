<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Services\ChecklistService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected PaymentService   $paymentService,
        protected ChecklistService $checklistService,
    ) {}

    public function index()
    {
        $user    = Auth::user();
        $wedding = $user->weddings()->with(['package', 'payments', 'checklistTasks', 'messages.sender', 'contracts'])->latest()->first();

        if (!$wedding) {
            return view('client.no-wedding');
        }

        $paymentSummary    = $this->paymentService->getWeddingPaymentSummary($wedding);
        $checklistProgress = $this->checklistService->getProgressByCategory($wedding);

        return view('client.dashboard', compact('wedding', 'paymentSummary', 'checklistProgress'));
    }
}
