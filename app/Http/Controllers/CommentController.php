<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $recipeId)
    {
        $recipe = Recipe::where('id', $recipeId)
            ->where('status', 'approved')
            ->firstOrFail();

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'recipe_id' => $recipeId,
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy($id)
    {
        $comment = Comment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}