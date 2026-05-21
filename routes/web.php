<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\VoteController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('elections', ElectionController::class);
    Route::get('/elections/{election}/results', [ElectionController::class, 'results'])->name('elections.results');
    Route::resource('candidates', CandidateController::class)->except(['show']);

    // Voting
    Route::get('/vote',              [VoteController::class, 'index'])->name('vote.index');
    Route::get('/vote/{election}',   [VoteController::class, 'show'])->name('vote.show');  // <-- new
    Route::post('/vote',             [VoteController::class, 'store'])->name('vote.store');

    Route::resource('voters', VoterController::class)->only(['index', 'edit', 'update', 'destroy']);
});

require __DIR__.'/auth.php';