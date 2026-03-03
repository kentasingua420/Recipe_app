<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeManagementController extends Controller
{

    public function index(Request $request)
    {
        $query = Recipe::with(['user', 'category']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $recipes = $query->latest()->paginate(15);

        return view('admin.recipes.index', compact('recipes'));
    }

    public function show($id)
    {
        $recipe = Recipe::with(['user', 'category'])->findOrFail($id);
        return view('admin.recipes.show', compact('recipe'));
    }

    public function approve($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update([
            'status' => 'approved',
            'admin_notes' => null,
        ]);

        return redirect()->back()->with('success', 'Recipe approved successfully!');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string',
        ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->back()->with('success', 'Recipe rejected with notes!');
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);

        // Delete image
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('admin.recipes.index')->with('success', 'Recipe deleted successfully!');
    }
}