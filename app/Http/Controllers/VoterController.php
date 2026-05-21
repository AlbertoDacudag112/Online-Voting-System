<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoterController extends Controller
{
    public function __construct()
    {
        if (Auth::user() && Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admins only.');
        }
    }

    public function index(Request $request)
    {
        $query = User::latest();

        // Filter by course
        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }

        // Filter by year level
        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $voters = $query->paginate(15)->withQueryString();

        return view('voters.index', compact('voters'));
    }

    public function edit($id)
    {
        $voter = User::findOrFail($id);
        return view('voters.edit', compact('voter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'role'       => 'required|in:admin,voter',
            'voter_id'   => 'nullable|string|unique:users,voter_id,' . $id,
            'course'     => 'nullable|string|in:' . implode(',', array_keys(\App\Models\User::COURSES)),
            'year_level' => 'nullable|string|in:' . implode(',', array_keys(\App\Models\User::YEAR_LEVELS)),
        ]);

        $voter = User::findOrFail($id);
        $voter->update($request->only('name', 'email', 'role', 'voter_id', 'is_active', 'course', 'year_level'));

        return redirect()->route('voters.index')->with('success', 'Voter updated successfully.');
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('voters.index')->with('error', 'You cannot delete your own account.');
        }
        User::findOrFail($id)->delete();
        return redirect()->route('voters.index')->with('success', 'Voter deleted successfully.');
    }
}