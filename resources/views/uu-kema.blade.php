<x-publik-layout>
    <!-- Header Section with Gradient -->
    <div class="pt-32 pb-20 bg-gradient-to-br from-indigo-900 via-slate-800 to-indigo-900 relative overflow-hidden">
        <!-- Decorative Orbs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[70%] rounded-full bg-indigo-500/20 blur-[120px]"></div>
            <div class="absolute top-[20%] -right-[10%] w-[40%] h-[60%] rounded-full bg-blue-500/20 blur-[100px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="text-indigo-200 font-bold tracking-widest text-sm uppercase bg-indigo-500/20 border border-indigo-400/30 px-5 py-2 rounded-full mb-6 inline-block backdrop-blur-sm">Dasar Hukum & Peraturan</span>
            <h2 class="text-4xl md:text-5xl font-heading font-extrabold text-white tracking-tight mt-6 mb-6">Undang-Undang Kema</h2>
            <p class="text-indigo-100 max-w-2xl mx-auto text-lg leading-relaxed">Pusat dokumentasi peraturan dan undang-undang yang berlaku di Keluarga Mahasiswa (Kema) Politeknik Negeri Medan.</p>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="py-16 bg-slate-50 min-h-[50vh] relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNlNWE1YTUiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-100 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($daftarUuKema as $uu)
                    <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl border border-slate-200/60 hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full relative overflow-hidden">
                        
                        <!-- Top Accent Line -->
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="flex items-start justify-between mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-50 to-blue-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm border border-indigo-100/50 group-hover:scale-110 transition-transform duration-300">
                                <!-- Scale of Justice Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
                                </svg>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                Aktif
                            </span>
                        </div>
                        
                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-slate-800 mb-3 leading-snug group-hover:text-indigo-600 transition-colors">{{ $uu->judul }}</h3>
                            <div class="flex items-center text-sm text-slate-500 mb-6 font-medium">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Diperbarui: {{ $uu->updated_at->translatedFormat('d F Y') }}
                            </div>
                        </div>

                        <a href="{{ Storage::url($uu->file_path) }}" target="_blank" class="mt-auto inline-flex items-center justify-center gap-2 w-full px-5 py-3 bg-slate-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl font-bold transition-all duration-300 border border-slate-100 hover:border-transparent group-hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Buka Dokumen PDF
                        </a>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed shadow-sm">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Dokumen</h3>
                        <p class="text-slate-500 text-center max-w-md">Saat ini belum ada dokumen Undang-Undang Kema yang dipublikasikan oleh pihak berwenang.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-publik-layout>
