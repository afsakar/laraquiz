<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Quiz;

class QuizCreateRequest extends FormRequest
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
            'title' => "required | max:255 | min:5 | unique:quizzes,title",
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
