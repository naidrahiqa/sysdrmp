<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Allow login page through without auth check
        if ($request->routeIs('admin.login') || $request->routeIs('admin.login.post')) {
            return $next($request);
        }

        // Check session token
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login')
                ->with('intended', $request->url());
        }

        return $next($request);
    }

    private function isAuthenticated(Request $request): bool
    {
        $token = $request->session()->get('admin_auth_token', '');
        $hash  = $request->session()->get('admin_auth_hash', '');

        if (! $token || ! $hash) {
            return false;
        }

        $adminPassword = env('ADMIN_PASSWORD', '');

        return hash_equals(
            hash('sha256', $token . $adminPassword),
            $hash
        );
    }
}
