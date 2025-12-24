<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Themesbrand" name="author" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="assets/images/favicon.ico">
  <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
    type="text/css" />
  <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />
  <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    :root {
      --telkom-red: #E30613;
      --telkom-red-dark: #C8161D;
      --telkom-red-light: #ffebee;
    }
    
    body {
      background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
      position: relative;
      overflow-x: hidden;
    }
    
    body::before {
      content: '';
      position: fixed;
      top: -50%;
      right: -10%;
      width: 60%;
      height: 120%;
      background: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-dark) 100%);
      border-radius: 50%;
      opacity: 0.08;
      z-index: -1;
    }
    
    body::after {
      content: '';
      position: fixed;
      bottom: -30%;
      left: -10%;
      width: 50%;
      height: 80%;
      background: linear-gradient(135deg, var(--telkom-red-dark) 0%, var(--telkom-red) 100%);
      border-radius: 50%;
      opacity: 0.06;
      z-index: -1;
    }
    
    .account-pages {
      position: relative;
      z-index: 1;
    }
    
    .card {
      border: none;
      box-shadow: 0 10px 40px rgba(227, 6, 19, 0.1);
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.95);
    }
    
    .btn-telkom {
      background-color: var(--telkom-red);
      border-color: var(--telkom-red);
      color: white;
    }
    
    .btn-telkom:hover {
      background-color: var(--telkom-red-dark);
      border-color: var(--telkom-red-dark);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(227, 6, 19, 0.3);
      transition: all 0.3s ease;
    }
    
    .text-telkom {
      color: var(--telkom-red) !important;
    }
    
    .bg-telkom-light {
      background-color: var(--telkom-red-light);
    }
    
    .form-control:focus {
      border-color: var(--telkom-red);
      box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.25);
    }
    
    .form-select:focus {
      border-color: var(--telkom-red);
      box-shadow: 0 0 0 0.2rem rgba(227, 6, 19, 0.25);
    }
    
    .form-check-input:checked {
      background-color: var(--telkom-red);
      border-color: var(--telkom-red);
    }
    
    a.text-telkom:hover {
      color: var(--telkom-red-dark) !important;
    }
  </style>
</head>

<body>
  <div class="account-pages my-5 pt-sm-5">
    <div class="container">
      @if (session()->has('success'))
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="alert alert-success alert-dismissible show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        </div>
      @endif
      
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card overflow-hidden">
            <div class="card-body">
              <div class="text-center mb-4">
                <a href="/dashboard" class="d-block">
                  <img src="{{ asset('assets/images/logo-sm.svg') }}" alt="" height="28">
                  <span class="logo-txt text-telkom fw-bold">Telkom Infrastruktur</span>
                </a>
              </div>
              
              <div class="text-center mb-4">
                <h5 class="mb-1">Welcome Back!</h5>
                <p class="text-muted">Sign in to your account</p>
              </div>
              
              <div class="p-2">
                <form class="form-horizontal" action="/signin" method="post">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label" for="login">Username or Telegram Username</label>
                    <input type="text" name="login" id="login"
                      class="form-control @error('login') is-invalid @enderror"
                      placeholder="Enter username or Telegram" value="{{ old('login') }}" required autofocus>
                    @error('login')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group auth-pass-inputgroup">
                      <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Enter password"
                        required>
                      <button class="btn btn-light" type="button" id="togglePassword"><i
                          class="mdi mdi-eye-outline"></i></button>
                    </div>
                    @error('password')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label" for="captcha">Captcha</label>
                    <div class="d-flex align-items-center mb-2">
                      <img id="captcha-img" src="{{ captcha_src('mini') }}" alt="captcha">
                      <button type="button" id="refresh-captcha" class="btn btn-link p-0 ms-2">🔄</button>
                    </div>
                    <input type="text" name="captcha" id="captcha"
                      class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha"
                      required>
                    @error('captcha')
                      <span class="text-danger">Invalid Captcha</span>
                    @enderror
                  </div>
                  
                  <div class="mt-3 d-grid">
                    <button class="btn btn-telkom waves-effect waves-light" type="submit">Sign In</button>
                  </div>
                </form>
                
                <div class="mt-4 text-center">
                  <p class="text-muted mb-0">Don't have an account? <a href="/signup"
                      class="text-telkom fw-semibold">Sign up now</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/libs/jquery/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/metismenu/metisMenu.min.js"></script>
  <script src="assets/libs/simplebar/simplebar.min.js"></script>
  <script src="assets/libs/node-waves/waves.min.js"></script>
  <script src="assets/libs/feather-icons/feather.min.js"></script>
  <script src="assets/libs/pace-js/pace.min.js"></script>
  <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
      let passwordInput = document.getElementById('password');
      let eyeIcon = document.getElementById('togglePassword').querySelector('i');
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("mdi-eye-outline");
        eyeIcon.classList.add("mdi-eye-off-outline");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("mdi-eye-off-outline");
        eyeIcon.classList.add("mdi-eye-outline");
      }
    });

    document.getElementById('refresh-captcha').addEventListener('click', function() {
      fetch('/refresh-captcha')
        .then(response => response.json())
        .then(data => {
          document.getElementById('captcha-img').src = data.captcha + '?t=' + new Date().getTime();
        })
        .catch(error => console.error('Error refreshing captcha:', error));
    });
  </script>
</body>

</html>