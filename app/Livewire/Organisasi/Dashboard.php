<?php

namespace App\Livewire\Organisasi;

use Livewire\Component;

use Livewire\Attributes\Layout;
use App\Models\ProgramKerja;
use App\Models\EvaluasiProker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $orgId = $user->organisasi_id;

        // 1. STATISTIK UMUM
        $totalProker = ProgramKerja::where('organisasi_id', $orgId)->count();
        $prokerBerjalan = ProgramKerja::where('organisasi_id', $orgId)->where('status', 'berjalan')->count();
        
        $totalEvaluasi = EvaluasiProker::whereHas('programKerja', function($q) use ($orgId) {
            $q->where('organisasi_id', $orgId);
        })->count();
        
        $avgRating = EvaluasiProker::whereHas('programKerja', function($q) use ($orgId) {
            $q->where('organisasi_id', $orgId);
        })->avg('rating') ?? 0;

        // 2. DATA CHART: Evaluasi per bulan (6 bulan terakhir)
        $bulanList = [];
        $evaluasiChart = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulanList[] = $date->translatedFormat('M Y');
            
            $evaluasiChart[] = EvaluasiProker::whereHas('programKerja', function($q) use ($orgId) {
                $q->where('organisasi_id', $orgId);
            })
            ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->count();
        }

        // 3. DATA CHART: Distribusi Aspek
        $aspekData = EvaluasiProker::select('aspek', DB::raw('count(*) as total'))
            ->whereHas('programKerja', function($q) use ($orgId) {
                $q->where('organisasi_id', $orgId);
            })
            ->groupBy('aspek')
            ->pluck('total', 'aspek')->toArray();
            
        $aspekLabels = ['Pendaftaran', 'Pelaksanaan', 'Manfaat', 'Koordinasi', 'Lainnya'];
        $aspekChart = [
            $aspekData['pendaftaran'] ?? 0,
            $aspekData['pelaksanaan'] ?? 0,
            $aspekData['manfaat'] ?? 0,
            $aspekData['koordinasi'] ?? 0,
            $aspekData['lainnya'] ?? 0,
        ];

        // 4. RECENT EVALUASI
        $recentEvaluasi = EvaluasiProker::with(['programKerja', 'user'])
            ->whereHas('programKerja', function($q) use ($orgId) {
                $q->where('organisasi_id', $orgId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.organisasi.dashboard', compact(
            'totalProker', 'prokerBerjalan', 'totalEvaluasi', 'avgRating',
            'bulanList', 'evaluasiChart', 'aspekLabels', 'aspekChart', 'recentEvaluasi'
        ));
    }
}
