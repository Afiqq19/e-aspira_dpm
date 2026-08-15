<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <h2 class="font-heading font-bold text-xl text-slate-800 leading-tight">
                    Halo, {{ Auth::user()->nama ?? Auth::user()->name }}! 👋
                </h2>
                <p class="text-sm text-slate-500 font-medium">Selamat datang di Dashboard Mahasiswa e-Aspira DPM Polmed.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Quick Actions (Glass Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Buat Pengaduan Card -->
            <a href="{{ route('mahasiswa.pengaduan.buat') }}" wire:navigate class="group relative overflow-hidden glass rounded-3xl p-6 md:p-8 hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-300 hover:-translate-y-1 border border-white/60">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-indigo-500/20 transition-colors"></div>
                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-700 transition-colors">Buat Laporan / Pengaduan</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Laporkan keluhan, temuan, atau aspirasi Anda. Rahasia dijamin 100% aman oleh DPM.</p>
                    </div>
                </div>
            </a>

            <!-- Lacak Pengaduan Card -->
            <a href="{{ route('mahasiswa.pengaduan.index') }}" wire:navigate class="group relative overflow-hidden glass rounded-3xl p-6 md:p-8 hover:shadow-2xl hover:shadow-emerald-500/20 transition-all duration-300 hover:-translate-y-1 border border-white/60">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-emerald-500/20 transition-colors"></div>
                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-emerald-700 transition-colors">Lacak Pengaduan Saya</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Pantau status laporan dan aspirasi yang telah Anda kirimkan ke DPM.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Riwayat Singkat (Optional for future) -->
        <div class="glass rounded-3xl p-6 md:p-8 border border-white/60">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Aktivitas Terakhir Anda
            </h3>
            
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h4 class="text-slate-700 font-medium mb-1">Belum ada aktivitas</h4>
                <p class="text-sm text-slate-500 max-w-sm">Anda belum membuat laporan pengaduan atau memberikan evaluasi BEM. Mulai suarakan aspirasi Anda sekarang!</p>
                <a href="{{ route('mahasiswa.pengaduan.buat') }}" wire:navigate class="mt-6 px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-slate-500/20">
                    Buat Laporan Pertama
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
