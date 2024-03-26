<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Component;

class AudioPlayer extends Component
{
    public Audio $audio;

    public function render()
    {
        $this->audio = Audio::find(1);
        return view('livewire.audio-player');
    }
}
