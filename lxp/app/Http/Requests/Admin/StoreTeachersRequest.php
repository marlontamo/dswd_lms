<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeachersRequest extends FormRequest
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
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email|unique:users,email',
            'username'      => 'required|min:5|max:255|alpha_dash|unique:users',
            'password'      => 'required|min:6',
            'gender'        => ['required', 'in:male,female'],
            //'image'         => ['required', 'image'],
            'facebook_link' => ['nullable', 'url'],
            'twitter_link'  => ['nullable', 'url'],
            'linkedin_link' => ['nullable', 'url'],

        ];
    }
}
