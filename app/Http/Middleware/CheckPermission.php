<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();

        if (!$user || !$user->hasPermission($permission)) {
            return response()->json(['error' => 'Forbidden, you do not have permission to access this resource.'], 403);
        }

        return $next($request);
    }
}
