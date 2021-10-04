<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'freelancerId' => 'required|integer',
            'roleId' => [
                'required',
                Rule::in([2])
            ],
            'name'  => 'required|string|min:3|max:255',
            'reviewTitle' => 'required|string|min:5|max:255',
            'comment' => 'required|string|max:500'
        ];
    }
}