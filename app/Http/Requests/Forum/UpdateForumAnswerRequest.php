<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class UpdateForumAnswerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'answer' => 'required|string',
        ];
    }
}
