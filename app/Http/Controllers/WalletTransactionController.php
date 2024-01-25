<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Http;

class WalletTransactionController extends Controller
{
    private $clientID ='AXyNcD9iTdW7ogJmpzjCdNicDkZxgtL7hTb1pG9ei5BWVmCTrAQvUEiETLc9PR_sbWTOd7-3su-9LXcs';
    private $secret = 'EOYzyBDC6FPVzyMiVcrCCr5U-WRczYNNA7pl5Bzqf8y0Q6E3KMC12kqPbBAcJA2tRLrEbpy_Ru8rP7ze';


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

        try{
                // Get access token
                $response = Http::withBasicAuth($this->clientID, $this->secret)
                ->asForm()
                ->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
                    'grant_type' => 'client_credentials',
                ]);

                $accessToken = $response->json()['access_token'];

                // Create an order
                $response = Http::withToken($accessToken)
                    ->post('https://api.sandbox.paypal.com/v2/checkout/orders', [
                        'intent' => 'CAPTURE',
                        'purchase_units' => [
                            [
                                'amount' => [
                                    'currency_code' => 'USD',
                                    'value' => $request->amount,
                                ],
                            ],
                        ],
                    ]);

                $orderID = $response->json()['id'];

                // Capture an order
                $response = Http::withToken($accessToken)
                    ->post("https://api.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture");

                $response->json();


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
        }catch(\Exception $e){
            return redirect()->route('wallet.index')->with('error', 'Something went wrong');
        }
    }

    


}
