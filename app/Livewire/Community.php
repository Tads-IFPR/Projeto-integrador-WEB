<?php

namespace App\Livewire;

use App\Models\Playlist;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class Community extends Component
{
    public $playlists;
    public ?string $timePeriod = null;
    public $isLoading = false;
    public string $search = '';

    // TODO: extract this logic of search to a abstract component class
    #[On('search')]
    public function filterBySearch($text)
    {
        $this->search = $text;
        $this->updatePlaylist();
    }

    public function updatePlaylist()
    {
        $this->isLoading = true;

        $this->playlists = Playlist::public()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->mostLiked($this->timePeriod)
            ->with('user', 'audios')
            ->limit(30)
            ->get();

        $this->isLoading = false;
    }

    public function mount()
    {
        $this->updatePlaylist();
    }

    public function filterMostLiked($timePeriod)
    {
        $this->timePeriod = $timePeriod;
        $this->updatePlaylist();
    }

    public function render()
    {
        return view('livewire.community');
    }
}
