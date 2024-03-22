<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudioStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'nullable'],
            'artist' => ['string', 'nullable'],
            'file' => ['required', 'file', 'max:10000'],
            'cover' => ['file', 'nullable'],
        ];
    }
}
