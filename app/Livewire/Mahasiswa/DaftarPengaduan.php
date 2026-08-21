<?php

namespace App\Livewire\Mahasiswa;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class DaftarPengaduan extends Component
{
    use WithPagination;
    public $searchTicketCode = '';

    public function lacakAnonim()
    {
        $this->validate([
            'searchTicketCode' => 'required|string|starts_with:PLP-',
        ], [
            'searchTicketCode.required' => 'Nomor tiket wajib diisi.',
            'searchTicketCode.starts_with' => 'Format nomor tiket tidak valid (harus diawali PLP-).',
        ]);

        // Cek apakah tiket ada
        $exists = Pengaduan::where('ticket_code', $this->searchTicketCode)->exists();

        if ($exists) {
            return redirect()->route('mahasiswa.pengaduan.detail', $this->searchTicketCode);
        } else {
            $this->addError('searchTicketCode', 'Nomor tiket tidak ditemukan.');
        }
    }

    public function render()
    {
        return view('livewire.mahasiswa.daftar-pengaduan', [
            'pengaduanUmum' => Pengaduan::where('user_id', Auth::id())->latest()->paginate(10),
        ]);
    }
}

