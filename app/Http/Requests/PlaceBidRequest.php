<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceBidRequest extends FormRequest
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
            'rate' => 'required|integer|min:1|lte:budgetMax',
            'bidderId' => 'nullable',
            'bidderRole' => [
                'nullable',
                Rule::in([2, 3])
            ],
            'timespan' => 'required|integer|min:1|max:99',
            'duration' => [
                'required',
                Rule::in(['days', 'hours'])
            ]
        ];
    }
}