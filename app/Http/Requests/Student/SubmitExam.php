<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class SubmitExam extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        // Get all question IDs from the request
        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, 'question_')) {
                $questionId = str_replace('question_', '', $key);
                $rules[$key] = ['required', 'exists:answers,id'];
            }
        }

        // Ensure at least one question is answered
        if (empty($rules)) {
            $rules['no_answers'] = ['required'];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'Please answer all questions.',
            'exists' => 'The selected answer is invalid.',
            'no_answers.required' => 'You must answer at least one question.'
        ];
    }
}
