<?php

namespace App\Http\Requests\Frontend\Activity;

use Illuminate\Foundation\Http\FormRequest;

class CreateActivityRequest extends FormRequest
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
            'email'=>'required|',
             'reporting_to'=>'required',
             'reporting_period'=>'required',
             'division'=>'required'
        
        ];
    }
    public function messages()
{
    return [
        'email.required' => 'email field  is required please provide a valid email address',
        'reporting_to.required' => 'A message is required',
        'reporting_period.required'=> 'reporting_period field is required',
        'division.required'=> 'division field is required'
    ];
}
}
