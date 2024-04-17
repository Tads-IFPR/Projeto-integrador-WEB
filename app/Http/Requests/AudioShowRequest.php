<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudioShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \App\Models\Audio */
        $audio = $this->route('audio');

        return $audio->user->is($this->user()) || $audio->is_public;
    }
}
