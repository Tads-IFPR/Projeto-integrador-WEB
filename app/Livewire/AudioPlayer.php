<?php

namespace App\Livewire;

use App\Models\Audio;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class AudioPlayer extends Component
{
    public Audio $audio;

    #[On('changed-audio')]
    public function updateAudio(Audio $audio)
    {
        $this->audio = $audio;
    }

    public function render()
    {
        return view('livewire.audio.audio-player');
    }
}
