<?php

namespace App\Livewire\Organisasi;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class KelolaKegiatan extends Component
{
    use WithPagination, WithFileUploads;

    public $kegiatan_id;
    public $judul, $deskripsi, $tanggal_mulai, $tanggal_selesai, $lokasi;
    public $kontak_penanggung_jawab, $no_kontak;
    public $is_published = false;
    public $organisasi_id;
    
    public $poster; // for file upload
    public $old_poster; // to store existing poster path
    
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $search = '';

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'kontak_penanggung_jawab' => 'nullable|string|max:255',
            'no_kontak' => 'nullable|string|max:50',
            'is_published' => 'boolean',
            'poster' => 'nullable|image|max:2048', // max 2MB
        ];
    }

    protected $messages = [
        'judul.required' => 'Judul kegiatan tidak boleh kosong.',
        'deskripsi.required' => 'Deskripsi kegiatan tidak boleh kosong.',
        'tanggal_mulai.required' => 'Tanggal mulai harus diisi.',
        'lokasi.required' => 'Lokasi harus diisi.',
        'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        'poster.image' => 'File harus berupa gambar.',
        'poster.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        
        $query = Kegiatan::query();

        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $query->where('organisasi_id', $user->organisasi_id);
        }

        $query->where(function ($q) {
            $q->where('judul', 'like', '%' . $this->search . '%')
              ->orWhere('lokasi', 'like', '%' . $this->search . '%')
              ->orWhereHas('organisasi', function($q2) {
                  $q2->where('nama', 'like', '%' . $this->search . '%')
                     ->orWhere('singkatan', 'like', '%' . $this->search . '%');
              });
        });

        $kegiatans = $query->orderBy('tanggal_mulai', 'desc')->paginate(10);
        $organisasis = \App\Models\Organisasi::all();

        return view('livewire.organisasi.kelola-kegiatan', compact('kegiatans', 'organisasis'));
    }

    public function create()
    {
        $this->resetInputFields();
        if (!auth()->user()->hasRole(['admin', 'staff_dewan'])) {
            $this->organisasi_id = auth()->user()->organisasi_id;
        }
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $this->resetInputFields();
        $user = auth()->user();
        
        $query = Kegiatan::query();
        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $query->where('organisasi_id', $user->organisasi_id);
        }
        
        $kegiatan = $query->findOrFail($id);
                        
        $this->kegiatan_id = $kegiatan->id;
        $this->judul = $kegiatan->judul;
        $this->deskripsi = $kegiatan->deskripsi;
        $this->tanggal_mulai = $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('Y-m-d\TH:i') : null;
        $this->tanggal_selesai = $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('Y-m-d\TH:i') : null;
        $this->lokasi = $kegiatan->lokasi;
        $this->kontak_penanggung_jawab = $kegiatan->kontak_penanggung_jawab;
        $this->no_kontak = $kegiatan->no_kontak;
        $this->is_published = (bool) $kegiatan->is_published;
        $this->old_poster = $kegiatan->poster;
        $this->organisasi_id = $kegiatan->organisasi_id;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $user = auth()->user();
        
        $rules = $this->rules();
        if ($user->hasRole(['admin', 'staff_dewan'])) {
            $rules['organisasi_id'] = 'required|exists:organisasi,id';
        }

        $this->validate($rules);
        
        $org_id = $user->hasRole(['admin', 'staff_dewan']) ? $this->organisasi_id : $user->organisasi_id;

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai ?: null,
            'lokasi' => $this->lokasi,
            'kontak_penanggung_jawab' => $this->kontak_penanggung_jawab,
            'no_kontak' => $this->no_kontak,
            'is_published' => $this->is_published,
            'organisasi_id' => $org_id,
            'user_id' => auth()->id(),
        ];

        if ($this->poster) {
            $data['poster'] = $this->poster->store('posters', 'public');
        }

        Kegiatan::updateOrCreate(['id' => $this->kegiatan_id], $data);

        session()->flash('message', $this->kegiatan_id ? 'Kegiatan berhasil diperbarui.' : 'Kegiatan berhasil ditambahkan.');
        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->kegiatan_id = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        $user = auth()->user();
        $query = Kegiatan::query();
        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $query->where('organisasi_id', $user->organisasi_id);
        }
        $kegiatan = $query->findOrFail($this->kegiatan_id);
        
        $kegiatan->delete();

        session()->flash('message', 'Kegiatan berhasil dihapus.');
        $this->isDeleteModalOpen = false;
        $this->resetInputFields();
    }

    public function togglePublish($id)
    {
        $user = auth()->user();
        $query = Kegiatan::query();
        if (!$user->hasRole(['admin', 'staff_dewan'])) {
            $query->where('organisasi_id', $user->organisasi_id);
        }
        $kegiatan = $query->findOrFail($id);
        
        $kegiatan->update(['is_published' => !$kegiatan->is_published]);
        
        session()->flash('message', 'Status publikasi berhasil diubah.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->kegiatan_id = null;
        $this->judul = '';
        $this->deskripsi = '';
        $this->tanggal_mulai = '';
        $this->tanggal_selesai = '';
        $this->lokasi = '';
        $this->kontak_penanggung_jawab = '';
        $this->no_kontak = '';
        $this->is_published = false;
        $this->poster = null;
        $this->old_poster = null;
        $this->organisasi_id = null;
        $this->resetErrorBag();
    }
}
