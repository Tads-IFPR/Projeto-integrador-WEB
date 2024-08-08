<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class AudioModal extends Component
{
    public $showModal = false;
    public $playlistId;

    #[On('openModal')]
    public function openModal($playlistId)
    {
        $this->playlistId = $playlistId;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.audio-modal');
    }
}
