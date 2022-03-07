<?php

namespace Sashsvamir\LaravelUserCRUD\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;


class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
            'notify' => ['boolean'],
            'notify_spam' => ['boolean'],
            'roles' => 'array',
            'roles.*' => Rule::in(User::getAvailableRoles()),
        ];
    }
}
