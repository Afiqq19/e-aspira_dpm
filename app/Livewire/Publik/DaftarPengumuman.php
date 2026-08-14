<?php

namespace App\Livewire\Publik;

use App\Models\Pengumuman;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPengumuman extends Component
{
    use WithPagination;

    public $filter = 'semua';
    public $search = '';
    
    public $selectedPengumuman = null;
    public $isModalOpen = false;

    public function showDetail($id)
    {
        $this->selectedPengumuman = Pengumuman::with('organisasi')->find($id);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedPengumuman = null;
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $query = Pengumuman::query()
            ->with(['organisasi'])
            ->published();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('isi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'dpm') {
            $query->dpm();
        } elseif ($this->filter === 'hmps') {
            $query->whereHas('organisasi', function($q) {
                $q->where('tipe', 'HMPS');
            });
        } elseif ($this->filter === 'ukm') {
            $query->whereHas('organisasi', function($q) {
                $q->where('tipe', 'UKM');
            });
        }

        $pengumuman = $query->orderByDesc('is_pinned')
                            ->orderByDesc('dipublikasikan_pada')
                            ->paginate(9);

        return view('livewire.publik.daftar-pengumuman', [
            'pengumumanList' => $pengumuman,
        ]);
    }
}
