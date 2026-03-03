<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedRecipeController extends Controller
{
    // Show user's saved recipes
    public function index()
    {
        $savedRecipes = Auth::user()->savedRecipes()
            ->with('category')
            ->where('status', 'approved')
            ->latest('saved_recipes.created_at')
            ->paginate(12);

        return view('recipes.saved', compact('savedRecipes'));
    }

    // Save a recipe
    public function store($recipeId)
    {
        $recipe = Recipe::where('id', $recipeId)
            ->where('status', 'approved')
            ->firstOrFail();

        // Check if already saved
        $exists = SavedRecipe::where('user_id', Auth::id())
            ->where('recipe_id', $recipeId)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Recipe already saved!');
        }

        SavedRecipe::create([
            'user_id' => Auth::id(),
            'recipe_id' => $recipeId,
        ]);

        return redirect()->back()->with('success', 'Recipe saved successfully!');
    }

    // Remove saved recipe
    public function destroy($recipeId)
    {
        SavedRecipe::where('user_id', Auth::id())
            ->where('recipe_id', $recipeId)
            ->delete();

        return redirect()->back()->with('success', 'Recipe removed from saved!');
    }
}