<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * RegisterController - Handles user registration.
 * Sends email verification after registration.
 */
class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return View The registration view.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     *
     * @param Request $request The incoming request with registration data.
     * @return RedirectResponse Redirect to home or verification notice.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'rol' => 'user',
            ]);

            
            event(new Registered($user));

            Auth::login($user);

            return redirect()
                ->route('verification.notice')
                ->with('success', 'Registration successful! Please verify your email address.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
