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

    public function removeShared(User $user)
    {
        $this->playlist->shareds()->detach($user->id);
        $this->playlist = Playlist::find($this->playlist->id);
        $this->dispatch('playlistUpdated');

    }

    public function newPlaylist($id){
        $this->playlist = Playlist::find($id);
    }

}
