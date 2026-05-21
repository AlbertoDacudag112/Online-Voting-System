<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Ballot;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id()); 

        $totalElections  = Election::count();
        $activeElections = Election::where('status', 'active')->count();
        $totalCandidates = Candidate::count();
        $totalVoters     = User::where('role', 'voter')->count();
        $recentElections = Election::latest()->take(5)->get();

        $votersByCourse = User::where('role', 'voter')
            ->selectRaw('course, count(*) as total')
            ->groupBy('course')
            ->orderByDesc('total')
            ->get();

        $votersByYear = User::where('role', 'voter')
            ->selectRaw('year_level, count(*) as total')
            ->groupBy('year_level')
            ->orderBy('year_level')
            ->get();

        $pendingElections = collect();
        if (!$user->isAdmin()) {
            $votedIds = Ballot::where('user_id', $user->id)
                              ->where('has_voted', true)
                              ->pluck('election_id');

            $pendingElections = Election::where('status', 'active')
                                        ->whereNotIn('id', $votedIds)
                                        ->get();
        }

        return view('dashboard', compact(
            'totalElections', 'activeElections', 'totalCandidates',
            'totalVoters', 'recentElections', 'votersByCourse',
            'votersByYear', 'pendingElections'
        ));
    }
}