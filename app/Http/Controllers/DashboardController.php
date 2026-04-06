<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalElections'  => Election::count(),
            'activeElections' => Election::where('status', 'active')->count(),
            'totalCandidates' => Candidate::count(),
            'totalVoters'     => User::where('role', 'voter')->count(),
            'recentElections' => Election::latest()->take(5)->get(),
        ]);
    }
}