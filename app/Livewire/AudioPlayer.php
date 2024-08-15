<?php

namespace App\Livewire;

use App\Models\Audio;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Playlist;

class AudioPlayer extends Component
{
    public Audio $audio;
    public $isPlaying = false;
    public ?Playlist $playlist = null;
    public $audios = [];

    public function mount($playlist = null, $audios = [])
    {
        $this->playlist = $playlist;
        $this->audios = $audios;
        if (!empty($audios)) {
            $this->audio = $audios[0]; 
        }
    }

    
    #[On('changed-audio')]
    public function updateAudio(Audio $audio)
    {
        $this->audio = $audio;
    }

    public function next()
{
    if ($this->playlist) {
        $nextAudio = $this->playlist->audios()
            ->where('id', '>', $this->audio->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextAudio) {
            
            $this->dispatch('changed-audio', audio: $nextAudio);
        }
    } else {
        $this->dispatch('changed-audio', audio: $this->audio->next);
    }
}

public function previous()
{
    if ($this->playlist) {
        $previousAudio = $this->playlist->audios()
            ->where('id', '<', $this->audio->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($previousAudio) {
            $this->dispatch('changed-audio', audio: $previousAudio);
        }
    } else {
        $this->dispatch('changed-audio', audio: $this->audio->previous);
    }
}

    public function startLastAudio(int $id)
    {
        $audio = Audio::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$audio) {
            return false;
        }

        $this->dispatch('changed-audio', audio: $audio);
    }

    public function togglePlaying()
    {
        $this->isPlaying = !$this->isPlaying;
    }

    public function render()
    {
        return view('livewire.audio.audio-player');
    }
}
