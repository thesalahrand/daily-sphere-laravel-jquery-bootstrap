<?php

namespace App\Http\Requests\User;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EditProfileRequest extends FormRequest
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
      'pseudo_name_id' => [
        'nullable',
        Rule::unique('users')->ignore(auth()->id()),
        Rule::exists('pseudo_names', 'id')->where(function (Builder $query) {
          return $query->where('gender', auth()->user()->pseudoName->gender);
        })
      ],
      'password' => ['nullable', 'confirmed', Password::min(8)->uncompromised()],
      'profile_pic' => ['nullable', 'max:1000', 'mimetypes:image/jpeg,image/png']
    ];
  }
}
