<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    /**
     * Set the application's accent color.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAccent(Request $request)
    {
        $request->validate([
            'accent_color' => 'required|string|in:rose,indigo,emerald,amber,violet,cyan,slate,tangerine'
        ]);

        $color = $request->accent_color;
        Session::put('accent_color', $color);

        // Persist to database if user is logged in
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->accent_color = $color;
            $user->save();
        }

        return response()->json(['success' => true, 'color' => $color]);
    }
}
