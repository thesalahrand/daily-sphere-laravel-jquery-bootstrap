@php
  use Carbon\Carbon;
@endphp

<x-layout>
  <div class="prayer-history-container">
    <h5 class="page-title text-uppercase fw-semibold my-3 text-center text-md-start">
      Salah History
    </h5>
    <div class="card mb-3">
      <div class="card-body">
        <div class="row flex-column flex-md-row align-items-center mb-4">
          <form action=""
            class="prayer-type-filter-form order-2 mt-3 order-md-1 mt-md-0 col-12 col-md-6 d-flex justify-content-center justify-content-md-start">
            <input class="form-check-input" type="radio" name="prayer_type_inp" value="fard" id="fard_inp"
              data-target=".fard-chart-wrapper" checked>
            <label class="form-check-label ms-2 me-3" for="fard_inp">Fard</label>
            <input class="form-check-input" type="radio" name="prayer_type_inp" value="sunnah" id="sunnah_inp"
              data-target=".sunnah-chart-wrapper">
            <label class="form-check-label ms-2 me-3" for="sunnah_inp">Sunnah</label>
            <input class="form-check-input" type="radio" name="prayer_type_inp" value="fard" id="others_inp"
              data-target=".others-chart-wrapper">
            <label class="form-check-label ms-2" for="others_inp">Others</label>
          </form>
          <form action="" class="history-filter-form order-1 order-md-2 col-12 col-md-6">
            <div class="row">
              <div class="col-6 col-sm-4">
                <select name="year" id="year" class="form-select me-2" required>
                  <option value="">Select a Year</option>
                  @foreach ($yearsWithMonthNo as $yearWithMonthNo)
                    <option value="{{ $yearWithMonthNo['year'] }}"
                      data-min-month-no="{{ $yearWithMonthNo['minMonthNo'] }}"
                      data-max-month-no="{{ $yearWithMonthNo['maxMonthNo'] }}">{{ $yearWithMonthNo['year'] }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6 col-sm-4">
                <select name="month_name" id="month_name" class="form-select me-2" required>
                  <option value="">Select a Month</option>
                </select>
              </div>
              <div class="col-12 col-sm-4 mt-2 mt-sm-0">
                <button class="history-filter-btn btn btn-primary w-100 text-white">Filter</button>
              </div>
            </div>
          </form>
        </div>
        <div class="chart-wrapper fard-chart-wrapper">
          <canvas class="fard-chart"></canvas>
        </div>
        <div class="chart-wrapper sunnah-chart-wrapper d-none">
          <canvas class="sunnah-chart"></canvas>
        </div>
        <div class="chart-wrapper others-chart-wrapper d-none">
          <canvas class="others-chart"></canvas>
        </div>
      </div>
    </div>
  </div>
</x-layout>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fardChart = $('.fard-chart');
    const sunnahChart = $('.sunnah-chart');
    const othersChart = $('.others-chart');

    new Chart(fardChart[0], {
      type: 'bar',
      data: {
        labels: [
          @foreach ($perMonthStat as $perDayStat)
            '{{ $perDayStat->date }}',
          @endforeach
        ],
        datasets: [{
          label: 'Fard Success Rate',
          backgroundColor: 'rgba(15, 156, 243, .5)',
          data: [
            @foreach ($perMonthStat as $perDayStat)
              {{ $perDayStat->fard_success_rate }},
            @endforeach
          ],
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';

                if (label) {
                  label += ': ';
                }

                if (context.parsed.y !== null) {
                  label += `${context.parsed.y}%`;
                }

                return label;
              },
            }
          }
        }
      }
    });

    new Chart(sunnahChart[0], {
      type: 'bar',
      data: {
        labels: [
          @foreach ($perMonthStat as $perDayStat)
            '{{ $perDayStat->date }}',
          @endforeach
        ],
        datasets: [{
          label: 'Sunnah Success Rate',
          backgroundColor: 'rgba(15, 156, 243, .5)',
          data: [
            @foreach ($perMonthStat as $perDayStat)
              {{ $perDayStat->sunnah_success_rate }},
            @endforeach
          ],
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';

                if (label) {
                  label += ': ';
                }

                if (context.parsed.y !== null) {
                  label += `${context.parsed.y}%`;
                }

                return label;
              },
            }
          }
        }
      }
    });

    new Chart(othersChart[0], {
      type: 'bar',
      data: {
        labels: [
          @foreach ($perMonthStat as $perDayStat)
            '{{ $perDayStat->date }}',
          @endforeach
        ],
        datasets: [{
          label: 'Others',
          backgroundColor: 'rgba(15, 156, 243, .5)',
          data: [
            @foreach ($perMonthStat as $perDayStat)
              {{ $perDayStat->others_rakats_count }},
            @endforeach
          ]
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';

                if (label) {
                  label += ': ';
                }

                if (context.parsed.y !== null) {
                  label += `${context.parsed.y} rak\'ats`;
                }

                return label;
              },
            }
          }
        }
      }
    });
  });
</script>

@vite('resources/js/prayer-tracker-history.js')
