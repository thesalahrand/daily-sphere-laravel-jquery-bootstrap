@if (session()->has('message'))
  <div class="toast-wrapper position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast w-100 {{ session('alert-type') }} align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
      <div class="d-flex">
        <div class="toast-body">
          <i class="bi bi-{{ session('alert-type') == 'success' ? 'check' : 'x' }}-lg"></i>
          <span class="ms-2 fw-medium">{{ session('message') }}</span>
        </div>
      </div>
    </div>
  </div>
@endif
