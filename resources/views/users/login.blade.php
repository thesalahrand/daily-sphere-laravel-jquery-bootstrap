<x-layout>
  <div class="login-container">
    <div class="row">
      <div class="col-12 col-md-6 mx-auto">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <x-logo mode="dark"/>
            </div>
            <form action="{{ route('login.store') }}" method="POST">
              @csrf
              <legend class="text-center fw-semibold mb-4">Login Now!</legend>

              @error('generic')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-times me-2"></i>
                  {{ $message }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @enderror

              <div class="mb-3">
                <label for="pseudo_name_id" class="form-label">Select your pseudo name</label>
                <select name="pseudo_name_id" id="pseudo_name_id" class="form-select @error('pseudo_name_id') is-invalid @enderror" required>
                  <option value="" selected>--Choose an option--</option>
                  @foreach ($pseudoNames as $pseudoName)
                    <option value="{{ $pseudoName->id }}">{{ $pseudoName->name }}</option>
                  @endforeach
                </select>
                @error('pseudo_name_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" required/>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                  <label class="form-check-label" for="remember">
                    Remember me
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary text-white w-100">Login</button>
              <p class="mt-4 mb-0 text-center">Don't have an account yet? <a class="text-primary" href="{{ route('register.show') }}">Register now</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layout>
