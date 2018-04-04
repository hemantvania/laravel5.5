<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddAdmin extends FormRequest
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
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'userrole' => 'required',
            'phone' => 'required|numeric',
            //'profileimage' => 'required',
            'addressline1' => 'required',
            // 'addressline2' => 'required',
            'city' => 'required',
            //'state' => 'required',
            'zip' => 'required|zip_validate:' . $this->country,
            'country' => 'required',
            'schoolId' => 'required',
            'default_school' => 'required',
            // 'classId' => 'required',
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
            'name.required' => __('adminuser.requiredfield'),
            'last.required' => __('adminuser.requiredfield'),
            'last_name.required' => __('adminuser.requiredfield'),
            'email.required' => __('adminuser.requiredfield'),
            'email.unique' => __('adminuser.uniqueemail'),
            'email.email' => __('adminuser.validemail'),
            'password.required' => __('adminuser.requiredfield'),
            'userrole.required' => __('adminuser.requiredfield'),
            'phone.required' => __('adminuser.requiredfield'),
            'phone.numeric' => __('adminuser.phonenumeric'),
            'phone.size' => __('adminuser.phonesize'),
            //  'profileimage.required' => __('adminuser.requiredfield'),
            'addressline1.required' => __('adminuser.requiredfield'),
            // 'addressline2.required' => __('adminuser.requiredfield'),
            'city.required' => __('adminuser.requiredfield'),
            //'state.required' => __('adminuser.validemail'),
            'zip.required' => __('adminuser.requiredfield'),
            'zip.zip_validate' => __('adminuser.zip_validate'),
            'country.required' => __('adminuser.requiredfield'),
            'schoolId.required' => __('adminuser.requiredfield'),
            'default_school.required' => __('adminuser.requiredfield'),
            // 'classId.required' => __('adminuser.requiredfield'),
            'default_language.required' => __('adminuser.requiredfield'),
        ];
    }
}
