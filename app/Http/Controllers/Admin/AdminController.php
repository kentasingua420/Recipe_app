<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{

    public function dashboard()
    {
        $stats = [
            'total_recipes' => Recipe::count(),
            'pending_recipes' => Recipe::where('status', 'pending')->count(),
            'approved_recipes' => Recipe::where('status', 'approved')->count(),
            'rejected_recipes' => Recipe::where('status', 'rejected')->count(),
            'total_users' => User::where('is_admin', 0)->count(),
            'total_categories' => Category::count(),
        ];

        $recent_recipes = Recipe::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_recipes'));
    }
}