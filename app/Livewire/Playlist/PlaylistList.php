<?php

namespace App\Livewire\Playlist;

use Livewire\Component;

class PlaylistList extends Component
{
    public $class;
    public $playlists;

    public function render()
    {
        return view('livewire.playlist.playlist-list');
    }
}
