<?php

namespace App\Livewire;

use App\Http\Repositories\AudioRepository;
use Livewire\Component;
use Livewire\WithFileUploads;

class AudioUpload extends Component
{
    use WithFileUploads;

    protected $rules = [
        'file' => 'required|file|max:10000|mimes:audio/mpeg,mpga,mp3,wav,aac',
    ];

    public $file;

    public function updatedFile()
    {
        $this->validate();
        $this->dispatch('fileProcessed');
    }

    public function save()
    {
        AudioRepository::store($this->file);
        $this->redirect('/');
        session()->flash('message', 'File successfully uploaded.');
    }

    public function render()
    {
        return view('livewire.audio.audio-upload');
    }
}
