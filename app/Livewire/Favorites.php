<?php

namespace App\Livewire;

use App\Models\Audio;
use App\Models\Playlist;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

class Favorites extends Component
{
    public $audios;
    public $playlists = [];
    private string $search = '';
    public $favoritesPlaylistId;

    #[On('search')]
    public function filterBySearch($text)
    {
        $this->search = $text;
        $this->updateAudios();
        $this->updatePlaylists();
    }

    private function updateAudios()
    {
        $this->audios = Audio::where(fn($q) => $q->public()->orWhere->currentUser())
            ->whereHas('likes', fn(Builder $q) => $q->where('user_id', auth()->user()->id))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->with('user')
            ->get();
        $this->saveToFavoritesPlaylist();
    }

    private function updatePlaylists()
    {
        $this->playlists = Playlist::where(fn($q) => $q->public()->orWhere->currentUser())
            ->whereHas('likes', fn(Builder $q) => $q->where('user_id', auth()->user()->id))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->with('user', 'audios')
            ->get();
    }

    public function mount()
    {
        $this->updateAudios();
        $this->updatePlaylists();
    }

    public function render()
    {
        return view('livewire.favorites');
    }

    private function saveToFavoritesPlaylist()
    {
        $user = auth()->user();
        $favoritesPlaylist = Playlist::firstOrCreate(
            ['name' => 'Favorites', 'user_id' => $user->id],
            ['description' => 'Your favorite audios']
        );

        $audioIds = collect($this->audios)->pluck('id')->toArray();
        $favoritesPlaylist->audios()->sync($audioIds);
        
        $this->favoritesPlaylistId = $favoritesPlaylist->id;

    }
    public function play()
    {
        return redirect()->route('playlist.show', ['playlist' => $this->favoritesPlaylistId]);
    }
}
