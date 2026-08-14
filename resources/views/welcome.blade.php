<x-publik-layout>
        <!-- Hero Section (Ultra Modern Split Layout) -->
        <section id="beranda" class="relative pt-20 pb-24 lg:pt-24 lg:pb-32 overflow-hidden">
            <!-- Background Orbs specific to Hero -->
            <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[100px] mix-blend-multiply animate-blob pointer-events-none"></div>
            <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-purple-500/20 rounded-full blur-[100px] mix-blend-multiply animate-blob animation-delay-2000 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left Content: Text & CTA -->
                    <div class="flex flex-col items-start text-left">
                        <!-- Modern Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100/80 shadow-sm mb-6 animate-slide-up">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            <span class="text-xs font-bold tracking-wide text-indigo-700 uppercase">Platform Resmi DPM Polmed</span>
                        </div>
                        
                        <!-- Massive Typography -->
                        <h1 class="text-4xl sm:text-5xl lg:text-5xl xl:text-[3.5rem] font-heading font-extrabold tracking-tight text-slate-800 leading-[1.15] mb-6 animate-slide-up [animation-delay:100ms]">
                            Sampaikan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 animate-gradient-x">Aspirasi,</span><br>
                            Kawal Kinerja BEM POLMED.
                        </h1>
                        
                        <p class="text-base md:text-lg text-slate-500 mb-10 max-w-xl leading-relaxed animate-slide-up [animation-delay:200ms]">
                            Ruang digital yang aman dan transparan bagi <strong>Mahasiswa</strong> untuk menyuarakan pengaduan, serta wadah resmi bagi <strong>HMPS & UKM</strong> untuk mengawal dan mengevaluasi Program Kerja BEM Politeknik Negeri Medan.
                        </p>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto animate-slide-up [animation-delay:300ms]">
                            @auth
                                <a href="{{ route('home') }}" class="group relative inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold text-base md:text-lg overflow-hidden transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_8px_rgba(79,70,229,0.3)]">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <span class="relative">Masuk ke Dashboard</span>
                                    <svg class="w-5 h-5 relative transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold text-base md:text-lg overflow-hidden transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_8px_rgba(79,70,229,0.3)]">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <span class="relative">Buat Pengaduan</span>
                                    <svg class="w-5 h-5 relative transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                                <a href="#alur" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white/70 backdrop-blur-md text-slate-700 hover:text-indigo-600 rounded-2xl font-bold text-base md:text-lg border border-slate-200/50 hover:border-indigo-200 hover:bg-white shadow-sm transition-all hover:-translate-y-1">
                                    Pelajari Alur
                                </a>
                            @endauth
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="mt-12 flex items-center gap-6 text-sm font-medium text-slate-500 animate-slide-up [animation-delay:400ms]">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg></div>
                                <span>100% Rahasia</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                                <span>Respons Cepat</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Content: 3D Floating Glass Mockups (Centered nicely) -->
                    <div class="relative hidden lg:flex items-center justify-center h-[500px] xl:h-[600px] w-full perspective-1000">
                        <!-- Abstract Floating Container -->
                        <div class="relative w-[380px] xl:w-[420px] animate-float">
                            
                            <!-- Main Glass Card (Dashboard Mockup) -->
                            <div class="w-full bg-white/40 backdrop-blur-2xl border border-white/60 rounded-3xl p-6 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] [transform:perspective(1000px)_rotateX(5deg)_rotateY(-10deg)] transition-transform duration-700 hover:[transform:perspective(1000px)_rotateX(0deg)_rotateY(0deg)] z-20">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">Status Laporan Terakhir</div>
                                            <div class="text-xs text-slate-500 font-mono">{{ $latestPengaduan ? $latestPengaduan->ticket_code : '#BELUM-ADA' }}</div>
                                        </div>
                                    </div>
                                    @php
                                        $warnaBadge = $latestPengaduan ? $latestPengaduan->warna_badge_status : 'gray';
                                        $labelStatus = $latestPengaduan ? $latestPengaduan->label_status : 'Tidak Ada';
                                    @endphp
                                    <span class="px-3 py-1 bg-{{ $warnaBadge }}-100 text-{{ $warnaBadge }}-700 text-xs font-bold rounded-full">{{ $labelStatus }}</span>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                        @if($latestPengaduan && $latestPengaduan->status == 'selesai')
                                            <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 w-full rounded-full"></div>
                                        @elseif($latestPengaduan && in_array($latestPengaduan->status, ['diproses', 'ditindaklanjuti', 'diverifikasi']))
                                            <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 w-2/3 rounded-full animate-pulse"></div>
                                        @elseif($latestPengaduan && $latestPengaduan->status == 'diterima')
                                            <div class="h-full bg-gradient-to-r from-blue-400 to-blue-500 w-1/3 rounded-full"></div>
                                        @elseif($latestPengaduan && $latestPengaduan->status == 'ditolak')
                                            <div class="h-full bg-gradient-to-r from-red-400 to-red-500 w-full rounded-full"></div>
                                        @else
                                            <div class="h-full bg-slate-300 w-0 rounded-full"></div>
                                        @endif
                                    </div>
                                    <div class="flex justify-between text-[11px] font-medium text-slate-400">
                                        <span class="{{ $latestPengaduan ? 'text-blue-600' : '' }}">Diterima</span>
                                        <span class="{{ ($latestPengaduan && in_array($latestPengaduan->status, ['diproses', 'ditindaklanjuti', 'selesai'])) ? 'text-amber-600' : '' }}">Diproses</span>
                                        <span class="{{ ($latestPengaduan && $latestPengaduan->status == 'selesai') ? 'text-emerald-600' : '' }}">Selesai</span>
                                    </div>
                                </div>
                                
                                <div class="mt-6 p-4 bg-white/50 rounded-2xl border border-white/50">
                                    <div class="flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 shrink-0 flex items-center justify-center text-indigo-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <div class="flex-1">
                                            @if($latestPengaduan)
                                                <div class="h-2 w-3/4 bg-slate-200 rounded-full mb-2"></div>
                                                <div class="h-2 w-full bg-slate-200 rounded-full mb-1.5"></div>
                                                <div class="h-2 w-1/2 bg-slate-200 rounded-full"></div>
                                            @else
                                                <div class="h-2 w-24 bg-slate-200 rounded-full mb-2"></div>
                                                <div class="h-2 w-48 bg-slate-200 rounded-full mb-1.5"></div>
                                                <div class="h-2 w-32 bg-slate-200 rounded-full"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Stat Card 1 -->
                            <div class="absolute -bottom-12 -left-12 xl:-bottom-16 xl:-left-20 w-64 bg-white/70 backdrop-blur-xl border border-white shadow-2xl rounded-3xl p-5 [transform:perspective(1000px)_rotateX(10deg)_rotateY(-15deg)] animate-float [animation-delay:1000ms] z-30 hover:!translate-y-[-10px] transition-transform duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 xl:w-14 xl:h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                                        <svg class="w-6 h-6 xl:w-7 xl:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-2xl xl:text-3xl font-heading font-extrabold text-slate-800">{{ $totalAspirasi }}</div>
                                        <div class="text-xs xl:text-sm font-medium text-slate-500">Aspirasi Disampaikan</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Element 2 (Decorative) -->
                            <div class="absolute -top-10 -right-6 w-24 h-24 bg-gradient-to-tr from-indigo-400 to-teal-400 rounded-[2rem] transform rotate-[15deg] opacity-60 mix-blend-multiply blur-[2px] animate-float [animation-delay:2000ms] z-10"></div>
                            
                            <!-- Floating Element 3 (Decorative Ring) -->
                            <div class="absolute -bottom-8 -right-4 w-32 h-32 border-[8px] border-rose-400/30 rounded-full transform rotate-[45deg] animate-float [animation-delay:1500ms] z-10"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- Section Sekilas DPM (Summary) -->
        <section id="tentang" class="py-24 bg-white border-t border-slate-200/50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 mb-6">
                    <img src="{{ asset('images/icon_dpm.png') }}" class="w-12 h-12 object-contain" alt="DPM Logo">
                </div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-800 tracking-tight">Lebih Dekat dengan DPM</h2>
                <p class="mt-4 text-slate-600 max-w-2xl mx-auto text-lg">
                    Dewan Perwakilan Mahasiswa Politeknik Negeri Medan adalah lembaga legislatif tertinggi yang hadir untuk mengawal kedaulatan mahasiswa, memastikan aspirasi tersampaikan, dan mengawasi jalannya roda organisasi kampus.
                </p>
                <div class="mt-10">
                    <a href="{{ route('tentang') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-full font-bold shadow-lg hover:-translate-y-1 transition-all">
                        Kenali DPM Lebih Lanjut
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Section Pengumuman -->
        <section id="pengumuman" class="py-24 bg-white/50 backdrop-blur-sm border-t border-slate-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-800 tracking-tight">Pusat Informasi & Pengumuman</h2>
                    <p class="mt-4 text-slate-600 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar pengumuman penting dari DPM serta berbagai organisasi mahasiswa.</p>
                </div>
                
                <!-- Livewire Component -->
                @livewire('publik.daftar-pengumuman')
            </div>
        </section>

        <!-- Section Kegiatan -->
        <section id="kegiatan" class="py-24 bg-slate-50/50 backdrop-blur-sm border-t border-slate-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-800 tracking-tight">Agenda Kegiatan Kampus</h2>
                    <p class="mt-4 text-slate-600 max-w-2xl mx-auto">Pantau jadwal seminar, perlombaan, dan acara kemahasiswaan lainnya dari seluruh HMPS dan UKM.</p>
                </div>
                
                <!-- Livewire Component -->
                @livewire('publik.daftar-kegiatan')
            </div>
        </section>

        <!-- Section Program Kerja -->
        <section id="proker" class="py-24 bg-white/50 backdrop-blur-sm border-t border-slate-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-800 tracking-tight">Program Kerja Terbaru</h2>
                    <p class="mt-4 text-slate-600 max-w-2xl mx-auto">Daftar program kerja (Proker) dari BEM, HMPS, dan UKM yang saat ini sedang direncanakan atau berjalan.</p>
                </div>
                
                <!-- Livewire Component -->
                @livewire('publik.daftar-proker')
            </div>
        </section>
</x-publik-layout>
