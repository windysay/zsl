<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\Request;

class ArticleCatCreateForm extends Request
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
            'cat_name'            => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cat_name.required'                  => '栏目名不能为空',
        ];
    }
}
