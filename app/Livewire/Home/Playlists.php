<?php

namespace App\Livewire\Home;

use App\Models\Playlist;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Playlists extends Component
{
    public $playlists = [];
    public string $search = '';

    #[On('playlist-created')]
    public function updatePlaylistList()
    {
        $this->updatePlaylist();
    }

    #[On('search')]
    public function filterBySearch($text)
    {
        $this->search = $text;
        $this->updatePlaylist();
    }

    private function updatePlaylist()
    {
        $this->playlists = Playlist::when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->where('user_id', auth()->id())
            ->with('user', 'audios')
            ->get();
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
