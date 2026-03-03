@extends('layouts.app')

@section('content')
<div>
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-inner">
            <h1 class="hero-title">Discover Amazing<br>Recipes</h1>
            <p class="hero-subtitle">Explore our collection of delicious recipes from our community</p>

            <form action="{{ route('recipes.index') }}" method="GET" class="hero-search">
                <input type="text" name="search" placeholder="Search recipes, ingredients, cuisines..." value="{{ request('search') }}" class="hero-search-input">
                <button type="submit" class="btn btn-primary hero-search-btn">Search Recipes</button>
            </form>
        </div>
    </section>

    <div class="search-panel">
        <form action="{{ route('recipes.index') }}" method="GET" class="search-panel-form">
            <div class="search-panel-field">
                <div class="search-panel-label">Search Recipes</div>
                <input type="text" name="search" placeholder="Search by title or description..." value="{{ request('search') }}" class="search-panel-input">
            </div>

            <div class="search-panel-field">
                <div class="search-panel-label">Category</div>
                <select name="category" class="search-panel-input">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="search-panel-actions">
                <button type="submit" class="btn btn-primary search-panel-btn">Search</button>
                @if(request('search') || request('category'))
                    <a href="{{ route('recipes.index') }}" class="btn btn-secondary search-panel-btn">Clear</a>
                @endif
            </div>
        </form>

        <div class="search-panel-chips">
            <span class="search-panel-chips-label">Popular:</span>
            @foreach($categories->take(6) as $category)
                <a class="chip" href="{{ route('recipes.index', array_filter(['category' => $category->id, 'search' => request('search')])) }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Enhanced Results Info -->
    @if(request('search') || request('category'))
        <div class="alert alert-info" data-icon="📊" style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-weight: 700; color: #0c5460;">{{ $recipes->total() }}</span>
                <span>recipe(s) found</span>
                @if(request('search'))
                    <span>for</span>
                    <span style="font-weight: 600; color: #0c5460; font-style: italic;">"{{ request('search') }}"</span>
                @endif
                @if(request('category'))
                    <span>in</span>
                    <span style="font-weight: 600; color: #0c5460;">{{ $categories->find(request('category'))->name ?? 'Unknown' }}</span>
                @endif
            </div>
        </div>
    @endif
    
    @if($recipes->count() > 0)
        <div class="featured-heading">
            <h2 class="featured-title">Featured Recipes</h2>
            <p class="featured-subtitle">Discover our most loved recipes from talented home cooks</p>
        </div>
        <div class="grid">
            @foreach($recipes as $recipe)
                <div class="recipe-card" style="position: relative; overflow: hidden;">
                    <!-- Recipe Image -->
                    <div style="position: relative; overflow: hidden;">
                        @if($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="recipe-card-image" style="transition: transform 0.3s ease;">
                        @else
                            <div class="recipe-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                🍳
                            </div>
                        @endif
                        
                        <!-- Category Badge on Image -->
                        <div style="position: absolute; top: 10px; left: 10px;">
                            <span class="recipe-card-category" style="box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                {{ $recipe->category->name }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="recipe-card-body">
                        <h3 class="recipe-card-title" style="min-height: 60px; display: flex; align-items: center;">
                            {{ $recipe->title }}
                        </h3>
                        
                        <p class="recipe-card-description" style="min-height: 60px;">
                            {{ Str::limit($recipe->description, 100) }}
                        </p>
                        
                        <!-- Recipe Meta Info -->
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding: 0.75rem; background-color: #f8f9fa; border-radius: 6px; font-size: 0.85rem;">
                            @if($recipe->prep_time || $recipe->cook_time)
                                <div style="display: flex; align-items: center; gap: 0.25rem; color: #7f8c8d;">
                                    ⏱️ {{ ($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0) }}m
                                </div>
                            @endif
                            
                            @if($recipe->servings)
                                <div style="display: flex; align-items: center; gap: 0.25rem; color: #7f8c8d;">
                                    👥 {{ $recipe->servings }}
                                </div>
                            @endif
                            
                            <div style="display: flex; align-items: center; gap: 0.25rem; color: #7f8c8d;">
                                💬 {{ $recipe->comments->count() }}
                            </div>
                        </div>
                        
                        <div class="recipe-card-footer" style="flex-direction: column; gap: 1rem; align-items: stretch;">
                            <!-- Rating -->
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="stars">
                                    @php
                                        try {
                                            $avgRating = $recipe->averageRating();
                                            $totalRatings = $recipe->totalRatings();
                                            $filledStars = round($avgRating);
                                            // Ensure we have valid numbers
                                            $avgRating = is_numeric($avgRating) ? $avgRating : 0;
                                            $filledStars = is_numeric($filledStars) ? max(0, min(5, $filledStars)) : 0;
                                        } catch (Exception $e) {
                                            $avgRating = 0;
                                            $totalRatings = 0;
                                            $filledStars = 0;
                                        }
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $filledStars ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <span style="color: #7f8c8d; font-size: 0.875rem; font-weight: 600;">
                                    {{ number_format($avgRating, 1) }} ({{ $totalRatings }})
                                </span>
                            </div>
                            
                            <!-- View Button -->
                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-primary" style="width: 100%; text-align: center; padding: 0.75rem; font-weight: 600; box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);">
                                View Recipe →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            {{ $recipes->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 4rem 2rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 2px dashed #dee2e6;">
            <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;">🔍</div>
            <h2 style="font-size: 1.5rem; color: #2c3e50; margin-bottom: 0.5rem; font-weight: 700;">No Recipes Found</h2>
            <p style="color: #7f8c8d; margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.6;">
                We couldn't find any recipes matching your search criteria.<br>
                Try adjusting your filters or browse all recipes.
            </p>
            @if(request('search') || request('category'))
                <a href="{{ route('recipes.index') }}" class="btn btn-primary" style="padding: 0.875rem 2rem; font-weight: 600;">
                    🍳 Browse All Recipes
                </a>
            @endif
        </div>
    @endif
</div>

<style>
    .hero {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        min-height: 340px;
        margin-bottom: 2.25rem;
        background-image: url("{{ asset('image/login2.jpg') }}");
        background-size: cover;
        background-position: center;
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(44, 62, 80, 0.75) 0%, rgba(102, 126, 234, 0.45) 100%);
    }

    .hero-inner {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 3.25rem 1.5rem;
        color: white;
        gap: 0.75rem;
    }

    .hero-title {
        margin: 0;
        font-size: 3rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
        text-shadow: 0 10px 30px rgba(0,0,0,0.35);
    }

    .hero-subtitle {
        margin: 0;
        max-width: 820px;
        color: rgba(255,255,255,0.92);
        font-size: 1.05rem;
        line-height: 1.6;
    }

    .hero-search {
        margin-top: 1.25rem;
        width: 100%;
        max-width: 760px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 0.75rem;
        align-items: center;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 16px;
        padding: 0.75rem;
        backdrop-filter: blur(10px);
    }

    .hero-search-input {
        width: 100%;
        border: none;
        outline: none;
        border-radius: 12px;
        padding: 0.95rem 1rem;
        font-size: 1rem;
        background: rgba(255,255,255,0.96);
        box-shadow: 0 6px 16px rgba(0,0,0,0.18);
    }

    .hero-search-btn {
        padding: 0.95rem 1.25rem;
        border-radius: 12px;
        white-space: nowrap;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .search-panel {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 22px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.06);
    }

    .search-panel-form {
        display: grid;
        grid-template-columns: 1fr 280px auto;
        gap: 1rem;
        align-items: end;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #eef1f4;
    }

    .search-panel-label {
        font-size: 0.8rem;
        font-weight: 800;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.5rem;
    }

    .search-panel-input {
        width: 100%;
        padding: 0.9rem 1rem;
        border: 2px solid #e1e8ed;
        border-radius: 12px;
        background: #fff;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .search-panel-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
    }

    .search-panel-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    .search-panel-btn {
        padding: 0.9rem 1.25rem;
        border-radius: 12px;
        min-width: 110px;
    }

    .search-panel-chips {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
        padding-top: 1rem;
    }

    .search-panel-chips-label {
        color: #7f8c8d;
        font-weight: 600;
        margin-right: 0.25rem;
        font-size: 0.9rem;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 0.9rem;
        border-radius: 999px;
        border: 1px solid #e1e8ed;
        color: #2c3e50;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        background: #f8f9fa;
        transition: all 0.2s ease;
    }

    .chip:hover {
        transform: translateY(-1px);
        border-color: rgba(102, 126, 234, 0.5);
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        background: white;
    }

    .featured-heading {
        text-align: center;
        margin: 2.5rem 0 1.25rem;
    }

    .featured-title {
        margin: 0;
        font-size: 2rem;
        color: #2c3e50;
        letter-spacing: -0.02em;
    }

    .featured-subtitle {
        margin: 0.5rem 0 0;
        color: #7f8c8d;
        font-size: 1rem;
    }

    .recipe-card:hover img {
        transform: scale(1.05);
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.25rem;
        }

        .hero-search {
            grid-template-columns: 1fr;
        }

        .search-panel-form {
            grid-template-columns: 1fr;
        }

        .search-panel-actions {
            justify-content: stretch;
        }

        .search-panel-btn {
            width: 100%;
        }
    }
</style>
@endsection