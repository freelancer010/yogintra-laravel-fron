<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminIp
{
    /**
     * Optionally restrict the login and administration routes to configured
     * IP addresses or CIDR ranges. An empty allowlist deliberately leaves the
     * routes available so deployments are not locked out by default.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = config('security.admin_allowed_ips', []);

        if ($allowedIps !== [] && ! IpUtils::checkIp($request->ip(), $allowedIps)) {
            abort(403);
        }

        return $next($request);
    }
}
