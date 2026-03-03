@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem 0;">
    <div class="card">
        <!-- Recipe Header -->
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div style="flex: 1; min-width: 300px;">
                <h1 style="margin: 0 0 0.5rem 0; color: #2c3e50; font-size: 2.5rem;">{{ $recipe->title }}</h1>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                    <span class="badge badge-primary">{{ $recipe->category->name }}</span>
                    @if($recipe->prep_time)
                        <span style="color: #6c757d; font-size: 0.9rem;">
                            ⏱️ Prep: {{ $recipe->prep_time }} min
                        </span>
                    @endif
                    @if($recipe->cook_time)
                        <span style="color: #6c757d; font-size: 0.9rem;">
                            🔥 Cook: {{ $recipe->cook_time }} min
                        </span>
                    @endif
                    @if($recipe->servings)
                        <span style="color: #6c757d; font-size: 0.9rem;">
                            👥 Servings: {{ $recipe->servings }}
                        </span>
                    @endif
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; color: #6c757d;">
                    @if($recipe->user && $recipe->user->profile_picture)
                        <img src="{{ asset('storage/' . $recipe->user->profile_picture) }}" alt="{{ $recipe->user->name }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(102, 126, 234, 0.25);">
                    @else
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.9rem;">
                            {{ strtoupper(substr($recipe->user->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <span>By {{ $recipe->user->name ?? 'Unknown' }}</span>
                    <span>•</span>
                    <span>{{ $recipe->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            
            @if(Auth::check())
                <div style="display: flex; gap: 0.5rem;">
                    <form action="{{ route('recipes.save', $recipe->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @if($isSaved)
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Unsave recipe">
                                ❤️ Saved
                            </button>
                        @else
                            <button type="submit" class="btn btn-outline-primary btn-sm" title="Save recipe">
                                🤍 Save
                            </button>
                        @endif
                    </form>
                    @if(Auth::id() === $recipe->user_id)
                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-outline-secondary btn-sm">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this recipe?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                🗑️ Delete
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        <!-- Recipe Image -->
        @if($recipe->image)
            <div style="margin-bottom: 2rem;">
                <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" 
                     style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            </div>
        @endif

        <!-- Recipe Content -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
            <!-- Description -->
            <div>
                <h2 style="color: #2c3e50; margin-bottom: 1rem;">Description</h2>
                <p style="color: #555; line-height: 1.6; white-space: pre-wrap;">{{ $recipe->description }}</p>
            </div>

            <!-- Ingredients -->
            <div>
                <h2 style="color: #2c3e50; margin-bottom: 1rem;">Ingredients</h2>
                <ul style="color: #555; line-height: 1.8; padding-left: 1.5rem;">
                    @foreach(explode("\n", $recipe->ingredients) as $ingredient)
                        <li>{{ trim($ingredient) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Instructions -->
        <div style="margin-bottom: 2rem;">
            <h2 style="color: #2c3e50; margin-bottom: 1rem;">Instructions</h2>
            <div style="color: #555; line-height: 1.8;">
                @php
                    $steps = explode("\n", $recipe->ingredients);
                    $instructions = explode("\n", $recipe->instructions);
                @endphp
                @foreach($instructions as $index => $instruction)
                    @if(trim($instruction))
                        <div style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
                            <div style="background: #dc3545; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: bold;">
                                {{ $index + 1 }}
                            </div>
                            <div style="flex: 1;">{{ trim($instruction) }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Rating Section -->
        @if(Auth::check())
            <div style="border-top: 1px solid #e9ecef; padding-top: 2rem; margin-bottom: 2rem;">
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">Rate this Recipe</h3>
                <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST">
                    @csrf
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="display: flex; gap: 0.25rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="submit" name="rating" value="{{ $i }}" 
                                        class="btn {{ $userRating && $userRating->rating >= $i ? 'btn-warning' : 'btn-outline-secondary' }}" 
                                        style="border: none; background: none; font-size: 1.5rem; cursor: pointer;">
                                    {{ $userRating && $userRating->rating >= $i ? '⭐' : '☆' }}
                                </button>
                            @endfor
                        </div>
                        <span style="color: #6c757d;">
                            {{ $userRating ? 'Your rating: ' . $userRating->rating . ' stars' : 'Click to rate' }}
                        </span>
                    </div>
                </form>
            </div>
        @endif

        <!-- Comments Section -->
        <div style="border-top: 1px solid #e9ecef; padding-top: 2rem;">
            <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">
                Comments ({{ $recipe->comments->count() }})
            </h3>

            @if(Auth::check())
                <form action="{{ route('comments.store', $recipe->id) }}" method="POST" style="margin-bottom: 2rem;">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="3" placeholder="Share your thoughts about this recipe..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
            @else
                <p style="color: #6c757d; margin-bottom: 2rem;">
                    <a href="{{ route('login') }}">Login</a> to post a comment.
                </p>
            @endif

            @if($recipe->comments->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @foreach($recipe->comments as $comment)
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px;">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="{{ $comment->user->name }}" 
                                     style="width: 40px; height: 40px; border-radius: 50%;">
                                <div>
                                    <div style="font-weight: 600; color: #2c3e50;">{{ $comment->user->name }}</div>
                                    <div style="color: #6c757d; font-size: 0.875rem;">{{ $comment->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                @if(Auth::check() && Auth::id() === $comment->user_id)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="margin-left: auto;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this comment?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p style="color: #555; line-height: 1.6; margin: 0;">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: #6c757d; text-align: center; padding: 2rem;">
                    No comments yet. Be the first to share your thoughts!
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
