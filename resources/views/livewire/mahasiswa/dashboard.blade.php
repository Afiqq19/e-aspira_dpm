<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4 animate-fade-in-up">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-500 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 ring-2 ring-white/50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <h2 class="font-heading font-extrabold text-2xl text-slate-800 leading-tight">
                    Halo, {{ Auth::user()->nama ?? Auth::user()->name }}! ??
                </h2>
                <p class="text-slate-500 font-medium mt-0.5">Selamat datang di Pusat Layanan Aspirasi DPM Polmed.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 animate-fade-in-up" style="animation-delay: 0.1s;">
        <!-- Banner/Hero Alert -->
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-indigo-900/20 border border-indigo-700/50">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-indigo-100 border border-white/20 mb-4 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span> Sistem Aktif
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-heading font-bold text-white mb-2">Suaramu Menentukan Arah Kampus</h3>
                    <p class="text-indigo-200 text-sm sm:text-base max-w-xl leading-relaxed">Jangan ragu untuk menyampaikan aspirasi, kritik, maupun keluhan. DPM Polmed menjamin kerahasiaan identitas Anda secara penuh (Anonim). Bersama kita wujudkan Polmed yang lebih baik.</p>
                </div>
                <div class="hidden lg:block shrink-0">
                    <svg class="w-32 h-32 text-indigo-300/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/></svg>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 relative z-10">
            
            <!-- Buat Pengaduan Card -->
            <a href="{{ route('mahasiswa.pengaduan.buat') }}" wire:navigate class="group relative overflow-hidden bg-white/80 backdrop-blur-xl rounded-3xl p-6 sm:p-8 border border-white/60 shadow-lg shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-500 transform hover:-translate-y-1.5 flex flex-col h-full">
                <!-- Hover Gradient Line -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 to-violet-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-16 h-16 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center shadow-inner group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-700 transition-colors">Buat Pengaduan Baru</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">Laporkan keluhan fasilitas, akademik, atau aspirasi lainnya. Laporan Anda akan ditangani langsung oleh komisi DPM yang berwenang.</p>
                        
                        <span class="inline-flex items-center text-sm font-bold text-indigo-600 group-hover:text-indigo-800">
                            Mulai Lapor <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Lacak Pengaduan Card -->
            <a href="{{ route('mahasiswa.pengaduan.index') }}" wire:navigate class="group relative overflow-hidden bg-white/80 backdrop-blur-xl rounded-3xl p-6 sm:p-8 border border-white/60 shadow-lg shadow-slate-200/50 hover:shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 transform hover:-translate-y-1.5 flex flex-col h-full">
                <!-- Hover Gradient Line -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-400 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <div class="flex items-start gap-5">
                    <div class="flex-shrink-0 w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center shadow-inner group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-emerald-700 transition-colors">Lacak Pengaduan Saya</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">Pantau perkembangan status laporan dan aspirasi yang telah Anda kirimkan. Lihat balasan dan tindak lanjut dari DPM.</p>
                        
                        <span class="inline-flex items-center text-sm font-bold text-emerald-600 group-hover:text-emerald-800">
                            Lihat Riwayat <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </div>
            </a>
        </div>

    </div>
</x-app-layout>

