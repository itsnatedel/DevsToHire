<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SaveTaskRequest extends FormRequest
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
            'taskTitle' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'unique:tasks,name'
            ],
            'category' => [
                'required',
                'string'
            ],
            'location' => [
                'required',
                'string'
            ],
            'budget_min' => [
                'required'
            ],
            'budget_max' => [
                'required'
            ],
            'radio' => [
                'required',
                Rule::in(['hourly', 'fixed'])
            ],
            'skills' => [
                'required',
                'string',
                'min:2',
                'max:250'
            ],
            'description' => [
                'required',
                'string'
            ],
            'files' => [
                'sometimes',
                'file',
                'max:20000'
            ],
            'qtyInput' => [
                'required',
                'numeric',
                'max:99'
            ],
            'taskDuration' => [
                'required',
                'string',
                Rule::in(['days', 'months']),
            ],
        ];
    }
}
