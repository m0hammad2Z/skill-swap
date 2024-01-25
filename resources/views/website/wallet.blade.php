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

    @if (session('status'))
        toastNotification('{{ session('status') }}', 'success', 3000);
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

            @foreach (Auth::user()->walletTransactions as $transaction)
            <div class="vcard">
                <div class="vcard-title">
                    <h4>20</h4>
                </div>
                <div class="date vcard__content">
                    <p>Deposit</p>
                </div>
                <div class="date vcard__content">
                    <p>20/10/2021</p>
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
            <form method="POST" action="{{ route('wallet.deposit') }}">
                @csrf
                <label for="amount">You will pay</label>
                <input type="number" name="amount" placeholder="Amount" id="amount" required>
                <input type="hidden" name="type" value="deposit">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <label for="result">You will get</label>
                <output id="result" name="result" style="border: 1px solid #ccc; padding: 0.5em; border-radius: 5px; margin-bottom: 1em; font-size:1.2em;">0</i></output>
                <button type="submit" class="cta-button" id="pay">Pay</button>
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


@endsection