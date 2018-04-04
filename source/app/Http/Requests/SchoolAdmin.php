<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'country' => 'required',
            'schoolName' => 'required|unique:schools,schoolName',
            // 'school_district' => 'required',
            'email' => 'required|email',
            'registrationNo' => 'required',
            'WebUrl' => 'sometimes|nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'address1' => 'required',
            'city' => 'required',
            //   'state' => 'required',
            'zip' => 'required',
            'facebook_url' => 'sometimes|nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'twitter_url' => 'sometimes|nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'instagram_url' => 'sometimes|nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'default_language' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'country.required' => 'Field is required.',
            'schoolName.required' => 'Field is required.',
            'schoolName.unique' => 'The school name has already been taken.',
            'email.required' => 'Field is required.',
            'email.email' => 'The email must be a valid email address.',
            'registrationNo.required' => 'Field is required.',
            'address1.required' => 'Field is required.',
            'city.required' => 'Field is required.',
            'state.required' => 'Field is required.',
            'zip.required' => 'Field is required.',
            'facebook_url' => 'Enter Valid Facebook Url.',
            'twitter_url' => 'Enter Valid twitter Url.',
            'instagram_url' => 'Enter Valid instagram Url.',
            'default_language.required' => 'Field is required.',
        ];
    }
}
