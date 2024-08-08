<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Playlist;
use App\Models\Audio;

class AudioModal extends Component
{
    public $showModal = false;
    public $playlistId;
    public $audios = [];


    #[On('openModal')]
    public function openModal($playlistId)
    {
        $this->playlistId = $playlistId;
        $this->showModal = true;
        $this->audios; 

    }

    public function getAudiosForPlaylist($playlistId)
    {
        $userId = auth()->id(); 

        return Audio::where('is_public', true)
                    ->orWhere('user_id', $userId)
                    ->get();
    }

    public function mount($playlistId)
    {
        $this->playlistId = $playlistId;
        $this->audios = $this->getAudiosForPlaylist($playlistId);
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.audio-modal',[
            'playlistId' => $this->playlistId,
            'audios' => $this->audios,
        ]);
    }

    public function addAudio($audioId, $playlistId)
    {
        $playlist = Playlist::find($playlistId);
        $playlist->audios()->attach($audioId);
    }
}
