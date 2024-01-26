<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Srmklive\PayPal\Services\ExpressCheckout;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalHttp\HttpException;


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
            'orderID' => 'required|string',
        ]);
    
        $user = auth()->user();
    
        $orderID = $request->orderID;



        try{
            $environment = new SandboxEnvironment($this->clientID, $this->secret);
            $client = new PayPalHttpClient($environment);   
        
            $response = $client->execute(new OrdersGetRequest($orderID));
            $order = $response->result;
        }catch(HttpException $ex){
            return redirect()->route('wallet.index')->with('error', 'Payment verification failed');
        }
    
        // Verify the payment details
        if ($order->status === 'COMPLETED' && $order->purchase_units[0]->amount->value == $request->amount) {
            $walletTransaction = new WalletTransaction();
            $walletTransaction->user_id = $user->id;
            $walletTransaction->amount = $request->amount;
            $walletTransaction->transaction_type = WalletTransaction::$deposit;
            $walletTransaction->transaction_date = now();
            $walletTransaction->save();
    
            $user->sbucks_balance += ($request->amount * 15);
            $user->save();
    
            return redirect()->route('wallet.index')->with('success', 'Deposit successful');
        } else {
            return redirect()->route('wallet.index')->with('error', 'Payment verification failed');
        }
    }
    

}
