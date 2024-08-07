<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Navbar extends Component
{
    public $searchInput = '';
    public $currentRouteName = '';

    public function search()
    {
        $this->dispatch('search', text: $this->searchInput);
    }

    public function mount()
    {
        $this->currentRouteName = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
