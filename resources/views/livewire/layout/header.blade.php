<header class="h-16 bg-white/80 backdrop-blur-xl border-b border-slate-200/80 sticky top-0 z-20 px-4 sm:px-8 flex items-center justify-between shadow-sm">
    <div class="flex items-center flex-1 gap-4">
        <!-- Hamburger Menu (Mobile Only) -->
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <!-- Search bar (opsional) -->
        <form wire:submit.prevent="searchTicket" class="relative w-full max-w-md hidden sm:block">
            <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center cursor-pointer hover:text-indigo-600 transition-colors">
                <svg class="h-5 w-5 text-slate-400 hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
            <input type="text" wire:model="searchQuery" class="block w-full pl-10 pr-3 py-2 border-none rounded-xl bg-slate-100 bg-opacity-50 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm" placeholder="Lacak atau cari tiket (Format: PLP-...)" title="Tekan Enter untuk mencari">
            
            @error('searchQuery')
                <div class="absolute top-full left-0 mt-1.5 bg-rose-50 text-rose-600 text-xs px-3 py-2 rounded-lg border border-rose-200 shadow-md font-bold z-50 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </div>
            @enderror
        </form>
    </div>
    
    <div class="flex items-center gap-4">
        <!-- Notifications -->
        <button class="relative p-2 text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none rounded-full hover:bg-slate-100">
            <span class="absolute top-1.5 right-1.5 h-2.5 w-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        </button>

        <!-- Profile Dropdown (Alpine.js) -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none bg-slate-100 p-1.5 rounded-full hover:bg-indigo-50 transition-colors border border-slate-200 hover:border-indigo-200">
                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold shadow-inner">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
                <span class="text-sm font-medium text-slate-700 hidden md:block">{{ explode(' ', auth()->user()->nama)[0] }}</span>
                <svg class="h-4 w-4 text-slate-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50 overflow-hidden"
                 style="display: none;">
                
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-sm font-medium text-slate-900 truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                
                <a href="{{ route('profile') }}" wire:navigate class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Saya
                </a>
                
                <div class="border-t border-slate-100 my-1"></div>
                
                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-left block px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </div>
        </div>
    </div>
</header>


