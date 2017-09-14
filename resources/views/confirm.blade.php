@extends('layouts.app')

@section('content')
<div class="justify-center mb-2">
<img class="img-fluid mx-auto d-block" src="img/transaction_icon.png" alt="transaction logo"/>
</div>
<p class="text-center">{{ __('confirm.instruction', ['srcAmount'=>$srcAmount, 'dstAmount'=>$dstAmount, 'card_number'=>$card_number]) }}</p>
<div class="mx-auto mb-2" id="qrcode" style="width: 200px;"></div>
<p class="green-grass condensed text-center mv-2" id="walletAddress">0x{{ $address }}</p>
<button class="btn btn-success btn-block btn-green" data-clipboard-target="#walletAddress" name="CopyAddress">{{ __('confirm.copy_button') }}</button>
<p class="text-center mv-2">Waiting for transaction...</p>
@endsection

@section('add_js')
<script>
var walletAddress = '{{ $address }}';
var walletId = '{{ $walletHash }}';
</script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
<script src="js/confirm_payment.js"></script>
@endsection