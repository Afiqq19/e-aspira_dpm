<?php

namespace App\Livewire\StaffDewan;

use App\Models\Pengaduan;
use App\Models\TanggapanPengaduan;
use App\Services\EnkripsiIdentitasService;
use App\Traits\MencatatAktivitas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class DetailPengaduan extends Component
{
    use MencatatAktivitas;

    public $ticket_code;
    public $pengaduan;
    public $isi_tanggapan;
    
    // Status update from detail
    public $status_baru;
    
    // Decrypted Identity
    public $identitasPelapor = null;

    public function mount($ticket_code, EnkripsiIdentitasService $enkripsiService)
    {
        $this->ticket_code = $ticket_code;
        $this->pengaduan = Pengaduan::with(['kategori', 'tanggapans.user', 'user'])->where('ticket_code', $ticket_code)->firstOrFail();
        
        $this->status_baru = $this->pengaduan->status;

        // Buka identitas otomatis jika mode anonim dan user berhak (opsional: atau biarkan tertutup sampai diklik)
        // Sesuai UI sebelumnya, Staff bisa buka jika ada permission 'penanganan_kasus_sensitif'
        if ($this->pengaduan->mode_privasi === 'anonim' && Auth::user()->can('penanganan_kasus_sensitif')) {
            $this->identitasPelapor = $enkripsiService->bukaIdentitas($this->pengaduan);
        }
    }

    public function balasTanggapan()
    {
        $this->validate([
            'isi_tanggapan' => 'required|string|min:5',
        ]);

        TanggapanPengaduan::create([
            'pengaduan_id' => $this->pengaduan->id,
            'user_id' => Auth::id(),
            'isi_tanggapan' => $this->isi_tanggapan,
            'is_internal' => false,
        ]);

        $this->catatLogBiasa('balas_tanggapan', $this->pengaduan, [
            'ticket_code' => $this->ticket_code,
            'oleh' => Auth::user()->nama,
        ]);

        $this->isi_tanggapan = '';
        $this->pengaduan->refresh();
        session()->flash('success_tanggapan', 'Tanggapan berhasil dikirim!');
    }

    public function updateStatus()
    {
        if ($this->status_baru !== $this->pengaduan->status) {
            $this->pengaduan->status = $this->status_baru;
            $this->pengaduan->save();

            $this->catatLogBiasa('update_status', $this->pengaduan, [
                'ticket_code' => $this->ticket_code,
                'status_baru' => $this->status_baru,
            ]);

            session()->flash('success_status', 'Status berhasil diperbarui!');
        }
    }

    public function render()
    {
        return view('livewire.staff-dewan.detail-pengaduan');
    }
}
