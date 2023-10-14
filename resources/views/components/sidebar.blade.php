@php
  use Carbon\Carbon;
@endphp

<div class="sidebar container-fluid bg-white pb-5">
  <ul class="sidebar-menu list-unstyled">
    <li class="sidebar-menu-title text-uppercase text-muted fw-semibold px-1 my-3">Trackers</li>
    <li class="position-relative">
      <a class="d-flex align-items-center text-decoration-none p-2 cursor-pointer">
        <img src="{{ asset('images/salah.png') }}" width="24" alt="">
        <span class="ms-3 text-dark">Salah Tracker</span>
      </a>
      <i class="position-absolute bi bi-chevron-down"></i>
      <ul class="list-unstyled border-start border-4 border-primary ms-2">
        <li class="px-2 py-1"><a href="{{ route('prayer_tracker_daily.show', Carbon::now()->format('Y-m-d')) }}" class="text-decoration-none">Daily Tracker</a></li>
        <li class="px-2 py-1"><a href="{{ route('prayer_tracker_history.index', [Carbon::yesterday()->format('Y'), Carbon::yesterday()->format('M')]) }}" class="text-decoration-none">History</a></li>
        <li class="px-2 py-1"><a href="{{ route('prayer_tracker_leaderboard.index') }}" class="text-decoration-none">Leaderboard</a></li>
      </ul>
    </li>
    {{-- <li class="position-relative">
      <a class="d-flex align-items-center text-decoration-none p-2 cursor-pointer">
        <img src="{{ asset('images/sawm.png') }}" width="24" alt="">
        <span class="ms-3 text-dark">Sawm Tracker</span>
      </a>
      <i class="position-absolute bi bi-chevron-down"></i>
      <ul class="list-unstyled border-start border-4 border-primary ms-2">
        <li class="px-2 py-1"><a class="text-decoration-none">Daily Tracker</a></li>
        <li class="px-2 py-1"><a class="text-decoration-none">Tracking History</a></li>
        <li class="px-2 py-1"><a class="text-decoration-none">Leaderboard</a></li>
      </ul>
    </li>
    <li class="position-relative">
      <a class="d-flex align-items-center text-decoration-none p-2 cursor-pointer">
        <img src="{{ asset('images/transaction.png') }}" width="24" alt="">
        <span class="ms-3 text-dark">Transaction Tracker</span>
      </a>
      <i class="position-absolute bi bi-chevron-down"></i>
      <ul class="list-unstyled border-start border-4 border-primary ms-2">
        <li class="px-2 py-1"><a class="text-decoration-none">Daily Tracker</a></li>
        <li class="px-2 py-1"><a class="text-decoration-none">Tracking History</a></li>
        <li class="px-2 py-1"><a class="text-decoration-none">Leaderboard</a></li>
      </ul>
    </li>
    <li class="position-relative">
      <a class="d-flex align-items-center text-decoration-none p-2 cursor-pointer">
        <img src="{{ asset('images/efforts.png') }}" width="24" alt="">
        <span class="ms-3 text-dark">Efforts Tracker</span>
      </a>
      <i class="position-absolute bi bi-chevron-down"></i>
      <ul class="list-unstyled border-start border-4 border-primary ms-2">
        <li class="px-2 py-1"><a class="text-decoration-none">Daily Tracker</a></li>
        <li class="px-2 py-1"><a class="text-decoration-none">Tracking History</a></li>
        <li class="px-2 py-1"><a class="text-decoration-none">Leaderboard</a></li>
      </ul>
    </li> --}}
  </ul>
</div>
