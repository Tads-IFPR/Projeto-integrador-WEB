<?php

namespace App\Livewire\Audio;

use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Models\Playlist;

class AudioList extends Component
{
    public $class;

    #[Reactive]
    public $audios;
    
    public ?Playlist $playlist = null;

    public function render()
    {
        return view('livewire.audio.audio-list');
    }
}
