<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with(['election', 'position'])->latest()->paginate(10);
        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $elections = Election::all();
        $positions = Position::all();
        return view('candidates.form', compact('elections', 'positions'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'name'        => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position_id' => 'required|exists:positions,id',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create([
            'name'        => $request->name,
            'election_id' => $request->election_id,
            'position_id' => $request->position_id,
            'party'       => $request->party,
            'bio'         => $request->bio,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidate added successfully.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $candidate = Candidate::findOrFail($id);
        $elections = Election::all();
        $positions = Position::all();
        return view('candidates.form', compact('candidate', 'elections', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $request->validate([
            'name'        => 'required|string|max:255',
            'election_id' => 'required|exists:elections,id',
            'position_id' => 'required|exists:positions,id',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $candidate = Candidate::findOrFail($id);
        $data = $request->only('name', 'election_id', 'position_id', 'party', 'bio');

        if ($request->hasFile('photo')) {
            if ($candidate->photo) Storage::disk('public')->delete($candidate->photo);
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($data);
        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        $candidate = Candidate::findOrFail($id);
        if ($candidate->photo) Storage::disk('public')->delete($candidate->photo);
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admins only.');
        }
    }
}