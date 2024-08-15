<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Audio;
use App\Models\Playlist;

class AddRemoveAudio extends Component
{
    public Audio $audio;
    public Playlist $playlist;
    public string $class;
    public $isAdded = false;
    public $playlistId;


    public function mount(Audio $audio, Playlist $playlist, string $class = '', $playlistId)
    {
        $this->audio = $audio;
        $this->playlist = $playlist;
        $this->class = $class;
        $this->playlistId = $playlistId;

    }

    public function render()
    {

        return view('livewire.playlist.add-remove-audio', [
            'audio' => $this->audio,
            'playlist' => $this->playlist,
        ]);
    }

    public function addAudio($audioId, $playlistId)
    {   
        if($this->isAdded){
            $playlist = Playlist::find($playlistId);
            $playlist->audios()->detach($audioId);
            $this->isAdded = false;
        }else{
            $playlist = Playlist::find($playlistId);
            $playlist->audios()->attach($audioId);
            $this->isAdded = true;
        }
    }

    public function toggleAddRemove()
    {
        $this->isAdded = !$this->isAdded;
    }
}
