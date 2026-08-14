<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.layout.sidebar');
    }
    
    /**
     * Check if a given route is active
     */
    public function isActive($route)
    {
        return request()->routeIs($route) ? 'bg-indigo-500/10 text-indigo-600 border-r-4 border-indigo-600 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600';
    }
}
