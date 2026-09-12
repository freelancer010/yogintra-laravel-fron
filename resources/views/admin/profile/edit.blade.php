@extends('layouts.admin')

@section('title', 'Profile Settings')

@push('styles')
<style>
  .profile-photo-upload { display:flex; align-items:center; gap:18px; padding:16px; border:1px dashed #9dcfd3; border-radius:12px; background:#f7fcfc; }
  .profile-photo-preview { width:82px; height:82px; flex:0 0 82px; border-radius:50%; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#0f7c87; color:#fff; font-size:27px; font-weight:700; border:4px solid #d9f0f1; }
  .profile-photo-preview img { width:100%; height:100%; object-fit:cover; }
  .profile-photo-copy { min-width:0; }
  .profile-photo-copy strong { color:#183c45; display:block; font-size:14px; }
  .profile-photo-copy small { color:#6b7f86; display:block; margin:4px 0 10px; }
  .profile-photo-select { position:relative; overflow:hidden; display:inline-flex; align-items:center; gap:6px; cursor:pointer; }
  .profile-photo-select input { position:absolute; inset:0; opacity:0; cursor:pointer; }
  @media (max-width: 480px) { .profile-photo-upload { align-items:flex-start; } }
</style>
@endpush

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profile Settings</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @include('admin.partials.flash')

        <!-- Profile Information Form -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update Profile Information</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="user_photo">Profile Photo</label>
                                <div class="profile-photo-upload">
                                    <div class="profile-photo-preview" id="profile-photo-preview">
                                        @if($user->user_photo)
                                            <img src="{{ asset($user->user_photo) }}" alt="Current profile photo">
                                        @else
                                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name ?? 'A', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="profile-photo-copy">
                                        <strong>Profile picture</strong>
                                        <small id="profile-photo-name">Upload a square JPG, PNG, or WebP image.</small>
                                        <label class="btn btn-outline-primary btn-sm profile-photo-select mb-0">
                                            <i class="fas fa-camera"></i> Choose photo
                                            <input type="file"
                                                   class="@error('user_photo') is-invalid @enderror"
                                                   id="user_photo"
                                                   name="user_photo"
                                                   accept="image/png,image/jpeg,image/webp">
                                        </label>
                                    </div>
                                </div>
                                @error('user_photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.password') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" id="toggleCurrentPassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Password must be at least 8 characters long.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" id="togglePasswordConfirmation" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Show a local preview before the profile form is saved.
document.getElementById('user_photo').addEventListener('change', function(e) {
    if(e.target.files[0]) {
        var fileName = e.target.files[0].name;
        document.getElementById('profile-photo-name').innerText = fileName;
        var reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('profile-photo-preview').innerHTML = '<img src="' + event.target.result + '" alt="New profile photo preview">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Password visibility toggle
function togglePasswordVisibility(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
    togglePasswordVisibility('current_password', 'toggleCurrentPassword');
});

document.getElementById('togglePassword').addEventListener('click', function() {
    togglePasswordVisibility('password', 'togglePassword');
});

document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
    togglePasswordVisibility('password_confirmation', 'togglePasswordConfirmation');
});
</script>
@endsection
