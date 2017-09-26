@extends('layouts.app')

@section('content')
<script>
	var coin_rate = {{ $eth_rate }};
</script>
<form method="post" action="/transit">
    {{ csrf_field() }}
    <div style="margin-bottom: 1em;">
        <label for="walletType">Select wallet type</label>
        <select name="walletType" id="walletType" class="form-control" aria-label="Wallet type" value="External" required="required" readonly="readonly">
            <option value="External" selected>External</option>
            <option value="Personal" disabled="disabled">Personal wallet</option>            
        </select>
    </div>
    
    <div style="margin-bottom: 1em;">
        <input type="text" name="srcAmount" size="10" id="srcAmount" class="form-control" aria-label="Transfer this amount of ETH" value="{{ number_format(1/$eth_rate,6) }}" required="required" readonly="readonly">
        <select name="srcCurrency" id="srcCurrency">
          <option value="ETH" selected>ETH</option>
          <option value="OMG" disabled="disabled">OMG</option>
          <option value="KNC" disabled="disabled">KNC</option>
          <option value="ZRX" disabled="disabled">ZRX</option>
          <option value="BAT" disabled="disabled">BAT</option>
          <option value="GNT" disabled="disabled">GNT</option>
          <option value="REP" disabled="disabled">REP</option>
        </select>
    </div>
    <div style="margin-bottom: 1em;">
        <input type="text" size="10" name="dstAmount" id="dstAmount" class="form-control" aria-label="Get this amount of $" placeholder="$ to get" value="1" required="required" readonly="readonly">
        <select name="srcCurrency" id="srcCurrency">
            <option value="USD" selected>USD</a>
            <option value="EUR" disabled="disabled">EUR</a>
            <option value="GBP" disabled="disabled">GBP</a>
        </select>
    </div>
	<div>
		<p class="green-grass emph">1 ETH = {{ $eth_rate }} USD</p>
	</div>
	<div>
		<p class="green-grass emph">{{ __('welcome.beta_version_warning') }}</p>
	</div>

    <div class="form-group">
		<input type="text" pattern="\d{4} \d{4} \d{4} \d{4}" required="required" name="plastic_card" class="form-control" id="plastic_card" aria-describedby="plasticCard" value="{{ old('plastic_card') }}" placeholder="{{ __('welcome.plastic_card_placeholder') }}" autocomplete="false">
        @if ($errors->get('plastic_card'))
            <p class="text-danger">
				@php echo $errors->get('plastic_card')[0];
				@endphp
			</p>
        @endif
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="validity_date" id="validity_date" required="required" value="{{ old('validity_date') }}" placeholder="{{ __('welcome.validity_date_placeholder') }}" autocomplete="false">
        @if ($errors->get('validity_date'))
            <p class="text-danger">
			    @php echo $errors->get('validity_date')[0];
			    @endphp
			</p>
        @endif
    </div>
    <div class="form-group">
        <input type="email" class="form-control" name="user_email" id="email" required="required" value="{{ old('user_email') }}" placeholder="{{ __('welcome.email_placeholder') }}">
    </div>
    @if ($errors->get('user_email'))
       <p class="text-danger">
       @php echo $errors->get('user_email')[0];
       @endphp
       </p>
    @endif
    <button type="submit" class="btn btn-success btn-block btn-green">{{ __('welcome.submit') }}</button>
</form>
<p>
@if (count($errors)>0)
<ul>
@foreach ($errors->all() as $error)
   <li>{{ $error }}</li>
@endforeach
</ul>
@endif
</p>
@endsection

@section('add_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="js/payment_info.js"></script>
@endsection