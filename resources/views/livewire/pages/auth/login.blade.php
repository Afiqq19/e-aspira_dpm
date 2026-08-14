<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Redirect based on role
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
        } elseif ($user->hasRole('staff_dewan')) {
            $this->redirectIntended(default: route('dewan.dashboard', absolute: false), navigate: true);
        } elseif ($user->hasRole('hmps') || $user->hasRole('ukm')) {
            $this->redirectIntended(default: route('organisasi.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('mahasiswa.dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address / NIM / Username -->
        <div>
            <x-input-label for="login" :value="__('Email / NIM / Username')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="form.login" wire:keydown.enter="login" id="login" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5" type="text" name="login" required autofocus autocomplete="username" placeholder="Masukkan Email atau NIM Anda" />
            <x-input-error :messages="$errors->get('form.login')" class="mt-2 text-rose-500" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="form.password" wire:keydown.enter="login" id="password" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-rose-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <!-- Left side: Back Button -->
            <a href="/" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>

            <!-- Right side: Forgot Password & Submit -->
            <div class="flex items-center">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa password?') }}
                    </a>
                @endif

                <x-primary-button type="submit" class="ms-4 bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out shadow-md shadow-indigo-500/30 min-w-[100px] justify-center">
                    <span wire:loading.remove wire:target="login">{{ __('Masuk') }}</span>
                    <span wire:loading.flex wire:target="login" class="items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Memproses...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </form>
</div>

