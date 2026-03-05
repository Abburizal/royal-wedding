<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PackageController;
use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\PortfolioController;
use App\Http\Controllers\Public\TestimonialController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\PaymentController as ClientPayment;
use App\Http\Controllers\Client\ChecklistController as ClientChecklist;
use App\Http\Controllers\Client\TimelineController as ClientTimeline;
use App\Http\Controllers\Client\MoodboardController as ClientMoodboard;
use App\Http\Controllers\Client\MessageController as ClientMessage;
use App\Http\Controllers\Client\ContractController as ClientContract;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WeddingController;
use App\Http\Controllers\Admin\WeddingNoteController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\VendorAssignmentController;
use App\Http\Controllers\Admin\PaymentInvoiceController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\MessageController as AdminMessage;

// ─── PROFILE ROUTES ────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── PUBLIC ROUTES ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/consultation', [BookingController::class, 'create'])->name('booking.create');
Route::post('/consultation', [BookingController::class, 'store'])->name('booking.store');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// ─── AUTH ROUTES (Breeze) ───────────────────────────────────────────────────────
require __DIR__.'/auth.php';

// Redirect after login based on role
Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->getDashboardRoute());
})->middleware(['auth', 'verified'])->name('dashboard');

// ─── CLIENT ROUTES ─────────────────────────────────────────────────────────────
Route::prefix('my-wedding')->name('client.')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
    Route::get('/payments', [ClientPayment::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/upload', [ClientPayment::class, 'uploadProof'])->name('payments.upload');
    Route::get('/payments/{payment}/pdf', [ClientPayment::class, 'downloadPdf'])->name('payments.pdf');
    Route::get('/checklist', [ClientChecklist::class, 'index'])->name('checklist.index');
    Route::patch('/checklist/{task}/status', [ClientChecklist::class, 'updateStatus'])->name('checklist.update-status');

    // Timeline & Moodboard
    Route::get('/timeline', [ClientTimeline::class, 'index'])->name('timeline.index');
    Route::patch('/timeline/{milestone}/status', [ClientTimeline::class, 'updateStatus'])->name('timeline.update-status');
    Route::get('/moodboard', [ClientMoodboard::class, 'index'])->name('moodboard.index');
    Route::post('/moodboard', [ClientMoodboard::class, 'store'])->name('moodboard.store');
    Route::delete('/moodboard/{moodboard}', [ClientMoodboard::class, 'destroy'])->name('moodboard.destroy');

    // Messages
    Route::post('/messages', [ClientMessage::class, 'store'])->name('messages.store');

    // Contract sign
    Route::post('/contracts/{contract}/sign', [ClientContract::class, 'sign'])->name('contracts.sign');
});

// ─── ADMIN ROUTES ──────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super_admin,wedding_planner,finance'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('weddings', WeddingController::class);
    Route::resource('packages', AdminPackageController::class);
    Route::resource('payments', AdminPaymentController::class)->only(['index','show','update']);
    Route::resource('vendors', VendorController::class);

    // Payment verification (finance only)
    Route::post('payments/{payment}/verify', [AdminPaymentController::class, 'verify'])
        ->name('payments.verify')->middleware('role:super_admin,finance');
    Route::post('payments/{payment}/reject', [AdminPaymentController::class, 'reject'])
        ->name('payments.reject')->middleware('role:super_admin,finance');

    // Assign planner to wedding
    Route::post('weddings/{wedding}/assign-planner', [WeddingController::class, 'assignPlanner'])
        ->name('weddings.assign-planner');

    // Internal notes
    Route::post('weddings/{wedding}/notes', [WeddingNoteController::class, 'store'])->name('wedding-notes.store');
    Route::delete('weddings/{wedding}/notes/{note}', [WeddingNoteController::class, 'destroy'])->name('wedding-notes.destroy');

    // Vendor Assignments
    Route::post('weddings/{wedding}/vendors', [VendorAssignmentController::class, 'store'])->name('wedding-vendors.store');
    Route::patch('weddings/{wedding}/vendors/{assignment}', [VendorAssignmentController::class, 'update'])->name('wedding-vendors.update');
    Route::delete('weddings/{wedding}/vendors/{assignment}', [VendorAssignmentController::class, 'destroy'])->name('wedding-vendors.destroy');

    // Payment Invoices (multi-payment)
    Route::post('weddings/{wedding}/invoices', [PaymentInvoiceController::class, 'store'])->name('wedding-invoices.store');
    Route::delete('weddings/{wedding}/invoices/{payment}', [PaymentInvoiceController::class, 'destroy'])->name('wedding-invoices.destroy');

    // Invoice PDF
    Route::get('payments/{payment}/pdf', [AdminPaymentController::class, 'pdf'])->name('payments.pdf');

    // Activity Log
    Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log');

    // Portfolio & Testimonials
    Route::resource('portfolios', AdminPortfolioController::class)->except(['show']);
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);

    // Consultations
    Route::resource('consultations', ConsultationController::class)->only(['index','show','update','destroy']);

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Contracts
    Route::get('weddings/{wedding}/contract', [ContractController::class, 'create'])->name('weddings.contract.create');
    Route::post('weddings/{wedding}/contract', [ContractController::class, 'store'])->name('weddings.contract.store');
    Route::get('contracts/{contract}/pdf', [ContractController::class, 'pdf'])->name('contracts.pdf');

    // Wedding Messages
    Route::post('weddings/{wedding}/messages', [AdminMessage::class, 'store'])->name('wedding-messages.store');
    Route::post('weddings/{wedding}/messages/read', [AdminMessage::class, 'markRead'])->name('wedding-messages.read');

    // Notifications
    Route::post('notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read-all');
});
