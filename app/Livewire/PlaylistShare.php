<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Playlist;
use App\Models\User;

class PlaylistShare extends Component
{
    public Playlist $playlist;
    public function render()
    {
        return view('livewire.playlist.playlist-share');
    }

    public function newPlaylist($id){
        $this->playlist = Playlist::find($id);
    }

}
