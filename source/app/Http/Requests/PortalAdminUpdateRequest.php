<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortalAdminUpdateRequest extends FormRequest
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
            'email' => 'required|unique:users,email,' . $this->id,
            'userrole' => 'required',
            'phone' => 'required|numeric',
            'addressline1' => 'required',
            'city' => 'required',
            'zip' => 'required|zip_validate:' . $this->country,
            'country' => 'required',
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
            'email.required' => __('adminuser.requiredfield'),
            'email.unique' => __('adminuser.uniqueemail'),
            'email.email' => __('adminuser.validemail'),
            'userrole.required' => __('adminuser.requiredfield'),
            'phone.required' => __('adminuser.requiredfield'),
            'phone.numeric' => __('adminuser.phonenumeric'),
            'phone.size' => __('adminuser.phonesize'),
            'addressline1.required' => __('adminuser.requiredfield'),
            'city.required' => __('adminuser.requiredfield'),
            'zip.required' => __('adminuser.requiredfield'),
            'zip.zip_validate' => __('adminuser.zip_validate'),
            'country.required' => __('adminuser.requiredfield'),
        ];
    }
}
