<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // If User is not logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        //Check if user is not super admin
        $userRole = Auth::user()->role;

        if($userRole !== 1){
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
