<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Playlist;
use App\Models\Audio;

class PlaylistCard extends Component
{
    public Playlist $playlist;
    public string $class;
    public $audios;

    public function mount()
    {
        $this->audios = Audio::all(); 
    }

    public function play()
    {
        return redirect()->route('playlist.show', $this->playlist);
    }

    public function render()
    {
        return view('livewire.playlist.playlist-card',[
            'playlist' => $this->playlist,
            'class' => $this->class,
            'audios' => $this->audios,
        ]);
    }
}
