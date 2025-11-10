<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="main-content">
    <div class="page-content" style="padding-top: 1rem;">
      <div class="container-fluid">
        <div class="container mx-auto" style="padding: 0 1rem;">
          <h1 class="fw-bold mb-3" style="color: #1a1a1a; font-size: 1.75rem;">Update Profile</h1>
          <div class="card shadow-sm p-4 border-0" style="background: #f8f9fa; border-radius: 12px;">
            <form action="/profile" method="post" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
                <h3 class="mb-3 mb-md-0" style="color: #2d3748; font-size: 1.25rem;">Profile Information</h3>
                <div class="text-center">
                  <img id="profile_preview"
                    src="{{ filter_var(auth()->user()->profile_picture, FILTER_VALIDATE_URL)
                        ? auth()->user()->profile_picture
                        : asset('storage/' . auth()->user()->profile_picture) }}"
                    alt="Profile Picture" 
                    class="rounded-circle mb-3" 
                    style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #e2e8f0;">
                  <div>
                    <input type="file" name="profile_picture" id="upload_profile" accept="image/*" hidden>
                    <button type="button" id="change_profile_picture" class="btn btn-sm" 
                      style="background: #4a5568; color: white; border-radius: 6px; padding: 6px 16px;">
                      Change Photo
                    </button>
                    <button type="submit" id="submit_form" hidden></button>
                  </div>
                </div>
              </div>
              
              <div class="mb-3">
                <label for="name" class="form-label" style="color: #2d3748; font-weight: 500;">Name</label>
                <input type="text" id="name" name="name" 
                  class="form-control"
                  value="{{ auth()->user()->name }}" 
                  style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
              </div>
              
              <div class="mb-4">
                <label for="username" class="form-label" style="color: #2d3748; font-weight: 500;">Username</label>
                <input type="text" id="username" name="username" 
                  class="form-control"
                  value="{{ auth()->user()->username }}" 
                  style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; background: white;">
              </div>
              
              <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn" 
                  style="background: #e2e8f0; color: #4a5568; border: none; border-radius: 6px; padding: 8px 20px;">
                  Cancel
                </button>
                <button type="submit" class="btn" 
                  style="background: #4a5568; color: white; border: none; border-radius: 6px; padding: 8px 20px;">
                  Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .form-control:focus {
      border-color: #4a5568;
      box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
      outline: none;
    }

    .btn:hover {
      opacity: 0.9;
    }
  </style>

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