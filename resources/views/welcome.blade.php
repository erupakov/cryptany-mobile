@extends('layouts.app')

@section('content')
<form method="post" action="/confirm-payment">
    {{ csrf_field() }}
    <div class="input-group" style="margin-bottom: 1em;">
      <input type="text" name="srcAmount" id="srcAmount" class="form-control" aria-label="Transfer this amount of ETH" value="0.00254" required="required">
      <div class="input-group-btn">
        <button type="button" name="switchSrc" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          ETN
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">BTC</a>
          <a class="dropdown-item" href="#">LTC</a>
          <a class="dropdown-item" href="#">ETN</a>
          <a class="dropdown-item" href="#">WVS</a>
        </div>
      </div>
    </div>
    <div class="input-group" style="margin-bottom: 1em;">
      <input type="text" name="dstAmount" id="dstAmount" class="form-control" aria-label="Get this amount of $" placeholder="$ to get" value="1" required="required">
      <div class="input-group-btn">     
        <button type="button" name="switchDst" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
		<p class="green-grass emph">1 ETN = US ${{ $eth_rate }}</p>
	</div>
	<div>
		<p class="green-grass emph">{{ __('welcome.beta_version_warning') }}</p>
	</div>

    <div class="form-group">
		<input type="text" pattern="\d{4} \d{4} \d{4} \d{4}" required="required" name="plastic_card" class="form-control" id="plastic_card" aria-describedby="plasticCard" placeholder="{{ __('welcome.plastic_card_placeholder') }}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="validity_date" id="validity_date" required="required" placeholder="{{ __('welcome.validity_date_placeholder') }}">
    </div>
    <div class="form-group">
        <input type="email" class="form-control" name="user_email" id="email" required="required" placeholder="{{ __('welcome.email_placeholder') }}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{ __('welcome.first_name_placeholder') }}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="family_name" id="family_name" placeholder="{{ __('welcome.family_name_placeholder') }}">
    </div>

    <button type="submit" class="btn btn-success btn-block btn-green">{{ __('welcome.submit') }}</button>
</form>
@endsection