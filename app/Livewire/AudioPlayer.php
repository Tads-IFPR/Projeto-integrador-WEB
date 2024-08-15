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
            ->where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('user_id', auth()->id());
            })
            ->where('id', '>', $this->audio->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextAudio) {
            $this->updateAudio($nextAudio);
            $this->dispatch('changed-audio', audio: $nextAudio);
        }
    } else {
        $nextAudio = Audio::where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('user_id', auth()->id());
            })
            ->where('id', '>', $this->audio->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextAudio) {
            $this->updateAudio($nextAudio);
            $this->dispatch('changed-audio', audio: $nextAudio);
        }
    }
}

public function previous()
{
    if ($this->playlist) {
        $previousAudio = $this->playlist->audios()
            ->where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('user_id', auth()->id());
            })
            ->where('id', '<', $this->audio->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($previousAudio) {
            $this->updateAudio($previousAudio);
            $this->dispatch('changed-audio', audio: $previousAudio);
        }
    } else {
        $previousAudio = Audio::where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('user_id', auth()->id());
            })
            ->where('id', '<', $this->audio->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($previousAudio) {
            $this->updateAudio($previousAudio);
            $this->dispatch('changed-audio', audio: $previousAudio);
        }
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
