<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $searchInput = '';

    public function search()
    {
        $this->dispatch('search', text: $this->searchInput);
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
