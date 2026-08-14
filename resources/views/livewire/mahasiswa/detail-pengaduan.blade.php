<div>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('mahasiswa.pengaduan.index') }}" wire:navigate class="p-2 rounded-lg bg-white/60 hover:bg-white text-slate-500 hover:text-indigo-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold tracking-wider mr-2 uppercase">Detail Tiket</span>
                <span class="font-bold text-slate-800">{{ $pengaduan->ticket_code }}</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Status Tracker Bar -->
        <div class="glass p-6 rounded-3xl shadow-lg border border-white/60">
            @php
                $statuses = ['diterima', 'diverifikasi', 'diproses', 'ditindaklanjuti', 'selesai'];
                $currentIndex = array_search($pengaduan->status, $statuses);
                if($pengaduan->status === 'ditolak') $currentIndex = -1;
            @endphp
            
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-6">Status Penanganan</h3>
            
            @if($pengaduan->status === 'ditolak')
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl">
                    <div class="flex items-center gap-3 text-rose-700 font-bold mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Pengaduan Ditolak
                    </div>
                    <p class="text-sm text-rose-600 font-medium">Alasan: {{ $pengaduan->alasan_penolakan ?? 'Tidak memenuhi syarat pengaduan.' }}</p>
                </div>
            @else
                <div class="relative">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-slate-200">
                        <div style="width: {{ ($currentIndex / 4) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-1000"></div>
                    </div>
                    <div class="flex justify-between text-xs font-semibold text-slate-500">
                        <div class="text-center w-1/5 {{ $currentIndex >= 0 ? 'text-indigo-600' : '' }}">Diterima</div>
                        <div class="text-center w-1/5 {{ $currentIndex >= 1 ? 'text-indigo-600' : '' }}">Diverifikasi</div>
                        <div class="text-center w-1/5 {{ $currentIndex >= 2 ? 'text-indigo-600' : '' }}">Diproses</div>
                        <div class="text-center w-1/5 {{ $currentIndex >= 3 ? 'text-indigo-600' : '' }}">Tindak Lanjut</div>
                        <div class="text-center w-1/5 {{ $currentIndex >= 4 ? 'text-emerald-600' : '' }}">Selesai</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left: Isi Pengaduan -->
            <div class="md:col-span-2 space-y-6">
                <!-- Data Pengaduan -->
                <div class="glass p-6 md:p-8 rounded-3xl shadow-lg border border-white/60">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Laporan Aspirasi / Pengaduan</h2>
                            <p class="text-sm text-slate-500">{{ $pengaduan->created_at->translatedFormat('l, d F Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/50 rounded-2xl p-5 border border-slate-100 mb-6">
                        <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $pengaduan->isi }}</p>
                    </div>
                    
                    <!-- Lampiran Foto -->
                    @if($pengaduan->lampiran && is_array($pengaduan->lampiran) && count($pengaduan->lampiran) > 0)
                        <h4 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Lampiran Bukti ({{ count($pengaduan->lampiran) }})
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($pengaduan->lampiran as $path)
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="block relative group overflow-hidden rounded-xl border border-slate-200 aspect-square">
                                    <img src="{{ asset('storage/' . $path) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tanggapan DPM -->
                <div class="glass p-6 md:p-8 rounded-3xl shadow-lg border border-white/60">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        Tanggapan Staff DPM
                    </h3>

                    @if($pengaduan->tanggapans->count() > 0)
                        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                            @foreach($pengaduan->tanggapans as $tanggapan)
                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <!-- Icon -->
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-indigo-100 text-indigo-600 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm z-10">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <!-- Card -->
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-2xl border border-slate-100 bg-white shadow-sm">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="font-bold text-slate-800 text-sm">{{ $tanggapan->user->nama ?? 'Staff DPM' }}</div>
                                            <time class="text-xs font-medium text-slate-400">{{ $tanggapan->created_at->diffForHumans() }}</time>
                                        </div>
                                        <div class="text-slate-600 text-sm">
                                            {{ $tanggapan->isi_tanggapan }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <p class="text-slate-500">Belum ada tanggapan dari Staff Dewan. Laporan Anda sedang dalam antrean pemeriksaan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Info Samping -->
            <div class="space-y-6">
                <div class="glass p-6 rounded-3xl shadow-lg border border-white/60">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Informasi Tiket</h3>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">Kategori</p>
                                <p class="text-sm font-bold text-slate-800">{{ $pengaduan->kategori->nama_kategori }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">Privasi</p>
                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ $pengaduan->mode_privasi === 'anonim' ? 'bg-slate-800 text-white' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ strtoupper($pengaduan->mode_privasi) }}
                                </span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-0.5">Update Terakhir</p>
                                <p class="text-sm font-bold text-slate-800">{{ $pengaduan->updated_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                @if($pengaduan->mode_privasi === 'anonim')
                <div class="glass p-6 rounded-3xl shadow-lg border border-slate-700 bg-slate-800 text-white">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <h3 class="font-bold">Mode Anonim Aktif</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Identitas Anda pada tiket ini telah disembunyikan dan dienkripsi dari staf biasa. Simpan baik-baik <strong class="text-white border-b border-dashed">Nomor Tiket</strong> Anda untuk melacak statusnya nanti.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
