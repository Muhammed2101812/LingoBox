<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTranslationRequest extends FormRequest
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
        return [
            'source_text' => 'required|string',
            'target_text' => 'required|string',
            'source_lang_id' => 'required|exists:languages,id',
            'target_lang_id' => 'required|exists:languages,id|different:source_lang_id',
            'category' => 'nullable|string|max:255',
            'example_sentence' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'source_lang_id.required' => 'Kaynak dil seçimi zorunludur.',
            'source_lang_id.exists' => 'Seçilen kaynak dil geçerli değil.',
            'target_lang_id.required' => 'Hedef dil seçimi zorunludur.',
            'target_lang_id.exists' => 'Seçilen hedef dil geçerli değil.',
            'target_lang_id.different' => 'Hedef dil, kaynak dilden farklı olmalıdır.',
            'source_text.required' => 'Kaynak metin alanı zorunludur.',
            'target_text.required' => 'Hedef metin alanı zorunludur.',
        ];
    }
}
