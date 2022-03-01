<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
            return redirect('login');

        $user = Auth::user();

        foreach ($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            switch ($role) {
                case 'admin':
                    if ($user->role == 'admin')
                        return $next($request);
                    break;
                case 'kabag_umum':
                    if ($user->role == 'kabag_umum')
                        return $next($request);
                    break;
                case 'kabag_pegawai':
                    if ($user->role == 'kabag_pegawai')
                        return $next($request);
                    break;
                default:
                    return redirect('login');
                    break;
            }
        }
        return abort('404');
    }
}
