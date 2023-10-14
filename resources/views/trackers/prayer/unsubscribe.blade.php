@php
  use Carbon\Carbon;
@endphp

<x-layout>
  <div class="prayer-leaderboard-container">
    <div class="row my-3">
      <div class="col-12">
        <h5 class="page-title text-uppercase fw-semibold mb-0 d-flex align-items-center">
           Unsubscribe to salah tracker
        </h5>
      </div>
    </div>
    <div class="card mb-3">
      <div class="card-body">
        <form action="{{ route('unsubscribe_to_prayer_tracker.update') }}" method="POST" class="d-flex flex-column align-items-center">
          @method('PUT')
          @csrf

          <h6>Unsubscribe to Salah Tracker?</h6>
          <p>When you unsubscribe, your all statistics will be deleted for that specific tracker.</p>
          <button class="btn btn-primary px-4 text-white">Continue</button>
        </form>
      </div>
    </div>
  </div>
</x-layout>


