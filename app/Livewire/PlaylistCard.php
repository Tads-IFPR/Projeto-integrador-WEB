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
    public $audiosNotInPlaylist;

    public function mount()
    {
        $this->audios = Audio::all();
        $this->audiosNotInPlaylist = $this->audios->diff($this->playlist->audios);
    }

    public function play()
    {
        return redirect()->route('playlist.show', $this->playlist);
    }

    public function togglePrivacy()
    {
        $this->playlist->is_public = !$this->playlist->is_public;
        $this->playlist->save();
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
