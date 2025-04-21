<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $method = 'is' . ucfirst($role);
        if (!auth()->user()->$method()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}