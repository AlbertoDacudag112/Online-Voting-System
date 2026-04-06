<?php

namespace App\Http\Controllers;

use App\Models\Election;
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
        return view('elections.form');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'title'      => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'required|in:upcoming,active,closed',
        ]);

        Election::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => $request->status,
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('elections.index')->with('success', 'Election created successfully.');
    }

    public function show($id)
    {
        $election = Election::with(['candidates.position', 'candidates.votes'])->findOrFail($id);
        return view('elections.show', compact('election'));
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $election = Election::findOrFail($id);
        return view('elections.form', compact('election'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();
        $request->validate([
            'title'      => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'required|in:upcoming,active,closed',
        ]);

        $election = Election::findOrFail($id);
        $election->update($request->only('title', 'description', 'start_date', 'end_date', 'status'));

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