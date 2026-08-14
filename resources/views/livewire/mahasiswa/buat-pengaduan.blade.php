<div>
    <x-slot name="header">
        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium mr-3">PENGADUAN</span>
        Buat Pengaduan Baru
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="glass p-8 rounded-3xl shadow-xl shadow-indigo-500/10 border-t border-t-white/60">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Formulir Pengaduan & Aspirasi</h2>
            
            <form wire:submit="submit" class="space-y-6">
                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Pengaduan <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($kategoriList as $kat)
                            <label class="relative flex cursor-pointer rounded-xl border {{ $kategori_id == $kat->id ? 'border-indigo-500 bg-indigo-50/50 ring-1 ring-indigo-500' : 'border-slate-200 bg-white/50 hover:bg-slate-50' }} p-4 shadow-sm focus:outline-none transition-all">
                                <input type="radio" wire:model.live="kategori_id" value="{{ $kat->id }}" class="sr-only">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-slate-900">{{ $kat->nama_kategori }}</span>
                                        @if($kat->level_sensitivitas === 'tinggi')
                                            <span class="mt-1 flex items-center text-xs text-rose-500 font-medium">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                Kategori Sensitif (Otomatis Anonim)
                                            </span>
                                        @endif
                                    </span>
                                </span>
                                @if($kategori_id == $kat->id)
                                    <svg class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    @error('kategori_id') <span class="text-xs text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

                <!-- Mode Privasi -->
                <div class="p-5 rounded-2xl border {{ $mode_privasi === 'anonim' ? 'bg-slate-800 border-slate-700' : 'bg-indigo-50 border-indigo-100' }} transition-colors duration-300">
                    <div class="flex items-start md:items-center justify-between flex-col md:flex-row gap-4">
                        <div>
                            <h4 class="text-base font-bold {{ $mode_privasi === 'anonim' ? 'text-white' : 'text-indigo-900' }}">Mode Pengiriman: {{ ucfirst($mode_privasi) }}</h4>
                            <p class="text-sm mt-1 {{ $mode_privasi === 'anonim' ? 'text-slate-400' : 'text-indigo-700/70' }}">
                                @if($mode_privasi === 'anonim')
                                    Identitas Anda disamarkan dengan enkripsi AES-256. Hanya tim khusus yang dapat membukanya jika diperlukan secara mendesak.
                                @else
                                    Identitas Anda (Nama & NIM) akan terlihat oleh Staff Dewan yang memproses laporan ini.
                                @endif
                            </p>
                        </div>
                        <div class="shrink-0">
                            @php
                                $isSensitif = false;
                                if($kategori_id) {
                                    $k = \App\Models\KategoriPengaduan::find($kategori_id);
                                    if($k && $k->level_sensitivitas === 'tinggi') $isSensitif = true;
                                }
                            @endphp
                            
                            @if($isSensitif)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                    Terkunci di Mode Anonim
                                </span>
                            @else
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="mode_privasi" value="anonim" class="sr-only peer" {{ $mode_privasi === 'anonim' ? 'checked' : '' }}>
                                    <div class="w-14 h-7 bg-indigo-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                                    <span class="ml-3 text-sm font-medium {{ $mode_privasi === 'anonim' ? 'text-white' : 'text-slate-700' }}">Aktifkan Anonim</span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Isi Laporan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Isi Pengaduan / Aspirasi <span class="text-rose-500">*</span></label>
                    <textarea wire:model="isi" rows="6" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 sm:text-sm p-4" placeholder="Jelaskan detail aspirasi atau kejadian yang ingin Anda laporkan secara rinci..."></textarea>
                    <p class="mt-2 text-xs text-slate-500">Minimal 20 karakter. Jelaskan dengan runtut 5W1H jika ini berupa laporan kejadian.</p>
                    @error('isi') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2 min-w-[150px] justify-center">
                        <span wire:loading.remove wire:target="submit" class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Kirim Laporan
                        </span>
                        <span wire:loading.flex wire:target="submit" class="items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Mengirim...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
