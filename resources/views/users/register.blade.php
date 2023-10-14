<x-layout>
  <div class="register-container">
    <div class="row">
      <div class="col-12 col-md-6 mx-auto">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <x-logo mode="dark"/>
            </div>

            <form action="{{ route('register.store') }}" method="POST">
              @csrf
              <legend class="text-center fw-semibold mb-4">Register Now!</legend>
              <div class="mb-3">
                <div class="d-flex">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male" required>
                    <label class="form-check-label" for="gender_male">Male</label>
                  </div>
                  <div class="form-check ms-3">
                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="Female" required>
                    <label class="form-check-label" for="gender_female">Female</label>
                  </div>
                </div>
                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label for="pseudo_name_id" class="form-label">Select your pseudo name</label>
                <select name="pseudo_name_id" id="pseudo_name_id" class="form-select @error('pseudo_name_id') is-invalid @enderror" required>
                  <option value="" selected>--Choose an option--</option>
                </select>
                <div class="form-text">We aim to protect your identity completely. You'll understand its necessity soon.</div>
                @error('pseudo_name_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" required minlength="8"/>
                <div class="form-text">Due to some valid reasons, we're not able to provide forgot password functionality. So, preserve it in a secured place.</div>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" required minlength="8"/>
                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <button type="submit" class="btn btn-primary text-white w-100">Register</button>
              <p class="mt-4 mb-0 text-center">Already registered? <a class="text-primary" href="{{ route('login.show') }}">Login now</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-layout>

@vite('resources/js/register.js')

