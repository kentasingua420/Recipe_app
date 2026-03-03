<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $recipeId)
    {
        $recipe = Recipe::where('id', $recipeId)
            ->where('status', 'approved')
            ->firstOrFail();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Update or create rating
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'recipe_id' => $recipeId,
            ],
            [
                'rating' => $validated['rating'],
            ]
        );

        return redirect()->back()->with('success', 'Rating submitted successfully!');
    }
}