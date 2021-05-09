<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyCreate extends FormRequest
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
            'name'  => 'required',
            'gender' => 'required',
            'birthday' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name'  => '姓名不能为空',
            'gender' => '性别不能为空',
            'birthday' => '生日不能为空',
        ];
    }
}
