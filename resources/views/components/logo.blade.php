@props(['mode'])

<a href="{{ route('dashboard') }}" class="logo text-decoration-none">
  <img height="24" class="me-1" src="https://laravel.com/img/logomark.min.svg" alt="Logo">
  <span class="fw-semibold {{ $mode == 'dark' ? 'text-dark' : 'text-light' }}">Daily Sphere</span>
</a>
