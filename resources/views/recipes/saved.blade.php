@extends('layouts.app')

@section('content')
<div>
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Saved Recipes</h1>
    
    @if($savedRecipes->count() > 0)
        <div class="grid">
            @foreach($savedRecipes as $recipe)
                <div class="recipe-card">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="recipe-card-image">
                    @else
                        <div class="recipe-card-image" style="background-color: #ecf0f1; display: flex; align-items: center; justify-content: center; color: #95a5a6;">
                            No Image
                        </div>
                    @endif
                    
                    <div class="recipe-card-body">
                        <span class="recipe-card-category">{{ $recipe->category->name }}</span>
                        <h3 class="recipe-card-title">{{ $recipe->title }}</h3>
                        <p class="recipe-card-description">{{ Str::limit($recipe->description, 100) }}</p>
                        
                        <div class="recipe-card-footer">
                            <div class="stars">
                                @php
                                    $avgRating = round($recipe->averageRating());
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $avgRating ? 'filled' : '' }}">★</span>
                                @endfor
                                <span style="margin-left: 0.5rem; color: #7f8c8d; font-size: 0.9rem;">
                                    ({{ $recipe->totalRatings() }})
                                </span>
                            </div>
                            
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">View</a>
                                
                                <form action="{{ route('recipes.unsave', $recipe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            {{ $savedRecipes->links() }}
        </div>
    @else
        <div class="card">
            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">
                You haven't saved any recipes yet. <a href="{{ route('recipes.index') }}" style="color: #3498db;">Browse recipes to get started!</a>
            </p>
        </div>
    @endif
</div>
@endsection