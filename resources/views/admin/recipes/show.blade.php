@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">← Back to Recipes</a>
    </div>
    
    <div class="card">
        <!-- Recipe Status Actions -->
        <div style="background-color: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">Recipe Status: 
                @if($recipe->status === 'pending')
                    <span class="badge badge-pending">Pending</span>
                @elseif($recipe->status === 'approved')
                    <span class="badge badge-approved">Approved</span>
                @else
                    <span class="badge badge-rejected">Rejected</span>
                @endif
            </h3>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                @if($recipe->status !== 'approved')
                    <form action="{{ route('admin.recipes.approve', $recipe->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Approve this recipe?')">✓ Approve Recipe</button>
                    </form>
                @endif
                
                @if($recipe->status !== 'rejected')
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('reject-form').style.display='block'">✗ Reject Recipe</button>
                @endif
            </div>
            
            <!-- Reject Form (Hidden by default) -->
            <div id="reject-form" style="display: none; margin-top: 1rem; padding: 1rem; background: white; border-radius: 8px;">
                <form action="{{ route('admin.recipes.reject', $recipe->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Reason for Rejection *</label>
                        <textarea name="admin_notes" class="form-control" required placeholder="Provide detailed feedback for the user..."></textarea>
                        @error('admin_notes')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn btn-danger">Submit Rejection</button>
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('reject-form').style.display='none'">Cancel</button>
                    </div>
                </form>
            </div>
            
            @if($recipe->admin_notes)
                <div style="margin-top: 1rem; padding: 1rem; background: #fff3cd; border-radius: 8px;">
                    <strong>Previous Admin Notes:</strong>
                    <p style="margin-top: 0.5rem;">{{ $recipe->admin_notes }}</p>
                </div>
            @endif
        </div>
        
        <!-- Recipe Details -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $recipe->title }}</h1>
            <p style="color: #7f8c8d;">
                Submitted by <strong>{{ $recipe->user->name }}</strong> ({{ $recipe->user->email }}) • 
                {{ $recipe->created_at->format('M d, Y') }}
            </p>
            <span class="recipe-card-category">{{ $recipe->category->name }}</span>
        </div>
        
        <!-- Recipe Image -->
        @if($recipe->image)
            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 2rem;">
        @endif
        
        <!-- Recipe Info -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 2rem; padding: 1rem; background-color: #f8f9fa; border-radius: 8px;">
            @if($recipe->prep_time)
                <div>
                    <strong>Prep Time:</strong>
                    <p>{{ $recipe->prep_time }} mins</p>
                </div>
            @endif
            
            @if($recipe->cook_time)
                <div>
                    <strong>Cook Time:</strong>
                    <p>{{ $recipe->cook_time }} mins</p>
                </div>
            @endif
            
            @if($recipe->servings)
                <div>
                    <strong>Servings:</strong>
                    <p>{{ $recipe->servings }}</p>
                </div>
            @endif
            
            <div>
                <strong>Rating:</strong>
                <div class="stars">
                    @php
                        $avgRating = round($recipe->averageRating());
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $avgRating ? 'filled' : '' }}">★</span>
                    @endfor
                    <span style="margin-left: 0.5rem;">({{ $recipe->totalRatings() }})</span>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Description</h2>
            <p style="line-height: 1.8;">{{ $recipe->description }}</p>
        </div>
        
        <!-- Ingredients -->
        <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Ingredients</h2>
            <div style="background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; white-space: pre-line;">{{ $recipe->ingredients }}</div>
        </div>
        
        <!-- Instructions -->
        <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Instructions</h2>
            <div style="background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; white-space: pre-line;">{{ $recipe->instructions }}</div>
        </div>
        
        <!-- Comments -->
        @if($recipe->comments->count() > 0)
            <div>
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Comments ({{ $recipe->comments->count() }})</h2>
                @foreach($recipe->comments as $comment)
                    <div style="padding: 1rem; background-color: #f8f9fa; border-radius: 8px; margin-bottom: 1rem;">
                        <div style="margin-bottom: 0.5rem;">
                            <strong>{{ $comment->user->name }}</strong>
                            <span style="color: #7f8c8d; font-size: 0.875rem; margin-left: 0.5rem;">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p>{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection