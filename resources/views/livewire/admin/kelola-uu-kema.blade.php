<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola UU Kema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session()->has('message'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Form Upload -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4">{{ $isEdit ? 'Edit UU Kema' : 'Tambah UU Kema Baru' }}</h3>
                <form wire:submit.prevent="simpan" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul UU Kema</label>
                        <input type="text" wire:model="judul" class="w-full rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: UU Kema Tahun 2026 tentang Organisasi Kemahasiswaan">
                        @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">File PDF (Maks 6MB)</label>
                        <input type="file" wire:key="file-input-{{ $isEdit ? $editId : 'new' }}" wire:model="file" accept=".pdf" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($isEdit)
                            <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah file PDF.</p>
                        @endif
                        @error('file') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors">
                            {{ $isEdit ? 'Update' : 'Simpan' }}
                        </button>
                        @if($isEdit)
                            <button type="button" wire:click="resetInput" class="px-6 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition-colors">
                                Batal
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar UU -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase">
                        <tr>
                            <th class="px-6 py-4 font-bold">Judul UU</th>
                            <th class="px-6 py-4 font-bold">File</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($daftarUu as $uu)
                            <tr wire:key="uu-{{ $uu->id }}" class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $uu->judul }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ Storage::url($uu->file_path) }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat PDF
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleActive({{ $uu->id }})" class="px-3 py-1 rounded-full text-xs font-bold {{ $uu->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $uu->is_active ? 'Ditampilkan' : 'Disembunyikan' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="edit({{ $uu->id }})" class="text-amber-500 hover:text-amber-700 font-bold">Edit</button>
                                    <button wire:click="hapus({{ $uu->id }})" wire:confirm="Yakin ingin menghapus UU ini?" class="text-rose-500 hover:text-rose-700 font-bold">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada dokumen UU Kema yang diupload.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $daftarUu->links() }}
            </div>
        </div>
    </div>
</div>




