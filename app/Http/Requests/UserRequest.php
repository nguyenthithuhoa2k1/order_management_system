<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'unique:users|required',
            'name_staff' => 'required',
            'password' => 'required',
            'password_confirm' =>'required',
        ];
    }
    public function messages()
    {
        return [
            'unique' => 'tài khoản của bạn đã tồn tại',
            'required' => ':attribute không được trống'
        ];
    }
}
