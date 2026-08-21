<?php

use Illuminate\Support\Facades\Route;

// Halaman Utama / Landing Page (Pengumuman & Kalender Umum)
Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard.redirect');
    }
    $totalAspirasi = \App\Models\Pengaduan::count();
    $latestPengaduan = (object)[ 'ticket_code' => 'PLP-2026-X1Y2', 'warna_badge_status' => 'amber', 'label_status' => 'Sedang Diproses', 'status' => 'diproses' ];
    return view('welcome', compact('totalAspirasi', 'latestPengaduan'));
})->name('home');

// Halaman Khusus Profil DPM (Tentang Kami)
Route::get('/tentang', \App\Livewire\Publik\TentangKami::class)->name('tentang');

// Halaman Legal & Privasi
Route::get('/syarat-ketentuan', \App\Livewire\Publik\SyaratKetentuan::class)->name('syarat');
Route::get('/kebijakan-privasi', \App\Livewire\Publik\KebijakanPrivasi::class)->name('privasi');

// =====================================================================
// OAUTH GOOGLE ROUTES
// =====================================================================
Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callback']);

// =====================================================================
// RUTE SETELAH LOGIN (Terlindungi Auth)
// =====================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Profil (Bisa diakses semua role)
    Route::view('profile', 'profile.index')->name('profile');
    Route::get('/dashboard-redirect', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('staff_dewan')) return redirect()->route('dewan.dashboard');
        if ($user->hasRole('hmps') || $user->hasRole('ukm')) return redirect()->route('organisasi.dashboard');
        return redirect()->route('mahasiswa.dashboard');
    })->name('dashboard.redirect');

    // 1. ADMIN ROUTES
    Route::middleware('check.role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        // Manajemen User (Livewire)
        Route::get('users', \App\Livewire\Admin\UserManagement::class)->name('users');
        // Manajemen Pengumuman
        Route::get('pengumuman', \App\Livewire\Admin\KelolaPengumuman::class)->name('pengumuman.index');
        // Log Aktivitas
        Route::get('log-aktivitas', \App\Livewire\Admin\LogAktivitas::class)->name('log-aktivitas');
        // Manajemen Pengaduan
        Route::get('pengaduan', \App\Livewire\StaffDewan\ManajemenPengaduan::class)->name('pengaduan.index');
        Route::get('pengaduan/{ticket_code}', \App\Livewire\StaffDewan\DetailPengaduan::class)->name('pengaduan.detail');
        // Pantau Evaluasi Proker
        Route::get('evaluasi-proker', \App\Livewire\StaffDewan\PantauEvaluasi::class)->name('evaluasi-proker.index');
        // Kelola Proker
        Route::get('proker', \App\Livewire\Organisasi\KelolaProker::class)->name('proker.index');
        // Kelola Kegiatan
        Route::get('kegiatan', \App\Livewire\Organisasi\KelolaKegiatan::class)->name('kegiatan.index');
    });

    // 2. STAFF DEWAN ROUTES
    Route::middleware('check.role:staff_dewan')->prefix('dewan')->name('dewan.')->group(function () {
        Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        
        // Manajemen Pengaduan
        Route::get('pengaduan', \App\Livewire\StaffDewan\ManajemenPengaduan::class)->name('pengaduan.index');
        Route::get('pengaduan/{ticket_code}', \App\Livewire\StaffDewan\DetailPengaduan::class)->name('pengaduan.detail');
        
        // Manajemen Pengumuman DPM
        Route::get('pengumuman', \App\Livewire\Admin\KelolaPengumuman::class)->name('pengumuman.index');
        
        // Rute sensitif dengan middleware tambahan 'sensitif'
        // Route::get('pengaduan-sensitif', ...)->middleware('sensitif')->name('pengaduan.sensitif');
        
        // Pantau Evaluasi Proker
        Route::get('evaluasi-proker', \App\Livewire\StaffDewan\PantauEvaluasi::class)->name('evaluasi-proker.index');
        
        // Kelola Proker
        Route::get('proker', \App\Livewire\Organisasi\KelolaProker::class)->name('proker.index');
        
        // Kelola Kegiatan
        Route::get('kegiatan', \App\Livewire\Organisasi\KelolaKegiatan::class)->name('kegiatan.index');

        // Beri Evaluasi ke BEM (Staff Dewan bisa ikut memberi evaluasi)
        Route::get('evaluasi-bem', \App\Livewire\Mahasiswa\EvaluasiProker::class)->name('evaluasi-bem.index');
    });

    // 3. HMPS / UKM ROUTES (Organisasi)
    Route::middleware('check.role:hmps,ukm')->prefix('organisasi')->name('organisasi.')->group(function () {
        Route::get('dashboard', \App\Livewire\Organisasi\Dashboard::class)->name('dashboard');
        
        // Manajemen Pengumuman Organisasi
        Route::get('pengumuman', \App\Livewire\Organisasi\KelolaPengumuman::class)->name('pengumuman.index');
        
        // Manajemen Kegiatan Organisasi
        Route::get('kegiatan', \App\Livewire\Organisasi\KelolaKegiatan::class)->name('kegiatan.index');

        // Manajemen Program Kerja
        Route::get('proker', \App\Livewire\Organisasi\KelolaProker::class)->name('proker.index');

        // Berikan Evaluasi ke BEM
        Route::get('evaluasi-bem', \App\Livewire\Mahasiswa\EvaluasiProker::class)->name('evaluasi-bem.index');

        // Pantau Evaluasi (Melihat kritikan masuk untuk prokernya sendiri)
        Route::get('evaluasi-proker', \App\Livewire\StaffDewan\PantauEvaluasi::class)->name('evaluasi-proker.index');
    });

    // 4. MAHASISWA ROUTES
    Route::middleware('check.role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::view('dashboard', 'livewire.mahasiswa.dashboard')->name('dashboard');
        
        Route::get('pengaduan/buat', \App\Livewire\Mahasiswa\BuatPengaduan::class)->name('pengaduan.buat');
        Route::get('pengaduan', \App\Livewire\Mahasiswa\DaftarPengaduan::class)->name('pengaduan.index');
        Route::get('pengaduan/{ticket_code}', \App\Livewire\Mahasiswa\DetailPengaduan::class)->name('pengaduan.detail');
    });
});
// ============================================================
// AUTO DEPLOY WEBHOOK 
// ============================================================
Route::get('/update-rahasia-mss', function () {
    $gitPath = 'git';
    if (file_exists('D:\laragon\bin\git\cmd\git.exe')) {
        $gitPath = 'D:\laragon\bin\git\cmd\git.exe';
    } elseif (file_exists('C:\laragon\bin\git\cmd\git.exe')) {
        $gitPath = 'C:\laragon\bin\git\cmd\git.exe';
    }
    
    putenv('GIT_TERMINAL_PROMPT=0');
    putenv('GCM_INTERACTIVE=false');
    
    $repoDir = base_path(); // base_path for Laravel project
    
    // Perintah sakti untuk update, install, dan migrate
    $output0 = shell_exec("cd \"$repoDir\" && \"$gitPath\" config --local credential.helper manager-core 2>&1");
    $output1 = shell_exec("cd \"$repoDir\" && \"$gitPath\" fetch --all 2>&1");
    $output2 = shell_exec("cd \"$repoDir\" && \"$gitPath\" reset --hard origin/main 2>&1");
    $output3 = shell_exec("cd \"$repoDir\" && composer install 2>&1");
    $output4 = shell_exec("cd \"$repoDir\" && php artisan migrate --force 2>&1");
    $output5 = shell_exec("cd \"$repoDir\" && npm install 2>&1");
    $output6 = shell_exec("cd \"$repoDir\" && npm run build 2>&1");
    
    return "<h1 style='color:green;'>Berhasil Menarik Kodingan Baru & Update Sistem oleh MSS!</h1>
            <h3>Laporan Log:</h3>
            <pre style='background:#333;color:#0f0;padding:20px;border-radius:10px;'>
[GIT CONFIG]
" . htmlspecialchars((string) $output0) . "

[GIT FETCH & PULL]
" . htmlspecialchars((string) $output1) . "
" . htmlspecialchars((string) $output2) . "

[COMPOSER INSTALL]
" . htmlspecialchars((string) $output3) . "

[DATABASE MIGRATE]
" . htmlspecialchars((string) $output4) . "

[NPM BUILD (TAMPILAN)]
" . htmlspecialchars((string) $output5) . "
" . htmlspecialchars((string) $output6) . "
            </pre>";
});

require __DIR__.'/auth.php';



