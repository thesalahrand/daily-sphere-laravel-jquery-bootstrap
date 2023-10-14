<?php

namespace App\Http\Requests\Trackers\Prayer;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowHistoryRequest extends FormRequest
{
  protected $stopOnFirstFailure = true;
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'year' => ['integer', 'min:' . Carbon::parse(auth()->user()->prayer_tracker_subscription_date)->format('Y'), 'max:' . Carbon::yesterday()->format('Y')],
      'month' => [
        Rule::in(array_map(fn($month) => Carbon::create(null, $month)->format('M'), range(1, 12))),
        function ($attribute, $value, $fail) {
          $requestedDate = Carbon::parse('first day of ' . $value . ' ' . request('year'));
          $minStartDate = Carbon::parse('first day of ' . auth()->user()->prayer_tracker_subscription_date);
          $maxEndDate = Carbon::parse('last day of ' . Carbon::yesterday()->format('Y-m-d'));

          if($requestedDate->lt($minStartDate) || $requestedDate->gt($maxEndDate)) {
            return $fail('Invalid month');
          }
        }
      ]
    ];
  }

  protected function prepareForValidation(): void
  {
    $this->merge([
      'year' => request('year'),
      'month' => request('month')
    ]);
  }
}

