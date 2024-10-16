<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        // Check if user account is suspended
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate user
        if(Auth::attempt($request->only('email', 'password'))){
            
            $user = Auth::user();

            // Check if user is suspended
            if($user->status == 1){

                // Log out user immediately
                Auth::logout();

                // Redirect to login with custom suspension message
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account is suspended, contact admin',
                ]);

            }
        }

        $request->authenticate();

        $request->session()->regenerate();

        $loggedInUserRole = $request->user()->role;

        //Super Admin
        if($loggedInUserRole == 1){
            return redirect()->intended(route('super-admin.dashboard', absolute: false));
        }
        //Admin
        elseif ($loggedInUserRole == 2){
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        //Normal User
        elseif ($loggedInUserRole == 3){
            return redirect()->intended(route('dashboard', absolute: false));
        }


    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
