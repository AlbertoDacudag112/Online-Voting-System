<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    public function index()
    {
        $elections = Election::latest()->paginate(10);
        return view('elections.index', compact('elections'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $courses = User::COURSES;
        return view('elections.form', compact('courses'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'title'      => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'required|in:upcoming,active,closed',
            'course'     => 'nullable|string',
        ]);

        Election::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => $request->status,
            'course'      => $request->course ?: null,
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('elections.index')->with('success', 'Election created successfully.');
    }

    public function show($id)
    {
        $election = Election::with(['candidates.position', 'candidates.votes'])->findOrFail($id);
        return view('elections.show', compact('election'));
    }

    public function results($id)
    {
        $election = Election::with([
            'positions' => fn($q) => $q->orderBy('display_order'),
            'positions.candidates.votes',
        ])->findOrFail($id);

        $positions = $election->positions->map(function ($position) {
            $candidates = $position->candidates->map(function ($candidate) {
                $candidate->vote_count = $candidate->votes->count();
                return $candidate;
            })->sortByDesc('vote_count')->values();

            $position->sorted_candidates = $candidates;
            $position->winner = $candidates->first();
            return $position;
        });

        $byCourse = $positions->groupBy(function ($position) {
            return $position->candidates->first()?->course ?? 'General';
        });

        return view('elections.results', compact('election', 'positions', 'byCourse'));
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $election = Election::findOrFail($id);
        $courses  = User::COURSES;
        return view('elections.form', compact('election', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $request->validate([
            'title'      => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'required|in:upcoming,active,closed',
            'course'     => 'nullable|string',
        ]);

        $election = Election::findOrFail($id);
        $election->update([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => $request->status,
            'course'      => $request->course ?: null,
        ]);

        return redirect()->route('elections.index')->with('success', 'Election updated successfully.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        Election::findOrFail($id)->delete();
        return redirect()->route('elections.index')->with('success', 'Election deleted successfully.');
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admins only.');
        }
    }
}