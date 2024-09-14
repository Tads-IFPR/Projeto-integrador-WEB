<?php

namespace App\Livewire;

use App\Models\Audio;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Playlist;

class AudioPlayer extends Component
{
    public Audio $audio;
    public $isExpanded = false;
    public $isPlaying = false;
    public $isShuffle = false;
    public $playedMusics = [];
    public ?Playlist $playlist = null;
    public $audios = [];

    public function mount($playlist = null, $audios = [])
    {
        $this->playlist = $playlist;
        $this->audios = $audios;
        if (!empty($audios) && isset($audios[0])){
            $this->audio = $audios[0]; 
        }
    }

    
    #[On('changed-audio')]
    public function updateAudio(Audio $audio)
    {
        if (isset($this->audio)) {
            $this->isPlaying = true;
        }

        if (
            $this->isShuffle
            && isset($audio)
            && !in_array($audio?->id, $this->playedMusics)
        ) {
            $this->playedMusics[] = $audio->id;
        }

        $this->audio = $audio;
    }

    public function next()
    {
        if ($this->playlist) {
            if ($this->isShuffle) {
                if ($this->playlist->is_public && auth()->id() !== $this->playlist->user_id) {
                    $remainingAudios = $this->playlist->audios()
                        ->where('is_public', true)
                        ->whereNotIn('id', $this->playedMusics)
                        ->get();
                } else {
                    $remainingAudios = $this->playlist->audios()
                        ->whereNotIn('id', $this->playedMusics)
                        ->get();
                }

                if ($remainingAudios->isNotEmpty()) {
                    $nextAudio = $remainingAudios->random();
                    $this->dispatch('changed-audio', audio: $nextAudio);
                    return;
                }
            }

            if ($this->playlist->is_public && auth()->id() !== $this->playlist->user_id) {

                $nextAudio = $this->playlist->audios()
                ->where('is_public', true)
                ->where('id', '>', $this->audio->id)
                ->orderBy('id', 'asc')
                ->first();

                if ($nextAudio) {
               
                    $this->dispatch('changed-audio', audio: $nextAudio);
                }
            }else{
                $nextAudio = $this->playlist->audios()
                ->where('id', '>', $this->audio->id)
                ->orderBy('id', 'asc')
                ->first();
            
                if ($nextAudio) {
                
                    $this->dispatch('changed-audio', audio: $nextAudio);
                }
            }
             
            
        } else {
            $nextAudio = $this->audio->next($this->playedMusics);
            if ($nextAudio) {
                $this->dispatch('changed-audio', audio: $nextAudio);
            } else {
                
            }

        }
    }

    public function previous()
{
    if ($this->playlist) {
        if ($this->isShuffle) {
            if ($this->playlist->is_public && auth()->id() !== $this->playlist->user_id) {
                $playedPublicMusics = array_filter($this->playedMusics, function ($audioId) {
                    $audio = $this->playlist->audios()->find($audioId);
                    return $audio && $audio->is_public;
                });

                if (!empty($playedPublicMusics)) {
                    array_pop($playedPublicMusics);

                    if (!empty($playedPublicMusics)) {
                        $previousAudioId = end($playedPublicMusics);
                        $previousAudio = $this->playlist->audios()->find($previousAudioId);

                        if ($previousAudio) {
                            $this->dispatch('changed-audio', audio: $previousAudio);
                            return;
                        }
                    }
                }
            } else {
                if (!empty($this->playedMusics)) {
                    array_pop($this->playedMusics);

                    if (!empty($this->playedMusics)) {
                        $previousAudioId = end($this->playedMusics);
                        $previousAudio = $this->playlist->audios()->find($previousAudioId);

                        if ($previousAudio) {
                            $this->dispatch('changed-audio', audio: $previousAudio);
                            return;
                        }
                    }
                }
            }
        } else {
            if ($this->playlist->is_public && auth()->id() !== $this->playlist->user_id) {
                $previousAudio = $this->playlist->audios()
                    ->where('is_public', true)
                    ->where('id', '<', $this->audio->id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($previousAudio) {
                    $this->dispatch('changed-audio', audio: $previousAudio);
                    return;
                }
            } else {
                $previousAudio = $this->playlist->audios()
                    ->where('id', '<', $this->audio->id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($previousAudio) {
                    $this->dispatch('changed-audio', audio: $previousAudio);
                    return;
                }
            }
        }
    } else {
        $previousAudio = $this->audio->previous($this->playedMusics);
        if ($previousAudio) {
            $this->dispatch('changed-audio', audio: $previousAudio);
        }
    }
}

    public function startLastAudio($state)
    {
        if ($this->playlist && $this->playlist->audios()->count() === 0) {
            $this->isPlaying = false; 
            return;
        }
    
        $audio = Audio::currentUser()->where('id', $state['currentSongId'])->where('user_id', auth()->id())->first();
    
        if (!$audio) {
            return false;
        }

        $this->audio = $audio;
    
        if (!isset($state['autoPlay']) || !$state['autoPlay']) {
            $this->isPlaying = false; 
            return;
        }
    
        if (isset($state['isShuffle'])) {
            $this->isShuffle = true;
        }
    
        $this->dispatch('changed-audio', audio: $audio);
        $this->isPlaying = true;
    }

    public function toggleExpanded()
    {
        $this->isExpanded = !$this->isExpanded;
    }

    public function togglePlaying()
    {
        $this->isPlaying = !$this->isPlaying;
    }

    public function toggleShuffle()
    {
        $this->isShuffle = !$this->isShuffle;

        if (!$this->isShuffle) {
            $this->playedMusics = [];
        } else if (isset($this->audio) && !in_array($this->audio->id, $this->playedMusics)) {
            $this->playedMusics[] = $this->audio->id;
        }
    }

    public function render()
    {
        return view('livewire.audio.audio-player');
    }
}
