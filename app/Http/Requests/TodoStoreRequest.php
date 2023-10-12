<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class TodoStoreRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        $content = view('todos.form')
            ->withErrors($validator->errors());

        throw new ValidationException(
            $validator,
            response($content),
        );
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
