<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Navbar extends Component
{
    public $searchInput = '';
    public $currentRouteName = '';
    public $currentUrl = ''; 


    public function search()
    {
        $this->dispatch('search', text: $this->searchInput);
        $this->dispatch('search-playlist', text: $this->searchInput, url: $this->currentUrl);
    }

    public function mount()
    {
        $this->currentRouteName = request()->route()->getName();
        $this->currentUrl = request()->url();
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
