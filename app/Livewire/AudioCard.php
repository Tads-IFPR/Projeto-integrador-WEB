<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Playlist;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\returnSelf;

class AudioCard extends Component
{
    public Audio $audio;
    public string $class = '';
    public bool $isPlaying;
    public ?Playlist $playlist = null;


    public function play()
    {
        $this->dispatch('changed-audio', audio: $this->audio);
    }

    #[On('changed-audio')]
    public function refreshPost(Audio $audio)
    {
        $this->isPlaying = $this->audio->id === $audio->id;
    }

    public function toggleLike()
    {
        $this->audio->likes()->toggle([auth()->user()->id]);
    }

    public function remove()
    {
        $this->playlist->audios()->detach($this->audio->id);
        
        return redirect()->route('playlist.show', ['playlist' => $this->playlist]);
    }


    public function render()
    {
        return view('livewire.audio.audio-card',[
            'audio' => $this->audio,
            'class' => $this->class,
            'playlist' => $this->playlist,
        ]);
    }
}
