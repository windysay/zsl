<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\Request;

class ArticleCreateForm extends Request
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
            'title'            => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                  => '标题不能为空',
        ];
    }
}
