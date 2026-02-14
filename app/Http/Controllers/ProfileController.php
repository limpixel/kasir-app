<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Transaction;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Get customer's transaction history.
     */
    public function getCustomerTransactions(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Ambil transaksi dari user saat ini menggunakan relasi
        $transactions = $user->transactions()->with(['details.product'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'invoice' => $transaction->invoice,
                    'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                    'status' => $transaction->status,
                    'customer_name' => $transaction->customer_name,
                    'customer_phone' => $transaction->customer_phone,
                    'customer_address' => $transaction->customer_address,
                    'payment_method' => $transaction->payment_method,
                    'grand_total' => $transaction->grand_total,
                    'items' => $transaction->details->map(function ($detail) {
                        return [
                            'product_name' => $detail->product->name,
                            'qty' => $detail->qty,
                            'subtotal' => $detail->subtotal,
                        ];
                    }),
                ];
            });

        return response()->json([
            'transactions' => $transactions
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
