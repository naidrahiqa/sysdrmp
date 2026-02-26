<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminLoginController extends Controller
{
    // ─── Show Login Page ──────────────────────────────────────────────────────
    public function showLogin()
    {
        // Already logged in? Go to dashboard
        if ($this->isLoggedIn()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    // ─── Handle Login ─────────────────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $adminPassword = config('admin.password', env('ADMIN_PASSWORD', ''));

        if (! $adminPassword || ! hash_equals($adminPassword, $request->input('password'))) {
            // Rate-limit feedback with a tiny delay to slow brute force
            sleep(1);

            return back()
                ->withErrors(['password' => 'Access denied. Invalid credentials.'])
                ->with('login_attempt', true);
        }

        // Generate a signed session token
        $token = Str::random(64);
        $hash  = hash('sha256', $token . $adminPassword);

        $request->session()->regenerate();
        $request->session()->put('admin_auth_token', $token);
        $request->session()->put('admin_auth_hash',  $hash);
        $request->session()->put('admin_logged_in_at', now()->toISOString());

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome back, Admin.');
    }

    // ─── Logout ───────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        $request->session()->forget(['admin_auth_token', 'admin_auth_hash', 'admin_logged_in_at']);
        $request->session()->regenerate();

        return redirect()->route('admin.login')
            ->with('logged_out', true);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────
    private function isLoggedIn(): bool
    {
        $token = session('admin_auth_token', '');
        $hash  = session('admin_auth_hash', '');

        if (! $token || ! $hash) return false;

        $adminPassword = config('admin.password', env('ADMIN_PASSWORD', ''));

        return hash_equals(
            hash('sha256', $token . $adminPassword),
            $hash
        );
    }
}
