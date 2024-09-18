<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaylistShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var \App\Models\Playlist */
        $playlist = $this->route('playlist');

        return $playlist->user->is($this->user())
            || $playlist->is_public
            || $playlist->shareds->contains($this->user());
    }
}
