<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class AccessIfRoleRoadICT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->user()->role->slug, [Role::ROLE_ROADS_OWNER, Role::ROLE_ICT_OWNER]) === false) {
            abort(403);
        }

        return $next($request);
    }
}
