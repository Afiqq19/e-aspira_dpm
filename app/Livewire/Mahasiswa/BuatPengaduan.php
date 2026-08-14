<?php

namespace App\Livewire\Mahasiswa;

use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use App\Services\EnkripsiIdentitasService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BuatPengaduan extends Component
{
    public $kategori_id;
    public $isi;
    public $mode_privasi = 'umum';

    public function render()
    {
        return view('livewire.mahasiswa.buat-pengaduan', [
            'kategoriList' => KategoriPengaduan::all(),
        ]);
    }

    public function submit(EnkripsiIdentitasService $enkripsiService)
    {
        $this->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'isi' => 'required|string|min:20',
            'mode_privasi' => 'required|in:umum,anonim',
        ], [
            'isi.min' => 'Isi pengaduan minimal 20 karakter untuk kejelasan.',
        ]);

        $kategori = KategoriPengaduan::find($this->kategori_id);
        
        $penanganan_khusus = $kategori->level_sensitivitas === 'tinggi' ? 1 : 0;
        
        // Auto-anonim jika sensitif
        if ($penanganan_khusus) {
            $this->mode_privasi = 'anonim';
        }

        // Generate Ticket Code (Format: PLP-2026-RANDOM)
        $ticketCode = 'PLP-' . date('Y') . '-' . strtoupper(substr(uniqid(), -4));

        $pengaduan = new Pengaduan();
        $pengaduan->ticket_code = $ticketCode;
        $pengaduan->kategori_id = $this->kategori_id;
        $pengaduan->isi = $this->isi;
        $pengaduan->mode_privasi = $this->mode_privasi;
        $pengaduan->status = 'diterima';
        $pengaduan->penanganan_khusus = $penanganan_khusus;

        if ($this->mode_privasi === 'anonim') {
            $pengaduan->user_id = null; // Identitas dikosongkan di tabel utama
            $pengaduan->save();
            
            // Simpan identitas asli terenkripsi
            $enkripsiService->simpanIdentitas($pengaduan, [
                'user_id' => Auth::id(),
                'nama' => Auth::user()->nama,
                'nim' => Auth::user()->nim,
                'email' => Auth::user()->email,
            ]);
        } else {
            $pengaduan->user_id = Auth::id();
            $pengaduan->save();
        }

        session()->flash('success', 'Pengaduan berhasil dikirim! Kode Tiket pelacakan Anda: ' . $ticketCode);
        return redirect()->route('mahasiswa.pengaduan.index');
    }
}
