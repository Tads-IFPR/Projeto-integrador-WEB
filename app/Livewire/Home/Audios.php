<?php

namespace App\Livewire\Home;

use App\Models\Audio;
use Livewire\Attributes\On;
use Livewire\Component;

class Audios extends Component
{
    public $audios = [];

    #[On('audio-created')]
    public function updateAudioList()
    {
        $this->updateAudio();
    }

    private function updateAudio()
    {
        $this->audios = Audio::currentUser()->get();
    }

    public function mount()
    {
        $this->updateAudio();
    }

    public function render()
    {
        return view('livewire.home.audios');
    }
}
