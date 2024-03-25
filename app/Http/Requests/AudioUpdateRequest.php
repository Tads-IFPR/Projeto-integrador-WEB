<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudioUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \App\Models\Audio */
        $audio = $this->route('audio');

        return $audio->user->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'nullable'],
            'artist' => ['string', 'nullable'],
            'file' => ['nullable', 'file', 'max:10000'],
            'cover' => ['file', 'nullable'],
        ];
    }
}
