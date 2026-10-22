<?php

namespace App\Http\Requests;

use App\Enums\Color;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'place_id' => ['required', 'exists:places,id'],
            'color' => ['required', Rule::enum(Color::class)],
            'found_on' => ['required', 'date', 'before_or_equal:today'],
            'description' => ['nullable', 'string', 'max:1000'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // Max 2Mo par photo
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'place_id.required' => 'Le lieu est obligatoire.',
            'place_id.exists' => 'Le lieu sélectionné est invalide.',
            'name.required' => 'Le nom de l\'objet est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 60 caractères.',
            'color.required' => 'La couleur est obligatoire.',
            'color.enum' => 'La couleur sélectionnée est invalide.',
            'found_on.required' => 'La date de découverte est obligatoire.',
            'found_on.date' => 'La date de découverte doit être une date valide.',
            'found_on.before_or_equal' => 'La date de découverte ne peut pas être dans le futur.',
            'photos.*.image' => 'Le fichier doit être une image.',
            'photos.*.mimes' => 'L\'image doit être au format JPEG, PNG, JPG ou WEBP.',
            'photos.*.max' => 'Chaque image ne doit pas dépasser 2 Mo.',
        ];
    }
}
