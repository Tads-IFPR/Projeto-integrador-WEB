<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Audio;
use App\Models\Playlist;

class ShowAudio extends Component
{
    public Audio $audio;
    public Playlist $playlist;
    public string $class;
    public int $playlistId;

    public function mount(Audio $audio, int $playlistId, string $class = '')
    {
        $this->audio = $audio;
        $this->playlistId = $playlistId;
        $this->class = $class;
        $this->playlist = Playlist::find($playlistId); 
    }

    public function play()
    {
        $this->dispatch('changed-audio', audio: $this->audio);
    }

    public function render()
    {
        return view('livewire.playlist.show-audio', [
            'audio' => $this->audio,
            'playlist' => $this->playlist,
            'playlistId' => $this->playlistId,
        ]);
    }
}