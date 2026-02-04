<?php

namespace App\Livewire;

use Livewire\Component;

class MobileMenu extends Component
{
    public $showMenu = false;

    public function toggle()
    {
        $this->showMenu = !$this->showMenu;
    }

    public function close()
    {
        $this->showMenu = false;
    }

    public function render()
    {
        return view('livewire.mobile-menu');
    }
}
