@extends('website.layouts.app')

@section('title', 'Reuqests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/wallet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myroomDetails.css') }}">
@endsection

@section('content')

<script>
    @foreach ($errors->all() as $error)
        toastNotification('{{ $error }}', 'error', 3000);
    @endforeach

    @if (session('success'))
        toastNotification('{{ session('success') }}', 'success', 3000);
    @endif

    @if (session('error'))
        toastNotification('{{ session('error') }}', 'error', 3000);
    @endif
</script>

<div class="container">
    <div id="resourceList">
        <h1 class="section-title">Wallet</h1>

        <div class="wallet">
            <div class="wallet__balance">
                <h1>Balance</h1>
                <h1>{{ Auth::user()->sbucks_balance }}</h1>
            </div>
            <div class="wallet__buttons">
                <button class="cta-button" onclick="openDepositModal()">Deposit</button>
            </div>
        </div>
        

        @if (Auth::user()->walletTransactions->count() == 0)
            <div class="empty" style="text-align: center; margin: 8em auto;">
                <i class="fas fa-money-bill-wave" style="font-size: 5em; color: #ccc;"></i>
                <h1>No transactions yet</h1>
                <p>Once you make a transaction, it will appear here</p>
            </div>
        @else
       
            <div class="table-titles vcard">
                <strong>Amount</strong>
                <strong>Type</strong>
                <strong>Date</strong>
            </div>

            @foreach (Auth::user()->walletTransactions->sortByDesc('created_at') as $transaction)
            <div class="vcard">
                <div class="vcard-title">
                    <h4>{{ $transaction->amount }}</h4>
                </div>
                <div class="date vcard__content">
                    <p>{{ $transaction->transaction_type }}</p>
                </div>
                <div class="date vcard__content">
                    <p>{{ $transaction->created_at }}</p>
                </div>
            </div>

            @endforeach

        @endif
        
    </div>
</div>

<div class="depositModal modal" id="depositModal">
    <div class="content">
        <div class="modal-top">
            <h2>Create Session</h2>
            <span class="close" onclick="closeDepositModal()">&times;</span>
        </div>
        <div class="modal-content">
            <form method="POST" action="{{ route('wallet.deposit') }}" id="depositForm">
                @csrf
                <label for="amount">You will pay</label>
                <input type="number" name="amount" placeholder="Amount" id="amount" required>
                <input type="hidden" name="type" value="deposit">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <label for="result">You will get</label>
                <output id="result" name="result" style="border: 1px solid #ccc; padding: 0.5em; border-radius: 5px; margin-bottom: 1em; font-size:1.2em;">0</i></output>
                <div id="paypal-button-container" style="margin: 0 auto;"></div>
            </form>
        </div>
    </div>
</div>

<hr>


<script>
    closeDepositModal();
    function openDepositModal(){
        document.getElementById('depositModal').style.display = 'block';
    }
    function closeDepositModal(){
        document.getElementById('depositModal').style.display = 'none';
    }

    function calculate(){
        var amount = document.getElementById('amount').value;
        var result = amount * 15;
        document.getElementById('result').value = result;
    }
    document.getElementById('amount').addEventListener('keyup', calculate);




</script>

<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>

<script>
  paypal.Buttons({

    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: document.getElementById('amount').value,
            currency: 'USD'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(orderData) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'orderID';
        input.value = orderData.id;
        document.getElementById('depositForm').appendChild(input);

        document.getElementById('depositForm').submit();
      });
    },

  }).render('#paypal-button-container');
</script>



@endsection