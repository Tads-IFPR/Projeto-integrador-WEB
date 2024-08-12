<?php

namespace App\Livewire;

use App\Models\Audio;
use Illuminate\Support\Facades\Log;
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
        $this->audio = $audio;

        if ($this->isShuffle) {
            $this->playedMusics[$this->audio->id] = $this->audio->id;
        }
    }

    public function next()
    {
        $this->dispatch('changed-audio', audio: $this->audio->next($this->playedMusics));
    }

    public function previous()
    {
        $this->dispatch('changed-audio', audio: $this->audio->previous());
    }

    public function startLastAudio(int $id)
    {
        $audio = Audio::find($id);

        if (!$audio) {
            return false;
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
        } else if ($this->audio) {
            $this->playedMusics[$this->audio->id] = $this->audio->id;
        }
    }

    public function render()
    {
        return view('livewire.audio.audio-player');
    }
}
