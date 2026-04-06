<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\VoteController;

// Public home redirect
Route::get('/', fn() => redirect()->route('dashboard'));

// Protected routes (must be logged in)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Elections CRUD
    Route::resource('elections', ElectionController::class);

    // Candidates CRUD
    Route::resource('candidates', CandidateController::class)->except(['show']);

    // Voting (voters only)
    Route::get('/vote',  [VoteController::class, 'index'])->name('vote.index');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');

    // Voters management (admin only — controller handles auth check)
    Route::resource('voters', VoterController::class)->only(['index', 'edit', 'update', 'destroy']);
});

// Laravel Breeze auth routes (login, register, logout)
require __DIR__.'/auth.php';
