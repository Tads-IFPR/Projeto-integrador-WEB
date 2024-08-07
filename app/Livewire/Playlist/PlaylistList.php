<?php

namespace App\Livewire\Playlist;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class PlaylistList extends Component
{
    public $class;

    #[Reactive]
    public $playlists;

    public function render()
    {
        return view('livewire.playlist.playlist-list');
    }
}
