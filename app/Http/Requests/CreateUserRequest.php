<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class CreateUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
            'phone_number' => ['required', 'string', 'min:8', 'max:11'],
            'dob' => ['required', 'date-format:Y-m-d'],
            'gender' => ['required', 'in:male,female']
        ];
    }

    /**
     * Get the User with params
     *
     * @return User
     */
    public function toUser(): User
    {
        $param = $this->validated();

        $param['password'] = Hash::make($param['password']);

        return new User($param);
    }
}
