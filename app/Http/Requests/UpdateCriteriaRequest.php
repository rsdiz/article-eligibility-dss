<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCriteriaRequest extends FormRequest
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
            'code' => ['required', 'string'],
            'name' => ['required', 'string'],
            'type' => ['required', 'in:cost,benefit'],
            'weight' => ['required', 'numeric'],
            'has_option' => ['required', 'in:0,1']
        ];
    }
}
