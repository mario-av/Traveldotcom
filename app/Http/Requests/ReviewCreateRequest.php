<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewCreateRequest extends FormRequest
{
    function attributes(): array
    {
        return [
            'vacation_id' => 'vacación',
            'rating' => 'puntuación',
            'comment' => 'comentario',
        ];
    }

    function authorize(): bool
    {
        return true;
    }

    function messages(): array
    {
        $required = 'El campo :attribute es obligatorio.';

        return [
            'vacation_id.required' => $required,
            'vacation_id.exists' => 'La vacación no existe.',
            'rating.required' => $required,
            'rating.integer' => 'La puntuación debe ser un número.',
            'rating.min' => 'La puntuación mínima es 1.',
            'rating.max' => 'La puntuación máxima es 5.',
            'comment.required' => $required,
            'comment.min' => 'El comentario debe tener al menos 10 caracteres.',
        ];
    }

    function rules(): array
    {
        return [
            'vacation_id' => 'required|exists:vacations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|min:10',
        ];
    }
}
