<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class CreateForumAnswerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'question_id' => 'required|exists:forum_questions,id',
            'answer' => 'required|string',
        ];
    }
}
