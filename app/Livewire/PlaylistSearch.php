<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Playlist;
use App\Models\Audio;

class PlaylistSearch extends Component
{
    public $search;
    public $playlist;
    public $url;
    public $playlistId = null;
    public $audios = [];



    #[On('search-playlist')]
    public function search($text, $url)
    {
        $this->search = $text;
        $this->url = $url;
        if (preg_match('/playlist\/(\d+)/', $url, $matches)) {
            $this->playlistId = $matches[1];
        }
        $this->busca($this->playlistId);
        
    }

    public function busca($playlistId)
    {
        $user = auth()->user();
        $this->playlist = Playlist::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('is_public', true);
        })
        ->where('id', $playlistId)
        ->with(['audios' => function ($query) use ($user) {
            $query->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('is_public', true);
            })
            ->where('name', 'like', '%'.$this->search.'%')
            ->with('user');
        }])
        ->first();
        if ($this->playlist) {
            $this->audios = $this->playlist->audios->sortBy('id')->values();
        }
    }

    public function mount()
    {
        $this->busca($this->playlistId);
    }

    public function render()
    {
        return view('livewire.playlist-search',['audios' => $this->audios]);
    }
}