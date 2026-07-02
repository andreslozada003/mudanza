<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('login.index');
    }

    public function showRegister(): View
    {
        return view('login.register');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $throttleKey = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withErrors(['email' => "Demasiados intentos. Intenta de nuevo en {$seconds} segundos."])
                ->onlyInput('email');
        }

        $remember = $request->boolean('remember');

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
                ->onlyInput('email');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
            'role' => ['required', 'in:cliente,conductor'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'document_type' => ['required', 'in:cc,ce,passport'],
            'document_number' => ['required', 'string', 'max:40', 'unique:user_verifications,document_number'],
            'document_issued_at' => ['required', 'date', 'before_or_equal:today'],
            'birth_date' => ['required', 'date', 'before:-18 years'],
            'gender' => ['required', 'in:femenino,masculino,otro,prefiero_no_decir'],
            'city' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string', 'max:180'],
            'document_front' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'document_back' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'selfie' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $user = DB::transaction(function () use ($data, $request) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'role' => $data['role'],
                'password' => $data['password'],
            ]);

            UserVerification::create([
                'user_id' => $user->id,
                'document_type' => $data['document_type'],
                'document_number' => $data['document_number'],
                'document_issued_at' => $data['document_issued_at'],
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'city' => $data['city'],
                'address' => $data['address'],
                'document_front_path' => $request->file('document_front')->store('verifications/documents', 'public'),
                'document_back_path' => $request->file('document_back')->store('verifications/documents', 'public'),
                'selfie_path' => $request->file('selfie')->store('verifications/selfies', 'public'),
                'status' => 'en_revision',
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function dashboard(): RedirectResponse
    {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'conductor' => redirect()->route('conductor.dashboard'),
            default => redirect()->route('cliente.dashboard'),
        };
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
