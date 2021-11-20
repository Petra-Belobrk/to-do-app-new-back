<?php

namespace App\Http\Requests\Auth;

use App\Dtos\UserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|'.Rule::unique('users', 'username')->ignore($this->id),
            'email' => 'required|email:filter|'.Rule::unique('users')->ignore($this->id),
            'password' => 'required|confirmed|min:8'
        ];
    }

    public function dto() {
        return new UserDto([
           'username' => $this->username,
           'email' => $this->email,
           'password' => $this->password
        ]);
    }
}
