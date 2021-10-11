<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
	        'jobTitle'  => [
		        'required',
		        'string',
		        'min:8',
		        'max:255',
		        'unique:tasks,name'
	        ],
	        'category'   => [
		        'required',
		        'string'
	        ],
	        'jobType'   => [
		        'required',
		        'string'
	        ],
	        'country'   => [
		        'required',
		        'string'
	        ],
	        'salary_min' => [
		        'required',
                'integer',
                'min:1',
                'max:99999',
                'lt:salary_max'
	        ],
	        'salary_max' => [
		        'required',
                'integer',
                'min:1',
                'max:99999',
                'gt:salary_min'
	        ],
	        'remote' => [
		        'required',
		        'string'
	        ],
	        'description' => [
		        'required',
		        'string'
	        ],
	        'projectFile' => [
		        'required',
		        'file',
		        'mimes:pdf',
		        'max:4092'
	        ],
	        'locally' => [
		        'sometimes',
		        'accepted'
	        ],
        ];
    }
}