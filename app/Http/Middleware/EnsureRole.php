<?php

namespace App\Http\Middleware;

use App\Support\AuthMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$allowedRoles): Response
    {
        $user = $request->user();

        if (!$user) {
            return $request->is('api/*') || $request->expectsJson()
                ? response()->json(['message' => AuthMessages::unauthenticated()], 401)
                : redirect()->route('login');
        }

        $hasAllowedRole = $user->roles()
            ->wherePivot('is_active', 1)
            ->whereIn('role_name', $allowedRoles)
            ->exists();

        if (!$hasAllowedRole) {
            return $request->is('api/*') || $request->expectsJson()
                ? response()->json(['message' => AuthMessages::unauthorizedModule()], 403)
                : abort(403, AuthMessages::unauthorizedModule());
        }

        return $next($request);
    }
}