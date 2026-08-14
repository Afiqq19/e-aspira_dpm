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

    public function render()
    {
        // Get all pengaduan of the logged-in user OR where the user_id is null but we can track it by identifying the encrypted identity? 
        // Wait, if it's completely anonymous, how does the user see it?
        // Ah! In PROMPT: "Nomor tiket unik otomatis untuk pelacakan tanpa membuka identitas"
        // And "Pelapor memantau status via nomor tiket tanpa perlu membuka ulang identitas"
        // Wait, if we set user_id = null, they can't see it in "My list" easily unless we track it by session or ticket search.
        // Or we can save user_id in Pengaduan BUT still encrypt the sensitive info in another table?
        // If we save user_id in pengaduan, then staff can see it by looking at the user_id!
        // To truly make it anonymous from staff, user_id MUST be null.
        // Therefore, Mahasiswa needs a feature to "Search Ticket by Code" to track it.
        // OR we can store the ticket codes in the user's session, or we can use another intermediate table.
        // Let's implement a Ticket Search approach in DaftarPengaduan, AND list non-anonymous ones.

        return view('livewire.mahasiswa.daftar-pengaduan', [
            'pengaduanUmum' => Pengaduan::where('user_id', Auth::id())->latest()->get(),
        ]);
    }
}
