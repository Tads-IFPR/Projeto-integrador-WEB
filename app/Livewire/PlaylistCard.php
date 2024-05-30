<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Playlist;

class PlaylistCard extends Component
{
    public Playlist $playlist;
    public string $class;

    public function play()
    {
        $this->dispatch('changed-playlist', playlist: $this->playlist);
    }

    public function render()
    {
        return view('livewire.playlist.playlist-card');
    }
}
