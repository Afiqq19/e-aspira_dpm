<?php

namespace App\Livewire\Organisasi;

use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class KelolaPengumuman extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $statusFilter = '';

    // Modal state
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;

    // Form fields
    public $pengumuman_id;
    public $judul;
    public $isi;
    public $kategori = 'kegiatan'; // default untuk organisasi
    public $is_pinned = false;
    public $status = 'published';
    public $lampiran;
    public $file_lampiran;
    
    // Kategori Options
    public $kategoriOptions = ['umum', 'akademik', 'kegiatan', 'penting'];

    public $pengumumanToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    private function getOrganisasiId()
    {
        return Auth::user()->organisasi_id;
    }

    public function render()
    {
        $query = Pengumuman::query()
            ->with(['user'])
            ->where('organisasi_id', $this->getOrganisasiId());

        if ($this->search) {
            $query->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('isi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $pengumuman = $query->orderByDesc('is_pinned')
                            ->orderByDesc('dipublikasikan_pada')
                            ->paginate(10);

        return view('livewire.organisasi.kelola-pengumuman', [
            'pengumumanList' => $pengumuman,
        ]);
    }

    public function create()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $this->resetFields();
        $pengumuman = Pengumuman::where('organisasi_id', $this->getOrganisasiId())->findOrFail($id);
        
        $this->pengumuman_id = $pengumuman->id;
        $this->judul = $pengumuman->judul;
        $this->isi = $pengumuman->isi;
        $this->kategori = $pengumuman->kategori ?? 'kegiatan';
        $this->is_pinned = $pengumuman->is_pinned;
        $this->status = $pengumuman->status;
        $this->lampiran = $pengumuman->lampiran;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        if ($this->file_lampiran) {
            // Hapus file lama jika ada
            if ($this->lampiran) {
                Storage::disk('public')->delete($this->lampiran);
            }
            $this->lampiran = $this->file_lampiran->store('pengumuman', 'public');
        }

        $data = [
            'judul' => $this->judul,
            'isi' => $this->isi,
            'kategori' => $this->kategori,
            'is_pinned' => $this->is_pinned,
            'status' => $this->status,
            'lampiran' => $this->lampiran,
            'organisasi_id' => $this->getOrganisasiId(),
        ];

        if ($this->status === 'published' && !$this->pengumuman_id) {
            $data['dipublikasikan_pada'] = now();
        }

        if (!$this->pengumuman_id) {
            $data['user_id'] = Auth::id();
        }

        Pengumuman::updateOrCreate(
            [
                'id' => $this->pengumuman_id, 
                'organisasi_id' => $this->getOrganisasiId() // Safety check
            ],
            $data
        );

        $this->isModalOpen = false;
        session()->flash('message', $this->pengumuman_id ? 'Pengumuman berhasil diperbarui.' : 'Pengumuman berhasil ditambahkan.');
    }

    public function confirmDelete($id)
    {
        $this->pengumumanToDelete = Pengumuman::where('organisasi_id', $this->getOrganisasiId())->findOrFail($id);
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        if ($this->pengumumanToDelete) {
            $this->pengumumanToDelete->delete();
            $this->isDeleteModalOpen = false;
            session()->flash('message', 'Pengumuman berhasil dihapus.');
        }
    }

    public function togglePin($id)
    {
        $pengumuman = Pengumuman::where('organisasi_id', $this->getOrganisasiId())->findOrFail($id);
        $pengumuman->is_pinned = !$pengumuman->is_pinned;
        $pengumuman->save();
        
        session()->flash('message', 'Status sematan (pin) berhasil diubah.');
    }

    private function resetFields()
    {
        $this->pengumuman_id = null;
        $this->judul = '';
        $this->isi = '';
        $this->kategori = 'kegiatan';
        $this->is_pinned = false;
        $this->status = 'published';
        $this->lampiran = null;
        $this->file_lampiran = null;
        $this->pengumumanToDelete = null;
    }
}
