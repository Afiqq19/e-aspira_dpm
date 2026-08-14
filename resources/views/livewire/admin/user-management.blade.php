<div>
    <x-slot name="header">
        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium mr-3">ADMIN</span>
        Manajemen User
    </x-slot>

    <!-- Notifikasi Flash -->
    @if (session()->has('message'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm shadow-emerald-500/10">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm shadow-rose-500/10">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="glass rounded-2xl p-6 shadow-sm shadow-indigo-500/5 border-t border-t-white/60">
        
        <!-- Action Bar: Search, Filter, Add Button -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-3 flex-1">
                <div class="relative max-w-xs w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm" placeholder="Cari nama, email, NIM...">
                </div>
                
                <select wire:model.live="roleFilter" class="max-w-[150px] border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm">
                    <option value="">Semua Role</option>
                    <option value="staff_dewan">Staff Dewan</option>
                    <option value="hmps">HMPS</option>
                    <option value="ukm">UKM</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
            
            <button wire:click="create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md shadow-indigo-500/30 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah User
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-slate-100 bg-white/50">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Pengguna</th>
                        <th class="px-6 py-4 font-semibold">NIM/Username</th>
                        <th class="px-6 py-4 font-semibold">Role & Organisasi</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                        {{ substr($user->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $user->nama }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $user->nim ?? $user->username }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->roles->count() > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 capitalize">
                                        {{ str_replace('_', ' ', $user->roles->first()->name) }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">No Role</span>
                                @endif
                                
                                @if($user->organisasi)
                                    <p class="text-xs text-slate-500 mt-1 font-medium">{{ $user->organisasi->singkatan }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="toggleStatus({{ $user->id }})" class="p-1.5 text-slate-400 hover:text-amber-600 rounded hover:bg-slate-100 transition-colors" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($user->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </button>
                                    <button wire:click="edit({{ $user->id }})" class="p-1.5 text-slate-400 hover:text-indigo-600 rounded hover:bg-slate-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $user->id }})" class="p-1.5 text-slate-400 hover:text-rose-600 rounded hover:bg-slate-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p>Tidak ada data user ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Form Tambah/Edit -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm transition-opacity" wire:click="$set('isModalOpen', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-slate-100">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl leading-6 font-bold text-slate-800" id="modal-title">
                            {{ $user_id ? 'Edit User' : 'Tambah User Baru' }}
                        </h3>
                        <button wire:click="$set('isModalOpen', false)" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form wire:submit="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Lengkap -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama / Organisasi</label>
                                <input wire:model="nama" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('nama') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- NIM atau Username (Conditional based on role) -->
                            @if($role === 'mahasiswa')
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">NIM Mahasiswa</label>
                                    <input wire:model="nim" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('nim') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                            @elseif($role !== '')
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                                    <input wire:model="username" type="text" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('username') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                <input wire:model="email" type="email" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @error('email') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Password {{ $user_id ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
                                <input wire:model="password" type="password" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ !$user_id ? 'required' : '' }}>
                                @error('password') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Role / Hak Akses</label>
                                <select wire:model.live="role" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($rolesList as $r)
                                        <option value="{{ $r->name }}">{{ ucwords(str_replace('_', ' ', $r->name)) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Status Akun</label>
                                <select wire:model="is_active" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>

                            <!-- Organisasi (Conditional) -->
                            @if(in_array($role, ['hmps', 'ukm']))
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Hubungkan ke Organisasi</label>
                                    <select wire:model="organisasi_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-indigo-50">
                                        <option value="">-- Pilih Organisasi --</option>
                                        @foreach($organisasiList as $org)
                                            @if(($role == 'hmps' && $org->tipe == 'HMPS') || ($role == 'ukm' && $org->tipe == 'UKM'))
                                                <option value="{{ $org->id }}">{{ $org->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-indigo-600 mt-1">Wajib dipilih karena role adalah {{ strtoupper($role) }}.</p>
                                    @error('organisasi_id') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button wire:click="save" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan Data
                    </button>
                    <button wire:click="$set('isModalOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if($isDeleteModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm transition-opacity" wire:click="$set('isDeleteModalOpen', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 mb-4">
                        <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">
                        Hapus Pengguna?
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-slate-500">
                            Apakah Anda yakin ingin menghapus pengguna <span class="font-bold text-slate-800">{{ $userToDelete?->nama }}</span>? Data yang telah dihapus tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100 gap-2">
                    <button wire:click="delete" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-base font-medium text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:w-auto sm:text-sm">
                        Ya, Hapus
                    </button>
                    <button wire:click="$set('isDeleteModalOpen', false)" type="button" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
