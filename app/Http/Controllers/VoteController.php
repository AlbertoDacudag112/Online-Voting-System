<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use App\Models\Ballot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    // Election picker — only shows elections open to the user's course
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard')
                             ->with('error', 'Admins are not allowed to vote.');
        }
        $status = $request->get('status', 'active');

        $elections = Election::with(['positions.candidates', 'ballots'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            // Show elections that are either open to all (course = null) OR match the user's course
            ->where(function ($q) use ($user) {
                $q->whereNull('course')
                  ->orWhere('course', $user->course);
            })
            ->latest()
            ->get();

        // Tag each election with whether the user has voted
        $elections->each(function ($election) use ($user) {
            $election->user_has_voted = $election->ballots
                ->where('user_id', $user->id)
                ->where('has_voted', true)
                ->isNotEmpty();
        });

        return view('vote.index', compact('elections', 'status'));
    }

    // Show voting form for a specific election
    public function show(Election $election)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard')
                             ->with('error', 'Admins are not allowed to vote.');
        }

        // Block access if election is course-restricted and user's course doesn't match
        if ($election->course && $election->course !== $user->course) {
            return redirect()->route('vote.index')
                             ->with('error', 'You are not eligible to vote in this election.');
        }

        if ($election->status !== 'active') {
            return redirect()->route('vote.index')
                             ->with('error', 'This election is not currently active.');
        }

        $hasVoted = $election->ballots()
                             ->where('user_id', $user->id)
                             ->where('has_voted', true)
                             ->exists();

        $election->load(['positions' => fn($q) => $q->where('election_id', $election->id),
                 'positions.candidates' => fn($q) => $q->where('election_id', $election->id)]);

        return view('vote.show', compact('election', 'hasVoted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'election_id' => 'required|exists:elections,id',
            'votes'       => 'required|array',
        ]);

        /** @var User $user */
        $user       = Auth::user();
        $userId     = $user->id;
        $electionId = $request->election_id;
        $election   = Election::findOrFail($electionId);

        // Double-check course eligibility on submit
        if ($election->course && $election->course !== $user->course) {
            return redirect()->route('vote.index')
                             ->with('error', 'You are not eligible to vote in this election.');
        }

        if (empty($user->course)) {
            return redirect()->route('vote.index')
                             ->with('error', 'Your account has no course assigned. Please contact an administrator.');
        }

        if ($user->hasVotedForCourse($electionId)) {
            return redirect()->route('vote.index')
                             ->with('error', 'You have already voted in this election.');
        }

        DB::transaction(function () use ($request, $userId, $electionId) {
            foreach ($request->votes as $positionId => $candidateId) {
                Vote::create([
                    'user_id'      => $userId,
                    'election_id'  => $electionId,
                    'position_id'  => $positionId,
                    'candidate_id' => $candidateId,
                    'ip_address'   => $request()->ip(),
                    'voted_at'     => now(),
                ]);
            }
            Ballot::updateOrCreate(
                ['user_id' => $userId, 'election_id' => $electionId],
                ['has_voted' => true, 'voted_at' => now()]
            );
        });

        return redirect()->route('vote.index')
                         ->with('success', 'Your vote has been submitted successfully!');
    }
}