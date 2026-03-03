@extends('layouts.app')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 2rem;">Manage Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">+ Add New Category</a>
    </div>
    
    @if($categories->count() > 0)
        <div class="card">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Recipes Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>{{ $category->recipes_count }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Edit</a>
                                        
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;" onclick="return confirm('Are you sure? This will fail if category has recipes.')">Delete</button>
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
            {{ $categories->links() }}
        </div>
    @else
        <div class="card">
            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">
                No categories yet. <a href="{{ route('admin.categories.create') }}" style="color: #3498db;">Create your first category!</a>
            </p>
        </div>
    @endif
</div>
@endsection