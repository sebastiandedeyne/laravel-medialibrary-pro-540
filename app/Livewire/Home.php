<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public bool $show = false;

    public $media = [];

    public function render()
    {
        return view('livewire.home');
    }
}
