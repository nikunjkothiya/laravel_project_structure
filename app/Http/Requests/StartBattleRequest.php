<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartBattleRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'monsterA' => 'required|exists:monsters,id',
            'monsterB' => 'required|exists:monsters,id',
        ];
    }

    public function messages(): array
    {
        return [
            'monsterA.required' => 'Monster A is required.',
            'monsterA.exists' => 'Monster A must exist in the database.',
            'monsterB.required' => 'Monster B is required.',
            'monsterB.exists' => 'Monster B must exist in the database.',
        ];
    }
}
