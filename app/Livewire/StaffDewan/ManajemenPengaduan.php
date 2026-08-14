<?php

namespace App\Livewire\StaffDewan;

use App\Models\Pengaduan;
use App\Services\EnkripsiIdentitasService;
use App\Traits\MencatatAktivitas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ManajemenPengaduan extends Component
{
    use WithPagination, MencatatAktivitas;

    public $search = '';
    public $statusFilter = '';
    
    // Menyimpan identitas yang sementara didekripsi di memori sesi komponen ini
    public $identitasTerbuka = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**
     * Membuka enkripsi identitas pelapor untuk pengaduan anonim.
     * Hanya bisa diakses oleh staff dengan permission 'penanganan_kasus_sensitif'.
     */
    public function bukaIdentitas($id, EnkripsiIdentitasService $enkripsiService)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if (!Auth::user()->can('penanganan_kasus_sensitif')) {
            session()->flash('error', 'AKSES DITOLAK: Anda tidak memiliki izin (Permission) untuk membuka identitas kasus sensitif.');
            return;
        }

        $identitasAsli = $enkripsiService->bukaIdentitas($pengaduan);

        if ($identitasAsli) {
            $this->identitasTerbuka[$id] = $identitasAsli;
            
            // Catat log aktivitas menggunakan Trait yang sudah kita buat
            $this->catatLogSensitif('buka_identitas_anonim', $pengaduan, [
                'ticket_code' => $pengaduan->ticket_code,
                'kategori' => $pengaduan->kategori->nama_kategori ?? 'Umum',
                'ip_address' => request()->ip(),
            ]);
            
            session()->flash('success_decrypt', 'Identitas berhasil didekripsi & Log Aktivitas telah dicatat.');
        } else {
            session()->flash('error', 'Gagal mendekripsi identitas atau data tidak ditemukan.');
        }
    }

    public function tutupIdentitas($id)
    {
        if (isset($this->identitasTerbuka[$id])) {
            unset($this->identitasTerbuka[$id]);
        }
    }

    public function updateStatus($id, $statusBaru)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $statusBaru;
        $pengaduan->save();
        
        session()->flash('message', 'Status pengaduan ' . $pengaduan->ticket_code . ' diperbarui.');
    }

    public function render()
    {
        $query = Pengaduan::with(['kategori', 'user'])->latest();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('ticket_code', 'like', '%' . $this->search . '%')
                  ->orWhere('isi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.staff-dewan.manajemen-pengaduan', [
            'pengaduans' => $query->paginate(10),
        ]);
    }
}
