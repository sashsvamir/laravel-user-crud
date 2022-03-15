<?php

namespace Sashsvamir\LaravelUserCRUD\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;


class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['string', 'min:4'],
            'notify' => ['nullable', 'boolean'],
            'notify_spam' => ['nullable', 'boolean'],
            'roles' => 'array',
            'roles.*' => Rule::in(User::getAvailableRoles()),
        ];
    }
}
