<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use App\Models\Ballot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function index()
    {
        $elections = Election::where('status', 'active')
            ->with(['positions.candidates', 'ballots'])
            ->get();
        return view('vote.index', compact('elections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'election_id' => 'required|exists:elections,id',
            'votes'       => 'required|array',
        ]);

        $userId     = Auth::id();
        $electionId = $request->election_id;

        $ballot = Ballot::where('user_id', $userId)
                        ->where('election_id', $electionId)
                        ->first();

        if ($ballot && $ballot->has_voted) {
            return redirect()->route('vote.index')->with('error', 'You have already voted in this election.');
        }

        DB::transaction(function () use ($request, $userId, $electionId) {
            foreach ($request->votes as $positionId => $candidateId) {
                Vote::create([
                    'user_id'      => $userId,
                    'election_id'  => $electionId,
                    'position_id'  => $positionId,
                    'candidate_id' => $candidateId,
                    'ip_address'   => request()->ip(),
                    'voted_at'     => now(),
                ]);
            }

            Ballot::updateOrCreate(
                ['user_id' => $userId, 'election_id' => $electionId],
                ['has_voted' => true, 'voted_at' => now()]
            );
        });

        return redirect()->route('vote.index')->with('success', 'Your vote has been submitted successfully!');
    }
}