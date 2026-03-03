@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- Enhanced Page Header -->
    <div style="text-align: center; margin-bottom: 3rem; padding: 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%); transform: translateX(-100%); animation: shimmer 3s infinite;"></div>
        <style>
            @keyframes shimmer {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
        </style>
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; color: white; font-weight: 700; position: relative; z-index: 1;">Profile Settings</h1>
        <p style="font-size: 1.1rem; color: rgba(255,255,255,0.9); position: relative; z-index: 1;">Manage your account settings and preferences</p>
    </div>
    
    <!-- Enhanced Profile Picture -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 class="card-header">📷 Profile Picture</h2>
        
        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
            <div style="position: relative;">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #667eea; box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3); transition: all 0.3s ease;">
                @else
                    <div style="width: 150px; height: 150px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold; box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3); transition: all 0.3s ease;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div style="position: absolute; bottom: 5px; right: 5px; width: 40px; height: 40px; background: #27ae60; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    ✓
                </div>
            </div>
            
            <div style="flex: 1;">
                <div style="margin-bottom: 1rem;">
                    <h3 style="font-size: 1.5rem; color: #2c3e50; margin-bottom: 0.25rem;">{{ auth()->user()->name }}</h3>
                    <p style="color: #7f8c8d; margin-bottom: 0;">{{ auth()->user()->email }}</p>
                </div>
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    
                    <div class="form-group">
                        <label class="form-label">📤 Upload New Picture</label>
                        <input type="file" name="profile_picture" class="form-control" accept="image/*">
                        @error('profile_picture')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                            📤 Upload Picture
                        </button>
                        
                        @if(auth()->user()->profile_picture)
                            <form method="POST" action="{{ route('profile.picture.remove') }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Remove profile picture?')" style="padding: 0.75rem 1.5rem;">
                                    🗑️ Remove Picture
                                </button>
                            </form>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Profile Information -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 class="card-header">👤 Profile Information</h2>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            
            <div class="form-group">
                <label class="form-label">📝 Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">📧 Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success" style="padding: 0.75rem 2rem;">
                💾 Update Profile
            </button>
        </form>
    </div>
    
    <!-- Enhanced User Statistics -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 class="card-header">📊 Your Statistics</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3); transition: all 0.3s ease;">
                <h3 style="font-size: 2.5rem; color: white; margin-bottom: 0.5rem; font-weight: 700;">{{ auth()->user()->recipes()->count() }}</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-weight: 500;">📝 Total Recipes</p>
            </div>
            
            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #27ae60 0%, #229954 100%); border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(39, 174, 96, 0.3); transition: all 0.3s ease;">
                <h3 style="font-size: 2.5rem; color: white; margin-bottom: 0.5rem; font-weight: 700;">{{ auth()->user()->recipes()->where('status', 'approved')->count() }}</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-weight: 500;">✅ Approved Recipes</p>
            </div>
            
            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(243, 156, 18, 0.3); transition: all 0.3s ease;">
                <h3 style="font-size: 2.5rem; color: white; margin-bottom: 0.5rem; font-weight: 700;">{{ auth()->user()->recipes()->where('status', 'pending')->count() }}</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-weight: 500;">⏳ Pending Recipes</p>
            </div>
            
            <div style="text-align: center; padding: 1.5rem; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); border-radius: 12px; color: white; box-shadow: 0 4px 6px rgba(231, 76, 60, 0.3); transition: all 0.3s ease;">
                <h3 style="font-size: 2.5rem; color: white; margin-bottom: 0.5rem; font-weight: 700;">{{ auth()->user()->savedRecipes()->count() }}</h3>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-weight: 500;">❤️ Saved Recipes</p>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Account Type -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 class="card-header">🔐 Account Information</h2>
        
        <div style="padding: 1.5rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #667eea;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <strong style="color: #2c3e50; font-size: 1.1rem;">Account Type:</strong>
                @if(auth()->user()->isAdmin())
                    <span class="badge badge-approved" style="padding: 0.5rem 1rem; font-size: 0.9rem;">👑 Administrator</span>
                @else
                    <span class="badge" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); padding: 0.5rem 1rem; font-size: 0.9rem;">👤 Regular User</span>
                @endif
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <strong style="color: #2c3e50; font-size: 1.1rem;">📧 Email:</strong>
                <span style="color: #7f8c8d; font-weight: 500;">{{ auth()->user()->email }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <strong style="color: #2c3e50; font-size: 1.1rem;">📅 Member Since:</strong>
                <span style="color: #7f8c8d; font-weight: 500;">{{ auth()->user()->created_at->format('F d, Y') }}</span>
            </div>
        </div>
    </div>
    
    <!-- Update Password -->
    <div class="card" style="margin-bottom: 2rem;">
        <h2 class="card-header">Update Password</h2>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
                @error('current_password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-success">Update Password</button>
        </form>
    </div>
    
    <!-- Delete Account -->
    <div class="card" style="border: 2px solid #e74c3c;">
        <h2 class="card-header" style="color: #e74c3c;">Delete Account</h2>
        
        <p style="color: #7f8c8d; margin-bottom: 1rem;">
            Once your account is deleted, all of your resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
        
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            
            <div class="form-group">
                <label class="form-label">Confirm your password to delete your account</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone!')">Delete Account</button>
        </form>
    </div>
</div>
@endsection