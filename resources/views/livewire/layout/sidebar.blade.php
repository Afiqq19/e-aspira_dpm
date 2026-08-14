<div class="w-64 bg-white border-r border-slate-200 flex flex-col h-screen z-10 shadow-sm shrink-0">
    <!-- Logo & Title -->
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <img src="{{ asset('images/icon_dpm.png') }}" class="w-8 h-8 object-contain drop-shadow-sm" alt="Logo">
        <span class="ml-3 font-heading font-bold text-slate-800 text-lg tracking-tight">e-Aspira <span class="text-indigo-600">DPM</span></span>
    </div>

    <!-- User Info Mini -->
    <div class="px-6 py-5 border-b border-slate-100">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Signed in as</p>
        <p class="font-medium text-slate-800 truncate">{{ auth()->user()->nama }}</p>
        <p class="text-xs text-indigo-600 font-medium mt-0.5 truncate">{{ auth()->user()->roles->first()->name }}</p>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        
        <!-- ADMIN MENU -->
        @role('admin')
            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4">Menu Admin</p>
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.dashboard') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.users') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Manajemen User</span>
            </a>
            <a href="{{ route('admin.pengumuman.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.pengumuman.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                <span class="font-medium">Pengumuman DPM</span>
            </a>
            <a href="{{ route('admin.pengaduan.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.pengaduan.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <span class="font-medium">Pengaduan Umum</span>
            </a>
            <a href="{{ route('admin.evaluasi-proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.evaluasi-proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Evaluasi Proker</span>
            </a>
            <a href="{{ route('admin.proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kelola Proker</span>
            </a>
            <a href="{{ route('admin.kegiatan.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.kegiatan.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kelola Kegiatan</span>
            </a>
            <a href="{{ route('admin.log-aktivitas') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('admin.log-aktivitas') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Log Aktivitas</span>
            </a>
        @endrole

        <!-- STAFF DEWAN MENU -->
        @role('staff_dewan')
            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4">Menu Staff</p>
            <a href="{{ route('dewan.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('dewan.dashboard') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('dewan.pengaduan.index') }}" wire:navigate class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('dewan.pengaduan.index') }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <span class="font-medium">Pengaduan Umum</span>
                </div>
            </a>
            <a href="{{ route('dewan.pengumuman.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('dewan.pengumuman.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                <span class="font-medium">Pengumuman DPM</span>
            </a>
            <a href="{{ route('dewan.evaluasi-proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('dewan.evaluasi-proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Evaluasi Proker</span>
            </a>
            <a href="{{ route('dewan.proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('dewan.proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kelola Proker</span>
            </a>
            <a href="{{ route('dewan.kegiatan.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('dewan.kegiatan.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kelola Kegiatan</span>
            </a>
            @can('penanganan_kasus_sensitif')
            <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-rose-600 hover:bg-rose-50">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span class="font-medium">Kasus Sensitif</span>
                </div>
            </a>
            @endcan
        @endrole

        <!-- ORGANISASI (HMPS/UKM) MENU -->
        @if(auth()->user()->hasRole('hmps') || auth()->user()->hasRole('ukm'))
            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4">Menu Organisasi</p>
            <a href="{{ route('organisasi.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('organisasi.dashboard') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('organisasi.pengumuman.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('organisasi.pengumuman.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                <span class="font-medium">Pengumuman</span>
            </a>
            <a href="{{ route('organisasi.kegiatan.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('organisasi.kegiatan.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kegiatan</span>
            </a>
            <a href="{{ route('organisasi.proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('organisasi.proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Program Kerja</span>
            </a>
            <a href="{{ route('organisasi.evaluasi-bem.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('organisasi.evaluasi-bem.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span class="font-medium">Evaluasi BEM</span>
            </a>
            <a href="{{ route('organisasi.evaluasi-proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('organisasi.evaluasi-proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Kritik Masuk</span>
            </a>
        @endif

        <!-- MAHASISWA MENU -->
        @role('mahasiswa')
            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4">Menu Mahasiswa</p>
            <a href="{{ route('mahasiswa.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('mahasiswa.dashboard') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('mahasiswa.pengaduan.buat') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('mahasiswa.pengaduan.buat') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-medium">Buat Pengaduan</span>
            </a>
            <a href="{{ route('mahasiswa.pengaduan.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('mahasiswa.pengaduan.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Pengaduan Saya</span>
            </a>
            <a href="{{ route('mahasiswa.evaluasi-proker.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $this->isActive('mahasiswa.evaluasi-proker.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span class="font-medium">Evaluasi Proker</span>
            </a>
        @endrole
    </nav>
</div>
