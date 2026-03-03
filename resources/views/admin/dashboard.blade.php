@extends('layouts.app')

@section('content')
<div>
    <h1 style="font-size: 2rem; margin-bottom: 2rem;">Admin Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="card" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $stats['total_recipes'] }}</h3>
            <p style="opacity: 0.9;">Total Recipes</p>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $stats['pending_recipes'] }}</h3>
            <p style="opacity: 0.9;">Pending Approval</p>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $stats['approved_recipes'] }}</h3>
            <p style="opacity: 0.9;">Approved</p>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $stats['rejected_recipes'] }}</h3>
            <p style="opacity: 0.9;">Rejected</p>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $stats['total_users'] }}</h3>
            <p style="opacity: 0.9;">Total Users</p>
        </div>
        
        <div class="card" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%); color: white;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $stats['total_categories'] }}</h3>
            <p style="opacity: 0.9;">Categories</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">Quick Actions</h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.recipes.index', ['status' => 'pending']) }}" class="btn btn-warning">Review Pending Recipes</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Manage Categories</a>
            <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">View All Recipes</a>
        </div>
    </div>
    
    <!-- Recent Recipes -->
    <div class="card">
        <h2 style="margin-bottom: 1rem;">Recent Recipes</h2>
        
        @if($recent_recipes->count() > 0)
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
                        @foreach($recent_recipes as $recipe)
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
                                    <a href="{{ route('admin.recipes.show', $recipe->id) }}" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Review</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">No recipes yet.</p>
        @endif
    </div>
</div>
@endsection