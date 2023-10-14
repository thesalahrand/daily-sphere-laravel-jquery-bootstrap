@php
  use Carbon\Carbon;
@endphp

<x-layout>
  <div class="daily-prayer-tracker-container">
    <h5 class="page-title text-uppercase fw-semibold my-3 d-flex flex-column flex-sm-row align-items-center">
      <span>Daily Salah Tracker</span>
      <span
        class="badge rounded-pill bg-primary fs-7 ls-0 ms-2">{{ Carbon::parse(request('date'))->format('D, M d, Y') }}</span>
    </h5>
    <ul class="list-unstyled d-flex align-items-center flex-wrap mb-3">
      <li>
        <div class="quick-actions-dropdown dropdown">
          <a class="dropdown-toggle text-dark" type="button" data-bs-toggle="dropdown">
            Quick Actions
          </a>
          <ul class="dropdown-menu">
            {!! $authUser->pseudoname->gender == 'Male'
                ? '<li><a class="dropdown-item" href="#">Offered all fards with takbeer e tahrima</a></li>'
                : '' !!}
            {!! $authUser->pseudoname->gender == 'Female'
                ? '<li><a class="dropdown-item" href="#">Offered all fards in time</a></li>'
                : '' !!}
            {!! $authUser->pseudoname->gender == 'Female'
                ? '<li><a class="dropdown-item" href="#">Excuse all fards</a></li>'
                : '' !!}
            <li><a class="dropdown-item" href="#">Offered all sunnat-e-muakkadahs in time</a></li>
            <li><a class="dropdown-item" href="#">Excuse all sunnat-e-muakkadahs</a></li>
          </ul>
        </div>
      </li>
      <li class="mx-1 fw-bold">&middot;</li>
      <li>
        <a href="{{ route('unsubscribe_to_prayer_tracker.show') }}" class="text-dark">Unsubscribe</a>
      </li>
      <li class="mx-1 fw-bold">&middot;</li>
      <li class="d-flex align-items-center mt-2 mt-sm-0">
        <label for="historic_date_inp" class="text-dark text-decoration-underline text-nowrap me-2">Go to:</label>
        <input min="{{ $authUser->prayer_tracker_subscription_date }}" max="{{ Carbon::now()->format('Y-m-d') }}"
          value="{{ request('date') }}" name="historic_date_inp" type="date" class="form-control"
          id="historic_date_inp" required>
      </li>
    </ul>
    @if (count($incompleteDates))
      <div class="d-flex flex-wrap mb-2">
        <span>Yet to be completed:</span>
        @foreach ($incompleteDates as $incompleteDate)
          <a href="{{ route('prayer_tracker_daily.show', $incompleteDate->format('Y-m-d')) }}"
            class="badge rounded-pill bg-info text-decoration-none text-white ms-2 mb-2">{{ $incompleteDate->format('M d, Y') }}</a>
        @endforeach
      </div>
    @endif
    <div class="card mb-3">
      <div class="card-body">
        <form action="{{ route('prayer_tracker_daily.update', request('date')) }}" method="POST">
          @csrf
          @method('PUT')

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Something went wrong. Please, try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @foreach ($dailyDetails as $dailyDetail)
            @if ($loop->index != 0 && $dailyDetails[$loop->index]->prayer_name != $dailyDetails[$loop->index - 1]->prayer_name)
              <hr>
            @endif

            @if ($loop->index == 0 || $dailyDetails[$loop->index]->prayer_name != $dailyDetails[$loop->index - 1]->prayer_name)
              <h6 class="card-title text-center text-uppercase mb-3">{{ $dailyDetail->prayer_name }}</h6>
            @endif

            @if ($dailyDetail->prayer_name != 'Others')
              @if (
                  $loop->index == 0 ||
                      $dailyDetails[$loop->index]->prayer_variation_id != $dailyDetails[$loop->index - 1]->prayer_variation_id)
                <div class="row align-items-center mb-3">
                  <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                    <div class="card-subtitle">
                      {{ $dailyDetail->prayer_type }}
                      @if ($dailyDetail->chosen_prayer_offering_option_id)
                        <i class="bi bi-check-circle-fill text-success ms-1"></i>
                      @endif
                    </div>
                    <div class="text-muted">{{ $dailyDetail->prayer_desc }}</div>
                  </div>
                  <div class="col-12 col-sm-8">
                    <div class="row">
              @endif

              <div class="col-12 col-xl-6 mb-1">
                <input class="form-check-input" type="radio"
                  name="prayer_tracker[{{ $dailyDetail->prayer_variation_id }}]"
                  value="{{ $dailyDetail->prayer_offering_option_id }}"
                  id="prayer_tracker_{{ $dailyDetail->prayer_variation_id }}_{{ $dailyDetail->prayer_offering_option_id }}"
                  {{ $dailyDetail->chosen_prayer_offering_option_id == $dailyDetail->prayer_offering_option_id ? 'checked' : '' }}>
                <label class="form-check-label ms-1"
                  for="prayer_tracker_{{ $dailyDetail->prayer_variation_id }}_{{ $dailyDetail->prayer_offering_option_id }}">
                  <span>{{ $dailyDetail->prayer_offering_option }}</span>
                  <span class="text-muted">({{ $dailyDetail->prayer_offering_option_points }} pts)</span>
                </label>
                <span data-bs-toggle="tooltip" data-bs-placement="top"
                  title="{{ $dailyDetail->prayer_offering_option_desc }}" class="cursor-pointer"><i
                    class="bi bi-info-circle-fill"></i></span>
              </div>

              @if ($dailyDetails[$loop->index]->prayer_variation_id != $dailyDetails[$loop->index + 1]->prayer_variation_id)
      </div>
    </div>
  </div>
  @endif
@else
  <div class="row align-items-center mb-3">
    <div class="col-12 col-sm-4 mb-2 mb-sm-0">
      <label class="card-subtitle" for="prayer_tracker[{{ $dailyDetail->prayer_variation_id }}]">Rak'ats
        Count</label>
      <div class="text-muted">{{ $dailyDetail->prayer_desc }}</div>
    </div>
    <div class="col-12 col-sm-8">
      <div class="input-group mb-3">
        <span class="num-inp-dec-btn input-group-text cursor-pointer">-</span>
        <input type="number" min="0" class="form-control" placeholder="Rak'ats Count"
          value="{{ $dailyDetail->rakats_cnt ?? 0 }}" name="prayer_tracker[{{ $dailyDetail->prayer_variation_id }}]"
          id="prayer_tracker[{{ $dailyDetail->prayer_variation_id }}]">
        <span class="num-inp-inc-btn input-group-text cursor-pointer">+</span>
      </div>
    </div>
  </div>
  @endif
  @endforeach

  <button class="save-btn btn btn-primary px-4 w-100 text-white">Save</button>
  </form>
  </div>
  </div>
  </div>
</x-layout>

@vite('resources/js/daily-prayer-tracker.js')
