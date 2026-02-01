<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * VerificationController - Handles email verification.
 * Users must verify email before making bookings.
 */
class VerificationController extends Controller
{
    /**
     * Show the email verification notice.
     *
     * @param Request $request The incoming request.
     * @return View|RedirectResponse The verification notice or redirect if verified.
     */
    public function notice(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle the email verification.
     *
     * @param EmailVerificationRequest $request The verification request.
     * @return RedirectResponse Redirect to home with success message.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()
            ->route('home')
            ->with('success', 'Email verified successfully! You can now make bookings.');
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request The incoming request.
     * @return RedirectResponse Redirect back with status.
     */
    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return redirect()
            ->back()
            ->with('success', 'Verification email sent! Please check your inbox.');
    }
}
