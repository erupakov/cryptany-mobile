@extends('layouts.app')

@section('content')
<p class="text-center">{{ __('payment.instruction', ['srcAmount'=>$srcAmount, 'dstAmount'=>$dstAmount, 'card_number'=>$card_number]) }}</p>
<div class="justify-center" id="qrcode"></div>
<p class="green-grass text-center">{{ $address }}</p>
<button class="btn btn-success btn-block" name="CopyAddress">{{ __('confirm.copy_button') }}</button>
@endsection