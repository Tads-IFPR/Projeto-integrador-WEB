<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Attributes\On;
use Livewire\Component;

class AudioCard extends Component
{
    public Audio $audio;
    public string $class;
    public bool $isPlaying;

    public function play()
    {
        $this->dispatch('changed-audio', audio: $this->audio);
    }

    #[On('changed-audio')]
    public function refreshPost(Audio $audio)
    {
        $this->isPlaying = $this->audio->id === $audio->id;
    }

    public function render()
    {
        return view('livewire.audio.audio-card');
    }
}
