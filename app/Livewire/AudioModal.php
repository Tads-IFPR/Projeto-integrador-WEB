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
    public $isPlaylistShow = false;


    #[On('openModal')]
    public function openModal($playlistId)
    {
        $this->playlistId = $playlistId;
        $this->showModal = true;
        $this->audios = $this->getAudiosForPlaylist($playlistId);
    }

    #[On('addedAudio')]
    public function updateAudios($playlistId)
    {
        return redirect()->route('playlist.show', ['playlist' => $this->playlistId]);
    }

    public function getAudiosForPlaylist($playlistId)
    {
        $userId = auth()->id(); 

        $playlist = Playlist::with('audios')->find($playlistId);
        $audioIdsInPlaylist = $playlist ? $playlist->audios->pluck('id')->toArray() : [];

        return Audio::where(function($query) use ($userId) {
                $query->where('is_public', true)
                      ->orWhere('user_id', $userId);
            })
            ->whereNotIn('id', $audioIdsInPlaylist)
            ->get();
    }

    public function mount($playlistId = null, $isPlaylistShow = false)
{
    if ($playlistId) {
        $this->playlistId = $playlistId;
        $this->audios = $this->getAudiosForPlaylist($playlistId);
    }
    $this->isPlaylistShow = $isPlaylistShow;
}

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('closeModal');
        if ($this->isPlaylistShow) {
            $this->dispatch('addedAudio', $this->playlistId);
        }
    }

    public function render()
    {
        return view('livewire.audio-modal',[
            'playlistId' => $this->playlistId,
            'audios' => $this->audios,
        ]);
    }
}