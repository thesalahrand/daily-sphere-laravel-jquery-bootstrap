<?php

namespace App\Http\Requests\User;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
      'gender' => ['required', Rule::in(['Male', 'Female'])],
      'pseudo_name_id' => [
        'required',
        'unique:users',
        Rule::exists('pseudo_names', 'id')->where(function (Builder $query) {
          return $query->where('gender', request('gender'));
        }),
      ],
      'password' => ['required', 'confirmed', Password::min(8)->uncompromised()],
    ];
  }
}
