@php
  use Carbon\Carbon;
@endphp

<x-layout>
  <div class="prayer-leaderboard-container">
    <div class="row my-3">
      <div class="col-12">
        <h5 class="page-title text-uppercase fw-semibold mb-0 d-flex align-items-center">
           Subscribe to salah tracker
        </h5>
      </div>
    </div>
    <div class="card mb-3">
      <div class="card-body">
        <form action="{{ route('subscribe_to_prayer_tracker.update') }}" method="POST" class="d-flex flex-column align-items-center">
          @method('PUT')
          @csrf

          <h6>Subscribe to Salah Tracker?</h6>
          <p class="mb-1">When you subscribe, your statistics will be calculated from that date.</p>
          <p>Please be regular to fill your trackers otherwise you may fall behind in the leaderboard.</p>
          <button class="btn btn-primary px-4 text-white">Continue</button>
        </form>
      </div>
    </div>
  </div>
</x-layout>


