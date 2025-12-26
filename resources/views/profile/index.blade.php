<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  
  <style>
    :root {
      --telkom-red: #E30613;
      --telkom-red-dark: #C8161D;
      --telkom-red-light: #ffebee;
    }

    .form-control:focus {
      border-color: var(--telkom-red);
      box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.1);
      outline: none;
    }

    .btn-telkom {
      background: var(--telkom-red);
      color: white;
      border: none;
      border-radius: 6px;
      padding: 8px 20px;
    }

    .btn-telkom:hover {
      background: var(--telkom-red-dark);
      transform: translateY(-1px);
      transition: all 0.2s ease;
      color: white;
    }

    .btn-secondary-telkom {
      background: #e2e8f0;
      color: #4a5568;
      border: none;
      border-radius: 6px;
      padding: 8px 20px;
    }

    .btn-secondary-telkom:hover {
      background: #cbd5e0;
      transform: translateY(-1px);
      transition: all 0.2s ease;
    }

    .btn-change-photo {
      background: var(--telkom-red);
      color: white;
      border-radius: 6px;
      padding: 6px 16px;
    }

    .btn-change-photo:hover {
      background: var(--telkom-red-dark);
      color: white;
    }

    .badge {
      font-size: 0.75rem;
      padding: 4px 8px;
      font-weight: 600;
    }

    .alert {
      font-size: 0.9rem;
    }

    .alert ol {
      font-size: 0.875rem;
      line-height: 1.6;
    }

    .section-icon {
      color: var(--telkom-red);
    }
  </style>

  <div class="main-content">
    <div class="page-content" style="padding-top: 1rem;">
      <div class="container-fluid">
        <div class="container mx-auto" style="padding: 0 1rem;">
          <h1 class="fw-bold mb-3" style="color: #1a1a1a; font-size: 1.75rem;">Update Profile</h1>
          
          <!-- Success Alert -->
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
              <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <!-- Error Alert -->
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i>
              <strong>Please fix the following errors:</strong>
              <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="card shadow-sm p-4 border-0" style="background: #f8f9fa; border-radius: 12px;">
            <form action="/profile" method="post" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              
              <!-- Profile Picture Section -->
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
                <h3 class="mb-3 mb-md-0" style="color: #2d3748; font-size: 1.25rem;">Profile Information</h3>
                <div class="text-center">
                  <img id="profile_preview"
                    src="{{ filter_var(auth()->user()->profile_picture, FILTER_VALIDATE_URL)
                        ? auth()->user()->profile_picture
                        : asset('storage/' . auth()->user()->profile_picture) }}"
                    alt="Profile Picture" 
                    class="rounded-circle mb-3" 
                    style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--telkom-red-light);">
                  <div>
                    <input type="file" name="profile_picture" id="upload_profile" accept="image/*" hidden>
                    <button type="button" id="change_profile_picture" class="btn btn-sm btn-change-photo">
                      Change Photo
                    </button>
                  </div>
                </div>
              </div>
              
              <!-- Basic Info -->
              <div class="mb-3">
                <label for="name" class="form-label" style="color: #2d3748; font-weight: 500;">
                  Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" 
                  class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', auth()->user()->name) }}" 
                  required
                  style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              
              <div class="mb-4">
                <label for="username" class="form-label" style="color: #2d3748; font-weight: 500;">
                  Username <span class="text-danger">*</span>
                </label>
                <input type="text" id="username" name="username" 
                  class="form-control @error('username') is-invalid @enderror"
                  value="{{ old('username', auth()->user()->username) }}" 
                  required
                  style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Contact Information Section -->
              <div class="border-top pt-4 mt-4">
                <h3 class="mb-3" style="color: #2d3748; font-size: 1.25rem;">
                  <i class="fas fa-bell me-2 section-icon"></i>Notification Settings
                </h3>
                <p class="text-muted small mb-4">Configure how you want to receive reminders and notifications</p>

                <!-- Email -->
                <div class="mb-3">
                  <label for="email" class="form-label d-flex align-items-center" style="color: #2d3748; font-weight: 500;">
                    <i class="fas fa-envelope me-2 text-secondary"></i>Email Address
                    @if(auth()->user()->email)
                      <span class="badge bg-success ms-2">Connected</span>
                    @else
                      <span class="badge bg-warning ms-2">Not Connected</span>
                    @endif
                  </label>
                  <input type="email" 
                         id="email" 
                         name="email" 
                         class="form-control @error('email') is-invalid @enderror"
                         value="{{ old('email', auth()->user()->email) }}" 
                         placeholder="your.email@example.com"
                         style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="text-muted">Required for email reminders and notifications</small>
                </div>

                <!-- Telegram ID -->
                <div class="mb-3">
                  <label for="telegram_id" class="form-label d-flex align-items-center" style="color: #2d3748; font-weight: 500;">
                    <i class="fab fa-telegram me-2 text-info"></i>Telegram Chat ID
                    @if(auth()->user()->telegram_id)
                      <span class="badge bg-success ms-2">Connected</span>
                    @else
                      <span class="badge bg-warning ms-2">Not Connected</span>
                    @endif
                  </label>
                  <input type="text" 
                         id="telegram_id" 
                         name="telegram_id" 
                         class="form-control @error('telegram_id') is-invalid @enderror"
                         value="{{ old('telegram_id', auth()->user()->telegram_id) }}" 
                         placeholder="123456789"
                         style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                  @error('telegram_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  
                  @if(!auth()->user()->telegram_id)
                    <div class="alert alert-info mt-2 mb-0" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 8px;">
                      <strong><i class="fas fa-info-circle me-1"></i>How to get your Telegram ID:</strong>
                      <ol class="mb-0 mt-2 ps-3">
                        <li>Open Telegram and search for your bot</li>
                        <li>Send any message to the bot (e.g., "/start")</li>
                        <li>The bot will reply with your Chat ID</li>
                        <li>Copy and paste the ID here</li>
                      </ol>
                    </div>
                  @else
                    <div class="alert alert-success mt-2 mb-0" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 8px;">
                      <i class="fas fa-check-circle me-2"></i>
                      Telegram connected! You can now receive reminders via Telegram.
                    </div>
                  @endif
                </div>
              </div>

              <!-- Password Change Section (Optional) -->
              <div class="border-top pt-4 mt-4">
                <h3 class="mb-3" style="color: #2d3748; font-size: 1.25rem;">
                  <i class="fas fa-lock me-2 text-warning"></i>Change Password (Optional)
                </h3>
                <p class="text-muted small mb-4">Leave blank if you don't want to change your password</p>

                <div class="mb-3">
                  <label for="current_password" class="form-label" style="color: #2d3748; font-weight: 500;">
                    Current Password
                  </label>
                  <input type="password" 
                         id="current_password" 
                         name="current_password" 
                         class="form-control @error('current_password') is-invalid @enderror"
                         placeholder="Enter your current password"
                         style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                  @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label" style="color: #2d3748; font-weight: 500;">
                    New Password
                  </label>
                  <input type="password" 
                         id="password" 
                         name="password" 
                         class="form-control @error('password') is-invalid @enderror"
                         placeholder="Enter new password"
                         style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="password_confirmation" class="form-label" style="color: #2d3748; font-weight: 500;">
                    Confirm New Password
                  </label>
                  <input type="password" 
                         id="password_confirmation" 
                         name="password_confirmation" 
                         class="form-control"
                         placeholder="Confirm new password"
                         style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary-telkom">
                  Cancel
                </a>
                <button type="submit" class="btn btn-telkom">
                  <i class="fas fa-save me-2"></i>Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const uploadButton = document.getElementById("change_profile_picture");
      const fileInput = document.getElementById("upload_profile");
      const profilePreview = document.getElementById("profile_preview");

      if (uploadButton && fileInput && profilePreview) {
        uploadButton.addEventListener("click", function() {
          fileInput.click();
        });

        fileInput.addEventListener("change", function(event) {
          const file = event.target.files[0];

          if (file) {
            if (!file.type.startsWith('image/')) {
              alert('Please select an image file');
              return;
            }

            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
              alert('File size must be less than 2MB');
              return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
              profilePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        });
      }
    });
  </script>
</x-layout>