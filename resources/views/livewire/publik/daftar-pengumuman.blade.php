<div class="space-y-8">
    <!-- Filters & Search -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Tabs -->
        <div class="flex p-1 bg-white/50 backdrop-blur-md rounded-2xl border border-slate-100 shadow-sm w-full md:w-auto overflow-x-auto">
            <button wire:click="setFilter('semua')" class="px-6 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all {{ $filter === 'semua' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50' }}">
                Semua Informasi
            </button>
            <button wire:click="setFilter('dpm')" class="px-6 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all {{ $filter === 'dpm' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50' }}">
                DPM Polmed
            </button>
            <button wire:click="setFilter('hmps')" class="px-6 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all {{ $filter === 'hmps' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50' }}">
                HMPS
            </button>
            <button wire:click="setFilter('ukm')" class="px-6 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all {{ $filter === 'ukm' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-white/50' }}">
                UKM
            </button>
        </div>

        <!-- Search -->
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-white/60 backdrop-blur-md placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all shadow-sm" placeholder="Cari informasi...">
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse($pengumumanList as $item)
            <div wire:click="showDetail({{ $item->id }})" class="cursor-pointer group bg-white/70 backdrop-blur-xl rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-white transition-all duration-300 hover:-translate-y-1 relative flex flex-col h-full">
                <!-- Highlight border top -->
                <div class="h-2 w-full {{ $item->is_pinned ? 'bg-amber-400' : ($item->organisasi_id ? 'bg-emerald-400' : 'bg-indigo-500') }}"></div>
                
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <!-- Sender Badge -->
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $item->organisasi_id ? 'bg-emerald-50 text-emerald-700' : 'bg-indigo-50 text-indigo-700' }}">
                            @if($item->organisasi_id)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                {{ $item->organisasi->singkatan ?? $item->organisasi->nama }}
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                                DPM Polmed
                            @endif
                        </div>
                        
                        @if($item->is_pinned)
                            <div class="text-amber-500 bg-amber-50 p-1.5 rounded-full" title="Disematkan">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-800 leading-snug mb-3 group-hover:text-indigo-600 transition-colors">{{ $item->judul }}</h3>
                    
                    <div class="text-slate-600 text-sm flex-1">
                        <p class="line-clamp-4">{{ strip_tags($item->isi) }}</p>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex flex-col gap-0.5 text-xs text-slate-400 font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $item->dipublikasikan_pada ? $item->dipublikasikan_pada->isoFormat('D MMM YYYY') : 'Tanpa Tanggal' }}
                            </div>
                            @if($item->dipublikasikan_pada)
                                <div class="ml-5 text-[10px] text-slate-500 italic font-normal">
                                    {{ $item->dipublikasikan_pada->diffForHumans() }}
                                </div>
                            @endif
                        </div>
                        
                        <button class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center group/btn">
                            Selengkapnya
                            <svg class="w-4 h-4 ml-1 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-white/50 backdrop-blur-md rounded-3xl border border-slate-100 shadow-sm">
                <div class="w-20 h-20 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Tidak ada pengumuman</h3>
                <p class="text-slate-500 max-w-md mt-2">Belum ada informasi atau pengumuman yang sesuai dengan kriteria yang Anda cari saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pengumumanList->links(data: ['scrollTo' => false]) }}
    </div>

    <!-- Modal Detail Pengumuman -->
    @if($isModalOpen && $selectedPengumuman)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold mb-3 {{ $selectedPengumuman->organisasi_id ? 'bg-emerald-50 text-emerald-700' : 'bg-indigo-50 text-indigo-700' }}">
                                {{ $selectedPengumuman->organisasi->singkatan ?? $selectedPengumuman->organisasi->nama ?? 'DPM Polmed' }}
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800" id="modal-title">
                                {{ $selectedPengumuman->judul }}
                            </h3>
                            <div class="text-xs text-slate-500 mt-2 font-medium">
                                Dipublikasikan pada: {{ $selectedPengumuman->dipublikasikan_pada ? $selectedPengumuman->dipublikasikan_pada->isoFormat('D MMMM YYYY') : 'Tanpa Tanggal' }}
                            </div>
                        </div>
                        <button type="button" wire:click="closeModal" class="text-slate-400 hover:text-slate-500 bg-slate-50 hover:bg-slate-100 rounded-full p-2 transition-colors shrink-0">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="prose prose-sm max-w-none text-slate-600 border-t border-slate-100 pt-6">
                        {!! nl2br(e($selectedPengumuman->isi)) !!}
                    </div>

                    @if($selectedPengumuman->lampiran)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Lampiran Pengumuman</h4>
                        <a href="{{ Storage::url($selectedPengumuman->lampiran) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-slate-200 rounded-xl shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Lihat Surat (PDF)
                        </a>
                    </div>
                    @endif
                </div>
                <div class="bg-slate-50 px-4 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button type="button" wire:click="closeModal" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-slate-200 text-base font-semibold text-slate-800 hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:w-auto sm:text-sm transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
