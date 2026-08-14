<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Log Aktivitas</h2>
            <p class="text-sm text-slate-500 mt-1">Pantau seluruh riwayat aktivitas dan jejak audit di dalam sistem.</p>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white/60 backdrop-blur-md p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-white/50 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition-colors" placeholder="Cari berdasarkan deskripsi atau modul...">
        </div>
        <div class="w-full sm:w-48">
            <select wire:model.live="eventFilter" class="block w-full py-2 px-3 border border-slate-200 bg-white/50 rounded-xl shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors">
                <option value="">Semua Event</option>
                <option value="created">Dibuat (Created)</option>
                <option value="updated">Diperbarui (Updated)</option>
                <option value="deleted">Dihapus (Deleted)</option>
                <option value="accessed">Diakses (Accessed)</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aktor</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Modul</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <div class="font-medium text-slate-900">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shrink-0">
                                        {{ substr($log->causer?->nama ?? 'Sys', 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-slate-900">{{ $log->causer?->nama ?? 'Sistem' }}</div>
                                        <div class="text-xs text-slate-500">{{ $log->causer?->roles->first()?->name ?? 'System' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                    {{ Str::title(str_replace('_', ' ', $log->log_name)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <div class="flex items-center gap-2">
                                    @if($log->event === 'created')
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    @elseif($log->event === 'updated')
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    @elseif($log->event === 'deleted')
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    @else
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    @endif
                                    <span class="font-medium">{{ $log->description }}</span>
                                </div>
                                @if($log->properties->count() > 0)
                                    <div class="mt-2 text-xs text-slate-400 font-mono bg-slate-50 p-2 rounded border border-slate-100 overflow-x-auto">
                                        {{ json_encode($log->properties, JSON_PRETTY_PRINT) }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-slate-900">Belum ada log aktivitas</h3>
                                    <p class="mt-1 text-sm text-slate-500">Data rekam jejak aktivitas akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $logs->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>
