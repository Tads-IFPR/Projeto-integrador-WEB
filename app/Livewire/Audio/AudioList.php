<?php

namespace App\Livewire\Audio;

use Livewire\Component;

class AudioList extends Component
{
    public $class;
    public $audios;

    public function render()
    {
        return view('livewire.audio.audio-list');
    }
}
