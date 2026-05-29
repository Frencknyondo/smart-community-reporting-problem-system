<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ThemePreferenceController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['required', Rule::in(['light', 'dark'])],
        ]);

        $request->user()->forceFill([
            'theme_preference' => $validated['theme'],
        ])->save();

        return response()->json([
            'theme' => $validated['theme'],
        ]);
    }
}
