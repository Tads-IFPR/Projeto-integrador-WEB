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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'path' => ['required', 'string'],
            'disk' => ['required', 'string'],
            'author' => ['nullable', 'string'],
            'duration' => ['required', 'integer'],
            'cover_path' => ['nullable', 'string'],
            'cover_disk' => ['nullable', 'string'],
            'is_public' => ['required'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
