<?php

namespace App\Livewire\Mahasiswa;

use App\Models\EvaluasiProker as EvaluasiModel;
use App\Models\ProgramKerja;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class EvaluasiProker extends Component
{
    use WithPagination;

    public $search = '';
    public $filterOrganisasi = '';
    
    public $isModalOpen = false;
    
    // Form fields
    public $proker_id;
    public $rating = 5;
    public $komentar = '';
    public $aspek = 'pelaksanaan';
    public $aspek_lainnya = '';
    public $is_anonim = false;
    public $selectedProker = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFilterOrganisasi()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        
        $prokers = ProgramKerja::with('organisasi')
            ->where('is_active', true)
            ->when($user->hasRole(['hmps', 'ukm']), function($q) {
                $q->whereHas('organisasi', function($q2) {
                    $q2->where('nama', 'like', '%BEM%')->orWhere('tipe', 'BEM');
                });
            })
            ->when($this->search, function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhereHas('organisasi', function($q2) {
                      $q2->where('nama', 'like', '%' . $this->search . '%')
                         ->orWhere('singkatan', 'like', '%' . $this->search . '%');
                  });
            })
            ->when($this->filterOrganisasi, function($q) {
                $q->where('organisasi_id', $this->filterOrganisasi);
            })
            ->latest()
            ->paginate(12);
            
        // Ambil daftar organisasi yang punya proker aktif
        $orgQuery = \App\Models\Organisasi::whereHas('programKerja', function($q) {
            $q->where('is_active', true);
        });
        
        if ($user->hasRole(['hmps', 'ukm'])) {
            $orgQuery->where('nama', 'like', '%BEM%')->orWhere('tipe', 'BEM');
        }
        
        $organisasis = $orgQuery->get();

        return view('livewire.mahasiswa.evaluasi-proker', compact('prokers', 'organisasis', 'user'));
    }

    public function bukaModalEvaluasi($id)
    {
        $this->selectedProker = ProgramKerja::with('organisasi')->findOrFail($id);
        $this->proker_id = $id;
        
        // Cek apakah user sudah pernah evaluasi proker ini
        $existingEvaluasi = EvaluasiModel::where('program_kerja_id', $id)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($existingEvaluasi) {
            $this->rating = $existingEvaluasi->rating;
            $this->aspek = $existingEvaluasi->aspek;
            $this->is_anonim = $existingEvaluasi->is_anonim;
            
            // Cek apakah komentar memiliki prefix [Aspek: ...]
            if ($this->aspek === 'lainnya' && preg_match('/^\[Aspek: (.*?)\]\n(.*)/s', $existingEvaluasi->komentar, $matches)) {
                $this->aspek_lainnya = $matches[1];
                $this->komentar = trim($matches[2]);
            } else {
                $this->komentar = $existingEvaluasi->komentar;
                $this->aspek_lainnya = '';
            }
        } else {
            $this->rating = 5;
            $this->komentar = '';
            $this->aspek = 'pelaksanaan';
            $this->aspek_lainnya = '';
            $this->is_anonim = false;
        }
        
        $this->isModalOpen = true;
    }

    public function setRating($val)
    {
        $this->rating = $val;
    }

    public function simpanEvaluasi()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10',
            'aspek' => 'required|in:pendaftaran,pelaksanaan,manfaat,koordinasi,lainnya',
            'aspek_lainnya' => 'required_if:aspek,lainnya',
            'is_anonim' => 'boolean',
        ], [
            'aspek_lainnya.required_if' => 'Aspek lainnya wajib diisi jika Anda memilih Lainnya.'
        ]);

        $user = auth()->user();
        
        $finalKomentar = $this->komentar;
        if ($this->aspek === 'lainnya' && !empty($this->aspek_lainnya)) {
            $finalKomentar = "[Aspek: " . $this->aspek_lainnya . "]\n" . $this->komentar;
        }
        
        EvaluasiModel::updateOrCreate(
            [
                'program_kerja_id' => $this->proker_id,
                'user_id' => $user->id,
            ],
            [
                'rating' => $this->rating,
                'komentar' => $finalKomentar,
                'aspek' => $this->aspek,
                // HMPS/UKM/Staff Dewan boleh anonim, tapi Admin selalu LIHAT nama asli (dihandle di view)
            'is_anonim' => $this->is_anonim,
            ]
        );

        $this->isModalOpen = false;
        session()->flash('message', 'Evaluasi Anda berhasil dikirim. Terima kasih atas partisipasinya!');
    }
}
