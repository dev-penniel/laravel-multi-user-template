<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    // Read Users
    public function index(): View
    {
        return view('users.index', [
            'users' => User::where('role', '!=', '1')->latest()->get(),
        ]);
    }

    // Store a newly created resource
    public function store (Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:200', 'unique:'.User::class],
            'role' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([

            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),

        ]);

        // Sent credentials to the newly created user via mail
        // event(new Registered($user));

        return redirect(route('users.index', absolute: false));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }
    

    // Update resource
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'lowercase', 'email', 'max:255','unigue:'.User::class,
        ]);

        $user->update($validated);

        return redirect(route('users.edit', $user))->with('status', 'user-updated');
    }

    // Suspend User
    public function suspend(Request $request, User $user): RedirectResponse
    {
        $request->validateWithBag('suspend', [
            'password' => ['required', 'current_password'],
        ]);


        $user->update(['status' => 1]);

        return back()->with('status', 'User Suspended');

    }

    // Unsuspend User
    public function unsuspend(Request $request, user $user): RedirectResponse
    {
        $request->validateWithBag('unsuspend', [
            'password' => ['required', 'current_password'],
        ]);

        $user->update(['status' => 0]);

        return back()->with('status', 'Users Unsupended');
    }


    // Delete user
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user->delete();

        return redirect(route('users.index'))->with('status', 'User account deleted successfully.');
        
    }
}
