<x-publik-layout>
    <div class="pt-24 pb-12">
        <section class="bg-slate-50 relative overflow-hidden min-h-[70vh]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center mb-16">
                    <span class="text-indigo-600 font-bold tracking-wider text-sm uppercase bg-indigo-100 px-4 py-1.5 rounded-full mb-4 inline-block">Dasar Hukum</span>
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-slate-800 tracking-tight mt-4">Undang-Undang Kema</h2>
                    <p class="mt-4 text-slate-600 max-w-2xl mx-auto">Kumpulan peraturan dan undang-undang yang berlaku di Keluarga Mahasiswa (Kema) Politeknik Negeri Medan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    @forelse($daftarUuKema as $uu)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:-translate-y-1 hover:shadow-md transition-all duration-300">
                            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2 leading-snug">{{ $uu->judul }}</h3>
                            <p class="text-sm text-slate-500 mb-6">Diperbarui: {{ $uu->updated_at->translatedFormat('d M Y') }}</p>
                            <a href="{{ Storage::url($uu->file_path) }}" target="_blank" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-xl font-bold transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download PDF
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200 border-dashed">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-slate-500 font-medium text-lg">Belum ada dokumen UU Kema yang dipublikasikan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-publik-layout>
