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

    public function index()
    {
        $voters = User::latest()->paginate(10);
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:admin,voter',
            'voter_id' => 'nullable|string|unique:users,voter_id,' . $id,
        ]);

        $voter = User::findOrFail($id);
        $voter->update($request->only('name', 'email', 'role', 'voter_id', 'is_active'));

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