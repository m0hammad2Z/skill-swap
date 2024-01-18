<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;

class WalletTransactionController extends Controller
{
    public function index()
    {
        return view('website.wallet');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:deposit,room_creation',
        ]);

        $user = auth()->user();

        $walletTransaction = new WalletTransaction();
        $walletTransaction->user_id = $user->id;
        $walletTransaction->amount = $request->amount;
        $walletTransaction->transaction_type = WalletTransaction::$deposit;
        $walletTransaction->transaction_date = now();
        $walletTransaction->save();

        $user->sbucks_balance += ($request->amount * 15);
        $user->save();

        return redirect()->route('wallet.index')->with('success', 'Amount deposited successfully');
    }
}
