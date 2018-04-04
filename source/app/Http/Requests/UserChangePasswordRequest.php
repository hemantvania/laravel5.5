<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserChangePasswordRequest extends FormRequest
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
            'curPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confNewPassword' => 'required|min:6',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'curPassword.required'      => 'Field is required.',
            'curPassword.min'           => 'Current Password should have at least 6 character',
            'newPassword.required'      => 'Field is required.',
            'newPassword.min'           => 'New Password should have at least 6 character',
            'confNewPassword.required'  => 'Field is required.',
            'confNewPassword.min'       => 'Confirm Password should have at least 6 character',
        ];
    }
}
