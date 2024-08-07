<?php

namespace App\Livewire\Home;

use App\Models\Audio;
use Livewire\Attributes\On;
use Livewire\Component;

class Audios extends Component
{
    public $audios = [];
    private string $search = '';

    #[On('audio-created')]
    public function updateAudioList()
    {
        $this->updateAudios();
    }

    #[On('search')]
    public function filterBySearch($text)
    {
        $this->search = $text;
        $this->updateAudios();
    }

    private function updateAudios()
    {
        $this->audios = Audio::when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->currentUser()
            ->with('user')
            ->get();
    }

    public function mount()
    {
        $this->updateAudios();
    }

    public function render()
    {
        return view('livewire.home.audios');
    }
}
