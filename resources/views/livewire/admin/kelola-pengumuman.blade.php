<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pengumuman DPM</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi publik dan agenda dewan perwakilan mahasiswa.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all shadow-md hover:shadow-lg shadow-indigo-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Pengumuman
        </button>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white/60 backdrop-blur-md p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-white/50 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-colors" placeholder="Cari judul atau isi...">
        </div>
        <div class="w-full sm:w-48">
            <select wire:model.live="statusFilter" class="block w-full py-2 px-3 border border-slate-200 bg-white/50 rounded-xl shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors">
                <option value="">Semua Status</option>
                <option value="published">Dipublikasikan</option>
                <option value="draft">Draft</option>
                <option value="archived">Diarsipkan</option>
            </select>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl relative flex items-start shadow-sm animate-slide-up" role="alert">
            <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Data List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($pengumumanList as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow relative flex flex-col">
                <!-- Status Badge -->
                <div class="absolute top-4 right-4 flex gap-2">
                    @if($item->is_pinned)
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-800 ring-1 ring-inset ring-amber-600/20" title="Disematkan">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> Pinned
                        </span>
                    @endif
                    @if($item->status === 'published')
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800 ring-1 ring-inset ring-emerald-600/20">Publik</span>
                    @elseif($item->status === 'draft')
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-800 ring-1 ring-inset ring-slate-600/20">Draft</span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-rose-100 text-rose-800 ring-1 ring-inset ring-rose-600/20">Arsip</span>
                    @endif
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-3 mt-2">
                        <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold uppercase tracking-wider">{{ $item->kategori }}</span>
                        <span class="text-xs text-slate-400 font-medium">&bull; {{ $item->dipublikasikan_pada ? $item->dipublikasikan_pada->format('d M Y') : 'Belum rilis' }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2">{{ $item->judul }}</h3>
                    <p class="text-sm text-slate-600 line-clamp-3 mb-4">{{ Str::limit(strip_tags($item->isi), 120) }}</p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-xs text-slate-500 font-medium">Oleh: {{ $item->user->nama ?? 'Admin' }}</div>
                        <div class="flex items-center gap-2">
                            <button wire:click="togglePin({{ $item->id }})" class="p-1.5 text-slate-400 hover:text-amber-500 transition-colors" title="{{ $item->is_pinned ? 'Lepas Sematan' : 'Sematkan' }}">
                                <svg class="w-4 h-4 {{ $item->is_pinned ? 'fill-amber-500 text-amber-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button wire:click="edit({{ $item->id }})" class="p-1.5 text-slate-400 hover:text-indigo-600 transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $item->id }})" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-white rounded-3xl border border-slate-100 border-dashed">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Belum Ada Pengumuman</h3>
                <p class="text-slate-500 max-w-sm mt-1 text-sm">Tidak ada data pengumuman yang sesuai dengan kriteria pencarian Anda.</p>
                <button wire:click="create" class="mt-4 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-medium text-sm hover:bg-indigo-100 transition-colors">
                    Buat Sekarang
                </button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pengumumanList->links(data: ['scrollTo' => false]) }}
    </div>

    <!-- Form Modal (Create/Edit) -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('isModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-6">
                        <div class="flex justify-between items-center mb-5 pb-4 border-b border-slate-100">
                            <h3 class="text-xl leading-6 font-bold text-slate-800" id="modal-title">
                                {{ $pengumuman_id ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}
                            </h3>
                            <button wire:click="$set('isModalOpen', false)" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-full p-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="save">
                            <div class="space-y-4">
                                <!-- Judul -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                                    <input wire:model="judul" type="text" class="w-full border-slate-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Pemilihan Presma 2026" required>
                                    @error('judul') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Kategori -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                                        <select wire:model="kategori" class="w-full border-slate-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            @foreach($kategoriOptions as $opt)
                                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                                        <select wire:model="status" class="w-full border-slate-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="draft">Draft (Simpan sementara)</option>
                                            <option value="published">Published (Publikasikan)</option>
                                            <option value="archived">Archived (Arsipkan)</option>
                                        </select>
                                        @error('status') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Isi Pengumuman -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Isi Pengumuman <span class="text-rose-500">*</span></label>
                                    <textarea wire:model="isi" rows="6" class="w-full border-slate-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis deskripsi atau isi pengumuman secara detail..." required></textarea>
                                    @error('isi') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- File Lampiran (PDF) -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Lampiran File (PDF/Gambar) - <span class="text-slate-400 font-normal">Opsional</span></label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl relative hover:bg-slate-50 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-slate-600 justify-center">
                                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-1">
                                                    <span>Upload file</span>
                                                    <input id="file-upload" type="file" wire:model="file_lampiran" class="sr-only" accept=".pdf,.png,.jpg,.jpeg">
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-slate-500">PDF, PNG, JPG maksimal 5MB</p>
                                            
                                            <!-- Preview -->
                                            <div wire:loading wire:target="file_lampiran" class="text-indigo-500 text-xs mt-2 font-medium">Sedang mengupload...</div>
                                            @if($file_lampiran)
                                                <p class="text-xs text-emerald-600 font-semibold mt-2">File dipilih: {{ $file_lampiran->getClientOriginalName() }}</p>
                                            @elseif($lampiran)
                                                <p class="text-xs text-indigo-600 font-semibold mt-2">File saat ini: Tersimpan (Pilih file baru untuk mengganti)</p>
                                            @endif
                                        </div>
                                    </div>
                                    @error('file_lampiran') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-slate-800">Sematkan (Pin) ke Atas</span>
                                        <span class="text-xs text-slate-500 mt-0.5">Pengumuman ini akan selalu muncul di urutan paling atas.</span>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="is_pinned" class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" wire:click="$set('isModalOpen', false)" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-medium text-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200 transition-colors">Batal</button>
                                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-md shadow-indigo-500/30 transition-all flex items-center">
                                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Simpan Pengumuman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($isDeleteModalOpen)
        <div class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="$set('isDeleteModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-6">
                        <div class="sm:flex sm:items-start mb-6">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-slate-800" id="modal-title">Hapus Pengumuman</h3>
                                <div class="mt-2 text-sm text-slate-500">
                                    <p>Apakah Anda yakin ingin menghapus pengumuman <span class="font-bold">"{{ $pengumumanToDelete?->judul }}"</span>? Data yang telah dihapus (soft delete) tidak akan tampil lagi di halaman publik.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" wire:click="$set('isDeleteModalOpen', false)" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-medium text-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200 transition-colors">Batal</button>
                            <button wire:click="delete" type="button" class="px-5 py-2.5 bg-rose-600 text-white rounded-xl font-medium text-sm hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 shadow-md shadow-rose-500/30 transition-all flex items-center">
                                <svg wire:loading wire:target="delete" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Ya, Hapus Pengumuman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
