<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    /**
     * Set the application's accent color in the session.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setAccent(Request $request)
    {
        $request->validate([
            'color' => 'required|string|in:rose,indigo,emerald,amber,violet,cyan,slate,tangerine'
        ]);

        Session::put('accent_color', $request->color);

        return response()->json(['success' => true, 'color' => $request->color]);
    }
}
