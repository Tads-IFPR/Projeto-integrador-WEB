<?php

namespace App\Livewire;

use App\Http\Repositories\AudioRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class AudioUpload extends Component
{
    use WithFileUploads;

    protected $rules = [
        'files' => 'required|array',
        'files.*' => 'file|mimes:audio/mpeg,mpga,mp3,wav,aac',
    ];

    public $files;

    public function updatedFiles()
    {
        $this->validate();
        $this->dispatch('fileProcessed');
    }

    public function save()
    {
        foreach ($this->files as $file) {
            AudioRepository::store($file);
        }

        $this->dispatch('audio-created');
    }

    public function render()
    {
        return view('livewire.audio.audio-upload');
    }
}
