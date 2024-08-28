<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonsterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'attack' => 'required|integer|min:0',
            'defense' => 'required|integer|min:0',
            'hp' => 'required|integer|min:0',
            'speed' => 'required|integer|min:0',
            'imageUrl' => 'nullable|url',
        ];
    }

    /**
     * Customize the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'attack.required' => 'The attack field is required.',
            'attack.integer' => 'The attack must be an integer.',
            'attack.min' => 'The attack must be at least 0.',
            'defense.required' => 'The defense field is required.',
            'defense.integer' => 'The defense must be an integer.',
            'defense.min' => 'The defense must be at least 0.',
            'hp.required' => 'The hp field is required.',
            'hp.integer' => 'The hp must be an integer.',
            'hp.min' => 'The hp must be at least 0.',
            'speed.required' => 'The speed field is required.',
            'speed.integer' => 'The speed must be an integer.',
            'speed.min' => 'The speed must be at least 0.',
            'imageUrl.url' => 'The image URL must be a valid URL.'
        ];
    }
}
