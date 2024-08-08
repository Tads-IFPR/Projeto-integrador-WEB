<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Audio;
use App\Models\Playlist;

class AddRemoveAudio extends Component
{
    public Audio $audio;
    public Playlist $playlist;
    public string $class;

    public function mount(Audio $audio, Playlist $playlist, string $class = '')
    {
        $this->audio = $audio;
        $this->playlist = $playlist;
        $this->class = $class;
    }

    public function render()
    {

        return view('livewire.playlist.add-remove-audio', [
            'audio' => $this->audio,
            'playlist' => $this->playlist,
        ]);
    }

    
}
