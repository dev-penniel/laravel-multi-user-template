<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    //
    /**
     * Admin update the user's password.
     */

     public function update(Request $request, User $user): RedirectResponse
     {
        $validated = $request->validateWithBag('updatePassword', [
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        return back()->with('status', 'password-updated')->withFragment('password-section');
     }
}
