<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LogAktivitas extends Component
{
    use WithPagination;

    public $search = '';
    public $eventFilter = ''; // created, updated, deleted

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingEventFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Activity::with('causer')
            ->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('log_name', 'like', '%' . $this->search . '%');
            });
            
        if ($this->eventFilter) {
            $query->where('event', $this->eventFilter);
        }

        $logs = $query->latest()->paginate(15);

        return view('livewire.admin.log-aktivitas', compact('logs'))
            ->layout('layouts.app');
    }
}
