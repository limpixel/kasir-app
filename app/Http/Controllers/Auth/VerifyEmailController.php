<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Check if the authenticated user has the specific email
        $user = $request->user();
        $isSpecialUser = $user && $user->email === 'customer@gmail.com';
        
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($isSpecialUser ? '/'.'?verified=1' : route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended($isSpecialUser ? '/'.'?verified=1' : route('dashboard', absolute: false).'?verified=1');
    }
}
