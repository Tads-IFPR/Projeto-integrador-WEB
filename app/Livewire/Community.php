<?php

namespace App\Livewire;

use App\Models\Playlist;
use Livewire\Component;

class Community extends Component
{
    public $playlists;

    public $isLoading = false;

    public function rendering()
    {
        $this->isLoading = true;
    }

    public function rendered()
    {
        $this->isLoading = false;
    }

    public function mount()
    {
        $this->playlists = Playlist::public()->limit(30)->get();
    }

    public function filterMostLiked(string $timePeriod)
    {
        $this->playlists = Playlist::public()
            ->mostLiked($timePeriod)
            ->limit(30)
            ->get();
    }

    public function render()
    {
        return view('livewire.community');
    }
}
