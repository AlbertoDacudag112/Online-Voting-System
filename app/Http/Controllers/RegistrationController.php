<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register', [
            'courses'     => User::COURSES,
            'year_levels' => User::YEAR_LEVELS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
    $request->validate([
        'first_name'  => ['required', 'string', 'max:100'],
        'middle_name' => ['nullable', 'string', 'max:100'],
        'last_name'   => ['required', 'string', 'max:100'],
        'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'course'      => ['required', 'string'],
        'year_level'  => ['required', 'string'],
        'password'    => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name);

    $user = User::create([
        'first_name'  => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name'   => $request->last_name,
        'name'        => $fullName,
        'email'       => $request->email,
        'course'      => $request->course,
        'year_level'  => $request->year_level,
        'password'    => Hash::make($request->password),
    ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard'));
    }
}