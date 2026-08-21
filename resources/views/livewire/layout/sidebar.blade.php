<div x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" 
     class="fixed md:relative inset-y-0 left-0 w-72 md:w-64 flex flex-col h-screen z-40 
            transition-transform duration-300 ease-in-out
            bg-gradient-to-b from-slate-900 via-slate-900 to-indigo-950 shadow-2xl shrink-0">

    <!-- Logo & Title -->
    <div class="h-16 flex items-center justify-between px-5 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center p-1 flex-shrink-0">
                <img src="{{ asset('images/icon_dpm.png') }}" class="w-full h-full object-contain" alt="Logo">
            </div>
            <span class="font-heading font-bold text-white text-lg tracking-tight">e-Aspira <span class="text-indigo-400">DPM</span></span>
        </div>
        <!-- Close button (mobile only) -->
        <button @click="sidebarOpen = false" class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- User Info Mini -->
    <div class="px-4 py-4 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center gap-3 p-3 bg-white/5 rounded-2xl border border-white/10">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-extrabold text-base shadow-lg flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="font-semibold text-white text-sm truncate">{{ auth()->user()->nama }}</p>
                <p class="text-xs text-indigo-300 font-medium mt-0.5 capitalize truncate">{{ auth()->user()->roles->first()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

        <!-- ADMIN MENU -->
        @role('admin')
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-4">Menu Admin</p>
            <a href="{{ route('admin.dashboard') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('admin.dashboard') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('admin.users') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Manajemen User</span>
            </a>
            <a href="{{ route('admin.pengumuman.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('admin.pengumuman.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                <span class="font-medium">Pengumuman</span>
            </a>
            <a href="{{ route('admin.pengaduan.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('admin.pengaduan.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Data Pengaduan</span>
            </a>
            <a href="{{ route('admin.uu-kema.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('admin.uu-kema.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-medium">Kelola UU Kema</span>
            </a>
        @endrole

        <!-- STAFF DEWAN MENU -->
        @role('staff_dewan')
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-4">Menu Staff Dewan</p>
            <a href="{{ route('dewan.dashboard') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('dewan.dashboard') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('dewan.pengaduan.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('dewan.pengaduan.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Data Pengaduan</span>
            </a>
            <a href="{{ route('dewan.proker.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('dewan.proker.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Kelola Proker</span>
            </a>
            <a href="{{ route('dewan.kegiatan.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('dewan.kegiatan.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kelola Kegiatan</span>
            </a>
            <a href="{{ route('dewan.uu-kema.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('dewan.uu-kema.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="font-medium">Kelola UU Kema</span>
            </a>
        @endrole

        <!-- ORGANISASI (HMPS/UKM) MENU -->
        @if(auth()->user()->hasRole('hmps') || auth()->user()->hasRole('ukm'))
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-4">Menu Organisasi</p>
            <a href="{{ route('organisasi.dashboard') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('organisasi.dashboard') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('organisasi.pengumuman.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('organisasi.pengumuman.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                <span class="font-medium">Pengumuman</span>
            </a>
            <a href="{{ route('organisasi.kegiatan.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('organisasi.kegiatan.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Kegiatan</span>
            </a>
            <a href="{{ route('organisasi.proker.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('organisasi.proker.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Program Kerja</span>
            </a>
            <a href="{{ route('organisasi.evaluasi-bem.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('organisasi.evaluasi-bem.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <span class="font-medium">Evaluasi BEM</span>
            </a>
            <a href="{{ route('organisasi.evaluasi-proker.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('organisasi.evaluasi-proker.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="font-medium">Kritik Masuk</span>
            </a>
        @endif

        <!-- MAHASISWA MENU -->
        @role('mahasiswa')
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-4">Menu Mahasiswa</p>
            <a href="{{ route('mahasiswa.dashboard') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('mahasiswa.dashboard') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('mahasiswa.pengaduan.buat') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('mahasiswa.pengaduan.buat') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span class="font-medium">Buat Pengaduan</span>
            </a>
            <a href="{{ route('mahasiswa.pengaduan.index') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm {{ $this->isActiveClass('mahasiswa.pengaduan.index') }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Pengaduan Saya</span>
            </a>
        @endrole

    </nav>

    <!-- Bottom Logout -->
    <div class="p-4 border-t border-white/10 flex-shrink-0">
        <a href="{{ route('profile') }}" wire:navigate @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-colors text-slate-400 hover:text-white text-sm mb-1">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="font-medium">Profil Saya</span>
        </a>
        <button wire:click="logout" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-rose-500/20 transition-colors text-slate-400 hover:text-rose-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span class="font-medium">Keluar</span>
        </button>
    </div>
</div>
