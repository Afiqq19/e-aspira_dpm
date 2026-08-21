<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'e-Aspira') }} - DPM Polmed</title>
        <link rel="icon" type="image/png" href="{{ asset('images/icon_dpm.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
            @livewireStyles
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800 overflow-x-hidden">
        <!-- Background Effects -->
        <div class="fixed inset-0 w-full h-full -z-10 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-indigo-50 via-slate-50 to-violet-50"></div>
            <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-200/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-violet-200/30 rounded-full blur-3xl"></div>
        </div>

        <!-- Navbar -->
        <nav x-data="{ open: false }" class="glass sticky top-0 z-50 transition-all duration-300 border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <a href="{{ route('dashboard.redirect') }}" wire:navigate class="flex shrink-0 items-center gap-3">
                        <img src="{{ asset('images/icon_dpm.png') }}" class="h-10 w-auto object-contain drop-shadow-md" alt="DPM Polmed Logo">
                        <span class="font-heading font-bold text-xl tracking-tight text-slate-800">e-Aspira <span class="text-indigo-600">DPM</span></span>
                    </a>

                    <div class="hidden md:flex space-x-8">
                        <a href="{{ route('home') }}" wire:navigate class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Beranda</a>
                        <a href="{{ route('tentang') }}" wire:navigate class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Tentang</a>
                        <a href="{{ route('home') }}#pengumuman" @click="open = false" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Pengumuman</a>
                        <a href="{{ route('home') }}#kegiatan" @click="open = false" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Kegiatan</a>
                        <a href="{{ route('uu-kema.publik') }}" @click="open = false" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">UU Kema</a>
                    </div>

                    <div class="hidden md:flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard.redirect') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md shadow-indigo-500/30 transition-all hover:-translate-y-0.5">
                                    Dashboard Saya
                                </a>
                            @else
                                <a href="{{ route('login') }}" wire:navigate class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md shadow-indigo-500/30 transition-all hover:-translate-y-0.5">
                                    Login
                                </a>
                            @endauth
                        @endif
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white/90 backdrop-blur-xl border-t border-slate-200">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard.redirect') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none transition duration-150 ease-in-out">Beranda</a>
                    <a href="{{ route('tentang') }}" wire:navigate class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition duration-150 ease-in-out">Tentang</a>
                    <a href="{{ route('home') }}#pengumuman" @click="open = false" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition duration-150 ease-in-out">Pengumuman</a>
                    <a href="{{ route('home') }}#kegiatan" @click="open = false" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition duration-150 ease-in-out">Kegiatan</a>
                    <a href="{{ route('uu-kema.publik') }}" @click="open = false" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition duration-150 ease-in-out">UU Kema</a>
                </div>
                <div class="pt-4 pb-4 border-t border-slate-200">
                    <div class="flex items-center px-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard.redirect') }}" class="w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold shadow-md">Dashboard Saya</a>
                            @else
                                <a href="{{ route('login') }}" wire:navigate class="w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold shadow-md">Login</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main>
            {{ $slot }}
        </main>
        
        <!-- Mega Footer -->
        <footer class="bg-slate-900 pt-16 pb-8 border-t border-slate-800 mt-24 relative overflow-hidden">
            <!-- Dekorasi Background -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-900/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
                    
                    <!-- Kolom 1: Logo & Info Utama (Span 4) -->
                    <div class="lg:col-span-4">
                        <div class="flex items-center gap-3 mb-6">
                            <img src="{{ asset('images/icon_dpm.png') }}" class="h-12 w-auto object-contain bg-white/10 p-1 rounded-xl" alt="DPM Polmed Logo">
                            <div>
                                <h3 class="font-heading font-bold text-xl text-white tracking-tight">DPM Polmed</h3>
                                <p class="text-indigo-400 text-sm font-medium">Lembaga Legislatif Mahasiswa</p>
                            </div>
                        </div>
                        <p class="text-slate-400 text-sm leading-relaxed mb-6 text-justify">
                            Dewan Perwakilan Mahasiswa Politeknik Negeri Medan hadir untuk mengawal kedaulatan mahasiswa, memastikan aspirasi tersampaikan, dan mengawasi jalannya roda organisasi kampus.
                        </p>
                        <!-- Social Icons -->
                        <div class="flex items-center gap-3">
                            <!--<a href="https://twitter.com/dpm_polmed" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-500 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a> -->
                            <a href="https://instagram.com/dpmpolmed" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 hover:bg-pink-600 hover:text-white hover:border-pink-500 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <!-- <a href="https://facebook.com/dpm.polmed" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white hover:border-blue-500 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                            </a> -->
                        </div>
                    </div>

                    <!-- Kolom 2: Tautan Cepat (Span 3) -->
                    <div class="lg:col-span-3">
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Tautan Cepat</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}" wire:navigate class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Beranda</a></li>
                            <li><a href="{{ route('tentang') }}" wire:navigate class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Tentang Kami</a></li>
                            <li><a href="{{ route('home') }}#pengumuman" @click="open = false" class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Pengumuman Terbaru</a></li>
                            <li><a href="{{ route('home') }}#kegiatan" @click="open = false" class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Kalender Kegiatan</a></li>
                            <li><a href="{{ route('uu-kema.publik') }}" @click="open = false" class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> UU Kema</a></li>
                        </ul>
                    </div>

                    <!-- Kolom 3: Layanan (Span 2) -->
                    <div class="lg:col-span-2">
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Layanan</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('login') }}" wire:navigate class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Login Sistem</a></li>
                            <li><a href="{{ route('mahasiswa.pengaduan.buat') }}" wire:navigate class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Buat Pengaduan</a></li>
                            <li><a href="mailto:dpm@polmed.ac.id" class="text-slate-400 hover:text-indigo-400 transition-colors text-sm flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> Pusat Bantuan</a></li>
                        </ul>
                    </div>

                    <!-- Kolom 4: Kunjungi Kami (Span 3) -->
                    <div class="lg:col-span-3">
                        <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Kunjungi Kami</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-indigo-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-slate-400 text-sm leading-relaxed">
                                    Sekretariat DPM Polmed,<br>
                                    Gedung U (Belakang Masjid Polmed),<br>
                                    Jl. Almamater No. 1, Padang Bulan,<br>
                                    Medan, Sumatera Utara.
                                </span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <a href="mailto:dpm@polmed.ac.id" class="text-slate-400 hover:text-white transition-colors text-sm">dpm@polmed.ac.id</a>
                            </li>
                            <li class="mt-4">
                                <a href="https://maps.app.goo.gl/YExUBY5JLhhSa1M48" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-indigo-600 text-white rounded-lg text-xs font-semibold transition-all border border-slate-700 hover:border-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Buka di Google Maps
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="pt-8 border-t border-slate-800 text-center flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-500 text-sm">
                        &copy; {{ date('Y') }} Dewan Perwakilan Mahasiswa Politeknik Negeri Medan. Hak Cipta Dilindungi.
                    </p>
                    <div class="flex gap-4 text-sm text-slate-500">
                        <a href="{{ route('syarat') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Syarat & Ketentuan</a>
                        <span class="text-slate-700">|</span>
                        <a href="{{ route('privasi') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Kebijakan Privasi</a>
                    </div>
                </div>
            </div>
        </footer>
            @livewireScripts
    </body>
</html>







