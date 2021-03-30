<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizUpdateRequest extends FormRequest
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
            'title' => ["required", "max:255", "min:5", Rule::unique('quizzes', 'title')->ignore($this->quiz_id)],
            'description' => "required",
            'finished_at' => 'nullable | after:'.now(),
        ];
    }

    public function attributes()
    {
        return [
            'title' => __('quiz.title'),
            'description' => __('quiz.description'),
            'finished_at' => __('quiz.finished_at'),
        ];
    }
}
