<div class="space-y-10">
    <!-- Filters -->
    <div class="flex flex-wrap justify-center gap-3">
        <button wire:click="setFilter('semua')" class="px-5 py-2 rounded-full font-semibold text-sm transition-all duration-200 {{ $filter === 'semua' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30 scale-105' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 hover:scale-105' }}">
            Semua Kegiatan
        </button>
        <button wire:click="setFilter('akan_datang')" class="px-5 py-2 rounded-full font-semibold text-sm transition-all duration-200 {{ $filter === 'akan_datang' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30 scale-105' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 hover:scale-105' }}">
            📅 Akan Datang
        </button>
        <button wire:click="setFilter('selesai')" class="px-5 py-2 rounded-full font-semibold text-sm transition-all duration-200 {{ $filter === 'selesai' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30 scale-105' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 hover:scale-105' }}">
            ✅ Selesai
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($kegiatans as $kegiatan)
            @php
                $org = $kegiatan->organisasi;
                $warna = $org ? $org->warna : ['bg'=>'bg-violet-700','light'=>'bg-violet-100','text'=>'text-violet-700','badge'=>'bg-violet-700 text-white','border'=>'border-violet-300','hex'=>'#6d28d9'];
                $isUpcoming = $kegiatan->tanggal_mulai && $kegiatan->tanggal_mulai->isFuture();
            @endphp
            <div class="bg-white rounded-3xl overflow-hidden shadow-md border border-slate-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                
                <!-- Color Header + Poster -->
                <div class="h-48 relative overflow-hidden flex items-center justify-center shrink-0">
                    @if($kegiatan->poster)
                        <img src="{{ Storage::url($kegiatan->poster) }}" alt="{{ $kegiatan->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <!-- Color overlay strip on top -->
                        <div class="absolute top-0 left-0 right-0 h-1 {{ $warna['bg'] }}"></div>
                    @else
                        <!-- Colored gradient fallback -->
                        <div class="absolute inset-0 {{ $warna['bg'] }} opacity-90"></div>
                        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0px, rgba(255,255,255,0.1) 1px, transparent 1px, transparent 12px)"></div>
                        <div class="relative z-10 text-center px-4">
                            <svg class="w-12 h-12 text-white/60 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <!-- Calendar Date Badge (top-left) -->
                    @if($kegiatan->tanggal_mulai)
                    <div class="absolute top-4 left-4 bg-white shadow-lg rounded-2xl overflow-hidden text-center min-w-[52px] border border-slate-100">
                        <div class="px-3 py-1 text-white text-xs font-black uppercase tracking-wide {{ $warna['bg'] }}">
                            {{ $kegiatan->tanggal_mulai->translatedFormat('M') }}
                        </div>
                        <div class="px-3 py-1.5">
                            <span class="text-2xl font-black text-slate-800 leading-none">{{ $kegiatan->tanggal_mulai->format('d') }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Upcoming/Selesai Badge (top-right) -->
                    <div class="absolute top-4 right-4">
                        @if($isUpcoming)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Akan Datang
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-500/80 text-white shadow-sm backdrop-blur-sm">Selesai</span>
                        @endif
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6 flex flex-col flex-1">
                    <!-- Org Badge -->
                    <div class="mb-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black {{ $warna['badge'] }} shadow-sm">
                            @if($org)
                                {{ $org->tipe }} • {{ $org->singkatan ?? $org->nama }}
                            @else
                                DPM POLMED
                            @endif
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-800 mb-3 leading-tight group-hover:{{ $warna['text'] }} transition-colors line-clamp-2">{{ $kegiatan->judul }}</h3>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-slate-600">
                            <svg class="w-4 h-4 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('H:i') . ' WIB' : '-' }}
                            @if($kegiatan->tanggal_selesai) — {{ $kegiatan->tanggal_selesai->format('d M Y') }} @endif
                            </span>
                        </div>
                        <div class="flex items-start text-sm text-slate-600">
                            <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="line-clamp-1">{{ $kegiatan->lokasi }}</span>
                        </div>
                    </div>
                    
                    <p class="text-sm text-slate-500 line-clamp-2 flex-1 mb-4">{{ strip_tags($kegiatan->deskripsi) }}</p>

                    @if($kegiatan->no_kontak)
                    <div class="mt-auto pt-4 border-t border-slate-100">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kegiatan->no_kontak) }}" target="_blank" 
                            class="inline-flex items-center gap-2 text-sm font-bold {{ $warna['text'] }} hover:opacity-70 transition-opacity">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Hubungi {{ $kegiatan->kontak_penanggung_jawab ?: 'Narahubung' }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-white/50 backdrop-blur rounded-3xl border-2 border-slate-200/60 border-dashed shadow-sm">
                <div class="w-20 h-20 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700">Belum Ada Kegiatan</h3>
                <p class="text-slate-500 max-w-sm mt-2">Saat ini belum ada agenda atau kegiatan yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $kegiatans->links(data: ['scrollTo' => false]) }}
    </div>

    <!-- Legend Kode Warna -->
    @if($kegiatans->count() > 0)
    @php
        $orgsInView = $kegiatans->pluck('organisasi')->filter()->unique('id');
        $hasDPM = $kegiatans->whereNull('organisasi_id')->count() > 0;
    @endphp
    <div class="mt-4 p-5 bg-white/60 backdrop-blur rounded-2xl border border-slate-200/60 shadow-sm">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3 text-center">Keterangan Warna Organisasi</p>
        <div class="flex flex-wrap justify-center gap-3">
            @if($hasDPM)
            <div class="flex items-center gap-2">
                <span class="w-3.5 h-3.5 rounded-full bg-violet-700"></span>
                <span class="text-sm font-medium text-slate-700">DPM Polmed</span>
            </div>
            @endif
            @foreach($orgsInView as $org)
            @php $w = $org->warna; @endphp
            <div class="flex items-center gap-2">
                <span class="w-3.5 h-3.5 rounded-full {{ $w['bg'] }}"></span>
                <span class="text-sm font-medium text-slate-700">{{ $org->tipe }}: {{ $org->singkatan ?? $org->nama }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

