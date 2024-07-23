<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Component;
use App\Models\Playlist;

class AudioCard extends Component
{
    public Audio $audio;
    public $playlists;
    public string $class;

    public function play()
    {
        $this->dispatch('changed-audio', audio: $this->audio);
    }

    public function render()
    {
        return view('livewire.audio.audio-card',[
            'audio' => $this->audio,
            'class' => $this->class,
            'playlists' => $this->playlists,
        ]);
    }
}
