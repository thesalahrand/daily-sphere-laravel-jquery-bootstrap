@php
  use Carbon\Carbon;
@endphp

<div class="new-feature-modal modal fade" id="new-feature-003" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex flex-column align-items-center">
        <img class="new-feature-icon" src="{{ asset('images/new-feature.png') }}" width="128" alt="">
        <h5 class="new-feature-title modal-title text-capitalize my-3">#003 Salah Tracker History in Charts!</h5>
        <p class="new-feature-short-desc mb-0">Now, you can view your <b>Salah History</b> in charts per month basis. <a href="{{ route('prayer_tracker_history.index', [Carbon::now()->format('Y'), Carbon::now()->format('M')]) }}">Check</a> it out now!</p>
      </div>
      <div class="row flex-column flex-sm-row justify-content-center align-items-center p-3">
        <div class="col-12 col-sm-6 mx-auto">
          <button type="button" class="dont-show-again-feature-btn btn btn-danger text-white w-100" data-bs-dismiss="modal">
            <i class="bi bi-x-lg me-2"></i>
            Don't show again
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
