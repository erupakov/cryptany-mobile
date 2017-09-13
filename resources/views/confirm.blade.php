@extends('layouts.app')

@section('content')
<div class="justify-center mb-2">
<img class="img-responsive" src="img/transaction-logo.png" alt="transaction logo"/>
</div>
<p class="text-center">{{ __('payment.instruction', ['srcAmount'=>$srcAmount, 'dstAmount'=>$dstAmount, 'card_number'=>$card_number]) }}</p>
<div class="justify-center mb-2" id="qrcode" style="height: 200px; width:200px;"></div>
<p class="green-grass text-center mv-2" id="walletAddress">0x{{ $address }}</p>
<button class="btn btn-success btn-block" name="CopyAddress">{{ __('confirm.copy_button') }}</button>
@endsection

@section('add_js')
<script>
var walletAddress = '{{ $address }}';
</script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="js/confirm_payment.js"></script>
@endsection