<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->tenant_id !== null) {
            Tenant::setCurrentId((int) $user->tenant_id);
        } else {
            Tenant::setCurrentId(null);
        }

        return $next($request);
    }
}

