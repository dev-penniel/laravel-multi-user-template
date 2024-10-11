<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //Check if user is not super admin
        $userRole = Auth::user()->role;

        if($userRole == 2){

            return $next($request);

        }elseif($userRole == 1){

            return redirect()->route('super-admin.dashboard');

        }elseif($userRole == 3) {
            
            return redirect()->route('dashboard');

        }

    }
}
