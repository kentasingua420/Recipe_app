@extends('layouts.app')

@section('content')
<div>
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Manage Recipes</h1>
    
    <!-- Filter by Status -->
    <div style="margin-bottom: 2rem;">
        <form action="{{ route('admin.recipes.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <select name="status" class="form-control" style="width: auto;">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request('status'))
                <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>
    
    @if($recipes->count() > 0)
        <div class="card">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
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
                                <td>{{ $recipe->user->name }}</td>
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
                                        <a href="{{ route('admin.recipes.show', $recipe->id) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Review</a>
                                        
                                        <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;" onclick="return confirm('Are you sure you want to delete this recipe?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            {{ $recipes->appends(request()->query())->links() }}
        </div>
    @else
        <div class="card">
            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">No recipes found.</p>
        </div>
    @endif
</div>
@endsection