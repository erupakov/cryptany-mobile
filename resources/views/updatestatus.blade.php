@extends('layouts.app')

@section('content')
<div class="justify-center mb-2">
<img class="img-fluid mx-auto d-block" src="/img/transaction_icon.png" alt="transaction logo"/>
</div>
<p class="text-center mv-2" id="txStatus_1">Transaction ID:{{ $txid }}</p>
<p class="text-center mv-2" id="txStatus_3">Transaction status:</p>
<p class="green-grass condensed text-center mv-2">{{ $statusText }} [{{ $statusCode }}], renewed on {{ $updated_at }}</p>
<form method="post">
{{ csrf_field() }}
<input type="hidden" value="{{ $txid }}" name="txid" >
<label for="newStatus">New transaction status</label>
<select name="newStatus" class="form-control">
	<option value="2">Registered</option>
	<option value="3">Confirmed</option>
	<option value="4">Processing</option>
	<option value="5">Processed</option>
	<option value="6" selected>Fiats sent</option>
	<option value="7">Closed</option>
</select>
<div class="d-block pv-2">
<button type="submit" class="btn btn-success btn-lg">Change status</button>
</div>
</form>
@endsection
@section('add_js')
@endsection