<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AudioUpload extends Component
{
    use WithFileUploads;

    public $file;

    protected $rules = [
        'file' => 'required|file|max:10000|mimes:audio/mpeg,mpga,mp3,wav,aac',
    ];

    public function upload()
    {
        $this->validate();

        $path = $this->file->store('audios');

        // Aqui você pode salvar o caminho no banco de dados ou realizar outras ações

        session()->flash('message', 'Upload bem-sucedido!');
    }

    public function render()
    {
        return view('livewire.audio-upload');
    }
}
