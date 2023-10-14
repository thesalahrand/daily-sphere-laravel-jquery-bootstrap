<?php

namespace App\Http\Requests\Trackers\Prayer;

use Illuminate\Foundation\Http\FormRequest;

class ShowDailyRequest extends FormRequest
{
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
      'date' => ['date_format:Y-m-d', 'after_or_equal:' . auth()->user()->prayer_tracker_subscription_date, 'before_or_equal:today']
    ];
  }

  protected function prepareForValidation(): void
  {
    $this->merge([
      'date' => request('date'),
    ]);
  }
}
