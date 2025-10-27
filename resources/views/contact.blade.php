<x-layout>
<x-slot:title>{{ $title }}</x-slot:title>
<div class="main-content">
  <div class="page-content">
      <div class="container py-5">
        <div class="row align-items-center g-4">
          <div class="col-lg-6">
            <div class="ratio ratio-16x9 rounded overflow-hidden">
              <img class="img-fluid" src="https://images.unsplash.com/photo-1572021335469-31706a17aaef?q=80&w=560&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Contacts Image">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="mb-4">
              <h3 class="fw-semibold text-dark">Our address</h3>
              <div class="d-flex align-items-start gap-3">
                <i class="bi bi-geo-alt text-secondary fs-4"></i>
                <div>
                  <p class="text-muted mb-1">Indonesia</p>
                  <address class="text-dark m-0">
                    Perum. Pasegan Asri D3/14<br>
                    Sukodono, Sidoarjo
                  </address>
                </div>
              </div>
            </div>
            <div>
              <h3 class="fw-semibold text-dark">Our contacts</h3>
              <div class="d-flex align-items-start gap-3">
                <i class="bi bi-envelope text-secondary fs-4"></i>
                <div>
                  <p class="text-muted mb-1">Email us</p>
                  <a href="mailto:hello@example.so" class="fw-medium text-dark text-decoration-none">hello@example.so</a>
                </div>
              </div>
              <div class="d-flex align-items-start gap-3 mt-3">
                <i class="bi bi-telephone text-secondary fs-4"></i>
                <div>
                  <p class="text-muted mb-1">Call us</p>
                  <a href="tel:(031)23456789" class="fw-medium text-dark text-decoration-none">(031) 23456789</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</x-layout>