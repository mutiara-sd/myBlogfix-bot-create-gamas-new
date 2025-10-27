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
</head>

<body>
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible show max-w-md" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="auth-page">
      <div class="container-fluid p-0">
        <div class="row g-0">
          <div class="col-xxl-3 col-lg-4 col-md-5">
            <div class="auth-full-page-content d-flex p-sm-5 p-4">
              <div class="w-100">
                <div class="d-flex flex-column h-100">
                  <div class="mb-4 mb-md-5 text-center">
                    <a href="/dashboard" class="d-block auth-logo">
                      <img src="{{ asset('assets/images/logo-sm.svg') }}" alt="" height="28">
                      <span class="logo-txt">Minia</span>
                    </a>
                  </div>
                  <div class="auth-content my-auto">
                    <div class="text-center">
                      <h5 class="mb-0">Welcome Back!</h5>
                      <p class="text-muted mt-2">Sign in to your account</p>
                    </div>
                    <form class="custom-form pt-2" action="/signin" method="post">
                      @csrf
                      <div class="mb-3">
                        <label class="form-label" for="login">Username or Telegram
                          Username</label>
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
                          <button class="btn btn-light ms-0" type="button" id="togglePassword"><i
                              class="mdi mdi-eye-outline"></i></button>
                        </div>
                        @error('password')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="captcha">Captcha</label>
                        <div class="d-flex align-items-center">
                          <img id="captcha-img" src="{{ captcha_src('mini') }}" alt="captcha">
                          <button type="button" id="refresh-captcha" class="btn btn-link p-0 ms-2">🔄</button>
                        </div>
                        <input type="text" name="captcha" id="captcha"
                          class="form-control mt-2 @error('captcha') is-invalid @enderror" placeholder="Enter Captcha"
                          required>
                        @error('captcha')
                          <span class="text-danger">Invalid Captcha</span>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Sign In</button>
                      </div>
                    </form>
                    <div class="mt-3 text-center">
                      <p class="text-muted mb-0">Don't have an account? <a href="/signup"
                          class="text-primary fw-semibold">Sign up now</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-9 col-lg-8 col-md-7">
            <div class="auth-bg pt-md-5 p-4 d-flex">
              <div class="bg-overlay bg-primary"></div>
              <ul class="bg-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
              </ul>
              <div class="row justify-content-center align-items-center">
                <div class="col-xl-7">
                  <div class="p-0 p-sm-4 px-xl-0">
                    <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0"
                          class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1"
                          aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2"
                          aria-label="Slide 3"></button>
                      </div>
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <div class="testi-contain text-white">
                            <i class="bx bxs-quote-alt-left text-success display-6"></i>

                            <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                              imposing change
                              on myself. It's a lot more progressing fun than looking
                              back.
                              That's why
                              I ultricies enim
                              at malesuada nibh diam on tortor neaded to throw curve
                              balls.”
                            </h4>
                            <div class="mt-4 pt-3 pb-5">
                              <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                  <img src="assets/images/users/avatar-1.jpg"
                                    class="avatar-md img-fluid rounded-circle" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3 mb-4">
                                  <h5 class="font-size-18 text-white">Richard Drews
                                  </h5>
                                  <p class="mb-0 text-white-50">Web Designer</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="carousel-item">
                          <div class="testi-contain text-white">
                            <i class="bx bxs-quote-alt-left text-success display-6"></i>

                            <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be
                              to
                              free ourselves by widening our circle of compassion to
                              embrace
                              all living
                              creatures and
                              the whole of quis consectetur nunc sit amet semper justo.
                              nature
                              and its beauty.”</h4>
                            <div class="mt-4 pt-3 pb-5">
                              <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                  <img src="assets/images/users/avatar-2.jpg"
                                    class="avatar-md img-fluid rounded-circle" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3 mb-4">
                                  <h5 class="font-size-18 text-white">Rosanna French
                                  </h5>
                                  <p class="mb-0 text-white-50">Web Developer</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="carousel-item">
                          <div class="testi-contain text-white">
                            <i class="bx bxs-quote-alt-left text-success display-6"></i>

                            <h4 class="mt-4 fw-medium lh-base text-white">“I've learned
                              that
                              people will forget what you said, people will forget what
                              you
                              did,
                              but people will never forget
                              how donec in efficitur lectus, nec lobortis metus you made
                              them
                              feel.”</h4>
                            <div class="mt-4 pt-3 pb-5">
                              <div class="d-flex align-items-start">
                                <img src="assets/images/users/avatar-3.jpg" class="avatar-md img-fluid rounded-circle"
                                  alt="...">
                                <div class="flex-1 ms-3 mb-4">
                                  <h5 class="font-size-18 text-white">Ilse R. Eaton
                                  </h5>
                                  <p class="mb-0 text-white-50">Manager
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
