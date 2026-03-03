@extends('layouts.app')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 2rem;">My Recipes</h1>
        <a href="{{ route('recipes.create') }}" class="btn btn-success">+ Submit New Recipe</a>
    </div>
    
    @if($recipes->count() > 0)
        <div class="card">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipes as $recipe)
                            <tr>
                                <td>{{ $recipe->title }}</td>
                                <td>{{ $recipe->category->name }}</td>
                                <td>
                                    @if($recipe->status === 'pending')
                                        <span class="badge badge-pending">Pending</span>
                                    @elseif($recipe->status === 'approved')
                                        <span class="badge badge-approved">Approved</span>
                                    @else
                                        <span class="badge badge-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $recipe->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        @if($recipe->status === 'approved')
                                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">View</a>
                                        @endif
                                        
                                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-warning" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Edit</a>
                                        
                                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</button>
                                        </form>
                                    </div>
                                    
                                    @if($recipe->status === 'rejected' && $recipe->admin_notes)
                                        <p style="color: #e74c3c; font-size: 0.875rem; margin-top: 0.5rem;">
                                            <strong>Admin Note:</strong> {{ $recipe->admin_notes }}
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            {{ $recipes->links() }}
        </div>
    @else
        <div class="card">
            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">
                You haven't submitted any recipes yet. <a href="{{ route('recipes.create') }}" style="color: #3498db;">Submit your first recipe!</a>
            </p>
        </div>
    @endif
</div>
@endsection