<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Attributes\On;
use Livewire\Component;

class AudioPlayer extends Component
{
    public Audio $audio;
    public $isExpanded = false;
    public $isPlaying = false;
    public $isShuffle = false;
    public $playedMusics = [];

    #[On('changed-audio')]
    public function updateAudio(Audio $audio)
    {
        if (isset($this->audio)) {
            $this->isPlaying = true;
        }

        if (
            $this->isShuffle
            && isset($audio)
            && !in_array($audio?->id, $this->playedMusics)
        ) {
            $this->playedMusics[] = $audio->id;
        }

        $this->audio = $audio;
    }

    public function next()
    {
        $this->dispatch('changed-audio', audio: $this->audio->next($this->playedMusics));
    }

    public function previous()
    {
        $this->dispatch('changed-audio', audio: $this->audio->previous($this->playedMusics));
    }

    public function startLastAudio($state)
    {
        $audio = Audio::currentUser()->find($state['currentSongId']);

        if (!$audio) {
            return false;
        }

        if (isset($state['isShuffle']) && $state['isShuffle']) {
            $this->isShuffle = true;
        }

        $this->dispatch('changed-audio', audio: $audio);
    }

    public function toggleExpanded()
    {
        $this->isExpanded = !$this->isExpanded;
    }

    public function togglePlaying()
    {
        $this->isPlaying = !$this->isPlaying;
    }

    public function toggleShuffle()
    {
        $this->isShuffle = !$this->isShuffle;

        if (!$this->isShuffle) {
            $this->playedMusics = [];
        } else if (isset($this->audio) && !in_array($this->audio->id, $this->playedMusics)) {
            $this->playedMusics[] = $this->audio->id;
        }
    }

    public function render()
    {
        return view('livewire.audio.audio-player');
    }
}
