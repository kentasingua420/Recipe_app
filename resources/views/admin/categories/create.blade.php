@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <h1 class="card-header">Create New Category</h1>
        
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">Create Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection