<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Restrict CMS operations to accounts explicitly marked as administrators.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || strcasecmp((string) $user->user_role, 'Admin') !== 0) {
            abort(403);
        }

        return $next($request);
    }
}
