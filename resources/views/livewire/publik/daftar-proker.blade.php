<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($prokers as $proker)
        @php
            // Assign color based on organization type or ID
            $orgName = strtolower($proker->organisasi->nama ?? '');
            if (str_contains($orgName, 'bem') || str_contains($orgName, 'badan eksekutif')) {
                $color = 'violet';
            } elseif ($proker->organisasi_id % 4 == 0) {
                $color = 'emerald';
            } elseif ($proker->organisasi_id % 4 == 1) {
                $color = 'blue';
            } elseif ($proker->organisasi_id % 4 == 2) {
                $color = 'amber';
            } else {
                $color = 'rose';
            }
        @endphp

        <div wire:click="showDetail({{ $proker->id }})" class="cursor-pointer bg-white rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group h-full">
            <div class="h-2 w-full bg-{{ $color }}-500 group-hover:bg-{{ $color }}-600 transition-colors"></div>
            
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                        {{ $proker->organisasi->singkatan ?? $proker->organisasi->nama ?? 'Umum' }}
                    </span>
                    @if($proker->status === 'berjalan')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 animate-pulse border border-blue-100">Sedang Berjalan</span>
                    @elseif($proker->status === 'selesai')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Selesai</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-700 border border-slate-200">Rencana</span>
                    @endif
                </div>
                
                <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-{{ $color }}-700 transition-colors line-clamp-2">
                    {{ $proker->nama }}
                </h3>
                
                <div class="text-xs font-semibold tracking-wider text-slate-400 uppercase mb-3">
                    Kategori: {{ ucfirst($proker->kategori) }}
                </div>
                
                <p class="text-slate-600 text-sm mb-6 flex-1 line-clamp-3">
                    {{ !empty($proker->deskripsi) ? $proker->deskripsi : 'Tidak ada deskripsi rinci untuk program kerja ini.' }}
                </p>
                
                @if($proker->tanggal_mulai)
                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center text-sm text-slate-500">
                    <svg class="w-4 h-4 mr-2 shrink-0 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>
                        <span class="font-semibold text-slate-600">Pelaksanaan:</span> {{ $proker->tanggal_mulai->format('d M Y') }}
                        @if($proker->tanggal_selesai && $proker->tanggal_selesai != $proker->tanggal_mulai)
                            s/d {{ $proker->tanggal_selesai->format('d M Y') }}
                        @endif
                    </span>
                </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white/50 backdrop-blur-sm rounded-3xl border border-slate-100 border-dashed">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Program Kerja</h3>
            <p class="text-slate-500 text-center max-w-md mt-2">Saat ini belum ada program kerja yang dipublikasikan oleh organisasi.</p>
        </div>
    @endforelse

    <!-- Modal Detail Proker -->
    @if($isModalOpen && $selectedProker)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-3">
                                {{ $selectedProker->organisasi->nama ?? 'Umum' }}
                            </span>
                            <h3 class="text-2xl font-bold text-slate-800" id="modal-title">
                                {{ $selectedProker->nama }}
                            </h3>
                            <div class="text-sm text-slate-500 mt-1 uppercase tracking-wider font-semibold">Kategori: {{ ucfirst($selectedProker->kategori) }}</div>
                        </div>
                        <button type="button" wire:click="closeModal" class="text-slate-400 hover:text-slate-500 bg-slate-50 hover:bg-slate-100 rounded-full p-2 transition-colors shrink-0">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 mb-6 border border-slate-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-slate-500 mb-1 font-semibold uppercase">Status Proker</div>
                                <div>
                                    @if($selectedProker->status === 'berjalan')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 animate-pulse">Sedang Berjalan</span>
                                    @elseif($selectedProker->status === 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Selesai</span>
                                    @elseif($selectedProker->status === 'dibatalkan')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Dibatalkan</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-200 text-slate-800">Rencana</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1 font-semibold uppercase">Waktu Pelaksanaan</div>
                                <div class="text-sm font-medium text-slate-800">
                                    @if($selectedProker->tanggal_mulai)
                                        {{ $selectedProker->tanggal_mulai->format('d M Y') }}
                                        @if($selectedProker->tanggal_selesai && $selectedProker->tanggal_selesai != $selectedProker->tanggal_mulai)
                                            s/d {{ $selectedProker->tanggal_selesai->format('d M Y') }}
                                        @endif
                                    @else
                                        Belum Ditentukan
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-base font-bold text-slate-800 mb-3">Deskripsi Lengkap</h4>
                        <div class="prose prose-sm max-w-none text-slate-600">
                            @if(!empty($selectedProker->deskripsi))
                                {!! nl2br(e($selectedProker->deskripsi)) !!}
                            @else
                                <p class="italic text-slate-400">Tidak ada deskripsi rinci untuk program kerja ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-5 sm:px-8 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button type="button" wire:click="closeModal" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-indigo-600 text-base font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Tutup
                    </button>
                    @auth
                        @if(auth()->user()->hasRole('mahasiswa') && $selectedProker->is_active)
                        <a href="{{ route('mahasiswa.evaluasi-proker.index') }}" class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-indigo-200 shadow-sm px-6 py-2.5 bg-indigo-50 text-base font-semibold text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Beri Evaluasi
                        </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
