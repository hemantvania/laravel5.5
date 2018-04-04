<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentAddRequest extends FormRequest
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
            'materialName' => 'required',
            'uploadcontent' => 'required_without:link',
            'link' => 'required_without:uploadcontent|url_validate:' . $this->materialType,
            'materialType' => 'required',
            'categoryId' => 'required',
            'default_language' => 'required',
           // 'description' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        return [
            'materialName.required' => __('general.requiredfield'),
            'uploadcontent.required_without' => __('general.uploadcontent'),
            'link.required_without' => __('general.linkmessage'),
            'materialType.required' => __('general.requiredfield'),
            'categoryId.required' => __('general.requiredfield'),
            'description.required' => __('general.requiredfield'),
            'default_language.required' => __('general.requiredfield'),

        ];
    }
}
