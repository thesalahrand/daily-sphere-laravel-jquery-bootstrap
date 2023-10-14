@php
  use Carbon\Carbon;
@endphp

<x-layout>
  <div class="prayer-leaderboard-container">
    <div class="row flex-column flex-md-row align-items-center my-3">
      <div class="col-12 col-md-8 mb-2 mb-md-0">
        <h5 class="page-title text-uppercase fw-semibold mb-0 text-center text-md-start">
          Salah Leaderboard
          <span data-bs-toggle="tooltip" data-bs-placement="top"
            title="Based on the statistics from {{ Carbon::parse($startDate)->format('M d, Y') }} to {{ Carbon::parse($endDate)->format('M d, Y') }} prioritizing fard success rate, sunnah success rate, other rak'ats count and subscription duration in sequence"
            class="cursor-pointer"><i class="bi bi-info-circle-fill"></i></span>
        </h5>
      </div>
      <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end">
        <span class="badge rounded-pill bg-primary">{{ $authUser->pseudoName->gender }}</span>
      </div>
    </div>
    <div class="card mb-3">
      <div class="card-body">
        @forelse ($leaders as $leader)
          @if ($loop->index != 0)
            <hr>
          @endif

          <div class="leader-row row align-items-end">
            <div class="col-12 mb-2 mb-sm-0 col-sm-2 d-flex align-items-center">
              <span
                class="serial-badge badge rounded-pill me-2 {{ $leader->user_id == auth()->id() ? 'bg-primary' : 'bg-secondary' }}">{{ $leaders->firstItem() + $loop->index }}</span>
              <span
                class="{{ $leader->user_id == auth()->id() ? '' : 'blur' }}">{{ $leader->user_id == auth()->id() ? $authUser->pseudoName->name : 'Pseudo' }}</span>
            </div>
            <div
              class="col-12 mb-2 mb-sm-0 col-sm-3 d-flex justify-content-between justify-content-sm-start align-items-center">
              <h6 class="mb-0">Fard Success Rate:</h6>
              <span class="badge rounded-pill bg-success ms-2">{{ $leader->fard_success_rate }}%</span>
            </div>
            <div
              class="col-12 mb-2 mb-sm-0 col-sm-3 d-flex justify-content-between justify-content-sm-start align-items-center">
              <h6 class="mb-0">Sunnah Success Rate:</h6>
              <span class="badge rounded-pill bg-success ms-2">{{ $leader->sunnah_success_rate }}%</span>
            </div>
            <div class="col-6 mb-2 mb-sm-0 col-sm-2">
              <span class="fw-medium">Others:</span>
              <span>{{ $leader->others_rakats_count }} rak'ats</span>
            </div>
            <div class="col-6 text-end text-sm-start mb-2 mb-sm-0 col-sm-2">
              <span class="serial-badge badge rounded-pill bg-info">last {{ $leader->stat_duration }}
                day{{ $leader->stat_duration > 1 ? 's' : '' }}</span>
            </div>
          </div>
        @empty
          <p class="text-center mb-0">No leaders found</p>
        @endforelse
      </div>
    </div>
  </div>

  {{ $leaders->links() }}
</x-layout>

@vite('resources/js/prayer-leaderboard.js')
