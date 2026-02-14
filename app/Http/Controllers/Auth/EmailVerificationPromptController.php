<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            // Check if the authenticated user has the specific email
            $user = $request->user();
            if ($user && $user->email === 'customer@gmail.com') {
                return redirect()->intended('/');
            }
            
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        return Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
