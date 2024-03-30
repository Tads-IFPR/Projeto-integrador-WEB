<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Component;

class AudioCard extends Component
{
    public Audio $audio;
    public string $class;

    public function play()
    {
        $this->dispatch('changed-audio', audio: $this->audio);
    }

    public function render()
    {
        return view('livewire.audio.audio-card');
    }
}
