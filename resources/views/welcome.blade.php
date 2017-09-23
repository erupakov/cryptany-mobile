@extends('layouts.app')

@section('content')
<script>
	var coin_rate = {{ $eth_rate }};
</script>
<form method="post" action="/transit">
    {{ csrf_field() }}
    <div class="input-group" style="margin-bottom: 1em;">
      <input type="text" name="srcAmount" id="srcAmount" class="form-control" aria-label="Transfer this amount of ETH" value="{{ number_format(1/$eth_rate,6) }}" required="required">
      <div class="input-group-btn">
        <button type="button" name="switchSrc" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          ETH
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">BTC</a>
          <a class="dropdown-item" href="#">LTC</a>
          <a class="dropdown-item" href="#">ETH</a>
        </div>
      </div>
    </div>
    <div class="input-group" style="margin-bottom: 1em;">
	  <div class="input-group-addon">$</div>
      <input type="text" name="dstAmount" id="dstAmount" class="form-control" aria-label="Get this amount of $" placeholder="$ to get" value="1" required="required">
      <div class="input-group-btn">     
        <button type="button" name="switchDst" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          USD
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">USD</a>
          <a class="dropdown-item" href="#">EUR</a>
          <a class="dropdown-item" href="#">GBP</a>
        </div>
      </div>
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
<script src="js/payment_info.js"></script>
@endsection