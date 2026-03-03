@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h1 class="card-header">Edit Recipe</h1>
        
        <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Recipe Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $recipe->title) }}" required>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" required>{{ old('description', $recipe->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Ingredients * (One per line)</label>
                <textarea name="ingredients" class="form-control" style="min-height: 200px;" required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
                @error('ingredients')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Instructions * (Step by step)</label>
                <textarea name="instructions" class="form-control" style="min-height: 250px;" required>{{ old('instructions', $recipe->instructions) }}</textarea>
                @error('instructions')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Prep Time (minutes)</label>
                    <input type="number" name="prep_time" class="form-control" value="{{ old('prep_time', $recipe->prep_time) }}" min="1">
                    @error('prep_time')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Cook Time (minutes)</label>
                    <input type="number" name="cook_time" class="form-control" value="{{ old('cook_time', $recipe->cook_time) }}" min="1">
                    @error('cook_time')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Servings</label>
                    <input type="number" name="servings" class="form-control" value="{{ old('servings', $recipe->servings) }}" min="1">
                    @error('servings')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Recipe Image</label>
                @if($recipe->image)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="Current image" style="max-width: 200px; border-radius: 8px;">
                        <p style="color: #7f8c8d; font-size: 0.875rem; margin-top: 0.5rem;">Current image (Upload a new one to replace)</p>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <p style="margin-top: 0.5rem; color: #6c757d; font-size: 0.875rem;">
                    Supported formats: JPEG, PNG, JPG, GIF, WebP (Max size: 2MB)
                </p>
                @error('image')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">Update Recipe</button>
                <a href="{{ route('recipes.my') }}" class="btn btn-secondary">Cancel</a>
            </div>
            
            <p style="margin-top: 1rem; color: #7f8c8d; font-size: 0.875rem;">
                * Required fields. Your updated recipe will be reviewed by an administrator before being published.
            </p>
        </form>
    </div>
</div>
@endsection