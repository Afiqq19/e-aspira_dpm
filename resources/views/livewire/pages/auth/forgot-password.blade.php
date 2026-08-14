<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-6 text-sm text-slate-600 leading-relaxed text-center">
        {{ __('Lupa password Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk membuat password baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-medium" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 text-sm py-2.5" type="email" name="email" required autofocus placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <!-- Left side: Back Button -->
            <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali Login
            </a>

            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out shadow-md shadow-indigo-500/30 min-w-[100px] justify-center">
                <span wire:loading.remove wire:target="sendPasswordResetLink">{{ __('Kirim Link Reset') }}</span>
                <span wire:loading.flex wire:target="sendPasswordResetLink" class="items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
