<?php

namespace App\Livewire;

use App\Models\Audio;
use App\Models\Playlist;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

class Favorites extends Component
{
    public $audios = [];
    public $playlists = [];
    private string $search = '';

    #[On('search')]
    public function filterBySearch($text)
    {
        $this->search = $text;
        $this->updateAudios();
    }

    private function updateAudios()
    {
        $this->audios = Audio::where(fn($q) => $q->public()->orWhere->currentUser())
            ->whereHas('likes', fn(Builder $q) => $q->where('user_id', auth()->user()->id))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->with('user')
            ->get();
    }

    private function updatePlaylists()
    {
        $this->playlists = Playlist::where(fn($q) => $q->public()->orWhere->currentUser())
            ->whereHas('likes', fn(Builder $q) => $q->where('user_id', auth()->user()->id))
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
}
