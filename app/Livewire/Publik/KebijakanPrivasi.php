<?php

namespace App\Livewire\Publik;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.publik')]
class KebijakanPrivasi extends Component
{
    public function render()
    {
        return view('livewire.publik.kebijakan-privasi');
    }
}
