<?php

namespace App\Livewire\Admin;

use App\Models\UuKema;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class KelolaUuKema extends Component
{
    use WithFileUploads;

    public $judul;
    public $file;
    public $isEdit = false;
    public $editId;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'file' => 'required|mimes:pdf|max:6144', // Max 3MB
    ];

    public function messages()
    {
        $fileSize = $this->file ? round($this->file->getSize() / 1024 / 1024, 2) : 0;
        return [
            "file.max" => "Ukuran file PDF yang Anda unggah terlalu besar ($fileSize MB). Maksimal ukuran yang diizinkan adalah 6 MB.",
            "file.required" => "File gagal diunggah (Server Nginx/Apache menolak) atau Anda belum memilih file. Pastikan ukuran di bawah 6 MB!",
        ];
    }

    public function simpan()
    {
        if ($this->isEdit) {
            $uu = UuKema::findOrFail($this->editId);
            $rules = [
                'judul' => 'required|string|max:255',
                'file' => 'nullable|mimes:pdf|max:6144',
            ];
            $this->validate($rules);
            
            if ($this->file) {
                Storage::disk('public')->delete($uu->file_path);
                $path = $this->file->store('uu_kema', 'public');
                $uu->file_path = $path;
            }
            
            $uu->judul = $this->judul;
            $uu->save();
            
            session()->flash('message', 'UU Kema berhasil diperbarui.');
        } else {
            $this->validate();
            
            $path = $this->file->store('uu_kema', 'public');
            
            UuKema::create([
                'judul' => $this->judul,
                'file_path' => $path,
            ]);
            
            session()->flash('message', 'UU Kema berhasil ditambahkan.');
        }
        
        $this->resetInput();
    }

    public function edit($id)
    {
        $uu = UuKema::findOrFail($id);
        $this->editId = $uu->id;
        $this->judul = $uu->judul;
        $this->isEdit = true;
    }

    public function hapus($id)
    {
        $uu = UuKema::findOrFail($id);
        Storage::disk('public')->delete($uu->file_path);
        $uu->delete();
        session()->flash('message', 'UU Kema berhasil dihapus.');
    }
    
    public function toggleActive($id)
    {
        $uu = UuKema::findOrFail($id);
        $uu->is_active = !$uu->is_active;
        $uu->save();
    }

    public function resetInput()
    {
        $this->judul = '';
        $this->file = null;
        $this->isEdit = false;
        $this->editId = null;
    }

    public function render()
    {
        return view('livewire.admin.kelola-uu-kema', [
            'daftarUu' => UuKema::latest()->get(),
        ]);
    }
}



