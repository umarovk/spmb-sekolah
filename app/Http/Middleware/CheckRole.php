<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        

        // Admin can access everything
        if ($user instanceof \App\Models\User && $user->role === 'admin') {
            return $next($request);
        }

        // // Admin can access everything
        // if ($user->isAdmin()) {
        //     return $next($request);
        // }

        // Debug logging
        Log::info('User Role Check', [
            'user_role' => $user->role,
            'required_roles' => $roles,
            'route' => $request->route()->getName()
        ]);

        // Check if user has the required role
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}