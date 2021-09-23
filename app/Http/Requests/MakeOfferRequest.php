<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class MakeOfferRequest extends FormRequest
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
			'userId' => 'required|integer',
            'name' => 'required|string',
	        'email' => 'required|email',
	        'message' => 'required|string',
	        'offerFile' => 'required|file|mimes:pdf|max:8192'
        ];
    }
}