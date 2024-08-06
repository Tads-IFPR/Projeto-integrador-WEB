<?php

namespace App\Livewire;

use App\Models\Audio;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class AudioPlayer extends Component
{
    public Audio $audio;
    public $isPlaying = false;

    #[On('changed-audio')]
    public function updateAudio(Audio $audio)
    {
        $this->audio = $audio;
    }

    public function next()
    {
        $this->dispatch('changed-audio', audio: $this->audio->next);
    }

    public function previous()
    {
        $this->dispatch('changed-audio', audio: $this->audio->previous);
    }

    public function startLastAudio(Audio $audio)
    {
        $this->dispatch('changed-audio', audio: $audio);
    }

    public function togglePlaying()
    {
        $this->isPlaying = !$this->isPlaying;
    }

    public function render()
    {
        return view('livewire.audio.audio-player');
    }
}
