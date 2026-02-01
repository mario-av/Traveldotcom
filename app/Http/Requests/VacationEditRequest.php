<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacationEditRequest extends FormRequest
{
    function attributes(): array
    {
        return [
            'title' => 'título de la vacación',
            'description' => 'descripción',
            'price' => 'precio',
            'location' => 'ubicación',
            'category_id' => 'categoría',
            'duration_days' => 'duración',
            'start_date' => 'fecha de inicio',
            'available_slots' => 'plazas disponibles',
        ];
    }

    function authorize(): bool
    {
        return true;
    }

    function messages(): array
    {
        $max = 'El campo :attribute no puede tener más de :max caracteres.';
        $min = 'El campo :attribute no puede tener menos de :min caracteres.';
        $required = 'El campo :attribute es obligatorio.';
        $numeric = 'El campo :attribute debe ser numérico.';

        return [
            'title.required' => $required,
            'title.min' => $min,
            'title.max' => $max,
            'description.required' => $required,
            'price.required' => $required,
            'price.numeric' => $numeric,
            'location.required' => $required,
            'category_id.required' => $required,
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'duration_days.required' => $required,
            'duration_days.integer' => 'La duración debe ser un número entero.',
            'start_date.required' => $required,
            'start_date.date' => 'Formato de fecha inválido.',
            'available_slots.required' => $required,
            'available_slots.integer' => 'Las plazas deben ser un número entero.',
        ];
    }

    function rules(): array
    {
        return [
            'title' => 'required|min:4|max:100|string',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0',
            'location' => 'required|min:2|max:100',
            'category_id' => 'required|exists:categories,id',
            'duration_days' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'available_slots' => 'required|integer|min:0',
            'active' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'photos.*' => 'nullable|image|max:2048',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:photos,id',
        ];
    }
}
