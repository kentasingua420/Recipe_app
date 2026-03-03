<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    // Show all approved recipes
    public function index(Request $request)
    {
        $query = Recipe::with(['user', 'category'])
            ->where('status', 'approved');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $recipes = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories'));
    }

    // Show single recipe
    public function show($slug)
    {
        $recipe = Recipe::with(['user', 'category', 'comments.user', 'ratings'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->firstOrFail();

        $userRating = null;
        if (Auth::check()) {
            $userRating = $recipe->ratings()->where('user_id', Auth::id())->first();
        }

        $isSaved = Auth::check() ? Auth::user()->savedRecipes->contains($recipe->id) : false;

        return view('recipes.show', compact('recipe', 'userRating', 'isSaved'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    // Store new recipe
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'prep_time' => 'nullable|integer|min:1',
            'cook_time' => 'nullable|integer|min:1',
            'servings' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['status'] = 'pending';

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        Recipe::create($validated);

        return redirect()->route('recipes.my')->with('success', 'Recipe submitted for approval!');
    }

    // Show user's recipes
    public function myRecipes()
    {
        $recipes = Recipe::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('recipes.my-recipes', compact('recipes'));
    }

    // Show edit form
    public function edit($id)
    {
        $recipe = Recipe::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $categories = Category::all();

        return view('recipes.edit', compact('recipe', 'categories'));
    }

    // Update recipe
    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'prep_time' => 'nullable|integer|min:1',
            'cook_time' => 'nullable|integer|min:1',
            'servings' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['status'] = 'pending'; // Reset to pending after edit

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $validated['image'] = $request->file('image')->store('recipes', 'public');
        }

        $recipe->update($validated);

        return redirect()->route('recipes.my')->with('success', 'Recipe updated and submitted for approval!');
    }

    // Delete recipe
    public function destroy($id)
    {
        $recipe = Recipe::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete image
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('recipes.my')->with('success', 'Recipe deleted successfully!');
    }
}