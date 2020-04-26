<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $privilege = Auth::user()->privilege_id;
        // dd($privilege);

        if($privilege == 2){
            return $next($request);
        }
        else{
            abort(403);
        }
        
        return $next($request);
    }
}
