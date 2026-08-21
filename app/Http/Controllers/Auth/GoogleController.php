<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // KUNCI: Wajib email kampus
            if (!Str::endsWith($googleUser->getEmail(), '@students.polmed.ac.id')) {
                return redirect()->route('login', ['oauth_error' => 'not_polmed']);
            }

            // Cek apakah user dengan google_id ini sudah ada
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Jika belum, cek apakah emailnya sudah terdaftar (mungkin daftar manual sebelumnya)
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Update user yang sudah ada dengan google_id
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                } else {
                    // Buat user baru secara otomatis
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'nama' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                        'password' => null, // Password kosong karena login via SSO
                        // NIM & Prodi diset null, bisa dilengkapi nanti di profil
                        'nim' => null,
                        'prodi' => null,
                        'is_active' => true,
                    ]);

                    // Assign role mahasiswa secara default
                    $user->assignRole('mahasiswa');
                }
            }

            // Login user tersebut
            Auth::login($user, true);

            // Redirect ke dashboard sesuai role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isStaffDewan()) {
                return redirect()->route('dewan.dashboard');
            } elseif ($user->isHMPS() || $user->isUKM()) {
                return redirect()->route('organisasi.dashboard');
            }
            
            return redirect()->route('mahasiswa.dashboard');

        } catch (\Exception $e) {
            // Jika terjadi error saat auth dengan google
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google: ' . $e->getMessage());
        }
    }
}

