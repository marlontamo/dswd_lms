<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionsRequest extends FormRequest
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
            'act_type' => 'required',
            'question' => 'required',
            // 'question' => 'required_if:act_type,1',
            // 'act_question' => 'required_if:act_type,2',
            'score' => 'max:2147483647|required',
            'correct_1' => 'required_if:act_type,1',
        ];
    }
}
