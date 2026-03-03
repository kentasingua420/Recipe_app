<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SavedRecipeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RecipeManagementController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [RecipeController::class, 'index'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{slug}', [RecipeController::class, 'show'])->name('recipes.show');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/picture', [ProfileController::class, 'removeProfilePicture'])->name('profile.picture.remove');

    // Recipe management
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->name('recipes.my');
    Route::get('/recipes-create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes-store', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes-edit/{id}', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes-update/{id}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes-delete/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    // Saved recipes
    Route::get('/saved-recipes', [SavedRecipeController::class, 'index'])->name('recipes.saved');
    Route::post('/recipes/{recipe}/save', [SavedRecipeController::class, 'store'])->name('recipes.save');
    Route::delete('/recipes/{recipe}/unsave', [SavedRecipeController::class, 'destroy'])->name('recipes.unsave');

    // Ratings
    Route::post('/recipes/{recipe}/rate', [RatingController::class, 'store'])->name('recipes.rate');

    // Comments
    Route::post('/recipes/{recipe}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Category management
    Route::resource('categories', CategoryController::class);

    // Recipe management
    Route::get('/recipes', [RecipeManagementController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/{recipe}', [RecipeManagementController::class, 'show'])->name('recipes.show');
    Route::post('/recipes/{recipe}/approve', [RecipeManagementController::class, 'approve'])->name('recipes.approve');
    Route::post('/recipes/{recipe}/reject', [RecipeManagementController::class, 'reject'])->name('recipes.reject');
    Route::delete('/recipes/{recipe}', [RecipeManagementController::class, 'destroy'])->name('recipes.destroy');
});

require __DIR__.'/auth.php';