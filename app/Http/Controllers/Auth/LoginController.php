<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * LoginController - Handles user authentication.
 */
class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return View The login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     *
     * @param Request $request The incoming request with credentials.
     * @return RedirectResponse Redirect to home or back with errors.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Welcome back!');
        }

        return redirect()
            ->back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'The provided credentials do not match our records.');
    }

    /**
     * Log the user out.
     *
     * @param Request $request The incoming request.
     * @return RedirectResponse Redirect to landing page.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('landing')
            ->with('success', 'You have been logged out.');
    }
}
