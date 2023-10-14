<x-layout>
  <div class="edit-profile-container">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('edit_profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <legend class="text-start fw-semibold mb-4">Edit Profile</legend>

          <div class="row mb-3">
            <div class="col-12 col-md-4 col-lg-2">
              <label for="gender" class="form-label">Gender</label>
            </div>
            <div class="col-12 col-md-8 col-lg-10">
              <input id="gender" class="form-control" value="{{ $authUser->pseudoName->gender }}" disabled />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-md-4 col-lg-2">
              <label for="pseudo_name_id" class="form-label">Pseudo name</label>
            </div>
            <div class="col-12 col-md-8 col-lg-10">
              <select name="pseudo_name_id" id="pseudo_name_id"
                class="form-select @error('pseudo_name_id') is-invalid @enderror" required>
                <option value="">--Choose an option--</option>
                @foreach ($pseudoNames as $pseudoName)
                  <option {{ $pseudoName->id == $authUser->pseudo_name_id ? 'selected' : '' }}
                    value="{{ $pseudoName->id }}">{{ $pseudoName->name }}</option>
                @endforeach
              </select>
              @error('pseudo_name_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-md-4 col-lg-2">
              <label for="password" class="form-label">New Password</label>
            </div>
            <div class="col-12 col-md-8 col-lg-10">
              <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" />
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-md-4 col-lg-2">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
            </div>
            <div class="col-12 col-md-8 col-lg-10">
              <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror" />
              @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-md-4 col-lg-2">
              <label for="profile_pic" class="form-label">Profile Picture</label>
              <span data-bs-toggle="tooltip" data-bs-placement="top" title="Max 1 MB jpg/png"
                class="cursor-pointer ms-1"><i class="bi bi-info-circle-fill"></i></span>
            </div>
            <div class="preview-img-wrapper col-12 col-md-8 col-lg-10">
              <input type="file" id="profile_pic" name="profile_pic"
                class="preview-img-inp form-control @error('profile_pic') is-invalid @enderror" />
              @error('profile_pic')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <img class="preview-img rounded mt-3" width="128"
                src="{{ $authUser->profile_pic ? asset('storage/' . $authUser->profile_pic) : asset('images/' . strtolower($authUser->pseudoName->gender) . '.png') }}"
                alt="{{ $authUser->pseudoName->name }}'s image">
            </div>
          </div>
          <button type="submit" class="btn btn-primary px-4 text-white">Edit</button>
        </form>
      </div>
    </div>
  </div>
</x-layout>
