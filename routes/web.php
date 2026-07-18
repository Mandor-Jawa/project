<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'reviewer') return redirect()->route('reviewer.dashboard');
    return redirect()->route('proposer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Proposer Routes
    Route::middleware('role:proposer')->prefix('proposer')->name('proposer.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ProposalController::class, 'index'])->name('dashboard');
        Route::get('/proposal/create', [\App\Http\Controllers\ProposalController::class, 'create'])->name('proposal.create');
        Route::post('/proposal', [\App\Http\Controllers\ProposalController::class, 'store'])->name('proposal.store');
        Route::get('/proposal/{proposal}', [\App\Http\Controllers\ProposalController::class, 'show'])->name('proposal.show');
        Route::get('/proposal/{proposal}/download', [\App\Http\Controllers\ProposalController::class, 'download'])->name('proposal.download');
        Route::post('/proposal/{proposal}/update-file', [\App\Http\Controllers\ProposalController::class, 'updateFile'])->name('proposal.updateFile');
    });

    // Reviewer Routes
    Route::middleware('role:reviewer')->prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ReviewController::class, 'index'])->name('dashboard');
        Route::get('/proposal/{proposal}', [\App\Http\Controllers\ReviewController::class, 'show'])->name('proposal.show');
        Route::post('/proposal/{proposal}/review', [\App\Http\Controllers\ReviewController::class, 'storeReview'])->name('proposal.review');
        Route::get('/proposal/{proposal}/download', [\App\Http\Controllers\ReviewController::class, 'download'])->name('proposal.download');
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::get('/proposal/{proposal}', [\App\Http\Controllers\AdminController::class, 'show'])->name('proposal.show');
        Route::post('/proposal/{proposal}/assign', [\App\Http\Controllers\AdminController::class, 'assignReviewer'])->name('proposal.assign');
        Route::get('/proposal/{proposal}/download', [\App\Http\Controllers\AdminController::class, 'download'])->name('proposal.download');
    });
});

require __DIR__.'/auth.php';
