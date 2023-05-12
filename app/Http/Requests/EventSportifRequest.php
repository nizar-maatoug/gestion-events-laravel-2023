<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventSportifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom' =>['required', 'max:100'],
            'description' => ['required'],
            'lieu'  => ['required','max:100'],
            'dateDebut' => ['required'],
            'dateFin' => ['required']
        ];
    }
}
