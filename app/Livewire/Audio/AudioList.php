<?php

namespace App\Livewire\Audio;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class AudioList extends Component
{
    public $class;

    #[Reactive]
    public $audios;

    public function render()
    {
        return view('livewire.audio.audio-list');
    }
}
