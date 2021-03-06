@extends('layouts.app')

@section('content')
<div class="justify-center mb-2">
<img class="img-fluid mx-auto d-block" src="img/transaction_icon.png" alt="transaction logo"/>
</div>
<p class="text-center mv-2" id="txStatus_1">Transaction ID:{{ $walletHash }}</p>
<p class="text-center mv-2" id="txStatus_2">Wallet address:{{ $address }}</p>
<p class="text-center mv-2" id="txStatus_3">Transaction status:</p>
<p class="green-grass condensed text-center mv-2">{{ $statusText }}</p>
<a class="btn btn-success btn-block btn-green" style="display: none;" id="btnSupport" href="mailto:support@cryptany.io?subject=Cryptany%20app%20support">{{ __('transaction.support_text') }}</a>
@endsection

@section('add_js')
<script>
var walletAddress = '{{ $address }}';
var walletId = '{{ $walletHash }}';
</script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="/js/transaction.js"></script>
@endsection