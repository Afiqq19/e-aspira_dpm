<?php

namespace App\Livewire\StaffDewan;

use App\Models\EvaluasiProker;
use App\Models\ProgramKerja;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PantauEvaluasi extends Component
{
    use WithPagination;

    public $search = '';
    public $filterOrganisasi = '';
    public $filterAspek = '';
    
    public $isModalOpen = false;
    public $selectedEvaluasi = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFilterOrganisasi()
    {
        $this->resetPage();
    }
    
    public function updatingFilterAspek()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        
        $query = EvaluasiProker::with(['programKerja.organisasi', 'user']);

        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $query->whereHas('programKerja', function($q) use ($user) {
                $q->where('organisasi_id', $user->organisasi_id);
            });
        }

        $evaluasis = $query
            ->when($this->search, function($q) {
                $q->whereHas('programKerja', function($q2) {
                    $q2->where('nama', 'like', '%' . $this->search . '%');
                })->orWhere('komentar', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterOrganisasi, function($q) {
                $q->whereHas('programKerja', function($q2) {
                    $q2->where('organisasi_id', $this->filterOrganisasi);
                });
            })
            ->when($this->filterAspek, function($q) {
                $q->where('aspek', $this->filterAspek);
            })
            ->latest()
            ->paginate(15);
            
        // Ambil daftar organisasi yang punya evaluasi (untuk dropdown filter)
        $orgQuery = \App\Models\Organisasi::whereHas('programKerja.evaluasi');
        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $orgQuery->where('id', $user->organisasi_id);
        }
        $organisasis = $orgQuery->get();

        return view('livewire.staff-dewan.pantau-evaluasi', compact('evaluasis', 'organisasis'));
    }

    public function lihatDetail($id)
    {
        $user = auth()->user();
        $query = EvaluasiProker::with(['programKerja.organisasi', 'user']);
        
        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $query->whereHas('programKerja', function($q) use ($user) {
                $q->where('organisasi_id', $user->organisasi_id);
            });
        }
        
        $this->selectedEvaluasi = $query->findOrFail($id);
        $this->isModalOpen = true;
    }
    
    public function delete($id)
    {
        if (auth()->user()->hasRole(['admin', 'staff_dewan'])) {
            EvaluasiProker::findOrFail($id)->delete();
            $this->isModalOpen = false;
            session()->flash('message', 'Evaluasi berhasil dihapus.');
        } else {
            session()->flash('error', 'Anda tidak memiliki akses untuk menghapus evaluasi.');
        }
    }
}
