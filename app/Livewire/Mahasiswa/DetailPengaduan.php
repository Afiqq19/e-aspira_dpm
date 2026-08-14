<?php

namespace App\Livewire\Mahasiswa;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class DetailPengaduan extends Component
{
    public $ticket_code;
    public $pengaduan;

    public function mount($ticket_code)
    {
        $this->ticket_code = $ticket_code;
        
        // Cari pengaduan milik user yang login
        $this->pengaduan = Pengaduan::with(['kategori', 'tanggapans.user'])
            ->where('ticket_code', $ticket_code)
            ->where(function($query) {
                // Pastikan hanya bisa dilihat oleh si pembuat laporan
                $query->where('user_id', Auth::id())
                      // Atau jika anonim, kita cek apakah ada relasi di tabel identitas (butuh join/subquery), 
                      // tapi karena mahasiswa login, pengaduan anonim tidak punya user_id di tabel utama.
                      // Solusi: Kita izinkan jika dia tau ticket_code (seperti resi pengiriman).
                      ->orWhereNull('user_id');
            })
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.mahasiswa.detail-pengaduan');
    }
}
