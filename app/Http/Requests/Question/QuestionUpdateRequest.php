<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
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
            'question' => "required | min:3",
            'image' => "nullable | file | max:1024 | mimes:jpg,jpeg,png",
            'answer1' => "required",
            'answer2' => "required",
            'answer3' => "required",
            'answer4' => "required",
            'correct_answer' => "required",
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'question' => __('question.question'),
            'image' => __('general.image'),
            'answer1' => __('question.answer')."-1",
            'answer2' => __('question.answer')."-2",
            'answer3' => __('question.answer')."-3",
            'answer4' => __('question.answer')."-4",
            'correct_answer' => __('question.correctAnswer'),
        ];
    }
}
