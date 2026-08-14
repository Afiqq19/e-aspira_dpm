<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $nim = '';
    public string $nama = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'nim' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['name'] = $validated['nama']; // name field required by Laravel defaults
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole('mahasiswa');

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('mahasiswa.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Akun Mahasiswa</h2>
        <p class="text-slate-500 text-sm mt-1">Silakan lengkapi data diri Anda di bawah ini</p>
    </div>

    <form wire:submit="register">
        <!-- NIM -->
        <div>
            <x-input-label for="nim" :value="__('Nomor Induk Mahasiswa (NIM)')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="nim" id="nim" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5" type="text" name="nim" required autofocus placeholder="Contoh: 2205012001" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2 text-rose-500" />
        </div>

        <!-- Nama Lengkap -->
        <div class="mt-4">
            <x-input-label for="nama" :value="__('Nama Lengkap')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="nama" id="nama" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5" type="text" name="nama" required placeholder="Nama Lengkap Anda" />
            <x-input-error :messages="$errors->get('nama')" class="mt-2 text-rose-500" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Mahasiswa')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5" type="email" name="email" required autocomplete="username" placeholder="email@students.polmed.ac.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-500" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-1.5" href="{{ route('login') }}" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Login
            </a>

            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out shadow-md shadow-indigo-500/30 min-w-[120px] justify-center">
                <span wire:loading.remove wire:target="register">{{ __('Daftar Sekarang') }}</span>
                <span wire:loading.flex wire:target="register" class="items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Mendaftar...
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
