<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
// Member Controllers
use App\Http\Controllers\Member\PackageController as MemberPackageController;
use App\Http\Controllers\Member\CheckInController as MemberCheckInController;
use App\Http\Controllers\Member\PersonalTrainerController;

// Halaman utama untuk tamu
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Route "Gerbang Pemisah" setelah login
// routes/web.php

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin');
    }

    $user = auth()->user();

    // 1. Prioritaskan mencari membership yang 'active'
    $displayMembership = $user->memberships()->where('status', 'active')->first();

    // 2. Jika tidak ada yang aktif, baru cari yang 'pending'
    if (!$displayMembership) {
        $displayMembership = $user->memberships()->where('status', 'pending')->latest()->first();
    }

    // 3. Jika masih tidak ada, baru cari yang paling baru (kemungkinan expired)
    if (!$displayMembership) {
        $displayMembership = $user->memberships()->latest()->first();
    }

    $checkInHistory = $user->checkIns()->latest()->take(10)->get();
    
    return view('dashboard', [
        'user' => $user,
        'membership' => $displayMembership, // Gunakan variabel yang sudah difilter
        'checkInHistory' => $checkInHistory,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


// GRUP ROUTE KHUSUS MEMBER
Route::middleware(['auth', 'member'])->group(function() {
    Route::get('/packages', [MemberPackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/{package}', [MemberPackageController::class, 'show'])->name('packages.show');
    Route::post('/packages/{package}/purchase', [MemberPackageController::class, 'purchase'])->name('packages.purchase');

    Route::get('/check-in', [MemberCheckInController::class, 'create'])->name('checkin.create');
    Route::post('/check-in', [MemberCheckInController::class, 'store'])->name('checkin.store');

    Route::get('/personal-trainers', [PersonalTrainerController::class, 'index'])->name('trainers.index');
});


// Route untuk SEMUA USER YANG LOGIN (Termasuk Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route otentikasi dari Breeze
Route::get('/pending-approval', function () {
    return view('auth.pending-approval');
})->middleware('auth')->name('pending.approval');

Route::get('/check-approval-status', function () {
    return response()->json(['is_approved' => auth()->user()->is_approved]);
})->middleware('auth')->name('check.approval.status');

require __DIR__.'/auth.php';
