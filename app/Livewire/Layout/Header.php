<?php

namespace App\Livewire\Layout;

use App\Livewire\Actions\Logout;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public $searchQuery = '';

    public function searchTicket()
    {
        $this->validate([
            'searchQuery' => 'required|string',
        ]);
        
        $query = strtoupper(trim($this->searchQuery));
        
        // Coba cari apakah ini tiket code
        if (str_starts_with($query, 'PLP-')) {
            $exists = Pengaduan::where('ticket_code', $query)->exists();
            
            if ($exists) {
                // Redirect based on role
                $user = Auth::user();
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.pengaduan.detail', $query);
                } elseif ($user->hasRole('staff_dewan')) {
                    return redirect()->route('dewan.pengaduan.detail', $query);
                } else {
                    return redirect()->route('mahasiswa.pengaduan.detail', $query);
                }
            } else {
                $this->addError('searchQuery', 'Nomor tiket tidak ditemukan.');
            }
        } else {
            // Future: global search for other things. For now:
            $this->addError('searchQuery', 'Format tiket harus diawali PLP-');
        }
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.layout.header');
    }
}
