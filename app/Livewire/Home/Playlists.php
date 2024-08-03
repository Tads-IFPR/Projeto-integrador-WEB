<?php

namespace App\Livewire\Home;

use App\Models\Playlist;
use Livewire\Attributes\On;
use Livewire\Component;

class Playlists extends Component
{
    public $playlists = [];

    #[On('playlist-created')]
    public function updatePlaylistList()
    {
        $this->updatePlaylist();
    }

    private function updatePlaylist()
    {
        $this->playlists = Playlist::where('user_id', auth()->id())->get();
    }

    public function mount()
    {
        $this->updatePlaylist();
    }

    public function render()
    {
        return view('livewire.home.playlists');
    }
}
