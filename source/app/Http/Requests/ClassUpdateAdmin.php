<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassUpdateAdmin extends FormRequest
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
            'className' => 'required',
            'schoolId' => 'required',
            'educationTypeId' => 'required',
            'standard' => 'required',
            'class_duration' => 'required',
            'class_size' => 'required',
            //  'user_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'className.required' => __('adminclasses.requiredfield'),
            'schoolId.required' => __('adminclasses.requiredfield'),
            'educationTypeId.required' => __('adminclasses.requiredfield'),
            'standard.required' => __('adminclasses.requiredfield'),
            'class_duration.required' => __('adminclasses.requiredfield'),
            'class_size.required' => __('adminclasses.requiredfield'),
            // 'user_id.required' => __('adminclasses.requiredfield'),
        ];
    }
}
