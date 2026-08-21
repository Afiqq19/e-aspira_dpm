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
     * Check if a given route is active and return dark-theme CSS classes
     */
    public function isActive($route)
    {
        return request()->routeIs($route) ? 'bg-indigo-500/20 text-indigo-300 font-semibold' : 'text-slate-400 hover:bg-white/10 hover:text-white';
    }

    /**
     * Alias for isActive - used in new sidebar template
     */
    public function isActiveClass($route)
    {
        return request()->routeIs($route) ? 'bg-indigo-500/20 text-indigo-300 font-semibold' : 'text-slate-400 hover:bg-white/10 hover:text-white';
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
