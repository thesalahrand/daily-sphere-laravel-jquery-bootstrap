<header class="topbar position-relative container-fluid d-flex align-items-center border-bottom bg-white">
  <div class="topbar-left-wrapper d-flex justify-content-between justify-content-lg-start">
    <x-logo mode="dark" />
    @auth
      <i class="hamburger-menu-icon d-lg-none cursor-pointer bi bi-list fs-2"></i>
    @endauth
  </div>

  <div class="topbar-right-wrapper d-flex">
    @guest
      <div class="w-100 text-end">
        <a href="{{ route('login.show') }}" class="btn btn-primary text-white">Login</a>
      </div>
    @endguest

    @auth
      <div class="dropdown ms-auto">
        <button type="button" class="btn border-0" data-bs-toggle="dropdown">
          <img class="rounded-circle of-cover" width="32" height="32"
            src="{{ $authUser->profile_pic ? asset('storage/' . $authUser->profile_pic) : asset('images/' . strtolower($authUser->pseudoName->gender) . '.png') }}"
            alt="{{ $authUser->pseudoName->name }}'s image">
          <span class="d-none d-sm-inline-block mx-1">{{ $authUser->pseudoName->name }}</span>
          <i class="bi bi-chevron-down"></i>
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="{{ route('edit_profile.show') }}">
            <i class="bi bi-person-circle text-primary"></i>
            <span class="ms-1">Edit Profile</span>
          </a>
          <a class="dropdown-item" href="/logout">
            <i class="bi bi-power text-primary"></i>
            <span class="ms-1">Logout</span>
          </a>
        </div>
      </div>
    @endauth
  </div>
</header>
