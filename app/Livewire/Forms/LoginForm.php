<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $login = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginType = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $user = null;
        if ($loginType !== 'email') {
            $user = \App\Models\User::where('username', $this->login)->orWhere('nim', $this->login)->first();
            if ($user) {
                $loginType = $user->nim === $this->login ? 'nim' : 'username';
            } else {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'form.login' => 'Akun tidak ditemukan. Periksa kembali NIM/Username Anda.',
                ]);
            }
        } else {
            $user = \App\Models\User::where('email', $this->login)->first();
            if (!$user) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'form.login' => 'Akun dengan email tersebut tidak ditemukan.',
                ]);
            }
        }

        if (! Auth::attempt([$loginType => $this->login, 'password' => $this->password, 'is_active' => true], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->login).'|'.request()->ip());
    }
}

